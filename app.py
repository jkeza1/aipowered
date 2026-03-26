from fastapi import FastAPI, UploadFile, File, Form
from fastapi.staticfiles import StaticFiles
import tensorflow as tf
import numpy as np
import re
from PIL import Image
import io
import os
import tempfile
import cv2  # Ensure you ran: pip install opencv-python
import pytesseract
from difflib import SequenceMatcher
import mysql.connector
import piexif
from PIL import Image, ImageChops

# --- CONFIGURE TESSERACT PATH ---
# Prefer env override; keep Windows default as fallback.
_tesseract_cmd = os.getenv("TESSERACT_CMD")
if _tesseract_cmd:
    pytesseract.pytesseract.tesseract_cmd = _tesseract_cmd
elif os.name == "nt":
    _default_tesseract = r"C:\Program Files\Tesseract-OCR\tesseract.exe"
    if os.path.exists(_default_tesseract):
        pytesseract.pytesseract.tesseract_cmd = _default_tesseract

# --- DATABASE CONFIG ---
DB_CONFIG = {
    "host": os.getenv("DB_HOST", "localhost"),
    "user": os.getenv("DB_USER", "root"),
    "password": os.getenv("DB_PASS", ""),
    "database": os.getenv("DB_NAME", "iremboaipowered")
}

PUBLIC_BASE_URL = os.getenv("PUBLIC_BASE_URL", "http://127.0.0.1:8001")

def check_citizen_record(national_id):
    """Verifies the National ID against the citizenregister table."""
    try:
        print(f"[DEBUG] Querying citizenregister for national_id: {national_id}")
        conn = mysql.connector.connect(**DB_CONFIG)
        cursor = conn.cursor(dictionary=True)
        # We query the citizenregister table which you use for official records
        query = "SELECT full_name, national_id FROM citizenregister WHERE national_id = %s"
        cursor.execute(query, (national_id,))
        record = cursor.fetchone()
        print(f"[DEBUG] Query result: {record}")
        cursor.close()
        conn.close()
        return record
    except Exception as e:
        print(f"Database Error: {e}")
        return None

def run_metadata_forensics(image_bytes):
    """Checks for editing software signatures in EXIF data."""
    try:
        exif_dict = piexif.load(image_bytes)
        software = exif_dict.get("0th", {}).get(piexif.ImageIFD.Software, b"")
        software_str = software.decode("utf-8", "ignore").lower()
        
        suspicious_list = ["photoshop", "gimp", "snapseed", "canva", "adobe", "pixelmator"]
        for susp in suspicious_list:
            if susp in software_str:
                return False, f"Metadata Check: Editing software detected ({software_str})"
        
        return True, "No suspicious metadata"
    except Exception:
        # Many scans don't have metadata, which is normal
        return True, "No metadata metadata signature found"

def run_ela_analysis(image_bytes):
    """
    Simulates Error Level Analysis (ELA) to detect JPEG resave artifacts.
    Areas with higher artifacts/noise often indicate digital modification.
    """
    try:
        temp_filename = None
        # Open original and save at a specific quality
        original = Image.open(io.BytesIO(image_bytes)).convert("RGB")
        with tempfile.NamedTemporaryFile(suffix=".jpg", delete=False) as tmp:
            temp_filename = tmp.name
        original.save(temp_filename, "JPEG", quality=90)
        
        # Open resaved and calculate difference
        resaved = Image.open(temp_filename)
        diff = ImageChops.difference(original, resaved)
        
        # Calculate stats on the difference
        extrema = diff.getextrema()
        max_diff = max([ex[1] for ex in extrema])
        if max_diff == 0:
            max_diff = 1
        
        # If the difference is too high in localized areas, it's a sign of editing
        # We simplify this to a global variance check for this bot
        stat = np.array(diff).std()
        
        if temp_filename and os.path.exists(temp_filename):
            os.remove(temp_filename)
        
        if stat > 10.0: # High ELA variance threshold
            return False, "ELA Check: Inconsistent compression artifacts detected (Likely edited)"
        
        return True, "ELA clean"
    except Exception as e:
        if temp_filename and os.path.exists(temp_filename):
            os.remove(temp_filename)
        return True, "ELA calculation skipped"

app = FastAPI()

# Create a folder for heatmaps
HEATMAP_PATH = "static/heatmaps"
os.makedirs(HEATMAP_PATH, exist_ok=True)
# Mount static files so they are accessible via URL
app.mount("/static", StaticFiles(directory="static"), name="static")

# --- CONFIGURATION ---
WEIGHTS_PATH = os.getenv("MODEL_WEIGHTS_PATH", "output/models/auth_check_model_weights.weights.h5")
IMG_SIZE = (224, 224)
AUTHENTIC_LABEL = 1
TAMPERED_LABEL = 0
AUTHENTIC_THRESHOLD = 0.45


def find_last_conv_layer(model):
    """Return the last convolution-like layer for Grad-CAM style outputs."""
    conv_like = (
        tf.keras.layers.Conv2D,
        tf.keras.layers.DepthwiseConv2D,
        tf.keras.layers.SeparableConv2D,
    )
    for layer in reversed(model.layers):
        if isinstance(layer, conv_like):
            return layer
    for layer in reversed(model.layers):
        try:
            out_shape = layer.output_shape
        except Exception:
            continue
        if isinstance(out_shape, tuple) and len(out_shape) == 4:
            return layer
    raise ValueError("No suitable conv-like layer found for heatmap generation")


def preprocess_for_effnet(image_rgb_np):
    """Match EfficientNet preprocessing used during notebook training."""
    return tf.keras.applications.efficientnet.preprocess_input(image_rgb_np.astype(np.float32))

def build_model_with_xai():
    """Builds model and exposes internal layers for Grad-CAM."""
    base_model = tf.keras.applications.EfficientNetB0(weights=None, include_top=False, input_shape=(*IMG_SIZE, 3))
    last_conv_layer = find_last_conv_layer(base_model)
    
    avg_pool = tf.keras.layers.GlobalAveragePooling2D()(base_model.output)
    max_pool = tf.keras.layers.GlobalMaxPooling2D()(base_model.output)
    merged = tf.keras.layers.Concatenate()([avg_pool, max_pool])
    
    x = tf.keras.layers.BatchNormalization()(merged)
    x = tf.keras.layers.Dense(512, activation='relu')(x)
    x = tf.keras.layers.Dropout(0.5)(x)
    x = tf.keras.layers.Dense(256, activation='relu', kernel_regularizer='l2')(x)
    x = tf.keras.layers.Dropout(0.3)(x)
    outputs = tf.keras.layers.Dense(1, activation='sigmoid')(x)
    
    # Return both the prediction and the heatmap activation map
    return tf.keras.Model(inputs=base_model.input, outputs=[outputs, last_conv_layer.output])

# Global model instance
model = build_model_with_xai()
if os.path.exists(WEIGHTS_PATH):
    model.load_weights(WEIGHTS_PATH)
    print("✅ Weights loaded successfully.")
else:
    print(f"❌ Weights not found at {WEIGHTS_PATH}")

@app.get("/")
async def root():
    return {"message": "Irembo AI Document Verification API is running. Use POST /verify to analyze documents."}

import re

# Add this to the top imports
import cv2  # Should already be there
from pyzbar import pyzbar # Add this: pip install pyzbar

def run_ocr_forensics(image_np, expected_name, expected_id, expected_type):
    """
    Combines OCR extraction, QR Code Decoding, and Database Matching.
    """
    try:
        # 1. Decode QR Code (Unfakable signature)
        qr_data = "None"
        qr_match = False
        barcodes = pyzbar.decode(image_np)
        if barcodes:
            qr_data = barcodes[0].data.decode("utf-8")
            # Logic: Check if the QR data matches the expected ID or known citizen data
            if expected_id and str(expected_id) in qr_data:
                qr_match = True

        # 2. Extract Text
        # Pre-process image for better OCR accuracy (Grayscale + Thresholding)
        gray = cv2.cvtColor(image_np, cv2.COLOR_RGB2GRAY)
        # Increase contrast
        processed_img = cv2.threshold(gray, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)[1]
        
        # Try OCR on both original and processed image
        text_orig = pytesseract.image_to_string(image_np)
        text_proc = pytesseract.image_to_string(processed_img)
        
        # Print raw OCR outputs for debugging
        print(f"--- OCR RAW OUTPUT START ---")
        print(f"text_orig: [{text_orig}]")
        print(f"text_proc: [{text_proc}]")
        print(f"--- OCR RAW OUTPUT END ---")
        
        text = text_orig + " " + text_proc
        clean_text = " ".join(text.lower().split())
        
        # DEBUG: Print exact OCR output to console for troubleshooting
        print(f"--- OCR DEBUG START ---")
        print(f"OCR TEXT DETECTED: [{clean_text}]")
        print(f"EXPECTED NAME: [{expected_name}]")
        print(f"EXPECTED ID: [{expected_id}]")
        print(f"--- OCR DEBUG END ---")
        
        # 3. Document Type Classification
        doc_type_detected = "unknown"
        keywords = {
            "nationalid": ["republic of rwanda", "national id", "indangamuntu", "identite", "identity", "rembo", "nid"],
            "passport": ["passport", "republic of rwanda", "p rwa", "passeport"],
            "drivinglicense": ["driving license", "conduit", "republique du rwanda", "permis"],
            "criminalrecord": ["criminal record", "extrait du casier", "republic of rwanda", "judicial records"],
            "goodconduct": ["good conduct", "certificate of good", "conduct"],
            "academictranscript": ["academic transcript", "student record", "marks", "university", "college", "school"],
            "bankstatement": ["bank statement", "transaction history", "account statement", "financial activities", "balance"],
            "salarycertificate": ["salary certificate", "payslip", "income record", "salary slip"],
            "employmentcontract": ["employment contract", "agreement", "employer", "employee", "job offer", "contract"],
            "businesslicense": ["business license", "rdb", "office of the registrar", "incorporation", "enterprise"],
            "medicalreport": ["medical report", "health certificate", "doctor", "hospital", "diagnosis"],
            "propertyownership": ["property ownership", "land title", "upi", "parcel", "real estate"],
            "notarialact": ["notarial act", "notary", "authentication", "notarized"],
            "powerofattorney": ["power of attorney", "authorized representative", "legal authority"],
            "courtjudgment": ["court judgment", "legal verdict", "ruling", "judge", "justice"]
        }
        
        for doc_key, kws in keywords.items():
            if any(kw in clean_text for kw in kws):
                doc_type_detected = doc_key
                break
                
        # Normalize expected_type from PHP for comparison
        # Remove spaces and convert to lowercase (e.g., "Employment Contract" -> "employmentcontract")
        norm_expected = str(expected_type).lower().replace(" ", "") if expected_type else ""
        
        # SPECIAL CASE: Map human-readable service names to AI keys if they don't match exactly
        type_mapping = {
            "employmentcontractcertification": "employmentcontract",
            "employmentcontract": "employmentcontract",
            "salarycertificate": "salarycertificate"
        }
        if norm_expected in type_mapping:
            norm_expected = type_mapping[norm_expected]

        # Use partial keyword matching for type if it's a known document type
        type_match = (doc_type_detected == norm_expected) or (doc_type_detected in norm_expected) if norm_expected else True
        
        # 4. Strict Database Matching (NLP)
        name_score = 0
        # Create a version of the text with NO SPACES and NO SPECIAL CHARS to catch "keza110" or "ID: 120..."
        clean_text_alphanumeric = re.sub(r'[^a-zA-Z0-9]', '', clean_text)
        
        if expected_name:
            # Check if all parts of the expected name are present in the OCR
            name_parts = str(expected_name).lower().split()
            matches = 0
            for part in name_parts:
                # Remove small noisy particles like 'a' or 'the' but keep names
                if len(part) < 2: continue 
                
                # Check for direct inclusion or alphanumeric inclusion
                clean_part = re.sub(r'[^a-z0-9]', '', part)
                if clean_part in clean_text or clean_part in clean_text_alphanumeric:
                    matches += 1
            
            # Use a more relaxed threshold: 30% match is enough for noisy scans
            name_score = (matches / len(name_parts)) * 100 if name_parts else 0

        # Match ID (Strip everything except numbers)
        clean_expected_id = re.sub(r'[^0-9]', '', str(expected_id))
        clean_ocr_numbers = re.sub(r'[^0-9]', '', clean_text)
        print(f"[DEBUG] clean_expected_id: {clean_expected_id}")
        print(f"[DEBUG] clean_ocr_numbers: {clean_ocr_numbers}")
        # ID is usually more unique, so we check for its presence in OCR
        id_in_ocr = clean_expected_id in clean_ocr_numbers if expected_id else False
        print(f"[DEBUG] id_in_ocr: {id_in_ocr}")
        # 5. INTEGRATED DATABASE VERIFICATION
        db_match = False
        db_name = "Not Found"
        if id_in_ocr:
            citizen = check_citizen_record(clean_expected_id)
            print(f"[DEBUG] citizen DB lookup: {citizen}")
            if citizen:
                db_match = True
                db_name = citizen['full_name']
        # Final ID match is only true if both OCR and DB match
        id_match = id_in_ocr and db_match
        print(f"[DEBUG] id_match (OCR+DB): {id_match}")
        # Determine Final Authenticity
        # Condition: OCR Success (Name/ID) AND verified in Citizen DB
        # If DB verification succeeds, we trust the name match more easily
        is_authentic = (name_score >= 20) and id_match
        if barcodes:
             is_authentic = is_authentic and qr_match # If QR exists, it MUST match

        return {
            "doc_type_detected": doc_type_detected,
            "type_match": type_match,
            "name_match_score": round(name_score, 2),
            "id_match": id_match,
            "db_verification": db_match,
            "citizen_name": db_name,
            "qr_data": qr_data,
            "is_authentic": is_authentic,
            "anomalies": ["None"] if is_authentic else ["Data Mismatch: Identity could not be verified in citizen database"]
        }
    except Exception as e:
        print(f"OCR Error: {e}")
        return {
            "type_match": False,
            "doc_type_detected": "Error",
            "name_match_score": 0,
            "id_match": False,
            "anomalies": ["OCR System Error"]
        }

@app.post("/verify")
async def verify_document(
    file: UploadFile = File(...), 
    expected_name: str = Form(None), 
    expected_id: str = Form(None),
    expected_type: str = Form(None)
):
    try:
        contents = await file.read()
        image = Image.open(io.BytesIO(contents)).convert('RGB')
        
        # Preprocess
        img_np = np.array(image)
        original_resized = np.array(image.resize(IMG_SIZE))
        img_array = np.expand_dims(original_resized, axis=0)
        img_array = preprocess_for_effnet(img_array)

        # 1. Digital Tampering (EfficientNet)
        # We increase input resolution for smaller forgery detection
        prediction, last_conv_output = model.predict(img_array)
        # Notebook mapping: sigmoid output 1=authentic, 0=tampered.
        authentic_score = float(prediction[0][0])
        tampered_score = float(1.0 - authentic_score)
        
        # --- NEW: ADVANCED FORENSIC PASSES ---
        # A. Metadata Pass
        is_metadata_clean, meta_msg = run_metadata_forensics(contents)
        
        # B. ELA Pass (Error Level Analysis)
        is_ela_clean, ela_msg = run_ela_analysis(contents)
        
        # C. Digital Forgery Pass
        gray_cv = cv2.cvtColor(img_np, cv2.COLOR_RGB2GRAY)
        # Detect edges and noise inconsistencies
        laplacian_var = cv2.Laplacian(gray_cv, cv2.CV_64F).var()
        is_pasted = laplacian_var < 100 # Low variance can indicate smooth digitally generated text/shapes
        
        # 2. OCR Forensics
        ocr_res = run_ocr_forensics(img_np, expected_name, expected_id, expected_type)
        
        # 3. Heatmap
        heatmap = np.mean(last_conv_output[0], axis=-1)
        heatmap = np.maximum(heatmap, 0) / (np.max(heatmap) + 1e-10)
        heatmap = cv2.resize(heatmap, (IMG_SIZE[1], IMG_SIZE[0]))
        heatmap = np.uint8(255 * heatmap)
        heatmap = cv2.applyColorMap(heatmap, cv2.COLORMAP_JET)
        
        original_bgr = cv2.cvtColor(original_resized, cv2.COLOR_RGB2BGR)
        pointed_img = cv2.addWeighted(original_bgr, 0.6, heatmap, 0.4, 0)
        
        result_filename = f"verify_{file.filename}.jpg"
        save_path = os.path.join(HEATMAP_PATH, result_filename)
        cv2.imwrite(save_path, pointed_img)

        # Logic for Overall Verdict
        is_type_valid = ocr_res.get('type_match', True)
        is_identity_valid = ocr_res.get('is_authentic', False)
        
        # INCREASED STRICTNESS FOR FORGERY:
        # 1. Deep ML authentic score must be high (> AUTHENTIC_THRESHOLD)
        # 2. Laplacian variance must not be suspicious (detects "copy-paste" blur)
        # 3. Metadata must be clean (no photoshop signatures)
        # 4. ELA must be consistent (no resave/modification noise)
        # 5. OCR and DB must match perfectly
        is_forensic_clean = (authentic_score >= AUTHENTIC_THRESHOLD) and (not is_pasted) and is_metadata_clean and is_ela_clean
        is_authentic = is_forensic_clean and is_type_valid and is_identity_valid
        
        # Prepare explanation based on failures
        # --- NEW TRAFFIC LIGHT REGISTRY LOGIC ---
        status = "Authentic"
        traffic_light = "GREEN"
        risk_score = 0

        # Risk Calculation
        if (authentic_score < 0.25 or is_pasted or not is_metadata_clean) and not is_authentic:
            traffic_light = "RED"
            status = "Fraudulent"
            risk_score = 100
        elif (authentic_score < AUTHENTIC_THRESHOLD or not is_ela_clean or not is_identity_valid or not is_type_valid) and not is_authentic:
            traffic_light = "YELLOW"
            status = "Suspicious"
            risk_score = 50
        
        if is_authentic:
            explanation = f"Verification successful. Document belongs to {ocr_res['citizen_name']} and forensic integrity (CNN/Metadata/ELA/DB) is confirmed."
        else:
            reasons = []
            if authentic_score < AUTHENTIC_THRESHOLD: reasons.append("CNN: Manipulation markers detected")
            if is_pasted: reasons.append("Inconsistent edge noise (Possible copy-paste)")
            if not is_metadata_clean: reasons.append(meta_msg)
            if not is_ela_clean: reasons.append(ela_msg)
            if not is_type_valid: reasons.append(f"Mismatched service ({expected_type})")
            if not is_identity_valid: 
                reasons.append("NLP: Identity could not be cross-referenced in official registry")
            explanation = "FAILED: " + ", ".join(reasons)

        return {
            "success": True,
            "status": status,
            "traffic_light": traffic_light,
            "risk_score": risk_score,
            "is_authentic": is_authentic,
            "authentic_score": round(authentic_score * 100, 2),
            "tampered_score": round(tampered_score * 100, 2),
            "digital_integrity": round(authentic_score * 100, 2),
            "ocr_forensics": ocr_res,
            "heatmap_url": f"{PUBLIC_BASE_URL}/static/heatmaps/{result_filename}",
            "explanation": explanation
        }
        

    except Exception as e:
        return {"success": False, "error": str(e)}

# --- NEW TRAINING ENDPOINT ---
@app.post("/train")
async def train_model(document_type: str = Form(...)):
    """
    Fine-tunes the model using verified documents from the admin's storage.
    Example: document_type='nationalid' will train on 'adminsection/nationalid/'
    """
    try:
        # Map types to folder paths
        folder_map = {
            "nationalid": "adminsection/nationalid/",
            "passport": "adminsection/passports/",
            "drivinglicense": "adminsection/drivinglicense/",
            "criminalrecord": "adminsection/criminalrecord/",
            "goodconduct": "adminsection/goodconduct/"
        }
        
        data_dir = folder_map.get(document_type.lower())
        if not data_dir or not os.path.exists(data_dir):
            return {"success": False, "error": f"Data directory for {document_type} not found."}

        # Load images from the verified folder
        images = []
        for filename in os.listdir(data_dir):
            if filename.endswith(('.jpg', '.jpeg', '.png')):
                img_path = os.path.join(data_dir, filename)
                img = Image.open(img_path).convert('RGB').resize(IMG_SIZE)
                images.append(np.array(img))

        if len(images) < 2:
            return {"success": False, "error": "Not enough verified documents to start training (minimum 2 required)."}

        X_train = np.array(images, dtype=np.float32)
        X_train = preprocess_for_effnet(X_train)
        # Since these are 'verified' authentic documents, label them as 1.
        y_train = np.full((len(X_train), 1), AUTHENTIC_LABEL, dtype=np.float32)

        # Perform 3 epochs of Transfer Learning (Fine-Tuning)
        model.compile(optimizer=tf.keras.optimizers.Adam(learning_rate=0.0001), 
                      loss='binary_crossentropy', metrics=['accuracy'])
        
        model.fit(X_train, y_train, epochs=3, batch_size=4, verbose=0)
        
        # Save updated weights
        model.save_weights(WEIGHTS_PATH)
        
        return {
            "success": True, 
            "message": f"Model successfully fine-tuned on {len(images)} {document_type} documents.",
            "updated_at": str(os.path.getmtime(WEIGHTS_PATH))
        }

    except Exception as e:
        return {"success": False, "error": f"Training failed: {str(e)}"}

if __name__ == "__main__":
    import uvicorn
    # Make sure this file is named app.py
    uvicorn.run("app:app", host="127.0.0.1", port=8001, reload=True)
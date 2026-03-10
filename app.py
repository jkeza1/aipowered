from fastapi import FastAPI, UploadFile, File
from fastapi.staticfiles import StaticFiles
import tensorflow as tf
import numpy as np
from PIL import Image
import io
import os
import cv2  # Ensure you ran: pip install opencv-python
import pytesseract
from difflib import SequenceMatcher
import re

# --- CONFIGURE TESSERACT PATH ---
# Explicitly setting the path for Windows
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

app = FastAPI()

# Create a folder for heatmaps
HEATMAP_PATH = "static/heatmaps"
os.makedirs(HEATMAP_PATH, exist_ok=True)
# Mount static files so they are accessible via URL
app.mount("/static", StaticFiles(directory="static"), name="static")

# --- CONFIGURATION ---
WEIGHTS_PATH = r"output/models/auth_check_model_weights.weights.h5"
IMG_SIZE = (224, 224)

def build_model_with_xai():
    """Builds model and exposes internal layers for Grad-CAM."""
    base_model = tf.keras.applications.EfficientNetB0(weights=None, include_top=False, input_shape=(*IMG_SIZE, 3))
    
    # We target 'top_activation' to see the final feature map before pooling
    last_conv_layer = base_model.get_layer("top_activation") 
    
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
        text = pytesseract.image_to_string(image_np)
        clean_text = " ".join(text.lower().split())
        
        # 3. Document Type Classification
        doc_type_detected = "unknown"
        keywords = {
            "nationalid": ["republic of rwanda", "national id", "indangamuntu"],
            "passport": ["passport", "republic of rwanda", "p rwa"],
            "drivinglicense": ["driving license", "conduit", "republique du rwanda"]
        }
        
        for doc_key, kws in keywords.items():
            if any(kw in clean_text for kw in kws):
                doc_type_detected = doc_key
                break
                
        type_match = (doc_type_detected == expected_type) if expected_type else True
        
        # 4. Strict Database Matching (NLP)
        name_score = 0
        if expected_name:
            # Check if all parts of the expected name are present in the OCR
            name_parts = expected_name.lower().split()
            matches = sum(1 for part in name_parts if part in clean_text)
            name_score = (matches / len(name_parts)) * 100 if name_parts else 0

        id_match = str(expected_id).lower().replace(" ", "") in clean_text.replace(" ", "") if expected_id else False
        
        # Determine Final Authenticity
        is_authentic = (name_score > 70) and id_match
        if barcodes:
             is_authentic = is_authentic and qr_match # If QR exists, it MUST match

        return {
            "doc_type_detected": doc_type_detected,
            "type_match": type_match,
            "name_match_score": round(name_score, 2),
            "id_match": id_match,
            "qr_data": qr_data,
            "qr_match": qr_match,
            "is_authentic": is_authentic,
            "anomalies": ["None"] if is_authentic else ["Data Mismatch: Document does not belong to applicant"]
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
    expected_name: str = None, 
    expected_id: str = None,
    expected_type: str = None
):
    try:
        contents = await file.read()
        image = Image.open(io.BytesIO(contents)).convert('RGB')
        
        # Preprocess
        img_np = np.array(image)
        original_resized = np.array(image.resize(IMG_SIZE))
        img_array = np.expand_dims(original_resized, axis=0)

        # 1. Digital Tampering (EfficientNet)
        prediction, last_conv_output = model.predict(img_array)
        tamp_score = float(prediction[0][0])
        
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
        is_authentic = tamp_score > 0.5 and is_type_valid
        
        return {
            "success": True,
            "status": "Authentic" if is_authentic else "Suspicious",
            "is_authentic": is_authentic,
            "digital_integrity": round(tamp_score * 100, 2),
            "ocr_forensics": ocr_res,
            "heatmap_url": f"http://127.0.0.1:8001/static/heatmaps/{result_filename}",
            "explanation": "High forensic integrity" if is_authentic else "Verification failed: Check document type or tampering heatmap."
        }
        

    except Exception as e:
        return {"success": False, "error": str(e)}

if __name__ == "__main__":
    import uvicorn
    # Make sure this file is named app.py
    uvicorn.run("app:app", host="127.0.0.1", port=8001, reload=True)
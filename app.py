from fastapi import FastAPI, UploadFile, File
import tensorflow as tf
import keras
import numpy as np
from PIL import Image
import io
import os
from pathlib import Path

app = FastAPI()

# --- CONFIGURATION (Must match your Notebook) ---
MODEL_PATH = r"output/models/auth_check_model.keras" 
WEIGHTS_PATH = r"output/models/auth_check_model_weights.weights.h5"
IMG_SIZE = (224, 224) 

def build_model():
    """Build the model architecture (must match notebook) to load weights into it."""
    base_model = tf.keras.applications.EfficientNetB0(weights=None, include_top=False, input_shape=(*IMG_SIZE, 3))
    avg_pool = tf.keras.layers.GlobalAveragePooling2D()(base_model.output)
    max_pool = tf.keras.layers.GlobalMaxPooling2D()(base_model.output)
    merged = tf.keras.layers.Concatenate()([avg_pool, max_pool])
    x = tf.keras.layers.BatchNormalization()(merged)
    x = tf.keras.layers.Dense(512, activation='relu')(x)
    x = tf.keras.layers.Dropout(0.5)(x)
    x = tf.keras.layers.Dense(256, activation='relu', kernel_regularizer='l2')(x)
    x = tf.keras.layers.Dropout(0.3)(x)
    outputs = tf.keras.layers.Dense(1, activation='sigmoid')(x)
    return tf.keras.Model(inputs=base_model.input, outputs=outputs)

# Load the model once when the API starts
if os.path.exists(WEIGHTS_PATH):
    try:
        model = build_model()
        model.load_weights(WEIGHTS_PATH)
        print(f"✅ AI Brain Loaded (Weights from): {WEIGHTS_PATH}")
    except Exception as e:
        print(f"⚠️ Weights loading failed, trying fallback to full model: {e}")
        if os.path.exists(MODEL_PATH):
            model = keras.models.load_model(MODEL_PATH)
            print(f"✅ AI Brain Loaded (Full Model from): {MODEL_PATH}")
else:
    print(f"❌ ERROR: Weights file not found at {WEIGHTS_PATH}")

@app.get("/")
def home():
    return {"status": "AI Server is Running", "model": "EfficientNetB0-Rwandan-Auth"}

@app.post("/verify")
async def verify_document(file: UploadFile = File(...)):
    try:
        # 1. Read the image sent from PHP
        contents = await file.read()
        image = Image.open(io.BytesIO(contents)).convert('RGB')
        
        # 2. Preprocess to match your AI training
        image = image.resize(IMG_SIZE)
        img_array = np.array(image) 
        # Note: EfficientNetB0 has internal rescaling, so we don't divide by 255 manually
        img_array = np.expand_dims(img_array, axis=0)

        # 3. Prediction
        prediction = model.predict(img_array)
        score = float(prediction[0][0]) # Probability of being Authentic
        
        # 4. Result Logic
        # In your notebook logic: 1 = Authentic, 0 = Tampered
        is_authentic = score > 0.5 
        confidence = score if is_authentic else (1 - score)

        return {
            "success": True,
            "is_authentic": is_authentic,
            "confidence_score": round(confidence * 100, 2),
            "status": "Authentic" if is_authentic else "Tampered/Forgery"
        }

    except Exception as e:
        return {"success": False, "error": str(e)}

if __name__ == "__main__":
    import uvicorn
    # Changed port to 8001 to avoid bind errors on 8000
    uvicorn.run(app, host="127.0.0.1", port=8001)

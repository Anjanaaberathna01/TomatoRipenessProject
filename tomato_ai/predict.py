# pyright: reportAttributeAccessIssue=false
import os
import sys
import json
import cv2
import numpy as np
import tensorflow as tf
import logging

# -----------------------------
# SUPPRESS TENSORFLOW LOGS
# -----------------------------
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'  # suppress TF INFO/WARN
logging.getLogger('tensorflow').setLevel(logging.FATAL)

# -----------------------------
# MODEL PATH
# -----------------------------
MODEL_PATH = "E:/TomatoRipenessProject/tomato_ai/tomato_detector.h5"  # Change to full path if needed

if not os.path.exists(MODEL_PATH):
    result = {
        "status": "error",
        "message": f"Model file '{MODEL_PATH}' not found",
        "result": None
    }
    print(json.dumps(result))
    sys.exit(1)

# Load model
model = tf.keras.models.load_model(MODEL_PATH)

# -----------------------------
# GET IMAGE PATH FROM ARGUMENT
# -----------------------------
if len(sys.argv) < 2:
    result = {
        "status": "error",
        "message": "No image path provided",
        "result": None
    }
    print(json.dumps(result))
    sys.exit(1)

image_path = sys.argv[1]

if not os.path.exists(image_path):
    result = {
        "status": "error",
        "message": f"Image file '{image_path}' not found",
        "result": None
    }
    print(json.dumps(result))
    sys.exit(1)

# -----------------------------
# LOAD AND PREPROCESS IMAGE
# -----------------------------
img = cv2.imread(image_path)
if img is None:
    result = {
        "status": "error",
        "message": f"Failed to read image '{image_path}'",
        "result": None
    }
    print(json.dumps(result))
    sys.exit(1)

img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
img = cv2.resize(img, (224, 224))
img = img / 255.0
img = np.expand_dims(img, axis=0)

# -----------------------------
# MAKE PREDICTION
# -----------------------------
prediction = model.predict(img, verbose=0)[0][0]

# -----------------------------
# DECIDE LABEL
# -----------------------------
TOMATO_THRESHOLD = 0.9
NOT_TOMATO_THRESHOLD = 0.3

if prediction >= TOMATO_THRESHOLD:
    label = "TOMATO"
elif prediction <= NOT_TOMATO_THRESHOLD:
    label = "NOT_TOMATO"
else:
    label = "UNCERTAIN"

result = {
    "status": "success",
    "message": f"{label} detected",
    "result": {
        "label": label,
        "confidence": float(prediction)
    }
}

# Only output JSON
print(json.dumps(result))

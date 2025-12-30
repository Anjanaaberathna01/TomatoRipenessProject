# pyright: reportAttributeAccessIssue=false
import os
import sys
import json
import cv2
import numpy as np
import tensorflow as tf
from typing import cast

# Suppress TensorFlow chatter to keep stdout clean JSON
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "3"
tf.get_logger().setLevel("ERROR")

MODEL_PATH = "E:/TomatoRipenessProject/tomato_ai/tomato_disease.h5"

# Class list must match the alphabetical order used by flow_from_directory during training
CLASS_NAMES = sorted([
    "Tomato___Bacterial_spot",
    "Tomato___Early_blight",
    "Tomato___Late_blight",
    "Tomato___Leaf_Mold",
    "Tomato___Septoria_leaf_spot",
    "Tomato___Spider_mites Two-spotted_spider_mite",
    "Tomato___Target_Spot",
    "Tomato___Tomato_Yellow_Leaf_Curl_Virus",
    "Tomato___Tomato_mosaic_virus",
])

def fail(message: str):
    print(json.dumps({"status": "error", "message": message}))
    sys.exit(1)

if not os.path.exists(MODEL_PATH):
    fail("Disease model not found")

if len(sys.argv) < 2:
    fail("No image path provided")

image_path = sys.argv[1]
if not os.path.exists(image_path):
    fail("Image file not found")

try:
    model = tf.keras.models.load_model(MODEL_PATH)
except Exception as exc:
    fail(f"Failed to load model: {exc}")

img = cv2.imread(image_path)
if img is None:
    fail("Failed to read image")
img = cast(np.ndarray, img)

try:
    img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
    img = cv2.resize(img, (224, 224))
    img = img.astype("float32") / 255.0
    img = np.expand_dims(img, axis=0)
    pred = model.predict(img, verbose=0)[0]
except Exception as exc:
    fail(f"Failed to preprocess/predict: {exc}")

if pred.shape[0] != len(CLASS_NAMES):
    fail(f"Model output size {pred.shape[0]} does not match class list {len(CLASS_NAMES)}")

idx = int(np.argmax(pred))

print(json.dumps({
    "status": "success",
    "disease": CLASS_NAMES[idx],
    "confidence": float(pred[idx])
}))

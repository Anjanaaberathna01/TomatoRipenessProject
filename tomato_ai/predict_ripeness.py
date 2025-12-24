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

MODEL_PATH = "E:/TomatoRipenessProject/tomato_ai/tomato_ripeness.h5"

def fail(message: str):
    print(json.dumps({"status": "error", "message": message}))
    sys.exit(1)

if not os.path.exists(MODEL_PATH):
    fail("Ripeness model not found")

if len(sys.argv) < 2:
    fail("No image path provided")

image_path = sys.argv[1]
if not os.path.exists(image_path):
    fail("Image file not found")

try:
    model = tf.keras.models.load_model(MODEL_PATH)
except Exception as exc:  # keep JSON-only output
    fail(f"Failed to load model: {exc}")

img = cv2.imread(image_path)
if img is None:
    fail("Failed to read image")
img = cast(np.ndarray, img)  # help type checker; runtime already guarded

try:
    img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
    img = cv2.resize(img, (224, 224))
    img = img.astype("float32")  # model includes rescaling
    img = np.expand_dims(img, axis=0)
    pred = model.predict(img, verbose=0)[0]
except Exception as exc:
    fail(f"Failed to preprocess/predict: {exc}")

# IMPORTANT: Must match training class order exactly (alphabetically sorted)
# Training uses sorted(['Old', 'Ripe', 'Unripe']) = ['Old', 'Ripe', 'Unripe']
classes = ["Old", "Ripe", "Unripe"]  # Index 0=Old, 1=Ripe, 2=Unripe
days_map = {"Unripe": 4, "Old": 0, "Ripe": 1}

# Debug: Print all predictions
# print(f"DEBUG - All predictions: Old={pred[0]:.4f}, Ripe={pred[1]:.4f}, Unripe={pred[2]:.4f}")

index = int(np.argmax(pred))
stage = classes[index]
confidence = float(pred[index])

# Confidence should be reasonably high; flag weak predictions
if confidence < 0.5:
    # Model is uncertain - don't trust this prediction
    pass

print(json.dumps({
    "status": "success",
    "stage": stage,
    "days_to_ripe": days_map[stage],
    "confidence": confidence
}))

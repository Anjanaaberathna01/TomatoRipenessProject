# pyright: reportAttributeAccessIssue=false
import os
import sys
import json
import cv2
import numpy as np
import tensorflow as tf
from typing import cast

# Keep TensorFlow quiet
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "3"
tf.get_logger().setLevel("ERROR")

MODEL_PATH = "E:/TomatoRipenessProject/tomato_ai/tomato_leaf_detector.h5"
THRESHOLD = float(os.getenv("TOMATO_PROB_THRESHOLD", "0.6"))


def fail(message: str, code: int = 1) -> None:
    print(json.dumps({"status": "error", "message": message}))
    sys.exit(code)


if not os.path.exists(MODEL_PATH):
    fail("Tomato leaf detector model not found. Train it with train_leaf_check.py")

if len(sys.argv) < 2:
    fail("No image path provided")

image_path = sys.argv[1]
if not os.path.exists(image_path):
    fail("Image file not found")

try:
    model = tf.keras.models.load_model(MODEL_PATH)
except Exception as exc:  # noqa: BLE001
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
    prob = float(model.predict(img, verbose=0)[0][0])  # probability the leaf is tomato
except Exception as exc:  # noqa: BLE001
    fail(f"Failed to preprocess/predict: {exc}")

is_tomato = prob >= THRESHOLD
label = "TOMATO_LEAF" if is_tomato else "OTHER_LEAF"
confidence = prob if is_tomato else 1.0 - prob

print(json.dumps(
    {
        "status": "success",
        "label": label,
        "confidence": confidence,
        "tomato_probability": prob,
        "threshold": THRESHOLD,
    }
))

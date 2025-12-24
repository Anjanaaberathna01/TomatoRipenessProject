# test_ripeness.py
# Test the ripeness model with real images

import os
import cv2
import numpy as np
import tensorflow as tf
from pathlib import Path

MODEL_PATH = "E:/TomatoRipenessProject/tomato_ai/tomato_ripeness.h5"
TEST_DIR = "E:/TomatoRipenessProject/tomato_ai/test_images"

# Load model
print("Loading model...")
model = tf.keras.models.load_model(MODEL_PATH)  # type: ignore
classes = ["Old", "Ripe", "Unripe"]

print("\n" + "=" * 70)
print("🍅 RIPENESS MODEL TEST")
print("=" * 70)

# Test each image
test_files = sorted(Path(TEST_DIR).glob("*.jpg")) + sorted(Path(TEST_DIR).glob("*.png"))

if not test_files:
    print(f"❌ No test images found in {TEST_DIR}")
    print("\nCreate this folder structure:")
    print(f"  {TEST_DIR}/")
    print("  ├── unripe_1.jpg (green tomato)")
    print("  ├── unripe_2.jpg")
    print("  ├── ripe_1.jpg (red tomato)")
    print("  ├── ripe_2.jpg")
    print("  ├── old_1.jpg (brown tomato)")
    print("  └── old_2.jpg")
else:
    for img_path in test_files:
        img = cv2.imread(str(img_path))
        if img is None:
            print(f"❌ Failed to read: {img_path.name}")
            continue
        
        # Preprocess
        img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        img = cv2.resize(img, (224, 224))
        img = img.astype("float32")
        img = np.expand_dims(img, axis=0)
        
        # Predict
        pred = model.predict(img, verbose=0)[0]
        idx = int(np.argmax(pred))
        stage = classes[idx]
        confidence = float(pred[idx])
        
        # Expected vs Actual
        expected = img_path.stem.split('_')[0].upper()  # "unripe_1.jpg" → "UNRIPE"
        match = "✅" if expected == stage.upper() else "❌"
        
        print(f"\n{match} {img_path.name}")
        print(f"   Expected: {expected} | Got: {stage}")
        print(f"   Predictions:")
        print(f"   - Old:    {pred[0]:.4f} ({pred[0]*100:5.1f}%)")
        print(f"   - Ripe:   {pred[1]:.4f} ({pred[1]*100:5.1f}%)")
        print(f"   - Unripe: {pred[2]:.4f} ({pred[2]*100:5.1f}%)")

print("\n" + "=" * 70)

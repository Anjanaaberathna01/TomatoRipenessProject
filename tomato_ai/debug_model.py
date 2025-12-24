# debug_model.py
# This script helps diagnose the ripeness model issue

import os
import sys
import tensorflow as tf
import numpy as np

MODEL_PATH = "E:/TomatoRipenessProject/tomato_ai/tomato_ripeness.h5"

print("=" * 60)
print("🔍 RIPENESS MODEL DIAGNOSTIC")
print("=" * 60)

# Step 1: Check if model exists
print(f"\n1️⃣  Checking model file...")
if not os.path.exists(MODEL_PATH):
    print(f"   ❌ MODEL NOT FOUND: {MODEL_PATH}")
    sys.exit(1)
else:
    file_size = os.path.getsize(MODEL_PATH) / (1024*1024)
    print(f"   ✅ Model found: {file_size:.2f} MB")

# Step 2: Load model
print(f"\n2️⃣  Loading model...")
try:
    model = tf.keras.models.load_model(MODEL_PATH)  # type: ignore
    print(f"   ✅ Model loaded successfully")
except Exception as e:
    print(f"   ❌ Failed to load model: {e}")
    sys.exit(1)

# Step 3: Check model structure
print(f"\n3️⃣  Model structure:")
print(f"   Input shape: {model.input_shape}")
print(f"   Output shape: {model.output_shape}")
print(f"   Total parameters: {model.count_params():,}")

# Step 4: Test with random image
print(f"\n4️⃣  Testing with random image...")
random_img = np.random.rand(1, 224, 224, 3).astype('float32')
pred = model.predict(random_img, verbose=0)[0]

classes = ["Old", "Ripe", "Unripe"]
print(f"   Predictions:")
print(f"   - Old:    {pred[0]:.4f} ({pred[0]*100:.2f}%)")
print(f"   - Ripe:   {pred[1]:.4f} ({pred[1]*100:.2f}%)")
print(f"   - Unripe: {pred[2]:.4f} ({pred[2]*100:.2f}%)")
print(f"   Argmax: {classes[np.argmax(pred)]} (index {np.argmax(pred)})")

if pred[2] > pred[0] and pred[2] > pred[1]:
    print(f"\n   ⚠️  WARNING: Model strongly biases toward UNRIPE!")
    print(f"      This indicates poor training or untrained weights.")

# Step 5: Training data check
print(f"\n5️⃣  Checking training data...")
TRAIN_DIR = "E:/TomatoRipenessProject/laravel_app/storage/app/tomato_dataset/training/ripeness"
if not os.path.exists(TRAIN_DIR):
    print(f"   ❌ Training directory not found: {TRAIN_DIR}")
else:
    for cls in ['Old', 'Ripe', 'Unripe']:
        path = os.path.join(TRAIN_DIR, cls)
        if os.path.exists(path):
            count = len([f for f in os.listdir(path) if f.lower().endswith(('.jpg', '.png', '.jpeg'))])
            print(f"   ✅ {cls}: {count} images")
        else:
            print(f"   ❌ {cls}: Directory not found")

print("\n" + "=" * 60)
print("RECOMMENDATIONS:")
print("=" * 60)
print("""
1. If model shows bias to UNRIPE (step 4):
   → The model needs to be RETRAINED with your dataset
   → Run: python train_ripeness.py

2. If training data missing (step 5):
   → Organize images into:
     {TRAIN_DIR}/Old/
     {TRAIN_DIR}/Ripe/
     {TRAIN_DIR}/Unripe/

3. If file sizes are suspiciously small:
   → Model may not have trained properly
   → Check for training errors

4. To verify class order is correct:
   → Expected: ['Old', 'Ripe', 'Unripe'] (alphabetical)
   → Verify in train_ripeness.py line 25
""")
print("=" * 60)

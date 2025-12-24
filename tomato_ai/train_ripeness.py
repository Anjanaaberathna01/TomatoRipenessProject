# train_ripeness.py
# pyright: reportMissingImports=false, reportAttributeAccessIssue=false
import tensorflow as tf
from tensorflow.keras import layers, models, applications

IMG_SIZE = (224, 224)
BATCH_SIZE = 8
EPOCHS = 30

TRAIN_DIR = "E:/TomatoRipenessProject/laravel_app/storage/app/tomato_dataset/training/ripeness"
VAL_DIR   = "E:/TomatoRipenessProject/laravel_app/storage/app/tomato_dataset/validation/ripeness"

# Verify directories exist before loading
import os
if not os.path.exists(TRAIN_DIR):
    print(f"❌ ERROR: Training directory not found: {TRAIN_DIR}")
    print(f"   Please organize your images in:")
    print(f"   {TRAIN_DIR}/Old/")
    print(f"   {TRAIN_DIR}/Ripe/")
    print(f"   {TRAIN_DIR}/Unripe/")
    exit(1)

train_data = tf.keras.utils.image_dataset_from_directory(
    TRAIN_DIR,
    image_size=IMG_SIZE,
    batch_size=BATCH_SIZE,
    label_mode="categorical",
    shuffle=True
)

val_data = tf.keras.utils.image_dataset_from_directory(
    VAL_DIR,
    image_size=IMG_SIZE,
    batch_size=BATCH_SIZE,
    label_mode="categorical",
    shuffle=False
)

class_names = sorted(train_data.class_names)  # Force alphabetical order
print("✓ CLASS ORDER:", class_names)
print("  MUST BE: ['Old', 'Ripe', 'Unripe']")
assert class_names == ['Old', 'Ripe', 'Unripe'], f"Class order mismatch! Got {class_names}"

base_model = applications.MobileNetV2(
    input_shape=(224, 224, 3),
    include_top=False,
    weights="imagenet"
)
base_model.trainable = True  # Enable fine-tuning

model = models.Sequential([
    layers.Rescaling(1.0 / 255.0, input_shape=(224, 224, 3)),
    base_model,
    layers.GlobalAveragePooling2D(),
    layers.Dense(64, activation="relu"),
    layers.Dense(3, activation="softmax")
])

model.compile(
    optimizer=tf.keras.optimizers.Adam(learning_rate=1e-4),
    loss="categorical_crossentropy",
    metrics=["accuracy"]
)

model.fit(
    train_data,
    validation_data=val_data,
    epochs=EPOCHS
)

model.save("tomato_ripeness.h5")
print("✅ Ripeness model saved correctly")

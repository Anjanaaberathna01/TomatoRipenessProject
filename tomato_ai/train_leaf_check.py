# pyright: reportMissingImports=false, reportAttributeAccessIssue=false
import os
import sys
import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator

# Suppress verbose TensorFlow logs to keep console tidy
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "2"

IMG_SIZE = (224, 224)
BATCH_SIZE = 32
EPOCHS = 12
MODEL_OUT = "E:/TomatoRipenessProject/tomato_ai/tomato_leaf_detector.h5"

# Dataset for tomato vs other leaves
BASE_DIR = r"\\?\E:\TomatoRipenessProject\laravel_app\storage\app\tomato_dataset\disease_check"

def resolve_dir(preferred: str, fallback: str | None = None) -> str:
    """Pick the first existing directory between preferred and fallback."""
    preferred_path = os.path.join(BASE_DIR, preferred)
    if os.path.isdir(preferred_path):
        return preferred_path

    if fallback:
        fallback_path = os.path.join(BASE_DIR, fallback)
        if os.path.isdir(fallback_path):
            return fallback_path

    sys.exit(f"Missing dataset directory: {preferred_path}" + (f" or {fallback_path}" if fallback else ""))

TRAIN_DIR = resolve_dir("training", "traning")  # handle misspelling in folder name
VAL_DIR = resolve_dir("validation")

train_gen = ImageDataGenerator(
    rescale=1.0 / 255,
    rotation_range=25,
    width_shift_range=0.15,
    height_shift_range=0.15,
    zoom_range=0.2,
    horizontal_flip=True,
    fill_mode="nearest",
)

val_gen = ImageDataGenerator(rescale=1.0 / 255)

train_data = train_gen.flow_from_directory(
    TRAIN_DIR,
    target_size=IMG_SIZE,
    batch_size=BATCH_SIZE,
    class_mode="binary",
    shuffle=True,
)
print("Training classes:", train_data.class_indices)

val_data = val_gen.flow_from_directory(
    VAL_DIR,
    target_size=IMG_SIZE,
    batch_size=BATCH_SIZE,
    class_mode="binary",
    shuffle=False,
)
print("Validation classes:", val_data.class_indices)

base_model = tf.keras.applications.MobileNetV2(
    input_shape=(224, 224, 3),
    include_top=False,
    weights="imagenet",
)
base_model.trainable = False

model = tf.keras.Sequential(
    [
        base_model,
        tf.keras.layers.GlobalAveragePooling2D(),
        tf.keras.layers.Dropout(0.25),
        tf.keras.layers.Dense(128, activation="relu"),
        tf.keras.layers.Dropout(0.25),
        tf.keras.layers.Dense(1, activation="sigmoid"),  # tomato leaf probability
    ]
)

model.compile(
    optimizer=tf.keras.optimizers.Adam(learning_rate=0.001),
    loss="binary_crossentropy",
    metrics=["accuracy"],
)

callbacks = [
    tf.keras.callbacks.EarlyStopping(monitor="val_accuracy", patience=3, restore_best_weights=True),
    tf.keras.callbacks.ReduceLROnPlateau(monitor="val_loss", factor=0.5, patience=2, min_lr=1e-5),
]

print("\nTraining tomato-leaf detector...")
print(f"Training samples: {train_data.samples}")
print(f"Validation samples: {val_data.samples}")

history = model.fit(
    train_data,
    validation_data=val_data,
    epochs=EPOCHS,
    callbacks=callbacks,
    verbose=1,
)

model.save(MODEL_OUT)

print("\nSaved tomato leaf detector to", MODEL_OUT)
print("Final training accuracy:", f"{history.history['accuracy'][-1]:.4f}")
print("Final validation accuracy:", f"{history.history['val_accuracy'][-1]:.4f}")

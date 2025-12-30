# pyright: reportMissingImports=false, reportAttributeAccessIssue=false
import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator
import os

# Suppress TensorFlow warnings
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "2"

IMG_SIZE = (224, 224)
BATCH_SIZE = 32
EPOCHS = 10

# Dataset paths (full 10-class disease set including healthy)
# Use extended-length prefix to avoid Windows path-length issues on deep filenames.
BASE_DIR = r"\\?\E:\TomatoRipenessProject\laravel_app\storage\app\tomato_dataset\disease"
TRAIN_DIR = os.path.join(BASE_DIR, "training")
VAL_DIR = os.path.join(BASE_DIR, "validation")

# Data augmentation for training
train_gen = ImageDataGenerator(
    rescale=1./255,
    rotation_range=25,
    width_shift_range=0.2,
    height_shift_range=0.2,
    zoom_range=0.2,
    horizontal_flip=True,
    fill_mode='nearest'
)

# No augmentation for validation
val_gen = ImageDataGenerator(rescale=1./255)

# Use all classes inferred from directory names (alphabetical order)
train_data = train_gen.flow_from_directory(
    TRAIN_DIR,
    target_size=IMG_SIZE,
    batch_size=BATCH_SIZE,
    class_mode='categorical',
    shuffle=True
)

print("\n📊 Training classes:", train_data.class_indices)

val_data = val_gen.flow_from_directory(
    VAL_DIR,
    target_size=IMG_SIZE,
    batch_size=BATCH_SIZE,
    class_mode='categorical',
    shuffle=False
)

print("📊 Validation classes:", val_data.class_indices)

# Build model using MobileNetV2 as base
base_model = tf.keras.applications.MobileNetV2(
    input_shape=(224, 224, 3),
    include_top=False,
    weights='imagenet'
)

base_model.trainable = False

model = tf.keras.Sequential([
    base_model,
    tf.keras.layers.GlobalAveragePooling2D(),
    tf.keras.layers.Dropout(0.3),
    tf.keras.layers.Dense(128, activation='relu'),
    tf.keras.layers.Dropout(0.3),
    tf.keras.layers.Dense(train_data.num_classes, activation='softmax')  # 10 classes
])

model.compile(
    optimizer=tf.keras.optimizers.Adam(learning_rate=0.001),
    loss='categorical_crossentropy',
    metrics=['accuracy']
)

print("\n🏋️ Training disease classification model...")
print(f"Training samples: {train_data.samples}")
print(f"Validation samples: {val_data.samples}")

history = model.fit(
    train_data,
    validation_data=val_data,
    epochs=EPOCHS,
    verbose=1
)

# Save the model
model.save("E:/TomatoRipenessProject/tomato_ai/tomato_disease.h5")

print("\n✅ Disease classification model saved as tomato_disease.h5")
print(f"Number of classes: {train_data.num_classes}")
print(f"Class names: {list(train_data.class_indices.keys())}")
print(f"Final training accuracy: {history.history['accuracy'][-1]:.4f}")
print(f"Final validation accuracy: {history.history['val_accuracy'][-1]:.4f}")

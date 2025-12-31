# 🍅 Tomato Health Monitor

**AI-Powered Tomato Disease Detection & Ripeness Assessment System**

A comprehensive web application that uses deep learning to detect tomato plant diseases, assess fruit ripeness, and provide actionable insights for farmers and gardeners.

![License](https://img.shields.io/badge/license-MIT-green)
![Python](https://img.shields.io/badge/Python-3.8+-blue)
![PHP](https://img.shields.io/badge/PHP-8.0+-purple)
![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![TensorFlow](https://img.shields.io/badge/TensorFlow-2.x-orange)

---

## 📋 Table of Contents

- [Features](#features)
- [Technologies](#technologies)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Disease Detection](#disease-detection)
- [Ripeness Assessment](#ripeness-assessment)
- [API Documentation](#api-documentation)
- [Model Training](#model-training)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

---

## ✨ Features

### 🔍 Disease Detection

- **10-Class Classification**: Detects 9 tomato diseases + healthy plants
  - Bacterial Spot
  - Early Blight
  - Late Blight
  - Leaf Mold
  - Septoria Leaf Spot
  - Spider Mites (Two-spotted spider mite)
  - Target Spot
  - Tomato Mosaic Virus
  - Tomato Yellow Leaf Curl Virus
  - Healthy

### 🍅 Ripeness Assessment

- **3-Stage Classification**: Old, Ripe, Unripe
- Accurate fruit maturity detection
- Optimized harvest timing recommendations

### 🌿 Leaf Detection

- Tomato leaf vs. other plant identification
- Binary classification for initial filtering

### 📚 Educational Resources

- Disease information and symptoms
- Prevention tips and best practices
- Visual guides for each disease

### 🚀 Additional Features

- Real-time image analysis
- Confidence scoring for predictions
- Responsive web interface
- Mobile-friendly design
- Easy-to-use upload system

---

## 🛠️ Technologies

### Backend

- **Laravel 10.x** - PHP web application framework
- **Python 3.8+** - AI model inference
- **TensorFlow 2.x** - Deep learning framework
- **Keras** - High-level neural networks API
- **OpenCV** - Image processing

### AI/ML Models

- **MobileNetV2** - Base architecture for transfer learning
- **CNN** - Convolutional Neural Networks
- **ImageDataGenerator** - Data augmentation

### Frontend

- **Blade Templates** - Laravel templating engine
- **HTML5/CSS3** - Modern web standards
- **JavaScript** - Interactive features
- **Bootstrap** (optional) - UI components

### Database & Storage

- **MySQL/SQLite** - Relational database
- **File Storage** - Image upload management

---

## 💻 System Requirements

### Minimum Requirements

- **OS**: Windows 10/11, macOS, or Linux
- **RAM**: 4GB (8GB recommended)
- **Storage**: 5GB free space
- **PHP**: 8.0 or higher
- **Python**: 3.8 or higher
- **Composer**: Latest version
- **Node.js**: 16.x or higher (optional, for frontend build)

### Required Software

- PHP 8.0+
- Python 3.8+
- Composer
- MySQL 8.0+ or SQLite
- Git

---

## 📦 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/TomatoRipenessProject.git
cd TomatoRipenessProject
```

### 2. Laravel Setup

```bash
cd laravel_app

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=tomato_health
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# Create storage link
php artisan storage:link
```

### 3. Python Environment Setup

```bash
# Create virtual environment
python -m venv .venv

# Activate virtual environment
# Windows:
.venv\Scripts\activate
# macOS/Linux:
source .venv/bin/activate

# Install Python dependencies
pip install tensorflow opencv-python numpy pillow
```

### 4. Download Pre-trained Models

Place the following model files in `tomato_ai/` directory:

- `tomato_disease.h5` - Disease classification model
- `tomato_ripeness.h5` - Ripeness assessment model
- `tomato_leaf_detector.h5` - Leaf detection model

### 5. Dataset Setup (Optional - for training)

Organize your dataset in the following structure:

```
laravel_app/storage/app/tomato_dataset/
├── disease/
│   ├── training/
│   │   ├── Tomato___Bacterial_spot/
│   │   ├── Tomato___Early_blight/
│   │   └── ... (10 classes)
│   └── validation/
├── training/ripeness/
│   ├── Old/
│   ├── Ripe/
│   └── Unripe/
└── validation/ripeness/
```

### 6. Start the Application

```bash
# Terminal 1: Start Laravel development server
cd laravel_app
php artisan serve

# The application will be available at http://localhost:8000
```

---

## 🚀 Usage

### Web Interface

1. **Home Page**: Navigate to `http://localhost:8000`
2. **Upload Image**: Click "Upload & Analyze" or go to `/upload`
3. **Select Image**: Choose a tomato plant/fruit image
4. **Get Results**: View disease detection or ripeness assessment
5. **Learn More**: Browse disease information at `/browse-diseases`

### Disease Detection

```bash
# Direct Python script usage
cd tomato_ai
python predict_disease.py "path/to/image.jpg"
```

### Ripeness Assessment

```bash
cd tomato_ai
python predict_ripeness.py "path/to/image.jpg"
```

---

## 📁 Project Structure

```
TomatoRipenessProject/
├── laravel_app/                 # Laravel web application
│   ├── app/
│   │   ├── Http/Controllers/   # Controllers
│   │   └── Models/             # Eloquent models
│   ├── config/                 # Configuration files
│   ├── database/               # Migrations & seeders
│   ├── public/                 # Public assets
│   │   ├── images/            # Disease images
│   │   └── logo/              # Application logo
│   ├── resources/
│   │   └── views/             # Blade templates
│   ├── routes/
│   │   └── web.php            # Web routes
│   └── storage/
│       └── app/
│           └── tomato_dataset/ # Training datasets
├── tomato_ai/                  # Python AI models
│   ├── predict_disease.py     # Disease prediction
│   ├── predict_ripeness.py    # Ripeness prediction
│   ├── train_disease.py       # Disease model training
│   ├── train_ripeness.py      # Ripeness model training
│   ├── tomato_disease.h5      # Disease model
│   ├── tomato_ripeness.h5     # Ripeness model
│   └── dataset/               # Training data
├── .venv/                      # Python virtual environment
├── README.md                   # This file
└── requirements.txt            # Python dependencies (optional)
```

---

## 🧠 Disease Detection

### Supported Diseases

| Disease                    | Severity | Symptoms                                | Prevention                                      |
| -------------------------- | -------- | --------------------------------------- | ----------------------------------------------- |
| **Bacterial Spot**         | Critical | Dark, greasy lesions; yellow halos      | Remove infected leaves; avoid overhead watering |
| **Early Blight**           | Critical | Circular brown spots with rings         | Proper spacing; fungicide application           |
| **Late Blight**            | Critical | Water-soaked lesions; rapid spread      | Use resistant varieties; remove infected plants |
| **Leaf Mold**              | Moderate | Yellow patches; gray-brown mold         | Improve air circulation; reduce humidity        |
| **Septoria Leaf Spot**     | Moderate | Small circular lesions; black specks    | Remove debris; avoid overhead irrigation        |
| **Spider Mites**           | Moderate | Fine stippling; yellowing leaves        | Monitor regularly; apply miticides if needed    |
| **Target Spot**            | Moderate | Target-shaped lesions; concentric rings | Maintain good drainage; crop rotation           |
| **Tomato Mosaic Virus**    | Critical | Mottled leaves; mosaic patterns         | Use disease-free seeds; sanitize tools          |
| **Yellow Leaf Curl Virus** | Critical | Leaf yellowing; upward curling          | Control whiteflies; use resistant varieties     |

### Model Architecture

- **Base Model**: MobileNetV2 (pre-trained on ImageNet)
- **Input Size**: 224x224x3
- **Output Classes**: 10
- **Activation**: Softmax
- **Training Images**: 23,768 (training set)

---

## 🍅 Ripeness Assessment

### Classification Categories

1. **Unripe** (Green)
   - Fully green tomatoes
   - Not ready for harvest
2. **Ripe** (Red/Mature)

   - Fully colored
   - Ready for immediate consumption
   - Optimal harvest time

3. **Old** (Overripe)
   - Past peak ripeness
   - Suitable for processing
   - Needs immediate use

### Model Performance

- **Training Samples**: 3,227+
- **Validation Samples**: 3,398+
- **Classes**: 3 (Old, Ripe, Unripe)
- **Architecture**: MobileNetV2 with fine-tuning

---

## 📡 API Documentation

### Disease Detection Endpoint

**Route**: `POST /tomato/diagnose`

**Request**:

```php
multipart/form-data
- image: file (jpg, png, jpeg)
```

**Response**:

```json
{
  "status": "success",
  "disease": "Tomato___Early_blight",
  "confidence": 0.95
}
```

### Ripeness Assessment Endpoint

**Route**: `POST /analyze`

**Request**:

```php
multipart/form-data
- image: file (jpg, png, jpeg)
```

**Response**:

```json
{
  "status": "success",
  "ripeness": "Ripe",
  "confidence": 0.89
}
```

---

## 🏋️ Model Training

### Train Disease Classification Model

```bash
cd tomato_ai
python train_disease.py
```

**Training Configuration**:

- **Epochs**: 10
- **Batch Size**: 32
- **Optimizer**: Adam (lr=0.001)
- **Loss**: Categorical Crossentropy
- **Image Size**: 224x224
- **Augmentation**: Rotation, shifting, zoom, horizontal flip

### Train Ripeness Model

```bash
cd tomato_ai
python train_ripeness.py
```

**Training Configuration**:

- **Epochs**: 30
- **Batch Size**: 8
- **Optimizer**: Adam (lr=1e-4)
- **Fine-tuning**: Enabled
- **Image Size**: 224x224

### Data Augmentation

```python
ImageDataGenerator(
    rescale=1./255,
    rotation_range=25,
    width_shift_range=0.2,
    height_shift_range=0.2,
    zoom_range=0.2,
    horizontal_flip=True,
    fill_mode='nearest'
)
```

---

## 🎯 Accuracy Metrics

### Disease Classification

- **Training Accuracy**: ~94%
- **Validation Accuracy**: ~92%
- **Classes**: 10

### Ripeness Assessment

- **Training Accuracy**: ~96%
- **Validation Accuracy**: ~94%
- **Classes**: 3

---

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Contribution Guidelines

- Follow PSR-12 coding standards for PHP
- Follow PEP 8 for Python code
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

---

## 📸 Screenshots

### Home Page

Beautiful, modern interface with easy navigation.

### Disease Detection

Upload an image and get instant disease diagnosis with confidence scores.

### Browse Diseases

Learn about different tomato diseases with images, symptoms, and prevention tips.

### Learn & Prevent

Educational resources for maintaining healthy tomato plants.

---

## 🔮 Future Enhancements

- [ ] Mobile application (iOS/Android)
- [ ] Real-time camera integration
- [ ] Multi-language support
- [ ] User accounts and history tracking
- [ ] Disease progression tracking
- [ ] Weather integration for disease risk assessment
- [ ] Community forum for farmers
- [ ] Export reports as PDF
- [ ] Treatment recommendations
- [ ] Integration with agricultural databases

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2025 Tomato Health Monitor

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 👥 Authors

- **Your Name** - _Initial work_ - [YourGitHub](https://github.com/yourusername)

---

## 🙏 Acknowledgments

- Plant Village Dataset for training data
- TensorFlow and Keras teams
- Laravel community
- MobileNetV2 architecture developers
- All contributors and testers

---

## 📧 Contact

- **Project Link**: https://github.com/yourusername/TomatoRipenessProject
- **Email**: your.email@example.com
- **Website**: https://yourwebsite.com

---

## 🌟 Star History

If you find this project helpful, please consider giving it a star ⭐

---

## 📊 Project Stats

![GitHub stars](https://img.shields.io/github/stars/yourusername/TomatoRipenessProject)
![GitHub forks](https://img.shields.io/github/forks/yourusername/TomatoRipenessProject)
![GitHub issues](https://img.shields.io/github/issues/yourusername/TomatoRipenessProject)
![GitHub pull requests](https://img.shields.io/github/issues-pr/yourusername/TomatoRipenessProject)

---

**Made with ❤️ for sustainable agriculture**

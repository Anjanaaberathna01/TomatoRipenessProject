# 🖼️ How to Add Local Images to Browse_Disease Page

## Step-by-Step Guide

### **Step 1: Create Image Directory**

Create this folder in your Laravel project:

```
laravel_app/public/images/diseases/
```

### **Step 2: Add Disease Images**

Place your disease images in the folder with these exact names:

```
laravel_app/public/images/diseases/
├── bacterial-spot.jpg
├── early-blight.jpg
├── late-blight.jpg
├── leaf-mold.jpg
├── septoria-leaf-spot.jpg
├── spider-mites.jpg
├── target-spot.jpg
├── tomato-mosaic-virus.jpg
└── yellow-leaf-curl-virus.jpg
```

### **Step 3: Update Browse_Disease.blade.php**

In Laravel, use the `asset()` helper to reference images in the public folder.

**Change from:**

```blade
<img src="https://images.unsplash.com/photo-1599599810694-08f64c0f0fe0?auto=format&fit=crop&w=500&q=60" alt="Late Blight" class="disease-image">
```

**Change to:**

```blade
<img src="{{ asset('images/diseases/late-blight.jpg') }}" alt="Late Blight" class="disease-image">
```

### **Complete Image References**

Replace all 9 image tags with local paths:

```blade
<!-- Bacterial Spot -->
<img src="{{ asset('images/diseases/bacterial-spot.jpg') }}" alt="Bacterial Spot" class="disease-image">

<!-- Early Blight -->
<img src="{{ asset('images/diseases/early-blight.jpg') }}" alt="Early Blight" class="disease-image">

<!-- Late Blight -->
<img src="{{ asset('images/diseases/late-blight.jpg') }}" alt="Late Blight" class="disease-image">

<!-- Leaf Mold -->
<img src="{{ asset('images/diseases/leaf-mold.jpg') }}" alt="Leaf Mold" class="disease-image">

<!-- Septoria Leaf Spot -->
<img src="{{ asset('images/diseases/septoria-leaf-spot.jpg') }}" alt="Septoria Leaf Spot" class="disease-image">

<!-- Spider Mites -->
<img src="{{ asset('images/diseases/spider-mites.jpg') }}" alt="Spider Mites" class="disease-image">

<!-- Target Spot -->
<img src="{{ asset('images/diseases/target-spot.jpg') }}" alt="Target Spot" class="disease-image">

<!-- Tomato Mosaic Virus -->
<img src="{{ asset('images/diseases/tomato-mosaic-virus.jpg') }}" alt="Tomato Mosaic Virus" class="disease-image">

<!-- Yellow Leaf Curl Virus -->
<img src="{{ asset('images/diseases/yellow-leaf-curl-virus.jpg') }}" alt="Yellow Leaf Curl Virus" class="disease-image">
```

### **Image Sources You Can Use**

You can get disease images from:

- **Your dataset:** `laravel_app/storage/app/tomato_dataset/disease/training/`
- **Public sources:**
  - Unsplash (unsplash.com)
  - Pexels (pexels.com)
  - Pixabay (pixabay.com)
  - Your own photos

### **Image Format & Size**

- **Format:** JPG, PNG, or WebP
- **Recommended size:** 500x400px or larger
- **File size:** Keep under 500KB per image for fast loading

### **Accessing Public Images in Laravel**

The `asset()` helper automatically creates the correct path:

- Files in `public/images/diseases/` are served as `/images/diseases/filename.jpg`
- Always use `{{ asset('path/to/file') }}` in Blade templates

---

**Once you have images in place, your Browse_Disease page will display them locally!** ✅

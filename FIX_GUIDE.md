# FIX_GUIDE.md

## 🔴 "Always Unripe" Bug - Complete Analysis & Fix

### ROOT CAUSE

The ripeness model always predicts "Unripe" due to **untrained/poorly-trained model weights**.

---

## 📋 ERROR BREAKDOWN

### Error 1: Model Class Order Mismatch ❌

**File:** `train_ripeness.py` (Line 25-27)
**Issue:** Classes must be alphabetically sorted

```python
# CORRECT ORDER (what the code does):
class_names = sorted(train_data.class_names)  # ['Old', 'Ripe', 'Unripe']

# Index mapping:
# 0 = Old
# 1 = Ripe
# 2 = Unripe
```

**File:** `predict_ripeness.py` (Line 50)

```python
# ✅ CORRECT - matches training order
classes = ["Old", "Ripe", "Unripe"]
```

**Status:** ✅ This part is CORRECT

### Error 2: Model Not Properly Trained ❌

**File:** `tomato_ripeness.h5`
**Issue:** The model file may contain:

- Random/untrained weights
- Only 1 epoch of training
- Biased dataset (more unripe images)

**Symptom:** Model predicts "Unripe" with 99%+ confidence regardless of input

### Error 3: No Validation of Training Data ❌

**File:** `train_ripeness.py` (No checks)
**Issue:** Missing verification that:

- Training directories exist
- Images are actually present
- Class balance is reasonable

---

## 🔧 HOW TO FIX

### STEP 1: Run Diagnostics

```bash
cd E:\TomatoRipenessProject
.\.venv\Scripts\Activate.ps1

python tomato_ai\debug_model.py
```

**Look for:**

- ❌ "Model Not Found" → Need to check file path
- ⚠️ "Model strongly biases toward UNRIPE" → Model is undertrained
- ❌ "Training directory not found" → Need to organize dataset

### STEP 2: Organize Your Dataset

Create this folder structure:

```
E:\TomatoRipenessProject\laravel_app\storage\app\tomato_dataset\
├── training/ripeness/
│   ├── Old/          (Put old/brown tomato images here)
│   ├── Ripe/         (Put ripe/red tomato images here)
│   └── Unripe/       (Put green/unripe tomato images here)
└── validation/ripeness/
    ├── Old/
    ├── Ripe/
    └── Unripe/
```

**Minimum images needed:** 20-30 per category per split (60-90 training + 20-30 validation = ~100 images minimum)

**Recommended:** 50+ images per category per split (150+ training images)

### STEP 3: Retrain the Model

```bash
cd E:\TomatoRipenessProject\tomato_ai

python train_ripeness.py
```

**What to expect:**

- Training should take 2-5 minutes
- Output shows: "✅ Ripeness model saved correctly"
- New `tomato_ripeness.h5` file (10-20 MB)

**If training fails:**

- Check image formats (must be .jpg, .jpeg, or .png)
- Remove corrupted image files
- Ensure images are actually photos (not screenshots)

### STEP 4: Verify the Fix

```bash
python debug_model.py
```

**Expected output:**

```
4️⃣  Testing with random image...
   Predictions:
   - Old:    0.2500 (25.00%)
   - Ripe:   0.3500 (35.00%)
   - Unripe: 0.4000 (40.00%)
   Argmax: Unripe (index 2)
   ✅ Predictions are balanced (not all going to one class)
```

### STEP 5: Test the Web App

1. Start Laravel app:

   ```bash
   cd laravel_app
   php artisan serve
   ```

2. Visit: `http://localhost:8000`

3. Upload test images:
   - Unripe tomato → Should show "Unripe" with ~40-60% confidence
   - Ripe tomato → Should show "Ripe" with ~40-60% confidence
   - Old tomato → Should show "Old" with ~40-60% confidence

**If ALL images still show "Unripe":**

- Model is still undertrained
- Collect more diverse training images
- Retrain with more epochs: Edit `train_ripeness.py` line 7: `EPOCHS = 50` (or higher)

---

## 🎯 COMMON ISSUES & SOLUTIONS

### Issue 1: "ModuleNotFoundError: No module named 'tensorflow'"

**Solution:**

```bash
.\.venv\Scripts\Activate.ps1
pip install tensorflow
```

### Issue 2: "Failed to detect ripeness" in web app

**Solution:**

1. Check Laravel logs: `storage/logs/laravel.log`
2. Run debug script: `python debug_model.py`
3. Verify Python path is correct in `TomatoController.php`

### Issue 3: Model accuracy is low (50-60%)

**Solution:**

- Retrain with more images (100+ per category minimum)
- Try different preprocessing in `predict_ripeness.py`:
  ```python
  # Current: just resize and rescale
  # Better: Add data augmentation to training
  ```

### Issue 4: Images uploaded but say "not a tomato"

**Solution:**

- Check if `tomato_detector.h5` is properly trained
- Run: `python debug_detector.py` (if it exists)
- Verify tomato images actually contain visible tomatoes

---

## ✅ VERIFICATION CHECKLIST

- [ ] Training directory created with Old/Ripe/Unripe folders
- [ ] At least 20+ images in each training folder
- [ ] At least 20+ images in each validation folder
- [ ] `python train_ripeness.py` completed successfully
- [ ] `debug_model.py` shows balanced predictions (not all "Unripe")
- [ ] Web app accepts tomato images without errors
- [ ] Different ripeness levels give different predictions
- [ ] Confidence scores are not 99%+ (indicates overfit/untrained)

---

## 📞 IF STILL BROKEN

1. **Share the output of:**

   ```bash
   python debug_model.py
   ```

2. **Check model file size:**

   ```powershell
   (Get-Item tomato_ai/tomato_ripeness.h5).Length / 1MB
   ```

   - Should be 15-30 MB
   - If < 5 MB → Model is corrupted/untrained

3. **Check training data:**

   ```powershell
   Get-ChildItem laravel_app\storage\app\tomato_dataset\training\ripeness -Recurse -Filter *.jpg | Measure-Object
   ```

   - Should show 60+ objects

4. **Enable verbose logging in predict_ripeness.py:**
   - Uncomment line: `# print(f"DEBUG - All predictions: Old={pred[0]:.4f}...`
   - This will show raw predictions

---

## 🚀 SUMMARY

| Component              | Status                 | Fix Required          |
| ---------------------- | ---------------------- | --------------------- |
| Class ordering in code | ✅ Correct             | No                    |
| Model file existence   | ❓ Unknown             | Check debug output    |
| Model training         | ❌ Likely undertrained | Retrain with dataset  |
| Dataset organization   | ❓ Unknown             | Create proper folders |
| Prediction bias        | ❌ All "Unripe"        | Retrain model         |

**Main Fix:** Collect images → Organize in folders → Run `train_ripeness.py` → Test web app

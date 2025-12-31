# 🚀 GitHub Upload Guide

## Quick Steps to Upload Your Project to GitHub

### 1. Create a GitHub Repository

1. Go to [GitHub](https://github.com) and sign in
2. Click the "+" icon in the top right and select "New repository"
3. Fill in repository details:
   - **Repository name**: `TomatoHealthMonitor` or `TomatoRipenessProject`
   - **Description**: "AI-powered tomato disease detection and ripeness assessment system"
   - **Visibility**: Public or Private
   - **DO NOT** initialize with README (we already have one)
4. Click "Create repository"

### 2. Initialize Git (if not already initialized)

Open terminal/command prompt in your project folder:

```bash
cd E:\TomatoRipenessProject

# Initialize git repository
git init

# Add all files to staging
git add .

# Create initial commit
git commit -m "Initial commit: Tomato Health Monitor with disease detection and ripeness assessment"
```

### 3. Connect to GitHub Repository

```bash
# Add remote origin
git remote add origin https://github.com/Anjanaaberathna01/TomatoRipenessProject.git

# Verify remote was added
git remote -v
```

### 4. Push to GitHub

```bash
# Push to main branch
git branch -M main
git push -u origin main
```

### 5. Verify Upload

1. Go to your GitHub repository URL
2. Refresh the page
3. You should see all your files uploaded!

---

## 📝 Before Uploading - Important Steps

### Remove Sensitive Data

Make sure these are in `.gitignore`:

- ✅ `.env` file (Laravel environment variables)
- ✅ `vendor/` folder (PHP dependencies)
- ✅ `node_modules/` folder (JavaScript dependencies)
- ✅ `.venv/` folder (Python virtual environment)
- ✅ Large model files (optional - see below)

### Handle Large Model Files

Your `.h5` model files are large. You have two options:

#### Option 1: Exclude models from repository (Recommended)

Models are already in `.gitignore`. Users will need to:

- Train their own models using provided scripts
- Or download pre-trained models from a separate location

#### Option 2: Use Git LFS for large files

```bash
# Install Git LFS
git lfs install

# Track .h5 files
git lfs track "*.h5"

# Add .gitattributes
git add .gitattributes

# Commit and push
git commit -m "Add Git LFS tracking for model files"
git push
```

---

## 🔄 Update Your README

✅ **Already Updated!** The README.md has been configured with:

1. **Repository URL**: `https://github.com/Anjanaaberathna01/TomatoRipenessProject`

2. **Contact Information**:

   - **Email**: anjanaaberathna01@gmail.com
   - **GitHub**: [@Anjanaaberathna01](https://github.com/Anjanaaberathna01)

3. **Badge URLs**: All badges updated with correct username

---

## 📦 What's Included

Files created for GitHub:

- ✅ `README.md` - Comprehensive project documentation
- ✅ `.gitignore` - Files to exclude from repository
- ✅ `LICENSE` - MIT License
- ✅ `requirements.txt` - Python dependencies
- ✅ `GITHUB_UPLOAD_GUIDE.md` - This file

---

## 🎯 After Upload

### Add Topics/Tags

On your GitHub repository page:

1. Click "⚙️ Settings"
2. Under "Topics", add relevant tags:
   - `machine-learning`
   - `deep-learning`
   - `tensorflow`
   - `laravel`
   - `agriculture`
   - `disease-detection`
   - `image-classification`
   - `plant-disease`
   - `computer-vision`

### Add Repository Description

Add a short description:
"🍅 AI-powered web application for tomato disease detection and ripeness assessment using deep learning"

### Enable GitHub Pages (Optional)

If you want to showcase your project documentation:

1. Go to Settings → Pages
2. Select source branch
3. Your documentation will be available at a GitHub Pages URL

---

## 🔐 Security Notes

### Never commit:

- ❌ Database passwords
- ❌ API keys
- ❌ `.env` files
- ❌ Private credentials

### Always check:

- ✅ `.gitignore` is properly configured
- ✅ Sensitive data is excluded
- ✅ Environment variables are documented but not included

---

## 📞 Need Help?

If you encounter issues:

1. **Remote already exists**:

   ```bash
   git remote remove origin
   git remote add origin YOUR_NEW_URL
   ```

2. **Rejected push**:

   ```bash
   git pull origin main --allow-unrelated-histories
   git push origin main
   ```

3. **Large file error**:
   - Use Git LFS (see above)
   - Or exclude large files from repository

---

## ✅ Final Checklist

Before pushing:

- [ ] Updated README.md with your information
- [ ] Removed `.env` file from tracking
- [ ] Checked `.gitignore` is working
- [ ] Tested that project structure is correct
- [ ] Added LICENSE file
- [ ] Created meaningful commit message
- [ ] Verified no sensitive data is included

---

**Your project is ready for GitHub! 🎉**

After uploading, share your repository link with the community!

@extends('layouts.app')

@section('content')
<style>
    .prevent-wrapper {
        background-color: #f9f9f9;
        padding: 60px 20px;
        min-height: 100vh;
    }

    .page-header {
        max-width: 1200px;
        margin: 0 auto 60px;
        text-align: center;
    }

    .page-header h1 {
        font-size: 2.5rem;
        color: #1f2937;
        margin: 0 0 15px 0;
        font-weight: 700;
    }

    .page-header p {
        font-size: 1.1rem;
        color: #6b7280;
        margin: 0;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .prevention-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .disease-section {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        transition: box-shadow 0.3s ease;
    }

    .disease-section:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .section-content {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 0;
    }

    .section-image {
        width: 100%;
        height: 280px;
        object-fit: cover;
        background: #f0f0f0;
    }

    .section-body {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 15px 0;
    }

    .section-description {
        color: #6b7280;
        font-size: 1rem;
        line-height: 1.6;
        margin: 0 0 25px 0;
    }

    .symptoms-box, .prevention-box {
        background: #f3f4f6;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .box-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 12px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .symptoms-box .box-title::before {
        content: "🔍";
    }

    .prevention-box .box-title::before {
        content: "🛡";
    }

    .box-list {
        margin: 0;
        padding-left: 20px;
        color: #4b5563;
        font-size: 0.95rem;
    }

    .box-list li {
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .healthy-section {
        background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
    }

    .healthy-section .section-title {
        color: #059669;
    }

    .healthy-section .box-title::before {
        content: "✅";
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .section-content {
            grid-template-columns: 1fr;
        }

        .section-image {
            height: 200px;
        }

        .section-body {
            padding: 25px;
        }

        .section-title {
            font-size: 1.4rem;
        }
    }
</style>

<div class="prevent-wrapper">
    <div class="page-header">
        <h1>🍅 Learn & Prevent Diseases</h1>
        <p>Explore disease information and effective prevention strategies</p>
    </div>

    <div class="prevention-container">
        <!-- Early Blight -->
        <div class="disease-section">
            <div class="section-content">
                <img src="{{ asset('assets/tomato-early-blight.jpg') }}" alt="Early Blight" class="section-image">
                <div class="section-body">
                    <h3 class="section-title">Early Blight</h3>
                    <p class="section-description">
                        A fungal disease that primarily affects lower leaves and spreads upward, causing circular lesions with distinctive concentric rings that resemble a target pattern.
                    </p>
                    <div class="symptoms-box">
                        <div class="box-title">Symptoms</div>
                        <ul class="box-list">
                            <li>Circular brown spots with concentric rings</li>
                            <li>Yellowing around lesions</li>
                            <li>Progressive lower leaf defoliation</li>
                            <li>May affect stems and fruit</li>
                        </ul>
                    </div>
                    <div class="prevention-box">
                        <div class="box-title">Prevention Tips</div>
                        <ul class="box-list">
                            <li>Remove infected leaves immediately</li>
                            <li>Avoid overhead watering - water at soil level</li>
                            <li>Ensure proper plant spacing for air circulation</li>
                            <li>Apply fungicides preventatively in humid conditions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Late Blight -->
        <div class="disease-section">
            <div class="section-content">
                <img src="{{ asset('assets/tomato-late-blight.jpg') }}" alt="Late Blight" class="section-image">
                <div class="section-body">
                    <h3 class="section-title">Late Blight</h3>
                    <p class="section-description">
                        A highly destructive fungal disease that causes water-soaked lesions on leaves and stems. It spreads rapidly in cool, wet conditions and can devastate entire crops quickly.
                    </p>
                    <div class="symptoms-box">
                        <div class="box-title">Symptoms</div>
                        <ul class="box-list">
                            <li>Water-soaked lesions on leaves and stems</li>
                            <li>White fungal growth on leaf undersides</li>
                            <li>Rapid leaf wilting and collapse</li>
                            <li>Stem rot and fruit decay</li>
                        </ul>
                    </div>
                    <div class="prevention-box">
                        <div class="box-title">Prevention Tips</div>
                        <ul class="box-list">
                            <li>Use disease-resistant tomato varieties</li>
                            <li>Ensure proper plant spacing and pruning</li>
                            <li>Water early morning at soil level only</li>
                            <li>Remove infected plants immediately to prevent spread</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaf Mold -->
        <div class="disease-section">
            <div class="section-content">
                <img src="{{ asset('assets/leaf_mold.jpg') }}" alt="Leaf Mold" class="section-image">
                <div class="section-body">
                    <h3 class="section-title">Leaf Mold</h3>
                    <p class="section-description">
                        A fungal disease common in greenhouses and high humidity environments. It affects the undersides of leaves, causing yellowing on the upper surface and fungal growth below.
                    </p>
                    <div class="symptoms-box">
                        <div class="box-title">Symptoms</div>
                        <ul class="box-list">
                            <li>Yellow patches on upper leaf surface</li>
                            <li>Gray-green or olive-brown mold on leaf undersides</li>
                            <li>Leaf curling and distortion</li>
                            <li>Premature leaf drop in severe cases</li>
                        </ul>
                    </div>
                    <div class="prevention-box">
                        <div class="box-title">Prevention Tips</div>
                        <ul class="box-list">
                            <li>Improve air circulation with fans and proper spacing</li>
                            <li>Reduce humidity by ventilating greenhouses</li>
                            <li>Remove infected leaves promptly</li>
                            <li>Apply fungicides if necessary</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Septoria Leaf Spot -->
        <div class="disease-section">
            <div class="section-content">
                <img src="{{ asset('assets/tomato-septoria-leaf-spot.jpg') }}" alt="Septoria Leaf Spot" class="section-image">
                <div class="section-body">
                    <h3 class="section-title">Septoria Leaf Spot</h3>
                    <p class="section-description">
                        A fungal disease creating small circular lesions with dark borders and tan centers. The lesions contain small black speck-like bodies visible with a magnifying glass.
                    </p>
                    <div class="symptoms-box">
                        <div class="box-title">Symptoms</div>
                        <ul class="box-list">
                            <li>Small circular lesions (about 1/8 inch)</li>
                            <li>Dark borders with tan or gray centers</li>
                            <li>Black fruiting bodies (pycnidia) in lesion centers</li>
                            <li>Leaf yellowing and dropping</li>
                        </ul>
                    </div>
                    <div class="prevention-box">
                        <div class="box-title">Prevention Tips</div>
                        <ul class="box-list">
                            <li>Remove infected leaves and debris</li>
                            <li>Avoid overhead irrigation</li>
                            <li>Maintain good air circulation</li>
                            <li>Use disease-resistant varieties when available</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Healthy Plant -->
        <div class="disease-section healthy-section">
            <div class="section-content">
                <img src="{{ asset('assets/Healthy_tomato.jpg') }}" alt="Healthy Tomato Plant" class="section-image">
                <div class="section-body">
                    <h3 class="section-title">Healthy Tomato Plant</h3>
                    <p class="section-description">
                        A healthy tomato plant has vibrant green leaves, strong stems, and shows no signs of disease. Regular monitoring and proper care are essential for maintaining plant health.
                    </p>
                    <div class="prevention-box">
                        <div class="box-title">Best Practices</div>
                        <ul class="box-list">
                            <li>Water regularly at soil level (1-2 inches per week)</li>
                            <li>Use balanced fertilizers and follow feeding schedules</li>
                            <li>Monitor plants weekly for early disease signs</li>
                            <li>Remove weeds and maintain clean growing area</li>
                            <li>Provide adequate support and proper pruning</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
<style>
    .browse-wrapper {
        background-color: #f9f9f9;
        padding: 60px 20px;
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

    .diseases-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        padding: 0 20px;
    }

    .disease-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .disease-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .disease-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        background: #f0f0f0;
    }

    .disease-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .disease-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 15px 0;
        line-height: 1.3;
    }

    .disease-description {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0 0 15px 0;
        flex: 1;
    }

    .disease-symptoms {
        background: #f3f4f6;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
        font-size: 0.85rem;
    }

    .disease-symptoms strong {
        color: #1f2937;
        display: block;
        margin-bottom: 8px;
    }

    .disease-symptoms ul {
        margin: 0;
        padding-left: 20px;
        color: #4b5563;
    }

    .disease-symptoms li {
        margin-bottom: 5px;
    }

    .disease-badge {
        display: inline-block;
        background: #dc2626;
        color: white;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .disease-badge.moderate {
        background: #f59e0b;
    }

    .disease-badge.mild {
        background: #10b981;
    }

    .learn-more-btn {
        background: #1a531b;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        border: none;
        cursor: pointer;
        transition: background 0.3s ease;
        font-size: 0.95rem;
    }

    .learn-more-btn:hover {
        background: #0d3810;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .diseases-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="browse-wrapper">
    <div class="page-header">
        <h1>🍅 Tomato Disease Guide</h1>
        <p>Learn about different tomato plant diseases to identify and prevent them early</p>
    </div>

    <div class="diseases-grid">
        <!-- Bacterial Spot -->
        <div class="disease-card">
            <img src="{{ asset('assets/tomato_bacterial.jpg') }}" alt="Bacterial Spot" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge">Critical</span>
                <h3 class="disease-title">Bacterial Spot</h3>
                <p class="disease-description">
                    A severe bacterial disease that causes dark, water-soaked lesions on leaves, stems, and fruit. Spreads rapidly in warm, wet conditions.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Dark, greasy lesions on leaves</li>
                        <li>Yellow halo around spots</li>
                        <li>Fruit spots with raised edges</li>
                        <li>Premature leaf drop</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>

        <!-- Early Blight -->
        <div class="disease-card">
            <img src="{{ asset('assets/tomato-early-blight.jpg') }}" alt="Early Blight" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge">Critical</span>
                <h3 class="disease-title">Early Blight</h3>
                <p class="disease-description">
                    A fungal infection that starts on lower leaves and spreads upward, causing circular lesions with concentric rings. Common in humid conditions.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Circular brown spots with rings</li>
                        <li>Target-like appearance</li>
                        <li>Yellowing around lesions</li>
                        <li>Lower leaf defoliation</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>

        <!-- Late Blight -->
        <div class="disease-card">
            <img src="{{ asset('assets/tomato-late-blight.jpg') }}" alt="Late Blight" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge">Critical</span>
                <h3 class="disease-title">Late Blight</h3>
                <p class="disease-description">
                    A highly destructive fungal disease that causes water-soaked lesions on leaves and stems. Can destroy entire crops in cool, wet weather.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Water-soaked lesions on leaves</li>
                        <li>White mold on leaf undersides</li>
                        <li>Stem rot and collapse</li>
                        <li>Rapid spread in cool weather</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>

        <!-- Leaf Mold -->
        <div class="disease-card">
            <img src="{{ asset('assets/leaf_mold.jpg') }}" alt="Leaf Mold" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge moderate">Moderate</span>
                <h3 class="disease-title">Leaf Mold</h3>
                <p class="disease-description">
                    A fungal disease that affects leaf undersides, causing yellowing on the upper surface. Common in greenhouses and high humidity environments.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Yellow patches on leaf tops</li>
                        <li>Gray-brown mold on undersides</li>
                        <li>Leaf curling and distortion</li>
                        <li>Defoliation in severe cases</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>

        <!-- Septoria Leaf Spot -->
        <div class="disease-card">
            <img src="{{ asset('assets/tomato-septoria-leaf-spot.jpg') }}" alt="Septoria Leaf Spot" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge moderate">Moderate</span>
                <h3 class="disease-title">Septoria Leaf Spot</h3>
                <p class="disease-description">
                    A fungal disease that creates small circular lesions with dark borders and tan centers. Often shows a speck pattern on affected leaves.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Small circular lesions</li>
                        <li>Dark borders with tan centers</li>
                        <li>Black speck-like bodies</li>
                        <li>Leaf yellowing and dropping</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>

        <!-- Spider Mites -->
        <div class="disease-card">
            <img src="{{ asset('assets/Spider_Mites.jpg') }}" alt="Spider Mites" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge moderate">Moderate</span>
                <h3 class="disease-title">Spider Mites</h3>
                <p class="disease-description">
                    Tiny pest mites that feed on leaf sap, causing stippled, yellowing leaves. More common in hot, dry conditions and greenhouse environments.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Fine stippling on leaves</li>
                        <li>Yellowing leaves</li>
                        <li>Fine webbing on plants</li>
                        <li>Leaf curling and drop</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>

        <!-- Target Spot -->
        <div class="disease-card">
            <img src="{{ asset('assets/target_spot.jpg') }}" alt="Target Spot" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge moderate">Moderate</span>
                <h3 class="disease-title">Target Spot</h3>
                <p class="disease-description">
                    A fungal disease creating lesions with concentric rings, resembling a target pattern. Spreads in warm, wet conditions with overhead irrigation.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Target-shaped lesions</li>
                        <li>Concentric rings pattern</li>
                        <li>Dark center surrounded by rings</li>
                        <li>Affects all foliage levels</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>

        <!-- Tomato Mosaic Virus -->
        <div class="disease-card">
            <img src="{{ asset('assets/tobacco-mosaic-virus.jpg') }}" alt="Tomato Mosaic Virus" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge">Critical</span>
                <h3 class="disease-title">Tomato Mosaic Virus</h3>
                <p class="disease-description">
                    A viral disease causing mottled, distorted leaves with mosaic patterns. Transmitted by contact, tools, and infected plants. No cure available.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Mottled leaf colors</li>
                        <li>Mosaic patterns</li>
                        <li>Leaf distortion and curling</li>
                        <li>Stunted plant growth</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>

        <!-- Yellow Leaf Curl Virus -->
        <div class="disease-card">
            <img src="{{ asset('assets/Yellow_Leaf_Curl_Virus.JPG') }}" alt="Yellow Leaf Curl Virus" class="disease-image">
            <div class="disease-content">
                <span class="disease-badge">Critical</span>
                <h3 class="disease-title">Yellow Leaf Curl Virus</h3>
                <p class="disease-description">
                    A viral disease causing leaves to yellow, curl upward, and become brittle. Transmitted by whiteflies, it severely reduces fruit production.
                </p>
                <div class="disease-symptoms">
                    <strong>Symptoms:</strong>
                    <ul>
                        <li>Leaf yellowing</li>
                        <li>Upward leaf curling</li>
                        <li>Brittle, reduced foliage</li>
                        <li>Severe growth reduction</li>
                    </ul>
                </div>
                <a href="{{ route('tomato.diagnose.page') }}" class="learn-more-btn">Upload to Diagnose</a>
            </div>
        </div>
    </div>
</div>

@endsection

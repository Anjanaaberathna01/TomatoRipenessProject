@extends('layouts.app')

@section('content')
<style>
    .about-wrapper {
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

    .content-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .hero-section {
        background: linear-gradient(135deg, #1a531b 0%, #2c5f2d 100%);
        color: white;
        padding: 60px 40px;
        border-radius: 12px;
        margin-bottom: 50px;
        box-shadow: 0 8px 30px rgba(26, 83, 27, 0.2);
    }

    .hero-section h2 {
        font-size: 2rem;
        margin: 0 0 20px 0;
        font-weight: 700;
    }

    .hero-section p {
        font-size: 1.1rem;
        line-height: 1.8;
        margin: 0;
        opacity: 0.95;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .feature-box {
        background: white;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .feature-box h3 {
        font-size: 1.3rem;
        color: #1f2937;
        margin: 0 0 15px 0;
        font-weight: 700;
    }

    .feature-box p {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    .mission-section {
        background: white;
        padding: 50px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 50px;
    }

    .mission-section h2 {
        font-size: 2rem;
        color: #1f2937;
        margin: 0 0 30px 0;
        font-weight: 700;
        text-align: center;
    }

    .mission-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }

    .mission-text h3 {
        font-size: 1.4rem;
        color: #1a531b;
        margin: 20px 0 15px 0;
        font-weight: 700;
    }

    .mission-text p {
        color: #6b7280;
        font-size: 1rem;
        line-height: 1.8;
        margin: 0 0 15px 0;
    }

    .mission-text ul {
        margin: 15px 0;
        padding-left: 25px;
        color: #6b7280;
    }

    .mission-text li {
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .technology-section {
        background: white;
        padding: 50px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 50px;
    }

    .technology-section h2 {
        font-size: 2rem;
        color: #1f2937;
        margin: 0 0 40px 0;
        font-weight: 700;
        text-align: center;
    }

    .tech-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .tech-item {
        background: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        border-left: 4px solid #1a531b;
    }

    .tech-item h4 {
        color: #1a531b;
        margin: 0 0 10px 0;
        font-weight: 700;
    }

    .tech-item p {
        color: #6b7280;
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.6;
    }

    .team-section {
        background: white;
        padding: 50px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 50px;
    }

    .team-section h2 {
        font-size: 2rem;
        color: #1f2937;
        margin: 0 0 40px 0;
        font-weight: 700;
        text-align: center;
    }

    .team-content {
        text-align: center;
        color: #6b7280;
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .cta-section {
        background: linear-gradient(135deg, #1a531b 0%, #2c5f2d 100%);
        color: white;
        padding: 60px 40px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 8px 30px rgba(26, 83, 27, 0.2);
    }

    .cta-section h2 {
        font-size: 2rem;
        margin: 0 0 20px 0;
        font-weight: 700;
    }

    .cta-section p {
        font-size: 1.1rem;
        margin: 0 0 30px 0;
        opacity: 0.95;
    }

    .cta-btn {
        display: inline-block;
        background: white;
        color: #1a531b;
        padding: 14px 40px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 700;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        font-size: 1rem;
    }

    .cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .hero-section {
            padding: 40px 25px;
        }

        .hero-section h2 {
            font-size: 1.5rem;
        }

        .mission-content {
            grid-template-columns: 1fr;
        }

        .mission-section,
        .technology-section,
        .team-section {
            padding: 30px;
        }

        .cta-section {
            padding: 40px 25px;
        }
    }
</style>

<div class="about-wrapper">
    <div class="page-header">
        <h1>🍅 About Tomato Health Monitor</h1>
        <p>Empowering farmers with AI-driven plant disease detection and ripeness assessment</p>
    </div>

    <div class="content-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h2>Our Vision</h2>
            <p>
                We are committed to revolutionizing tomato farming through artificial intelligence.
                Our platform helps farmers detect diseases early, assess fruit ripeness accurately,
                and make informed decisions to maximize their harvests and minimize losses.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-icon">🤖</div>
                <h3>AI-Powered Detection</h3>
                <p>
                    Advanced machine learning models trained on thousands of images
                    to accurately identify tomato diseases and ripeness stages.
                </p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">⚡</div>
                <h3>Instant Results</h3>
                <p>
                    Get disease diagnosis and ripeness assessment in seconds.
                    No waiting, just quick and reliable results.
                </p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">📚</div>
                <h3>Educational Resources</h3>
                <p>
                    Learn about diseases, prevention tips, and best practices
                    to keep your tomato plants healthy.
                </p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">🎯</div>
                <h3>Accurate Classification</h3>
                <p>
                    Identifies 9 different tomato diseases plus healthy plants.
                    Also assesses ripeness in three categories.
                </p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">📱</div>
                <h3>Easy to Use</h3>
                <p>
                    Simple, intuitive interface. Just upload a photo and get
                    instant analysis results.
                </p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">🔒</div>
                <h3>Reliable & Secure</h3>
                <p>
                    Built with proven technologies and best practices to ensure
                    accuracy and data security.
                </p>
            </div>
        </div>

        <!-- Mission & Goals Section -->
        <div class="mission-section">
            <h2>Our Mission</h2>
            <div class="mission-content">
                <div class="mission-text">
                    <h3>🌱 Empower Farmers</h3>
                    <p>
                        We believe that every farmer, whether small-scale or commercial,
                        deserves access to advanced tools for crop management. Our platform
                        democratizes AI technology to help farmers make better decisions.
                    </p>

                    <h3>🔍 Early Detection</h3>
                    <p>
                        Early disease detection can save entire harvests. By identifying
                        problems at their earliest stage, farmers can take preventive action
                        before significant damage occurs.
                    </p>

                    <h3>📈 Increase Productivity</h3>
                    <p>
                        With accurate ripeness assessment and disease monitoring, farmers
                        can optimize harvest timing and reduce crop losses, ultimately
                        increasing productivity and profitability.
                    </p>
                </div>

                <div class="mission-text">
                    <h3>🎓 Knowledge Sharing</h3>
                    <p>
                        We provide comprehensive guides about tomato diseases, their symptoms,
                        and prevention strategies. Education is key to sustainable farming.
                    </p>

                    <h3>🌍 Sustainable Agriculture</h3>
                    <p>
                        By helping farmers reduce unnecessary pesticide use through accurate
                        disease detection, we promote sustainable and environmentally friendly
                        farming practices.
                    </p>

                    <h3>💡 Continuous Improvement</h3>
                    <p>
                        Our models are continuously trained with new data to improve accuracy.
                        We're committed to staying at the forefront of agricultural AI technology.
                    </p>
                </div>
            </div>
        </div>

        <!-- Technology Section -->
        <div class="technology-section">
            <h2>Our Technology</h2>
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>🧠 Deep Learning</h4>
                    <p>
                        Uses convolutional neural networks (CNNs) trained on extensive
                        tomato plant datasets for accurate image classification.
                    </p>
                </div>

                <div class="tech-item">
                    <h4>🏗️ MobileNetV2</h4>
                    <p>
                        Efficient neural network architecture optimized for mobile
                        devices and real-time predictions.
                    </p>
                </div>

                <div class="tech-item">
                    <h4>⚙️ TensorFlow</h4>
                    <p>
                        Industry-leading machine learning framework for building
                        and training our AI models.
                    </p>
                </div>

                <div class="tech-item">
                    <h4>🐍 Python Backend</h4>
                    <p>
                        Robust Python-based backend for model inference and data processing,
                        ensuring reliability and performance.
                    </p>
                </div>

                <div class="tech-item">
                    <h4>🔗 Laravel Framework</h4>
                    <p>
                        Modern PHP framework providing secure, scalable web application
                        architecture and user experience.
                    </p>
                </div>

                <div class="tech-item">
                    <h4>💾 Data Management</h4>
                    <p>
                        Efficient database systems and file storage for managing
                        uploaded images and analysis results.
                    </p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="team-section">
            <h2>Our Team</h2>
            <div class="team-content">
                <p>
                    Tomato Health Monitor is developed by a dedicated team of software engineers,
                    data scientists, and agricultural experts. We're passionate about combining
                    technology with agriculture to solve real-world problems.
                </p>
                <p style="margin-top: 20px;">
                    <strong>Our expertise spans:</strong>
                </p>
                <p>
                    Artificial Intelligence • Web Development • Agricultural Science • Data Analysis •
                    Image Processing • Software Architecture
                </p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <h2>Ready to Transform Your Farming?</h2>
            <p>Start using Tomato Health Monitor today to detect diseases early and assess ripeness accurately.</p>
            <a href="{{ route('upload') }}" class="cta-btn">Start Analyzing Now</a>
        </div>
    </div>
</div>

@endsection

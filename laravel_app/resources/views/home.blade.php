@extends('layouts.app')

@section('content')
<style>
    .home-wrapper { background-color: #f9f9f9; padding-bottom: 60px; }

    /* Hero Image Split */
    .hero-container {
        display: flex;
        width: 100%;
        height: 400px;
        gap: 10px;
        padding: 10px;
        background: white;
    }

    .hero-box {
        flex: 1;
        background-size: cover;
        background-position: center;
        border-radius: 4px;
    }

    /* Hero Text Content */
    .hero-text-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hero-title-area h1 {
        font-size: 2.2rem;
        color: #333;
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .hero-title-area p {
        color: #777;
        font-size: 1rem;
    }

    .get-started-btn {
        background: #1a531b;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Feature Grid */
    .features-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 0 20px;
    }

    .feature-card {
        background: white;
        padding: 40px 30px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .feature-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        margin: 0 auto 20px;
        color: #4CAF50;
    }

    .feature-card h3 {
        font-size: 1.25rem;
        margin-bottom: 15px;
        color: #333;
    }

    .feature-card p {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .hero-container { height: 250px; flex-direction: column; }
        .hero-text-section { flex-direction: column; text-align: center; gap: 30px; }
        .features-grid { grid-template-columns: 1fr; }
        .hero-title-area h1 { font-size: 1.8rem; }
    }
</style>

<div class="home-wrapper">
    <div class="hero-container">
        <div class="hero-box" style="background-image: url('https://images.unsplash.com/photo-1592841200221-a6898f307baa?auto=format&fit=crop&w=800&q=80');"></div>
        <div class="hero-box" style="background-image: url('https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&w=800&q=80');"></div>
    </div>

    <div class="hero-text-section">
        <div class="hero-title-area">
            <h1>Early Detection for<br>Healthier Harvests</h1>
            <p>Identify tomato plant diseases instantly using AI</p>
        </div>
        <a href="{{ route('upload') }}" class="get-started-btn">
            Get Started <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v12H4V4zm2 2v8h12V6H6zm3 3h2v2H9V9zm4 0h2v2h-2V9z"></path></svg>
        </a>
    </div>

    <div class="features-grid">
        <a href="{{ route('upload') }}" class="feature-link">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"></path></svg>
                </div>
                <h3>Upload & Analyze</h3>
                <p>Quickly upload photos of tomato plants for analysis</p>
            </div>
        </a>

        <a href="{{ route('tomato.diagnose.page') }}" class="feature-link">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                </div>
                <h3>Instant Diagnosis</h3>
                <p>Receive immediate feedback on potential diseases</p>
            </div>
        </a>

        <div class="feature-card">
            <div class="feature-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path></svg>
            </div>
            <h3>Learn & Prevent</h3>
            <p>Explore disease information and prevention tips</p>
        </div>
    </div>
</div>
@endsection

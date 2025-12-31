<style>
    .navbar {
        background: white; /* Matching the white header in the image */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
        padding: 15px 0;
    }

    .nav-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .nav-logo-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        gap: 10px;
        color: #1a531b; /* Dark green from logo */
        font-weight: 700;
        font-size: 1.4rem;
    }

    .logo-img { height: 40px; width: auto; }

    .nav-items {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .nav-link {
        text-decoration: none;
        color: #555;
        font-size: 0.95rem;
        font-weight: 500;
        transition: color 0.3s;
    }

    .nav-link:hover { color: #2c5f2d; }

    .login-btn {
        background: #1a531b;
        color: white;
        padding: 10px 25px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        transition: opacity 0.3s;
    }

    .nav-toggle {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        flex-direction: column;
        gap: 5px;
    }

    .nav-toggle span {
        width: 25px;
        height: 3px;
        background: #1a531b;
        border-radius: 2px;
    }

    /* Mobile Responsive Nav */
    @media (max-width: 992px) {
        .nav-toggle { display: flex; }
        .nav-items {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .nav-items.active { display: flex; }
    }
</style>

<nav class="navbar">
    <div class="nav-container">
        <a href="{{ url('/') }}" class="nav-logo-link">
            <img src="{{ asset('logo/logo.png') }}" class="logo-img" alt="Logo">
            <span>Tomato Health Monitor</span>
        </a>

        <button class="nav-toggle" id="navToggle">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-items" id="navItems">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
            <a href="#" class="nav-link">Upload Image</a>
            <a href="#" class="nav-link">Browse Diseases</a>
            <a href="#" class="nav-link">About Us</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="login-btn">Dashboard</a>
            @else
                <a href="{{ url('/login') }}" class="login-btn">Log In</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navToggle = document.getElementById('navToggle');
        const navItems = document.getElementById('navItems');
        navToggle.addEventListener('click', () => navItems.classList.toggle('active'));
    });
</script>

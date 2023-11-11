<style>
    .navbar-brand {
        display: flex;
        align-items: center;
    }

    .navbar-brand img {
        margin-right: 10px;
        /* Atur margin kanan sesuai kebutuhan */
    }
</style>

<div id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<div class="container-fluid sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark p-0">
            <a href="#home" class="navbar-brand">
                <img class="img-fluid" src="img/logo-01.png" style="width: 40px; height: 40px">
                <span style="font-weight: 700; font-size: 40px;">GoEstate</span>
            </a>
            <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto">
                    <a href="#home" class="nav-item nav-link">Home</a>
                    <a href="#about-us" class="nav-item nav-link">About</a>
                    <a href="#services" class="nav-item nav-link">Services</a>
                    <a href="#faq" class="nav-item nav-link">FAQs</a>

                    @if (Route::has('login'))
                    @auth
                    <a href="{{ route('home') }}" class="nav-item nav-link">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                    @endauth
                    @endif
                </div>
            </div>
        </nav>
    </div>
</div>
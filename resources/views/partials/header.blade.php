<header>
    <!-- MOBILE OVERLAY (NEW) -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <div class="container header-wrap">
        <!-- LOGO -->
        <div class="logo">
            <img src="{{ asset('assets/images/Logo1.jpg') }}" alt="Vision Logo" class="logo-img">
            <div class="logo-text">VISION</div>
        </div>

        <!-- DESKTOP NAV -->
        <nav class="desktop-nav">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="{{ route('home') }}#path">Path to Fluency</a></li>
                <li><a href="{{ route('home') }}#teachers">Teachers</a></li>
                <li><a href="{{ route('home') }}#courses">Courses</a></li>
                <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
                <li><a href="{{ route('home') }}#vision">Vision</a></li>
            </ul>
        </nav>

        <!-- ACTIONS -->
        <div class="actions">
            <!-- MOBILE MENU BUTTON (NEW) -->
            <button class="mobile-menu" id="menuBtn" aria-label="Open menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <button class="mode-toggle" id="modeBtn" aria-label="Toggle theme">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </div>

    <!-- MOBILE NAV (NEW) -->
    <nav class="mobile-nav" id="mobileNav">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="{{ route('home') }}#path">Path to Fluency</a></li>
            <li><a href="{{ route('home') }}#teachers">Teachers</a></li>
            <li><a href="{{ route('home') }}#courses">Courses</a></li>
            <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
            <li><a href="{{ route('home') }}#vision">Vision</a></li>
        </ul>
    </nav>
</header>


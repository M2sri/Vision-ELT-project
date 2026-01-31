<script>
// =====================
// Dark Mode Toggle
// =====================
const modeToggle = document.querySelector('.mode-toggle');
const body = document.body;

if (modeToggle) {

    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
    const currentTheme = localStorage.getItem('theme');

    if (currentTheme) {
        body.classList.toggle('light', currentTheme === 'light');
    } else {
        body.classList.toggle('light', !prefersDark.matches);
    }

    updateToggleIcon();

    modeToggle.addEventListener('click', () => {
        body.classList.toggle('light');
        const theme = body.classList.contains('light') ? 'light' : 'dark';
        localStorage.setItem('theme', theme);
        updateToggleIcon();
    });

    function updateToggleIcon() {
        const icon = modeToggle.querySelector('i');
        if (!icon) return;

        if (body.classList.contains('light')) {
            icon.className = 'fas fa-moon';
            modeToggle.setAttribute('aria-label', 'Switch to dark mode');
        } else {
            icon.className = 'fas fa-sun';
            modeToggle.setAttribute('aria-label', 'Switch to light mode');
        }
    }
}

// =====================
// Mobile Menu Toggle
// =====================
const mobileMenuBtn = document.querySelector('.mobile-menu');
const mobileOverlay = document.querySelector('.mobile-overlay');
const mobileNav = document.querySelector('.mobile-nav');

if (mobileMenuBtn && mobileOverlay && mobileNav) {

    mobileMenuBtn.addEventListener('click', () => {
        mobileNav.classList.toggle('active');
        mobileOverlay.classList.toggle('active');
        document.body.style.overflow =
            mobileNav.classList.contains('active') ? 'hidden' : '';
    });

    mobileOverlay.addEventListener('click', () => {
        mobileNav.classList.remove('active');
        mobileOverlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    document.querySelectorAll('.mobile-nav a').forEach(link => {
        link.addEventListener('click', () => {
            mobileNav.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    });
}
</script>

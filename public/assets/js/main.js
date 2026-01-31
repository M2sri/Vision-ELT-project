document.addEventListener("DOMContentLoaded", () => {

    /* ==================================================
       ELEMENTS
    ================================================== */
    const header        = document.querySelector("header");
    const html          = document.documentElement;

    const desktopLinks  = document.querySelectorAll(".desktop-nav a");
    const allNavLinks   = document.querySelectorAll(".desktop-nav a, .mobile-nav a");

    const modeToggle    = document.querySelector(".mode-toggle");

    /* MOBILE MENU ELEMENTS */
    const menuBtn       = document.getElementById("menuBtn");
    const mobileNav     = document.getElementById("mobileNav");
    const mobileOverlay = document.getElementById("mobileOverlay");

    /* ==================================================
       THEME TOGGLE
    ================================================== */
    const savedTheme =
        localStorage.getItem("theme") ||
        (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light");

    if (savedTheme === "light") html.classList.add("light");

    function updateThemeIcon() {
        if (!modeToggle) return;
        const icon = modeToggle.querySelector("i");
        icon.className = html.classList.contains("light")
            ? "fas fa-moon"
            : "fas fa-sun";
    }

    if (modeToggle) {
        updateThemeIcon();
        modeToggle.addEventListener("click", () => {
            html.classList.toggle("light");
            localStorage.setItem(
                "theme",
                html.classList.contains("light") ? "light" : "dark"
            );
            updateThemeIcon();
        });
    }

    /* ==================================================
       MOBILE MENU (TOP SLIDE)
    ================================================== */
    function openMenu() {
        menuBtn.classList.add("active");
        mobileNav.classList.add("active");
        mobileOverlay.classList.add("active");
        document.body.style.overflow = "hidden";
    }

    function closeMenu() {
        menuBtn.classList.remove("active");
        mobileNav.classList.remove("active");
        mobileOverlay.classList.remove("active");
        document.body.style.overflow = "";
    }

    if (menuBtn && mobileNav) {
        menuBtn.addEventListener("click", () => {
            mobileNav.classList.contains("active") ? closeMenu() : openMenu();
        });

        mobileOverlay.addEventListener("click", closeMenu);
    }

    /* ==================================================
       SMOOTH SCROLL (DESKTOP + MOBILE)
    ================================================== */
    allNavLinks.forEach(link => {
        link.addEventListener("click", e => {
            const targetId = link.getAttribute("href");
            if (!targetId || !targetId.startsWith("#")) return;

            const target = document.querySelector(targetId);
            if (!target) return;

            e.preventDefault();

            const offset = header.offsetHeight;
            window.scrollTo({
                top: target.offsetTop - offset,
                behavior: "smooth"
            });

            /* Close mobile menu after navigation */
            if (mobileNav?.classList.contains("active")) {
                closeMenu();
            }
        });
    });

    /* ==================================================
       COUNTER ANIMATION
    ================================================== */
    document.querySelectorAll("[data-count]").forEach(counter => {
        const target = +counter.dataset.count;
        let current = 0;
        const step = Math.max(1, Math.floor(target / 60));

        function update() {
            current += step;
            if (current >= target) {
                counter.textContent = target;
            } else {
                counter.textContent = current;
                requestAnimationFrame(update);
            }
        }
        update();
    });

    /* ==================================================
       VISION SECTION ANIMATION
    ================================================== */
    const vision = document.querySelector(".vision-coming");
    if (vision) {
        const visionObserver = new IntersectionObserver(
            ([entry]) => entry.isIntersecting && entry.target.classList.add("visible"),
            { threshold: 0.15 }
        );
        visionObserver.observe(vision);
    }

    /* ==================================================
       PARTICLE RANDOMIZATION
    ================================================== */
    document.querySelectorAll(".particle").forEach(p => {
        p.style.setProperty("--tx", `${Math.random() * 200 - 100}px`);
        p.style.setProperty("--ty", `${Math.random() * 200 - 100}px`);
        p.style.animationDelay = `${Math.random() * 20}s`;
    });

});

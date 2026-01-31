document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.teachers-track');
    const slides = Array.from(track.children);
    const nextBtn = document.querySelector('.slider-btn.next');
    const prevBtn = document.querySelector('.slider-btn.prev');

    if (!track || slides.length === 0) return;

    /* =========================
       CONFIG
    ========================= */
    const CLONES = 2;
    const MOBILE_BREAKPOINT = 768;

    let currentIndex = CLONES;
    let isDragging = false;
    let startX = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let rafId = null;

    /* =========================
       RESPONSIVE
    ========================= */
    function itemsPerView() {
        const w = window.innerWidth;
        if (w <= 768) return 1;
        if (w <= 1024) return 2;
        return 3;
    }

    /* =========================
       CLONE SLIDES (INFINITE)
    ========================= */
    for (let i = 0; i < CLONES; i++) {
        track.appendChild(slides[i].cloneNode(true));
        track.insertBefore(
            slides[slides.length - 1 - i].cloneNode(true),
            track.firstChild
        );
    }

    const allSlides = Array.from(track.children);

    /* =========================
       SLIDER UPDATE
    ========================= */
    function updateSlider(animate = true) {
        const perView = itemsPerView();
        const slideWidth = 100 / perView;

        track.style.transition = animate
            ? 'transform 0.35s cubic-bezier(0.22, 0.61, 0.36, 1)'
            : 'none';

        const offset =
            window.innerWidth <= MOBILE_BREAKPOINT
                ? currentIndex * slideWidth
                : currentIndex * slideWidth - slideWidth * (perView - 1) / 2;

        currentTranslate = -offset;
        prevTranslate = currentTranslate;
        track.style.transform = `translateX(${currentTranslate}%)`;

        allSlides.forEach((slide, i) => {
            slide.classList.toggle(
                'active',
                window.innerWidth <= MOBILE_BREAKPOINT
                    ? Math.abs(i - currentIndex) < 1
                    : i === currentIndex
            );
        });
    }

    /* =========================
       TOUCH / DRAG
    ========================= */
    function getX(e) {
        return e.type.includes('mouse')
            ? e.clientX
            : e.touches[0].clientX;
    }

    function dragStart(e) {
        isDragging = true;
        startX = getX(e);
        track.style.transition = 'none';
        rafId = requestAnimationFrame(dragLoop);
        e.preventDefault();
    }

    function dragMove(e) {
        if (!isDragging) return;
        const diff = (getX(e) - startX) / track.offsetWidth * 100;
        currentTranslate = prevTranslate + diff * 1.15; // resistance
    }

    function dragEnd() {
        if (!isDragging) return;
        isDragging = false;
        cancelAnimationFrame(rafId);

        const moved = currentTranslate - prevTranslate;
        const threshold = window.innerWidth <= MOBILE_BREAKPOINT ? 4 : 6;

        if (moved < -threshold) currentIndex++;
        if (moved > threshold) currentIndex--;

        updateSlider();
    }

    function dragLoop() {
        if (!isDragging) return;
        track.style.transform = `translateX(${currentTranslate}%)`;
        rafId = requestAnimationFrame(dragLoop);
    }

    /* =========================
       EVENTS
    ========================= */
    const isTouch = 'ontouchstart' in window;

    if (!isTouch) {
        track.addEventListener('mousedown', dragStart);
        track.addEventListener('mousemove', dragMove);
        track.addEventListener('mouseup', dragEnd);
        track.addEventListener('mouseleave', dragEnd);
    }

    track.addEventListener('touchstart', dragStart, { passive: false });
    track.addEventListener('touchmove', dragMove, { passive: false });
    track.addEventListener('touchend', dragEnd);

    track.querySelectorAll('img').forEach(img =>
        img.addEventListener('dragstart', e => e.preventDefault())
    );

    nextBtn?.addEventListener('click', () => {
        currentIndex++;
        updateSlider();
    });

    prevBtn?.addEventListener('click', () => {
        currentIndex--;
        updateSlider();
    });

    track.addEventListener('transitionend', () => {
        if (currentIndex >= slides.length + CLONES) {
            currentIndex = CLONES;
            updateSlider(false);
        }
        if (currentIndex < CLONES) {
            currentIndex = slides.length + CLONES - 1;
            updateSlider(false);
        }
    });

    window.addEventListener('resize', () => updateSlider(false));

    /* =========================
       INIT
    ========================= */
    updateSlider(false);

    if (window.innerWidth <= MOBILE_BREAKPOINT && slides.length <= 1) {
        nextBtn?.style.setProperty('display', 'none');
        prevBtn?.style.setProperty('display', 'none');
    }
});

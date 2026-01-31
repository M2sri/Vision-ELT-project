document.addEventListener("DOMContentLoaded", () => {

    const slider = document.querySelector(".gallery-slider");
    const track  = document.querySelector(".gallery-track");
    const slides = Array.from(document.querySelectorAll(".gallery-slide"));
    const nextBtn = slider?.querySelector(".next");
    const prevBtn = slider?.querySelector(".prev");

    if (!track || slides.length === 0) return;

    /* ==================================================
       CONFIG
    ================================================== */
    const TRANSITION = "transform 0.55s cubic-bezier(0.4, 0, 0.2, 1)";
    const DRAG_THRESHOLD = 0.15; // 15% of one slide

    let currentIndex = slides.length;
    let isDragging = false;
    let startX = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let rafId = null;
    let pointerId = null;

    /* ==================================================
       CLONE SLIDES (INFINITE LOOP)
    ================================================== */
    slides.forEach(slide => {
        track.appendChild(slide.cloneNode(true));
        track.insertBefore(slide.cloneNode(true), track.firstChild);
    });

    const allSlides = Array.from(track.children);

    /* ==================================================
       HELPERS
    ================================================== */
    function visibleSlides() {
        if (window.innerWidth <= 768) return 1;
        if (window.innerWidth <= 1024) return 2;
        return 4;
    }

    function slideWidthPercent() {
        return 100 / visibleSlides();
    }

    function setTranslate(value, animate = true) {
        track.style.transition = animate ? TRANSITION : "none";
        track.style.transform = `translate3d(${value}%, 0, 0)`;
    }

    function updatePosition(animate = true) {
        const offset = -(currentIndex * slideWidthPercent());
        currentTranslate = offset;
        prevTranslate = offset;
        setTranslate(offset, animate);
        setActiveSlide();
    }

    function setActiveSlide() {
        allSlides.forEach(slide => slide.classList.remove("active"));
        const centerIndex = currentIndex + Math.floor(visibleSlides() / 2);
        allSlides[centerIndex]?.classList.add("active");
    }

    function getX(e) {
        return e.clientX;
    }

    /* ==================================================
       DRAG LOGIC (POINTER EVENTS)
    ================================================== */
    function dragStart(e) {
        if (e.button && e.button !== 0) return;

        isDragging = true;
        pointerId = e.pointerId;
        startX = getX(e);
        track.setPointerCapture(pointerId);
        track.style.transition = "none";
        track.classList.add("grabbing");

        rafId = requestAnimationFrame(dragLoop);
    }

    function dragMove(e) {
        if (!isDragging || e.pointerId !== pointerId) return;

        const deltaX = getX(e) - startX;
        const percentMove = (deltaX / track.offsetWidth) * 100;
        currentTranslate = prevTranslate + percentMove;
    }

    function dragEnd(e) {
        if (!isDragging || e.pointerId !== pointerId) return;

        isDragging = false;
        cancelAnimationFrame(rafId);
        track.classList.remove("grabbing");
        track.releasePointerCapture(pointerId);

        const moved = currentTranslate - prevTranslate;
        const slideSize = slideWidthPercent();

        if (Math.abs(moved) > slideSize * DRAG_THRESHOLD) {
            currentIndex += moved < 0 ? 1 : -1;
        }

        updatePosition(true);
    }

    function dragLoop() {
        setTranslate(currentTranslate, false);
        if (isDragging) rafId = requestAnimationFrame(dragLoop);
    }

    /* ==================================================
       INFINITE LOOP FIX
    ================================================== */
    track.addEventListener("transitionend", () => {
        if (currentIndex >= allSlides.length - slides.length) {
            currentIndex = slides.length;
            updatePosition(false);
        }

        if (currentIndex < slides.length) {
            currentIndex = allSlides.length - slides.length * 2;
            updatePosition(false);
        }
    });

    /* ==================================================
       CONTROLS
    ================================================== */
    nextBtn?.addEventListener("click", () => {
        currentIndex++;
        updatePosition(true);
    });

    prevBtn?.addEventListener("click", () => {
        currentIndex--;
        updatePosition(true);
    });

    /* ==================================================
       EVENTS
    ================================================== */
    track.addEventListener("pointerdown", dragStart);
    track.addEventListener("pointermove", dragMove);
    track.addEventListener("pointerup", dragEnd);
    track.addEventListener("pointercancel", dragEnd);
    track.addEventListener("pointerleave", dragEnd);

    window.addEventListener("resize", () => {
        updatePosition(false);
    });

    /* ==================================================
       INIT
    ================================================== */
    updatePosition(false);
});

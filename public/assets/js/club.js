document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.club-track');
    const slides = Array.from(document.querySelectorAll('.club-slide'));
    const progressBar = document.querySelector('.progress-fill');
    
    let currentIndex = slides.length; // Start at the first real slide (after clones)
    const slideGap = 24; 
    
    // 1. Clone slides for infinite loop
    const firstClones = slides.slice(0, 3).map(s => s.cloneNode(true));
    const lastClones = slides.slice(-3).map(s => s.cloneNode(true));
    
    lastClones.reverse().forEach(clone => track.prepend(clone));
    firstClones.forEach(clone => track.append(clone));

    const allSlides = document.querySelectorAll('.club-slide');

    function updateSlider(transition = true) {
        const slideWidth = slides[0].offsetWidth;
        const offset = currentIndex * (slideWidth + slideGap);
        
        track.style.transition = transition ? 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1)' : 'none';
        
        // Center alignment calculation
        const viewportWidth = document.querySelector('.slider-viewport').offsetWidth;
        const centerOffset = (viewportWidth / 2) - (slideWidth / 2);
        track.style.transform = `translateX(${-offset + centerOffset}px)`;

        // Update Dominant Class (Scale/Opacity)
        allSlides.forEach((slide, index) => {
            slide.classList.toggle('is-active', index === currentIndex);
        });

        // Update Progress Bar
        if (progressBar) {
            const progress = ((currentIndex - slides.length) % slides.length + slides.length) % slides.length;
            progressBar.style.width = `${((progress + 1) / slides.length) * 100}%`;
        }
    }

    // Infinite Loop Jump Logic
    track.addEventListener('transitionend', () => {
        if (currentIndex >= allSlides.length - 3) {
            currentIndex = 3;
            updateSlider(false);
        }
        if (currentIndex < 3) {
            currentIndex = allSlides.length - 4;
            updateSlider(false);
        }
    });

    // Auto Play
    setInterval(() => {
        currentIndex++;
        updateSlider();
    }, 4000);

    window.addEventListener('resize', () => updateSlider(false));
    updateSlider(false);
});
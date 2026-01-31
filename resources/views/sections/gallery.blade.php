<section id="gallery" class="gallery-section">
    <div class="container">

        <!-- Section Header -->
        <div class="section-title">
            <span class="badge gradient-text">Portfolio</span>
            <h2>Our Gallery</h2>
            <p class="section-subtitle">
                Our learning environment and success
            </p>
        </div>

        <!-- Gallery Slider -->
        <div class="gallery-slider">

            <button class="slider-btn prev" aria-label="Previous">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="slider-viewport">
                <div class="gallery-track">
                    @foreach($gallery as $item)
                        <div class="gallery-slide">
                            <article class="gallery-card base-card">
                                <div class="gallery-image">
                                    <div class="image-overlay"></div>
                                    <img
                                        src="{{ asset('storage/'.$item->image) }}"
                                        alt="{{ $item->title ?? 'Gallery Image' }}"
                                        loading="lazy"
                                    >
                                    <div class="gallery-icon">
                                        <i class="fas fa-expand"></i>
                                    </div>
                                </div>

                                <div class="gallery-info">
                                    <h4>{{ $item->title ?? 'Gallery Item' }}</h4>
                                    <span>{{ $item->category ?? 'Gallery' }}</span>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
                
                <!-- Progress Indicator -->
                <div class="slider-progress">
                    <div class="progress-bar"></div>
                </div>
            </div>

            <button class="slider-btn next" aria-label="Next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <!-- Dots Navigation -->
            <div class="slider-dots"></div>

        </div>

        @if($gallery->count() >= 8)
            <div class="gallery-action text-center mt-6">
                <a href="{{ route('main-page.gallery') }}" class="btn btn-primary">
                    <span>See More Photos</span>
                    <i class="fas fa-images"></i>
                </a>
            </div>
        @endif

    </div>
</section>

<!-- Lightbox Modal -->
<div class="gallery-lightbox">
    <div class="lightbox-overlay"></div>
    <div class="lightbox-container">
        <button class="lightbox-close" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
        <div class="lightbox-content">
            <img src="" alt="" class="lightbox-image">
            <div class="lightbox-info">
                <h3></h3>
                <p></p>
            </div>
        </div>
        <button class="lightbox-nav prev" aria-label="Previous">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="lightbox-nav next" aria-label="Next">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
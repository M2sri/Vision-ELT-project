<section id="teachers" class="teachers-section">
    <div class="container">
        <div class="section-title">
            <h2>Our Teachers</h2>
            <p class="section-subtitle">Meet our professional and experienced team</p>
        </div>

        <div class="teachers-slider">
            <button class="slider-btn prev" aria-label="Previous">‹</button>

            <div class="slider-viewport">
                <div class="teachers-track">
                    @foreach($teams as $teacher)
                        <div class="teacher-slide">
                            <div class="teacher-card base-card">
                                <div class="teacher-image">
                                    <img src="{{ asset('storage/' . $teacher->image) }}" alt="{{ $teacher->name }}">
                                </div>

                                <div class="teacher-info">
                                    <h3>{{ $teacher->name }}</h3>
                                    <span class="teacher-title">{{ $teacher->title }}</span>
                                    <p>{{ Str::limit($teacher->description, 90) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button class="slider-btn next" aria-label="Next">›</button>
        </div>
    </div>
</section>
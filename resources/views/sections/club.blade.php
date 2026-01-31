<section id="activities" class="activities-section">
    <div class="container">

        {{-- Section Header with Modern Styling --}}
        <div class="section-header">
            <span class="section-badge">Featured</span>
            <h2 class="section-title">Our Activities</h2>
            <p class="section-subtitle">Discover transformative programs designed for growth and innovation</p>
            <div class="header-decoration">
                <div class="decoration-line"></div>
                <div class="decoration-dot"></div>
                <div class="decoration-line"></div>
            </div>
        </div>

        @php
            $latestClub = $clubs->first();
        @endphp

        @if($latestClub)
        {{-- Featured Activity Card --}}
        <div class="featured-activity-card">
            <div class="activity-glow"></div>
            
            {{-- Image Side --}}
            <div class="activity-image-wrapper">
                <div class="image-frame">
                    <img 
                        src="{{ asset('storage/' . $latestClub->image) }}" 
                        alt="{{ $latestClub->title }}"
                        class="activity-image"
                    >
                </div>
                <div class="image-overlay"></div>
                <div class="activity-tag">
                    <i class="fas fa-star"></i>
                    <span>Featured</span>
                </div>
            </div>

            {{-- Content Side --}}
            <div class="activity-content">
                <div class="activity-meta">
                    <span class="activity-duration">
                        <i class="fas fa-clock"></i>
                        {{ $latestClub->duration }}
                    </span>
                    <span class="activity-category">
                        <i class="fas fa-tag"></i>
                        Current Program
                    </span>
                </div>
                
                <h3 class="activity-title">{{ $latestClub->title }}</h3>
                
                <p class="activity-description">
                    {{ Str::limit($latestClub->description, 200) }}
                </p>
                
                <div class="activity-features">
                    <div class="feature">
                        <i class="fas fa-users"></i>
                        <span>Collaborative</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-lightbulb"></i>
                        <span>Innovative</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-chart-line"></i>
                        <span>Growth Focused</span>
                    </div>
                </div>
                
                <div class="activity-actions">
                    <a href="#" class="btn btn-primary">
                        <span>Explore Activity</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#" class="btn btn-outline">
                        <span>View All Activities</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Other Activities Grid (Optional) --}}
        @if($clubs->count() > 1)
        <div class="activities-grid">
            @foreach($clubs->skip(1)->take(3) as $activity)
            <div class="activity-card">
                <div class="card-image">
                    <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}">
                </div>
                <div class="card-content">
                    <span class="card-duration">{{ $activity->duration }}</span>
                    <h4>{{ Str::limit($activity->title, 40) }}</h4>
                    <p>{{ Str::limit($activity->description, 80) }}</p>
                    <a href="#" class="card-link">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @endif

    </div>
</section>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Zone 1 Result</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/test-style/result.css') }}">
</head>

<body>

<div class="result-container">

    <!-- ================= HEADER ================= -->
    <div class="result-header">
        <h1 class="mb-3">🎉 Great Job! 🎉</h1>
        <p class="text-muted">Kids Placement Test – Zone 1 Results</p>
    </div>

    <!-- ================= SUMMARY CARDS ================= -->
    <div class="row mb-4">

        <!-- Kid Info -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Student Info</h5>
                    <p><strong>Name:</strong> {{ session('kid_name', 'Guest') }}</p>
                    <p><strong>Test:</strong> Zone 1 – Kids Placement</p>
                    <p><strong>Date:</strong> {{ $attempt->completed_at->format('F j, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Score -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Score</h5>

                    <div class="score-circle mb-3">
                        {{ $attempt->score }}/{{ $attempt->total_marks }}
                    </div>

                    <h3>{{ number_format($attempt->percentage, 1) }}%</h3>

                    <div class="progress progress-bar-custom mt-2">
                        <div class="progress-bar bg-success"
                             style="width: {{ $attempt->percentage }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= LEVEL ================= -->
    <div class="text-center my-5">
        <div class="congratulations">
            Your Suggested Level
        </div>

        <div class="level-display">
            {{ $attempt->level }}
        </div>

        <p class="text-muted mt-2">
            Based on your performance in Zone 1
        </p>
    </div>

    <!-- ================= RECOMMENDATION ================= -->
    <div class="recommendation-box">
        <h5>🌟 What This Means</h5>

        @php
            $recommendations = [
                'PRE-1' => 'Your child is starting their English journey. We recommend beginning with phonics and basic vocabulary.',
                'PRE-2' => 'Your child shows early understanding of English sounds and words. A beginner course is recommended.',
                'Level 1' => 'Your child is ready for simple sentences and basic communication activities.',
                'Level 2' => 'Your child can understand basic English and is ready to build confidence through practice.',
            ];

            $recommendation = $recommendations[$attempt->level]
                ?? 'Our team will help guide your child to the best learning path.';
        @endphp

        <p>{{ $recommendation }}</p>

        <div class="mt-4">
            <a href="{{ route('home') }}" class="btn btn-outline-primary me-2">
                Finish
            </a>

            <button onclick="window.print()" class="btn btn-outline-secondary">
                Print Result
            </button>
        </div>
    </div>

</div>

</body>
</html>

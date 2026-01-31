<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/test-style/result.css') }}">
    <style>
        
    </style>
</head>
<body>
    <div class="result-container">
        <div class="result-header">
            <h1 class="mb-3">🎉 Test Completed! 🎉</h1>
            <p class="text-muted">English Placement Test Results</p>
        </div>

        <!-- Student Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">#</h5>
                        <p><strong>Name:</strong> {{ $attempt->student->name }}</p>
                        <p><strong>Email:</strong> {{ $attempt->student->email }}</p>
                        <p><strong>Test Date:</strong> {{ $attempt->completed_at->format('F j, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Overall Score</h5>
                        <div class="text-center mt-3">
                            <div class="score-circle mb-3">
                                {{ $attempt->score }}/{{ $attempt->total_marks }}
                            </div>
                            <h3 class="mb-2">{{ number_format($attempt->percentage, 1) }}%</h3>
                            <div class="progress progress-bar-custom">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ $attempt->percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Level Result -->
        <div class="text-center my-5">
            <div class="congratulations">
                Your English Level is:
            </div>
            <div class="level-display">
                {{ $attempt->level }}
            </div>
            <p class="text-muted mt-2">
                Based on your performance in the placement test
            </p>
        </div>

        <!-- Section-wise Breakdown -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Section-wise Performance</h5>
            </div>
            <div class="card-body">
                @php
                    $sections = $attempt->answers->groupBy(function($answer) {
                        return $answer->question->section;
                    });
                    
                    $sectionNames = [
                        'word_order' => 'Word Order',
                        'vocabulary' => 'Vocabulary',
                        'verb_opposites' => 'Verb Opposites',
                        'passive_form' => 'Passive Form',
                        'sentence_transformation' => 'Sentence Transformation',
                        'reading' => 'Reading Comprehension'
                    ];
                @endphp
                
                @foreach($sections as $section => $answers)
                    @php
                        $correctCount = $answers->where('is_correct', true)->count();
                        $totalCount = $answers->count();
                        $percentage = $totalCount > 0 ? ($correctCount / $totalCount) * 100 : 0;
                        $sectionMarks = $answers->sum(function($answer) {
                            return $answer->question->marks;
                        });
                        $earnedMarks = $answers->sum(function($answer) {
                            return $answer->is_correct ? $answer->question->marks : 0;
                        });
                    @endphp
                    <div class="section-score">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $sectionNames[$section] ?? ucfirst(str_replace('_', ' ', $section)) }}</h6>
                                <small class="text-muted">
                                    {{ $correctCount }} out of {{ $totalCount }} correct
                                </small>
                            </div>
                            <div class="text-end">
                                <strong>{{ $earnedMarks }}/{{ $sectionMarks }} marks</strong>
                                <div class="progress mt-1" style="width: 150px; height: 8px;">
                                    <div class="progress-bar 
                                        @if($percentage >= 80) bg-success
                                        @elseif($percentage >= 60) bg-info
                                        @elseif($percentage >= 40) bg-warning
                                        @else bg-danger
                                        @endif" 
                                        style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recommendations -->
        <div class="recommendation-box">
            <h5>🎯 Recommendations</h5>
            @php
                $levelNumber = (int) filter_var($attempt->level, FILTER_SANITIZE_NUMBER_INT);
                $recommendations = [
                    'PRE-1' => 'We recommend starting with basic English courses focusing on vocabulary and simple sentence structures.',
                    'PRE-2' => 'You should begin with foundational courses covering basic grammar and everyday vocabulary.',
                    'Level 1' => 'Start with beginner courses focusing on basic conversations and essential grammar.',
                    'Level 2' => 'Continue with elementary courses to build confidence in everyday communication.',
                    'Level 3' => 'Intermediate courses focusing on grammar accuracy and vocabulary expansion are recommended.',
                    'Level 4' => 'Upper-intermediate courses will help refine your language skills for better fluency.',
                    'Level 5' => 'Consider advanced courses focusing on complex grammatical structures and formal writing.',
                    'Level 6' => 'Advanced courses with emphasis on academic writing and nuanced communication.',
                    'Level 7' => 'You\'re ready for proficiency-level courses focusing on professional and academic contexts.',
                    'Level 8' => 'Near-native proficiency. Consider specialized courses in specific domains.',
                    'Level 9' => 'Excellent command of English. Consider advanced academic or professional certification courses.',
                ];
                
                $recommendation = $recommendations[$attempt->level] ?? 'Please consult with an academic advisor for personalized recommendations.';
            @endphp
            <p>{{ $recommendation }}</p>
            <p class="mb-0 mt-3">
                <strong>Next Steps:</strong> 
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary ms-2">
                    Visit Our Website
                </a>
                <button onclick="window.print()" class="btn btn-sm btn-outline-secondary ms-2">
                    Print Results
                </button>
            </p>
        </div>
    </div>

    <script>
        function downloadResults() {
            // In a real application, this would generate a PDF
            alert('PDF download would be generated here. This is a demo.');
        }
        
        // Confetti animation (optional)
        function showConfetti() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 }
                });
            }
        }
        
        // Show confetti on page load
        window.onload = showConfetti;
    </script>
    
    <!-- Optional: Add confetti library -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
</body>
</html>
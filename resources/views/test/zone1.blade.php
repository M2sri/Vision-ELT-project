<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $test->title }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/test-style/test.css') }}">
    
    <style>
        .comprehension-text {
            background: #f8f9fa;
            border-left: 4px solid #4e73df;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        
        .match-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .match-item {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
        }
        
        .match-icon {
            font-size: 40px;
            color: #4e73df;
            margin: 10px 0;
            display: block;
        }
        
        .question-card {
            margin-bottom: 25px;
        }
        
        .section-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 25px 0 15px;
            font-weight: 600;
        }
        
        .option-label {
            display: block;
            padding: 10px 15px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .option-label:hover {
            background: #f0f8ff;
        }
        
        .option-label input[type="radio"] {
            margin-right: 10px;
        }
        
        .question-number {
            background: #4e73df;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
    </style>
</head>

<body>

<div class="test-container">

    <!-- ================= HEADER ================= -->
    <div class="test-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2>{{ $test->title }}</h2>
            <p class="text-muted mb-0">
                Student: {{ session('kid_name', 'Guest') }}

            </p>
        </div>
    </div>

    <!-- ================= FORM ================= -->
    <form action="{{ route('kids.zone1.submit', $attempt->id) }}" method="POST">
        @csrf

        @php
            $currentSection = null;
            
            $sectionTitles = [
                'phonics'          => 'A. Circle the Correct Letter',
                'matching_letters' => 'B. Match Letter to Picture',
                'matching_words'   => 'C. Read and Match',
                'reading_choose'   => 'D. Read and Choose',
                'comprehension'    => 'E. Reading Comprehension',
            ];
        @endphp

        @foreach($questions as $index => $question)

            <!-- ========== SECTION HEADER ========== -->
            @if($currentSection !== $question->section)
                @php $currentSection = $question->section; @endphp
                <div class="section-title">
                    {{ $sectionTitles[$question->section] ?? ucfirst($question->section) }}
                </div>
                
                <!-- Reading Comprehension Text -->
                @if($question->section === 'comprehension')
                    <div class="comprehension-text">
                        <strong>Read this:</strong><br>
                        Sarah has a big blue bag. She likes her bag. She puts her book in the bag.
                    </div>
                @endif
            @endif

            <!-- ========== QUESTION CARD ========== -->
            <div class="question-card">

                <div class="d-flex align-items-start mb-3">
                    <div class="question-number">
                        {{ $index + 1 }}
                    </div>
                    <h5 class="mb-0">
                        {{ $question->question }}
                    </h5>
                </div>

                <!-- ===== MCQ (Regular radio buttons) ===== -->
                @if($question->type === 'mcq')
                    @foreach(json_decode($question->options) as $option)
                        <label class="option-label">
                            <input type="radio"
                                   name="answers[{{ $question->id }}]"
                                   value="{{ $option }}"
                                   required>
                            <span>{{ $option }}</span>
                        </label>
                    @endforeach
                @endif

                <!-- ===== MATCH (Letter/Word to Picture) ===== -->
                @if($question->type === 'match')
                    @php
                        $matchData = json_decode($question->correct_answer, true);
                        $options = json_decode($question->options);
                    @endphp
                    
                    <div class="match-grid">
                        @foreach($matchData as $left => $icon)
                            <div class="match-item text-center">
                                <strong class="d-block mb-2">{{ $left }}</strong>
                                
                                <!-- Display the icon -->
                                <i class="fas {{ $icon }} match-icon mb-2"></i>
                                
                                <select class="form-select"
                                        name="answers[{{ $question->id }}][{{ $left }}]"
                                        required>
                                    <option value="">Choose</option>
                                    @foreach($options as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        @endforeach

        <!-- ================= SUBMIT ================= -->
        <div class="navigation-buttons">
            <div></div>
            <button type="submit"
                    class="btn btn-success btn-lg"
                    onclick="return confirm('Finish Zone 1 test?')">
                Finish Test ✓
            </button>
        </div>

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
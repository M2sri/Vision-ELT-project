<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English Placement Test for adult</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/test-style/test.css') }}">

    <style>
        
    </style>
</head>

<body>

<div class="test-container">

{{-- ================= HEADER ================= --}}
<div class="test-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>English Placement Test for adult</h2>
            <p class="text-muted mb-0">Student: {{ $attempt->student->name }}</p>
        </div>
        <div class="timer" id="timer">Time: 45:00</div>
    </div>

    {{-- PROGRESS --}}
    <div class="mt-3">
        <div class="d-flex justify-content-between mb-1">
            <span>Progress</span>
            <span>{{ min($index + $perPage, $questions->count()) }} / {{ $questions->count() }}</span>
        </div>
        <div class="progress-container">
            <div class="progress-bar"
                 style="width: {{ (min($index + $perPage, $questions->count()) / max(1,$questions->count())) * 100 }}%">
            </div>
        </div>
    </div>
</div>

@php
$sections = [
    'word_order' => [
        'title' => 'Word Order',
        'instruction' => 'Choose the correct words to complete each question.'
    ],
    'vocabulary' => [
        'title' => 'Vocabulary',
        'instruction' => 'Choose the correct word or phrase.'
    ],
    'verb_opposites' => [
        'title' => 'Verb Opposites',
        'instruction' => 'Choose the word with the opposite meaning.'
    ],
    'passive_form' => [
        'title' => 'Passive Form',
        'instruction' => 'Choose the sentence written in the correct passive form.'
    ],
    'sentence_transformation' => [
        'title' => 'Sentence Transformation',
        'instruction' => 'Choose the sentence that has the same meaning.'
    ],
    'reading' => [
        'title' => 'Reading Comprehension',
        'instruction' => 'Read the passage carefully and answer the questions.'
    ],
];
$pageQuestions = $pageQuestions->values();
@endphp

<form action="{{ route('test.answer', $attempt) }}" method="POST" id="testForm">
@csrf
<input type="hidden" name="current_index" value="{{ $pageStart }}">

{{-- SHOW READING PASSAGE --}}
@if($pageQuestions->contains(fn($q) => $q->section === 'reading'))
    <div class="reading-passage">
        {{ $attempt->test->reading_passage }}
    </div>
@endif


@foreach($pageQuestions as $key => $question)
@php
    $previous = $pageQuestions->get($key - 1);
    $sectionChanged = $key === 0 || ($previous && $question->section !== $previous->section);
    $questionNumber = $pageStart + $key + 1;
    $currentAnswer = $attempt->answers->where('question_id',$question->id)->first();
@endphp

@if($sectionChanged)
    <div class="section-title">
        {{ $sections[$question->section]['title'] }}
    </div>
    <div class="section-instruction">
        {{ $sections[$question->section]['instruction'] }}
    </div>
@endif

<div class="question-card">
    <div class="d-flex align-items-start mb-3">
        <div class="question-number">{{ $questionNumber }}</div>
        <h5 class="mb-0">{{ $question->question }}</h5>
    </div>

    @foreach($question->options as $option)
        <label class="option-label">
            <input type="radio"
                   name="answers[{{ $question->id }}][answer]"
                   value="{{ $option }}"
                   {{ $currentAnswer && $currentAnswer->answer === $option ? 'checked' : '' }}>
            <span class="ms-2">{{ $option }}</span>
        </label>
    @endforeach

    <input type="hidden" name="answers[{{ $question->id }}][question_id]" value="{{ $question->id }}">
</div>
@endforeach

{{-- NAVIGATION --}}
<div class="navigation-buttons">
    @if($index > 0)
        <a class="btn btn-outline-primary"
           href="{{ route('test.adult',[$attempt,max(0,$index-$perPage)]) }}">
            ← Previous
        </a>
    @else
        <div></div>
    @endif

    @if(($index + $perPage) >= $questions->count())
        <button class="btn btn-success btn-lg" type="submit"
                onclick="return confirm('Submit test?')">
            Submit Test ✓
        </button>
    @else
        <button class="btn btn-primary btn-lg" type="submit">
            Next →
        </button>
    @endif
</div>

</form>
</div>

{{-- TIMER --}}
{{-- REQUIRE ALL QUESTIONS ON PAGE --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('testForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        const groups = {};
        form.querySelectorAll('input[type="radio"]').forEach(radio => {
            groups[radio.name] = groups[radio.name] || false;
            if (radio.checked) groups[radio.name] = true;
        });

        const unanswered = Object.values(groups).some(v => !v);
        if (unanswered) {
            e.preventDefault();
            alert('Please answer all questions on this page before continuing.');
        }
    });
});
</script>


</body>
</html>

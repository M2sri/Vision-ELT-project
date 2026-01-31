<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Kid;
use App\Models\Question;
use App\Models\TestAttempt;
use Illuminate\Http\Request;


class KidsTestController extends Controller
{
    public function zone1(TestAttempt $attempt)
    {
        // Get the test related to this attempt
        $test = Test::findOrFail($attempt->test_id);

        // Get questions for this test
        $questions = Question::where('test_id', $test->id)
            ->orderBy('order')
            ->get();

        return view('test.zone1', compact('test', 'questions', 'attempt'));
    }

public function startZone1(Kid $kid)
    {

    // Store kid name in session
    session([
        'kid_name' => $kid->name,
    ]);
    
        // 1️⃣ Get Zone 1 test
        $test = Test::where('title', 'Kids Placement Test – Zone 1')
            ->firstOrFail();

        // 2️⃣ If already completed → go to result
        $completed = TestAttempt::where('kid_id', $kid->id)
            ->where('test_id', $test->id)
            ->where('status', 'completed')
            ->latest()
            ->first();

        if ($completed) {
            return redirect()->route('kids.zone1.result', $completed->id);
        }

        // 3️⃣ Resume in-progress attempt
        $attempt = TestAttempt::where('kid_id', $kid->id)
            ->where('test_id', $test->id)
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        // 4️⃣ Create new attempt if none exists
        if (!$attempt) {
            $attempt = TestAttempt::create([
                'kid_id'     => $kid->id,
                'test_id'    => $test->id,
                'status'     => 'in_progress',
                'started_at' => now(),
            ]);
        }

        // 5️⃣ Go to Zone 1 test page
        return redirect()->route('kids.zone1', $attempt->id);
    }

    public function submitZone1(Request $request, TestAttempt $attempt)
{
    // Safety: do not re-submit
    if ($attempt->status === 'completed') {
        return redirect()->route('kids.zone1.result', $attempt->id);
    }

    // Validate answers
    $request->validate([
        'answers' => 'required|array',
    ]);

    $score = 0;

    // Load questions once
    $questions = Question::where('test_id', $attempt->test_id)->get();

    foreach ($questions as $question) {

        // Skip if no answer
        if (!isset($request->answers[$question->id])) {
            continue;
        }

        $studentAnswer = $request->answers[$question->id];

        /*
         |------------------------------------------
         | MCQ QUESTIONS
         |------------------------------------------
         */
        if ($question->type === 'mcq') {
            $correctAnswers = $question->correct_answer;

            if (!is_array($correctAnswers)) {
                $correctAnswers = [$correctAnswers];
            }

            if (in_array($studentAnswer, $correctAnswers, true)) {
                $score += $question->marks;
            }
        }

        /*
         |------------------------------------------
         | MATCH QUESTIONS
         |------------------------------------------
         */
        if ($question->type === 'match') {

            $correctPairs = $question->correct_answer ?? [];


            if (!is_array($correctPairs)) {
                $correctPairs = [];
            }

            foreach ($correctPairs as $left => $right) {
                if (
                    isset($studentAnswer[$left]) &&
                    $studentAnswer[$left] === $right
                ) {
                    $score += $question->marks;
                }
            }
        }
    }

   $totalMarks = $questions->sum(fn ($q) => $q->totalMarks());


$half = $totalMarks / 2;

$level = $score <= $half
    ? 'Foundation'
    : 'Beginner';

$attempt->update([
    'score'        => $score,
    'total_marks'  => $totalMarks,
    'percentage'   => $totalMarks > 0
        ? round(($score / $totalMarks) * 100, 2)
        : 0,
    'level'        => $level,
    'status'       => 'completed',
    'completed_at' => now(),
]);


    return redirect()->route('kids.zone1.result', $attempt->id);
}




public function resultZone1(TestAttempt $attempt)
{
    // Safety check
    if ($attempt->status !== 'completed') {
        return redirect()->route('kids.zone1', $attempt->id);
    }

    return view('test.zone1-result', compact('attempt'));
}


}



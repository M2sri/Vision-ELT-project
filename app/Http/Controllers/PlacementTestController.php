<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class PlacementTestController extends Controller
{

    /* =========================
       START TEST
    ========================= */
    public function start(Student $student)
    {
        $test = Test::where('title', 'English Placement Test')->firstOrFail();

        // If already completed → go directly to result
        $completed = TestAttempt::where('student_id', $student->id)
            ->where('test_id', $test->id)
            ->where('status', 'completed')
            ->latest()
            ->first();

        if ($completed) {
           return redirect()->route('test.result', $completed->id);

        }

        // Resume in-progress attempt
        $attempt = TestAttempt::where('student_id', $student->id)
            ->where('test_id', $test->id)
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        if (!$attempt) {
            $attempt = TestAttempt::create([
                'student_id' => $student->id,
                'test_id'    => $test->id,
                'status'     => 'in_progress',
                'started_at' => now(),
            ]);
        }

        return redirect()->route('test.question', [$attempt->id, 0]);

    }

    /* =========================
       SHOW QUESTIONS
    ========================= */
    public function question(TestAttempt $attempt, $index = 0)
    {
        if ($attempt->status === 'completed') {
            return redirect()->route('test.result', $attempt->id);

        }

        $questions = $attempt->test->questions()
            ->where('marks', '>', 0)
            ->orderBy('order')
            ->get()
            ->values();

        if ($index >= $questions->count()) {
            return redirect()->route('test.result', $attempt->id);

        }

        $perPage = 10;
        $pageStart = floor($index / $perPage) * $perPage;
        $pageQuestions = $questions->slice($pageStart, $perPage)->values();

        $isReadingSection = $pageStart >= 40;

        return view('test.adult', compact(
            'attempt',
            'questions',
            'pageQuestions',
            'index',
            'pageStart',
            'perPage',
            'isReadingSection'
        ));
    }

    /* =========================
       SUBMIT ANSWERS
    ========================= */
  public function answer(Request $request, TestAttempt $attempt)
{
    if ($attempt->status === 'completed') {
        return redirect()->route('test.result', $attempt->id);
    }

    $request->validate([
        'answers' => 'required|array',
        'current_index' => 'required|integer',
    ]);

    foreach ($request->answers as $data) {

        if (!isset($data['question_id'], $data['answer'])) {
            continue;
        }

        $question = Question::find($data['question_id']);
        if (!$question) {
            continue;
        }

        $answer = trim($data['answer']);

        // ✅ correct_answer is ARRAY
        $correctAnswers = $question->correct_answer ?? [];

        $isCorrect = in_array($answer, $correctAnswers, true);

        Answer::updateOrCreate(
            [
                'test_attempt_id' => $attempt->id,
                'question_id'     => $question->id,
            ],
            [
                'answer'     => $answer,
                'is_correct' => $isCorrect,
            ]
        );
    }

    $total = $attempt->test->questions()->where('marks', '>', 0)->count();
    $nextIndex = $request->current_index + 10;

    if ($nextIndex >= $total) {
        return $this->completeTest($attempt);
    }

    return redirect()->route('test.question', [$attempt, $nextIndex]);
}



    /* =========================
       COMPLETE TEST
    ========================= */
    private function completeTest(TestAttempt $attempt)
    {
        if ($attempt->status === 'completed') {
           return redirect()->route('test.result', $attempt->id);

        }

        $totalMarks = $attempt->test->total_marks;

        $score = $attempt->answers()
            ->where('is_correct', true)
            ->count();

        $percentage = round(($score / $totalMarks) * 100, 1);
        $level = $this->determineLevel($percentage);

        $attempt->update([
            'status' => 'completed',
            'score' => $score,
            'total_marks' => $totalMarks,
            'percentage' => $percentage,
            'level' => $level,
            'completed_at' => now(),
        ]);

        return redirect()->route('test.result', $attempt->id);

    }

    /* =========================
       LEVEL LOGIC
    ========================= */
    private function determineLevel($p)
    {
        return match (true) {
            $p >= 95 => 'Level 9',
            $p >= 90 => 'Level 8',
            $p >= 80 => 'Level 7',
            $p >= 70 => 'Level 6',
            $p >= 60 => 'Level 5',
            $p >= 50 => 'Level 4',
            $p >= 40 => 'Level 3',
            $p >= 30 => 'Level 2',
            $p >= 20 => 'Level 1',
            $p >= 10 => 'PRE-2',
            default  => 'PRE-1',
        };
    }

    /* =========================
       RESULT PAGE
    ========================= */
public function result($attempt)
{
    $attempt = TestAttempt::findOrFail($attempt);

    if ($attempt->status !== 'completed') {
        abort(404);
    }

    return view('test.result', compact('attempt'));
}

}

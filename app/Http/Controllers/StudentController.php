<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // Show registration form
    public function create()
    {
        return view('test.register');
    }


    // Store student and start placement test
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'country'     => 'required|string|max:100',
            'city'        => 'required|string|max:100',
            'branch'      => 'required|in:Eldoge,Nasr City,Online',
            'age'         => 'required|integer|min:10|max:100',
            'phone'       => 'required|string|max:20',
            'prefer_time' => 'required|in:Morning,Afternoon,Evening',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find or create student
        $student = Student::firstOrCreate(
            ['email' => $request->email],
            $request->all()
        );

        // Save student in session
        session(['student_id' => $student->id]);

        // 👉 START PLACEMENT TEST
        return redirect()->route('test.start', $student->id);
    }

public function index(Request $request)
{
    $query = Student::with('latestTestResult')
        ->withCount('testResults as test_attempts_count')
        ->orderBy('test_attempts_count', 'desc')
        ->orderBy('created_at', 'desc');

    // Filter by status
    if ($request->has('status') && $request->status !== '') {
        if ($request->status === 'completed') {
            $query->has('testResults');
        } elseif ($request->status === 'not_taken') {
            $query->doesntHave('testResults');
        }
    }

    // Filter by branch
    if ($request->has('branch') && $request->branch !== '') {
        $query->where('branch', $request->branch);
    }

    $students = $query->paginate(20)->appends(request()->query());

    return view('admin.students.index', compact('students'));
}

}

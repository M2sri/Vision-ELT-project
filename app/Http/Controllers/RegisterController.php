<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'       => 'required',
            'email'           => 'required|email|unique:students',
            'phone'           => 'required',
            'age'             => 'nullable|integer',
            'address'         => 'nullable',
            'preferred_time'  => 'nullable',
            'course_interest' => 'required',
            'goals'           => 'nullable',
        ]);

        $student = Student::create($data);

        return redirect()->route('test.show', $student);
    }
}

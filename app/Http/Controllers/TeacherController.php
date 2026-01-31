<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::latest()->get();
        return view('admin.add-teachers', compact('teachers'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'required|image|max:4096',
    ]);

    // ✅ EXACT SAME PATTERN AS CLUB
    $data['image'] = $request->file('image')->store('add-teachers', 'public');
    $data['is_active'] = true;

    Teacher::create($data);

    return back()->with('success', 'Teacher added');
}


    public function destroy(Teacher $teacher)
    {
        Storage::disk('public')->delete($teacher->image);
        $teacher->delete();

        return back()->with('success', 'Teacher deleted');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ClubSection;
use App\Models\ClubItem; // Add this
use Illuminate\Http\Request;

class ClubSectionController extends Controller
{
    public function edit()
    {
        $section = ClubSection::firstOrCreate([]);
        $clubs = ClubItem::orderBy('order')->get(); // Add this line
        
        return view('admin.club.section', compact('section', 'clubs')); // Add clubs here
    }

    public function update(Request $request)
    {
        $section = ClubSection::first();

        $section->update($request->validate([
            'title' => 'required|string|max:255',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'is_active' => 'nullable',
        ]));

        return back()->with('success', 'Section updated');
    }
}
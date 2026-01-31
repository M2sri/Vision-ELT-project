<?php


namespace App\Http\Controllers;

use App\Models\ClubItem;
use App\Models\ClubSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClubItemController extends Controller
{
    public function index()
    {
        $section = ClubSection::firstOrCreate([]);
        $clubs = ClubItem::orderBy('order')->get();

        return view('admin.club.items', compact('section', 'clubs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'nullable|string|max:255',
            'place' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
        ]);

        $data['image'] = $request->file('image')->store('club', 'public');
        $data['club_section_id'] = ClubSection::first()->id;

        ClubItem::create($data);

        return back()->with('success', 'Club added');
    }

    public function destroy(ClubItem $clubItem)
    {
        Storage::disk('public')->delete($clubItem->image);
        $clubItem->delete();

        return back()->with('success', 'Club deleted');
    }

   

}

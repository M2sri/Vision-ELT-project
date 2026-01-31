<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Teacher;
use App\Models\ClubItem;
use App\Models\ClubSection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $gallery = Gallery::latest()->take(6)->get();

        $teams = Teacher::where('is_active', true)
            ->latest()
            ->get();

        $clubs = ClubItem::where('is_active', true)
            ->latest()
            ->get();

        $latestClub = ClubItem::where('is_active', true)
            ->latest()
            ->first();


        

        $section = ClubSection::first();

        return view('pages.home', compact(
            'gallery',
            'teams',
            'clubs',
            'section'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kid;

class KidsController extends Controller
{
    /**
     * Show kids registration page
     */
    public function index()
    {
        // Page is inside: resources/views/test/kids-register.blade.php
        return view('test.kids-register');
    }

    /**
     * Store registration and redirect to zone test
     */
    public function store(Request $request)
{
    $request->validate([
        'zone'      => 'required|in:zone1,zone2',
        'kid_name'  => 'required|string|max:255',
        'age'       => 'required|integer|min:5|max:11',
        'phone'     => 'required|string|max:20',
        'country'   => 'required|string|max:255',
        'city'      => 'required|string|max:255',
    ]);

    $kid = Kid::create([
        'zone'      => $request->zone,
        'kid_name'  => $request->kid_name,
        'age'       => $request->age,
        'phone'     => $request->phone,
        'country'   => $request->country,
        'city'      => $request->city,
    ]);

    // ✅ Only zone1 is allowed for now
    if ($request->zone === 'zone1') {
        return redirect()->route('kids.zone1.start', $kid->id);
    }

    // 🚫 Zone2 not ready
    return back()->withErrors([
        'zone' => 'Zone 2 is not available yet.'
    ]);
}


}

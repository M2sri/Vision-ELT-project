<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display the gallery page with all images
     */
    public function index()
{
    $gallery = Gallery::latest()->paginate(12);
    $categories = Gallery::distinct()->pluck('category')->filter()->toArray();

    return view('admin.gallery', compact('gallery', 'categories'));
}

public function adminIndex()
{
    $gallery = Gallery::latest()->paginate(12);

    return view('admin.gallery', compact('gallery'));
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        // Store image
        $path = $request->file('image')->store('gallery', 'public');

        // Create gallery item
        Gallery::create([
            'title'    => $request->title,
            'category' => $request->category,
            'image'    => $path,
        ]);

        return back()->with('success', 'Image added successfully!');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete image from storage
        if (Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        
        // Delete record from database
        $gallery->delete();

        return back()->with('success', 'Image deleted successfully!');
    }

    /**
     * AJAX endpoint for loading more images
     */
    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $category = $request->get('category', 'all');
        $perPage = 8;

        $query = Gallery::query();
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        $gallery = $query->latest()->paginate($perPage, ['*'], 'page', $page);
        
        if ($request->ajax()) {
            $html = '';
            foreach ($gallery as $item) {
                $html .= view('partials.gallery-item', compact('item'))->render();
            }
            
            return response()->json([
                'html' => $html,
                'hasMore' => $gallery->hasMorePages(),
                'count' => $gallery->count(),
                'total' => $gallery->total()
            ]);
        }
        
        return abort(404);
    }
}
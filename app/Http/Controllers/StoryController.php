<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Story::active();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $stories = $query->paginate(9)->withQueryString();
        $featuredStory = Story::active()->featured()->first() ?? Story::active()->first();

        return view('cerita.index', compact('stories', 'featuredStory'));
    }

    public function show(string $slug)
    {
        $story = Story::where('slug', $slug)->firstOrFail();
        $recentStories = Story::active()->where('id', '!=', $story->id)->take(3)->get();

        return view('cerita.show', compact('story', 'recentStories'));
    }
}

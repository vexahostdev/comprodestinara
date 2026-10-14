<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::latest()->paginate(15);

        return view('admin.stories.index', compact('stories'));
    }

    public function create()
    {
        return view('admin.stories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'archive_no' => 'nullable|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'author_name' => 'nullable|string|max:150',
            'author_role' => 'nullable|string|max:150',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:3072',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']).'-'.rand(100, 999);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['published_at'] = now();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stories', 'public');
            $validated['image_path'] = $path;
        }

        Story::create($validated);

        return redirect()->route('admin.stories.index')->with('success', 'Cerita lapangan berhasil diterbitkan!');
    }

    public function edit(Story $story)
    {
        return view('admin.stories.edit', compact('story'));
    }

    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'archive_no' => 'nullable|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'author_name' => 'nullable|string|max:150',
            'author_role' => 'nullable|string|max:150',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:3072',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stories', 'public');
            $validated['image_path'] = $path;
        }

        $story->update($validated);

        return redirect()->route('admin.stories.index')->with('success', 'Cerita lapangan berhasil diperbarui!');
    }

    public function destroy(Story $story)
    {
        $story->delete();

        return redirect()->route('admin.stories.index')->with('success', 'Cerita lapangan berhasil dihapus!');
    }
}

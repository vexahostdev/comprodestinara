<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('order')->get();

        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'target' => 'required|string|in:sekolah,peneliti,mitra_desa',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:3072',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('programs', 'public');
            $validated['image_path'] = $path;
        }

        Program::create($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan!');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'target' => 'required|string|in:sekolah,peneliti,mitra_desa',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:3072',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('programs', 'public');
            $validated['image_path'] = $path;
        }

        $program->update($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui!');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus!');
    }
}

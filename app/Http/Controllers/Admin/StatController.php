<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::orderBy('order')->get();

        return view('admin.stats.index', compact('stats'));
    }

    public function create()
    {
        return view('admin.stats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:150',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Stat::create($validated);

        return redirect()->route('admin.stats.index')->with('success', 'Statistik berhasil ditambahkan!');
    }

    public function edit(Stat $stat)
    {
        return view('admin.stats.edit', compact('stat'));
    }

    public function update(Request $request, Stat $stat)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:150',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $stat->update($validated);

        return redirect()->route('admin.stats.index')->with('success', 'Statistik berhasil diperbarui!');
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();

        return redirect()->route('admin.stats.index')->with('success', 'Statistik berhasil dihapus!');
    }
}

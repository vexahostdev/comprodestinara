<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('order')->orderBy('id')->get();

        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.form', [
            'member' => new TeamMember,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'affiliation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $validated['photo'] = $path;
        }

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('success', 'Anggota kurator/tim berhasil ditambahkan!');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.form', [
            'member' => $team,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'affiliation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($team->photo && str_starts_with($team->photo, 'team/')) {
                Storage::disk('public')->delete($team->photo);
            }
            $path = $request->file('photo')->store('team', 'public');
            $validated['photo'] = $path;
        }

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        $team->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Data anggota kurator/tim berhasil diperbarui!');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->photo && str_starts_with($team->photo, 'team/')) {
            Storage::disk('public')->delete($team->photo);
        }

        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Anggota kurator/tim berhasil dihapus!');
    }
}

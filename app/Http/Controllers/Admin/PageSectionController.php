<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageSectionController extends Controller
{
    protected array $pages = [
        'home' => 'Beranda',
        'about' => 'Tentang Kami',
        'for-schools' => 'Untuk Sekolah',
        'for-researchers' => 'Untuk Peneliti',
        'for-villages' => 'Mitra Desa',
        'contact' => 'Kontak',
    ];

    public function index(Request $request)
    {
        $activePage = $request->query('page', 'home');

        if (! array_key_exists($activePage, $this->pages)) {
            $activePage = 'home';
        }

        $sections = PageSection::where('page_slug', $activePage)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return view('admin.pages.index', [
            'pages' => $this->pages,
            'activePage' => $activePage,
            'sections' => $sections,
        ]);
    }

    public function edit(PageSection $page)
    {
        // Parameter name in route is $page or $section
        $section = $page;

        return view('admin.pages.edit', [
            'section' => $section,
            'pages' => $this->pages,
        ]);
    }

    public function update(Request $request, PageSection $page)
    {
        $section = $page;

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_caption' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'items' => 'nullable|array',
        ]);

        if ($request->hasFile('image_file')) {
            // Delete old uploaded image if it was stored in storage
            if ($section->image && str_starts_with($section->image, 'page-sections/')) {
                Storage::disk('public')->delete($section->image);
            }
            $path = $request->file('image_file')->store('page-sections', 'public');
            $section->image = $path;
        }

        $section->title = $validated['title'] ?? null;
        $section->subtitle = $validated['subtitle'] ?? null;
        $section->badge = $validated['badge'] ?? null;
        $section->content = $validated['content'] ?? null;
        $section->image_caption = $validated['image_caption'] ?? null;
        $section->button_text = $validated['button_text'] ?? null;
        $section->button_link = $validated['button_link'] ?? null;
        $section->secondary_button_text = $validated['secondary_button_text'] ?? null;
        $section->secondary_button_link = $validated['secondary_button_link'] ?? null;
        $section->is_active = $request->boolean('is_active', true);

        if ($request->has('items')) {
            $filteredItems = array_values(array_filter($request->input('items', []), function ($item) {
                return ! empty($item['title']) || ! empty($item['stat']) || ! empty($item['desc']);
            }));
            $section->items = ! empty($filteredItems) ? $filteredItems : null;
        }

        $section->save();

        return redirect()->route('admin.pages.index', ['page' => $section->page_slug])
            ->with('success', "Section '{$section->section_name}' pada halaman {$this->pages[$section->page_slug]} berhasil diperbarui!");
    }

    public function toggle(PageSection $page)
    {
        $section = $page;
        $section->is_active = ! $section->is_active;
        $section->save();

        $status = $section->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Section '{$section->section_name}' berhasil {$status}!");
    }
}

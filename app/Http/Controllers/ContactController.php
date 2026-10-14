<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\PageSection;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $sections = PageSection::where('page_slug', 'contact')
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        return view('kontak', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'institution' => 'required|string|max:150',
            'whatsapp' => 'required|string|max:50',
            'topic' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:3000',
        ]);

        $message = ContactMessage::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('site.form.success_msg'),
            ]);
        }

        return redirect()->back()->with('success', __('site.form.success_msg'));
    }
}

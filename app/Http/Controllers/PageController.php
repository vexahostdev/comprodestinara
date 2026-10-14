<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use App\Models\Program;
use App\Models\Stat;
use App\Models\TeamMember;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function about()
    {
        $sections = PageSection::where('page_slug', 'about')
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        $team = TeamMember::active()->get();

        return view('tentang-kami', [
            'sections' => $sections,
            'team' => $team,
            'stats' => Stat::active()->get(),
            'testimonials' => Testimonial::active()->get(),
        ]);
    }

    public function forSchools()
    {
        $sections = PageSection::where('page_slug', 'for-schools')
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        $programs = Program::active()->forTarget('sekolah')->get();

        return view('untuk-sekolah', compact('programs', 'sections'));
    }

    public function forResearchers()
    {
        $sections = PageSection::where('page_slug', 'for-researchers')
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        $programs = Program::active()->forTarget('peneliti')->get();

        return view('untuk-peneliti', compact('programs', 'sections'));
    }

    public function forVillages()
    {
        $sections = PageSection::where('page_slug', 'for-villages')
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        $programs = Program::active()->forTarget('mitra_desa')->get();

        return view('mitra-desa', compact('programs', 'sections'));
    }
}

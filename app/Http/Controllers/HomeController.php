<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Story;
use App\Models\Program;
use App\Models\Testimonial;
use App\Models\Stat;
use App\Models\PageSection;

class HomeController extends Controller
{
    public function index()
    {
        $sections = PageSection::where('page_slug', 'home')
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        return view('home', [
            'sections' => $sections,
            'featuredDestinations' => Destination::active()->orderByDesc('is_featured')->take(4)->get(),
            'allDestinations' => Destination::active()->get(),
            'stories' => Story::active()->take(3)->get(),
            'programs' => Program::active()->get(),
            'testimonials' => Testimonial::active()->get(),
            'stats' => Stat::active()->get(),
        ]);
    }
}
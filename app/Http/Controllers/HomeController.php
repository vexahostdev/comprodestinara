<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use App\Models\Program;
use App\Models\Stat;
use App\Models\Story;
use App\Models\Testimonial;
use App\Services\CoreSystemClient;

class HomeController extends Controller
{
    public function index(CoreSystemClient $coreClient)
    {
        $sections = PageSection::where('page_slug', 'home')
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        $destinationsRes = $coreClient->getDestinations(['featured' => 1, 'per_page' => 6]);
        $destinations = collect($destinationsRes['data'] ?? [])->map(function ($d) {
            $obj = (object) $d;
            $obj->location = ! empty($obj->city) ? ($obj->city.(! empty($obj->province) ? ', '.$obj->province : '')) : ($obj->province ?? '');
            $obj->image_url = $obj->cover_url ?? asset('assets/img/hd/hero-fieldwork.jpg');
            $obj->lead = $obj->short_description ?? '';
            $obj->category_name = is_array($obj->category) ? ($obj->category['name'] ?? '') : (is_object($obj->category) ? ($obj->category->name ?? '') : (string) $obj->category);

            return $obj;
        });

        return view('home', [
            'sections' => $sections,
            'featuredDestinations' => $destinations->take(4),
            'allDestinations' => $destinations,
            'stories' => Story::active()->take(3)->get(),
            'programs' => Program::active()->get(),
            'testimonials' => Testimonial::active()->get(),
            'stats' => Stat::active()->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Program;
use App\Models\Story;
use App\Models\Testimonial;
use App\Services\CoreSystemClient;

class DashboardController extends Controller
{
    public function index(CoreSystemClient $coreClient)
    {
        $stats = $coreClient->getStats();
        $destinationsRes = $coreClient->getDestinations(['per_page' => 4]);

        return view('admin.dashboard', [
            'totalDestinations' => $stats['published_destinations'] ?? 0,
            'totalStories' => Story::count(),
            'totalPrograms' => Program::count(),
            'totalTestimonials' => Testimonial::count(),
            'totalMessages' => ContactMessage::count(),
            'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
            'recentDestinations' => $destinationsRes['data'] ?? [],
        ]);
    }
}

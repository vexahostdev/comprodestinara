<?php

namespace App\Http\Controllers;

use App\Services\CoreSystemClient;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request, CoreSystemClient $client)
    {
        $params = [];
        if ($request->filled('category') && $request->category !== 'all') {
            $params['category'] = $request->category;
        }

        if ($request->filled('province')) {
            $params['province'] = $request->province;
        }

        if ($request->filled('q')) {
            $params['q'] = $request->q;
        }

        if ($request->filled('page')) {
            $params['page'] = (int) $request->page;
        }

        $response = $client->getDestinations($params);
        $destinations = collect($response['data'] ?? [])->map(function ($d) {
            $obj = (object) $d;
            $obj->location = ! empty($obj->city) ? ($obj->city.(! empty($obj->province) ? ', '.$obj->province : '')) : ($obj->province ?? '');
            $obj->image_url = $obj->cover_url ?? ($obj->image_url ?? asset('assets/img/hd/hero-fieldwork.jpg'));
            $obj->lead = $obj->short_description ?? ($obj->lead ?? '');
            $categoryName = is_array($obj->category ?? null) ? ($obj->category['name'] ?? ($obj->category['slug'] ?? '')) : (is_object($obj->category ?? null) ? ($obj->category->name ?? '') : (string) ($obj->category ?? ''));
            $obj->category_name = $categoryName;
            $obj->category = $categoryName;
            $obj->badge = $obj->badge ?? (! empty($obj->is_featured) ? 'Unggulan' : null);

            return $obj;
        });

        $meta = $response['meta'] ?? [];
        $totalActive = $meta['total'] ?? $destinations->count();
        $categories = $client->getCategories();

        return view('destinasi.index', compact('destinations', 'totalActive', 'categories', 'meta'));
    }

    public function show(string $slug, CoreSystemClient $client)
    {
        $data = $client->getDestination($slug);

        if (! $data) {
            abort(404, 'Destinasi tidak ditemukan.');
        }

        $destination = (object) $data;
        $destination->location = ! empty($destination->city) ? ($destination->city.(! empty($destination->province) ? ', '.$destination->province : '')) : ($destination->province ?? '');
        $destination->image_url = $destination->cover_url ?? ($destination->image_url ?? asset('assets/img/hd/hero-fieldwork.jpg'));
        $destination->cover_image_url = $destination->image_url;
        $destination->lead = $destination->short_description ?? ($destination->lead ?? '');
        $destination->badge = $destination->badge ?? (! empty($destination->is_featured) ? 'Unggulan' : null);

        $categoryName = '';
        if (isset($destination->category)) {
            if (is_array($destination->category)) {
                $categoryName = $destination->category['name'] ?? ($destination->category['slug'] ?? '');
            } elseif (is_object($destination->category)) {
                $categoryName = $destination->category->name ?? ($destination->category->slug ?? '');
            } else {
                $categoryName = (string) $destination->category;
            }
        }
        $destination->category_name = $categoryName;
        $destination->category = $categoryName;

        // Map educational highlights to module_name and research_focus if missing
        $highlights = $destination->educational_highlights ?? [];
        $highlightText = is_array($highlights) ? implode(', ', $highlights) : (string) $highlights;
        $destination->module_name = $destination->module_name ?? (! empty($highlightText) ? $highlightText : null);
        $destination->research_focus = $destination->research_focus ?? (! empty($highlightText) ? $highlightText : null);

        // Normalize packages with price_per_pax and formatted price
        $packages = collect($destination->packages ?? [])->map(function ($p) {
            $pkg = (object) $p;
            $price = $pkg->price_per_pax ?? ($pkg->price ?? 0);
            $pkg->price = $price;
            $pkg->price_per_pax = $price;
            $pkg->price_formatted = 'Rp '.number_format((float) $price, 0, ',', '.');

            return $pkg;
        });
        $destination->packages = $packages;

        // Normalize capacity
        if (empty($destination->capacity)) {
            if ($packages->isNotEmpty()) {
                $minPax = $packages->min('min_pax') ?: 10;
                $maxPax = $packages->max('max_pax') ?: 50;
                $destination->capacity = "{$minPax}-{$maxPax} Peserta";
            } else {
                $destination->capacity = '20-50 Peserta';
            }
        }

        $destination->reviews = collect($destination->reviews ?? [])->map(fn ($r) => (object) $r);

        // Fetch related destinations
        $allRes = $client->getDestinations(['per_page' => 4]);
        $related = collect($allRes['data'] ?? [])
            ->filter(fn ($d) => ($d['slug'] ?? '') !== $slug)
            ->take(3)
            ->map(function ($d) {
                $obj = (object) $d;
                $obj->location = ! empty($obj->city) ? ($obj->city.(! empty($obj->province) ? ', '.$obj->province : '')) : ($obj->province ?? '');
                $obj->image_url = $obj->cover_url ?? ($obj->image_url ?? asset('assets/img/hd/hero-fieldwork.jpg'));
                $obj->lead = $obj->short_description ?? ($obj->lead ?? '');
                $obj->badge = $obj->badge ?? (! empty($obj->is_featured) ? 'Unggulan' : null);

                return $obj;
            });

        return view('destinasi.show', compact('destination', 'related'));
    }
}

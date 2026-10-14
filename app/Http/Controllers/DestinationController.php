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
            $obj->image_url = $obj->cover_url ?? asset('assets/img/hd/hero-fieldwork.jpg');
            $obj->lead = $obj->short_description ?? '';
            $obj->category_name = is_array($obj->category) ? ($obj->category['name'] ?? '') : (is_object($obj->category) ? ($obj->category->name ?? '') : (string) $obj->category);

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
        $destination->image_url = $destination->cover_url ?? asset('assets/img/hd/hero-fieldwork.jpg');
        $destination->lead = $destination->short_description ?? '';
        $destination->category_name = is_array($destination->category) ? ($destination->category['name'] ?? '') : (is_object($destination->category) ? ($destination->category->name ?? '') : (string) $destination->category);
        $destination->packages = collect($destination->packages ?? [])->map(fn ($p) => (object) $p);
        $destination->reviews = collect($destination->reviews ?? [])->map(fn ($r) => (object) $r);

        // Fetch related destinations
        $allRes = $client->getDestinations(['per_page' => 4]);
        $related = collect($allRes['data'] ?? [])
            ->filter(fn ($d) => ($d['slug'] ?? '') !== $slug)
            ->take(3)
            ->map(function ($d) {
                $obj = (object) $d;
                $obj->location = ! empty($obj->city) ? ($obj->city.(! empty($obj->province) ? ', '.$obj->province : '')) : ($obj->province ?? '');
                $obj->image_url = $obj->cover_url ?? asset('assets/img/hd/hero-fieldwork.jpg');
                $obj->lead = $obj->short_description ?? '';

                return $obj;
            });

        return view('destinasi.show', compact('destination', 'related'));
    }
}

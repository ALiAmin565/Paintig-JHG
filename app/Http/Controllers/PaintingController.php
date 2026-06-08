<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaintingRequest;
use App\Http\Requests\UpdatePaintingRequest;
use App\Models\Hotel;
use App\Models\Painting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PaintingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Painting::query()->with('hotel');

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('media', 'like', "%{$search}%")
                    ->orWhere('owned_by', 'like', "%{$search}%");
            });
        }

        if ($hotelId = $request->integer('hotel_id')) {
            $query->where('hotel_id', $hotelId);
        }

        $sort = $request->string('sort')->toString();
        match ($sort) {
            'year_asc' => $query->orderBy('production_year'),
            'year_desc' => $query->orderByDesc('production_year'),
            'title_asc' => $query->orderBy('title'),
            default => $query->orderByDesc('created_at'),
        };

        $paintings = $query->paginate(15)->withQueryString();
        $hotels = Hotel::orderBy('name')->get(['id', 'name']);

        return view('paintings.index', compact('paintings', 'hotels'));
    }

    public function create(Request $request): View
    {
        $hotels = Hotel::where('status', 'active')->orderBy('name')->get();
        $selectedHotelId = $request->integer('hotel_id') ?: null;

        return view('paintings.create', compact('hotels', 'selectedHotelId'));
    }

    public function store(StorePaintingRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('photo');
        $data = array_merge($data, $this->extractPhotoData($request));

        Painting::create($data);

        return redirect()
            ->route('paintings.index')
            ->with('success', 'Painting created successfully.');
    }

    public function show(Painting $painting): View
    {
        $painting->load('hotel');

        return view('paintings.show', compact('painting'));
    }

    public function photo(Painting $painting): Response
    {
        if (! $painting->hasPhoto()) {
            abort(404);
        }

        return response($painting->photo, 200, [
            'Content-Type' => $painting->photo_mime ?? 'application/octet-stream',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function edit(Painting $painting): View
    {
        $hotels = Hotel::where('status', 'active')->orderBy('name')->get();

        return view('paintings.edit', compact('painting', 'hotels'));
    }

    public function update(UpdatePaintingRequest $request, Painting $painting): RedirectResponse
    {
        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            $data = array_merge($data, $this->extractPhotoData($request));
        }

        $painting->update($data);

        return redirect()
            ->route('paintings.show', $painting)
            ->with('success', 'Painting updated successfully.');
    }

    public function destroy(Painting $painting): RedirectResponse
    {
        $painting->delete();

        return redirect()
            ->route('paintings.index')
            ->with('success', 'Painting deleted successfully.');
    }

    private function extractPhotoData(Request $request): array
    {
        $file = $request->file('photo');

        return [
            'photo' => file_get_contents($file->getRealPath()),
            'photo_mime' => $file->getMimeType(),
        ];
    }
}

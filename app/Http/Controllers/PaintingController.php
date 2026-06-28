<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaintingRequest;
use App\Http\Requests\UpdatePaintingRequest;
use App\Models\Gallery;
use App\Models\Hotel;
use App\Models\Location;
use App\Models\Painting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PaintingController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\Response
    {
        $query = Painting::query()->with(['hotel', 'location']);
        $this->applyFilters($request, $query);

        $paintings = $query->paginate(15)->withQueryString();
        $hotels = Hotel::orderBy('name')->get(['id', 'name']);
        $locations = Location::orderBy('name')->get(['id', 'name']);

        if ($request->ajax()) {
            return response()->view('paintings._index-results', compact('paintings'));
        }

        return view('paintings.index', compact('paintings', 'hotels', 'locations'));
    }

    public function create(Request $request): View
    {
        $hotels = Hotel::where('status', 'active')->orderBy('name')->get();
        $selectedHotelId = $request->integer('hotel_id') ?: null;

        return view('paintings.create', compact('hotels', 'selectedHotelId'));
    }

    public function store(StorePaintingRequest $request): RedirectResponse
    {
        $data = $this->preparePaintingData($request);
        $data = array_merge($data, $this->extractPhotoData($request));

        $painting = Painting::create($data);

        return redirect()
            ->route('paintings.index')
            ->with('success', 'Painting created successfully.');
    }

    public function show(Painting $painting): View
    {
        $painting->load(['hotel', 'location', 'gallery', 'notes.user']);

        return view('paintings.show', compact('painting'));
    }

    public function print(Painting $painting): View
    {
        $painting->load(['hotel', 'location', 'gallery', 'notes.user']);

        return view('paintings.print-single', compact('painting'));
    }

    public function printAll(Request $request): View
    {
        $query = Painting::query()->with(['hotel', 'location', 'gallery', 'notes']);
        $this->applyFilters($request, $query);

        $paintings = $query->get();

        return view('paintings.print-all', compact('paintings'));
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
        $painting->load(['location', 'gallery']);

        return view('paintings.edit', compact('painting', 'hotels'));
    }

    public function update(UpdatePaintingRequest $request, Painting $painting): RedirectResponse
    {
        $data = $this->preparePaintingData($request, $painting);

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
        $painting->deleteCertificateFile();
        $painting->delete();

        return redirect()
            ->route('paintings.index')
            ->with('success', 'Painting deleted successfully.');
    }

    private function preparePaintingData(Request $request, ?Painting $painting = null): array
    {
        $data = $request->safe()->except(['photo', 'certificate_file', 'new_location_name', 'new_gallery_name']);

        $locationType = $request->input('location_type');

        if ($locationType === 'hotel') {
            $data['location_id'] = null;
        } elseif ($locationType === 'location') {
            $data['hotel_id'] = null;

            if (! $request->filled('location_id') && $request->filled('new_location_name')) {
                $location = Location::firstOrCreate(
                    ['name' => trim($request->input('new_location_name'))],
                    ['description' => null]
                );
                $data['location_id'] = $location->id;
            }
        } else {
            $data['hotel_id'] = null;
            $data['location_id'] = null;
        }

        $purchasedFromType = $request->input('purchased_from_type');

        if ($purchasedFromType === 'gallery') {
            $data['purchased_from_person'] = null;

            if (! $request->filled('gallery_id') && $request->filled('new_gallery_name')) {
                $gallery = Gallery::firstOrCreate(
                    ['name' => trim($request->input('new_gallery_name'))],
                    ['description' => null]
                );
                $data['gallery_id'] = $gallery->id;
            }
        } else {
            $data['gallery_id'] = null;
        }

        if ($request->input('certificate_type') === 'text') {
            $data['certificate_file_path'] = null;
            if ($painting) {
                $painting->deleteCertificateFile();
            }
        } elseif ($request->input('certificate_type') === 'file' && $request->hasFile('certificate_file')) {
            if ($painting) {
                $painting->deleteCertificateFile();
            }
            $data['certificate_file_path'] = $request->file('certificate_file')->store('certificates', 'public');
            $data['certificate_text'] = null;
        }

        return $data;
    }

    private function extractPhotoData(Request $request): array
    {
        $file = $request->file('photo');

        return [
            'photo' => file_get_contents($file->getRealPath()),
            'photo_mime' => $file->getMimeType(),
        ];
    }

    private function applyFilters(Request $request, $query): void
    {
        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('media', 'like', "%{$search}%")
                    ->orWhere('painter_name', 'like', "%{$search}%")
                    ->orWhere('owned_by', 'like', "%{$search}%");
            });
        }

        if ($locationType = $request->string('location_type')->trim()->toString()) {
            $query->where('location_type', $locationType);
        }

        if ($hotelId = $request->integer('hotel_id')) {
            $query->where('location_type', 'hotel')->where('hotel_id', $hotelId);
        }

        if ($locationId = $request->integer('location_id')) {
            $query->where('location_type', 'location')->where('location_id', $locationId);
        }

        $sort = $request->string('sort')->toString();
        match ($sort) {
            'year_asc' => $query->orderBy('production_year'),
            'year_desc' => $query->orderByDesc('production_year'),
            'title_asc' => $query->orderBy('title'),
            'price_desc' => $query->orderByDesc('price'),
            'price_asc' => $query->orderBy('price'),
            default => $query->orderByDesc('created_at'),
        };
    }
}

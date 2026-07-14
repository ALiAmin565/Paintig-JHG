<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Models\Hotel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Hotel::class);
        
        $query = Hotel::query()->withCount('paintings');

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('pms_code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->trim()->toString()) {
            $query->where('status', $status);
        }

        $hotels = $query->orderBy('name')->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return view('hotels._table', compact('hotels'));
        }

        return view('hotels.index', compact('hotels'));
    }

    public function create(): View
    {
        $this->authorize('create', Hotel::class);
        
        return view('hotels.create');
    }

    public function store(StoreHotelRequest $request): RedirectResponse
    {
        $hotel = Hotel::create($request->validated());

        return redirect()
            ->route('hotels.show', $hotel)
            ->with('success', 'Hotel created successfully.');
    }

    public function show(Hotel $hotel): View
    {
        $this->authorize('view', $hotel);
        
        $hotel->loadCount('paintings');
        $paintings = $hotel->paintings()->latest()->paginate(12);

        return view('hotels.show', compact('hotel', 'paintings'));
    }

    public function edit(Hotel $hotel): View
    {
        $this->authorize('update', $hotel);
        
        return view('hotels.edit', compact('hotel'));
    }

    public function update(UpdateHotelRequest $request, Hotel $hotel): RedirectResponse
    {
        $hotel->update($request->validated());

        return redirect()
            ->route('hotels.show', $hotel)
            ->with('success', 'Hotel updated successfully.');
    }

    public function destroy(Hotel $hotel): RedirectResponse
    {
        $this->authorize('delete', $hotel);
        
        // Check if hotel has paintings
        if ($hotel->paintings()->count() > 0) {
            return redirect()
                ->route('hotels.index')
                ->with('error', 'Cannot delete hotel with associated paintings.');
        }

        $hotel->delete();

        return redirect()
            ->route('hotels.index')
            ->with('success', 'Hotel deleted successfully.');
    }
}

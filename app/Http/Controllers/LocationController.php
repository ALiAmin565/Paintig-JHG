<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Location::query()->withCount('paintings')->orderBy('name');

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $locations = $query->paginate(15)->withQueryString();

        return view('locations.index', compact('locations'));
    }

    public function create(): View
    {
        return view('locations.create');
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        Location::create($request->validated());

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function edit(Location $location): View
    {
        return view('locations.edit', compact('location'));
    }

    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Only admins can delete locations.');
        }

        if ($location->paintings()->exists()) {
            return back()->with('error', 'Cannot delete a location that is assigned to paintings.');
        }

        $location->delete();

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}

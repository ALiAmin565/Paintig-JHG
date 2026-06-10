<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Location::query()->orderBy('name');

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $locations = $query->limit(50)->get(['id', 'name', 'description']);

        return response()->json($locations);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('locations', 'name')],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $location = Location::create($validated);

        return response()->json($location, 201);
    }
}

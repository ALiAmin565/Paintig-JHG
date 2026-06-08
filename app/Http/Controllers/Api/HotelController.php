<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Hotel::query()->orderBy('name');

        if (! $request->boolean('all_statuses')) {
            $query->where('status', 'active');
        }

        if ($status = $request->string('status')->trim()->toString()) {
            $query->where('status', $status);
        }

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('pms_code', 'like', "%{$search}%");
            });
        }

        $hotels = $query->limit(50)->get(['id', 'name', 'pms_code', 'status']);

        return response()->json($hotels);
    }
}

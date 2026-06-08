<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    public function index(Request $request): View
    {
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

    public function show(Hotel $hotel): View
    {
        $hotel->loadCount('paintings');
        $paintings = $hotel->paintings()->latest()->paginate(12);

        return view('hotels.show', compact('hotel', 'paintings'));
    }
}

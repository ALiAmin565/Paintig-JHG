<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Location;
use App\Models\Painting;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'paintingsCount' => Painting::count(),
            'hotelsCount' => Hotel::count(),
            'locationsCount' => Location::count(),
            'usersCount' => User::where('status', 'active')->count(),
            'paintingsAtHotels' => Painting::where('location_type', 'hotel')->count(),
            'paintingsAtLocations' => Painting::where('location_type', 'location')->count(),
            'paintingsNoLocation' => Painting::where('location_type', 'none')->count(),
            'recentPaintings' => Painting::with(['hotel', 'location'])
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}

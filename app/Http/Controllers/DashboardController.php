<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Painting;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'hotelsCount' => Hotel::count(),
            'paintingsCount' => Painting::count(),
            'recentPaintings' => Painting::with('hotel')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaintingNoteRequest;
use App\Models\Painting;
use Illuminate\Http\RedirectResponse;

class PaintingNoteController extends Controller
{
    public function store(StorePaintingNoteRequest $request, Painting $painting): RedirectResponse
    {
        $painting->notes()->create([
            'user_id' => auth()->id(),
            'body' => $request->validated('body'),
        ]);

        return redirect()
            ->route('paintings.show', $painting)
            ->with('success', 'Note added successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CastController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/Casts/Index', [
            'casts' => Cast::orderBy('updated_at', 'desc')->paginate(12),
        ]);
    }

    public function show(Cast $cast)
    {
        return Inertia::render('Frontend/Casts/Show', [
            'cast' => $cast,
            'movies' => $cast->movies,
        ]);
    }
}

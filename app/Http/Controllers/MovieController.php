<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/Movies/Index', [
            'movies' => Movie::orderBy('updated_at', 'desc')->with('genres')->paginate(12),
        ]);
    }

    public function show(Movie $movie)
    {
        return Inertia::render('Frontend/Movies/Show', [
            'latests' => Movie::orderBy('created_at', 'desc')->with('genres')->take(6)->get(),
            'movie' => $movie,
            'movieGenres' => $movie->genres,
            'casts' => $movie->casts,
            'tags' => $movie->tags,
            'trailers' => $movie->trailers,
            'downloads' => $movie->downloads,
        ]);
    }
}

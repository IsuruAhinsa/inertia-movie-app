<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GenreController extends Controller
{
    public function show(Genre $genre)
    {
        return Inertia::render('Frontend/Genres/Index', [
            'movies' => $genre->movies()->paginate(12),
            'genre' => $genre,
        ]);
    }
}

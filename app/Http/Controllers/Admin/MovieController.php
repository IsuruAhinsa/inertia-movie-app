<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index()
    {
        return Inertia::render('Movies/Index', [
            'movies' => Movie::query()
                        ->when(request()->input('search'), function ($query, $search) {
                            return $query->where('title', 'like', "%{$search}%");
                        })
                        ->paginate(request()->input('perPage', 5))
                        ->withQueryString(),

            'filters' => request()->only(['search', 'perPage']),
        ]);
    }

    public function store(Request $request)
    {
        $movie =Movie::where('tmdb_id', $request->input('movieTMDBId'))->exists();

        $tmdb_movie = Http::asJson()->get(config('services.tmdb.endpoint') . 'movie/' . $request->input('movieTMDBId') . '?api_key=' . config('services.tmdb.secret') .'&language=en-US');

        if ($movie) {
            return redirect()
            ->back()
            ->with('flash.banner', 'Movie Exists.');
        }

        if ($tmdb_movie->successful()) {
            $createdMovie = Movie::create([
                'tmdb_id' => $tmdb_movie['id'],
                'title' => $tmdb_movie['title'],
                'release_date' => $tmdb_movie['release_date'],
                'runtime' => $tmdb_movie['runtime'],
                'lang' => $tmdb_movie['original_language'],
                'video_format' => 'HD',
                'is_public' => false,
                'rating' => $tmdb_movie['vote_average'],
                'poster_path' => $tmdb_movie['poster_path'],
                'backdrop_path' => $tmdb_movie['backdrop_path'],
                'overview' => $tmdb_movie['overview'],
            ]);

            // Many To Many Relationships
            $tmdb_movie_genres = $tmdb_movie['genres'];
            $tmdb_movie_genres_IDs = collect($tmdb_movie_genres)->pluck('id');
            $genres = Genre::whereIn('tmdb_id', $tmdb_movie_genres_IDs)->get();
            $createdMovie->genres()->attach($genres);

            return redirect()
            ->back()
            ->with('flash.banner', 'Movie Created.');
        } else {
            return redirect()
            ->back()
            ->with('flash.banner', 'API Error.')
            ->with('flash.bannerStyle', 'danger');
        }
    }

    public function edit(Movie $movie)
    {
        return Inertia::render('Movies/Edit', [
            'movie' => $movie,
        ]);
    }

    public function update(Request $request, Movie $movie)
    {
        $movie->update($request->validate([
            'title' => 'required',
            'release_date' => 'required|date',
            'runtime' => 'required|numeric',
            'lang' => 'required|string|min:2',
            'video_format' => 'required|string|min:2',
            'rating' => 'required|numeric',
            'poster_path' => 'required|string',
            'backdrop_path' => 'required|string',
            'overview' => 'required|string',
            'is_public' => 'nullable|boolean',
        ]));

        return redirect()
                ->route('admin.movies.index')
                ->with('flash.banner', 'Movie Updated.');
    }

    public function destroy(Movie $movie)
    {
        $movie->genres()->sync([]);

        $movie->delete();

        return redirect()
        ->route('admin.movies.index')
            ->with('flash.banner', 'Movie Deleted.')
            ->with('flash.bannerStyle', 'danger');
    }
}

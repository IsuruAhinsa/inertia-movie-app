<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class GenreController extends Controller
{
    public function index()
    {
        return Inertia::render('Genres/Index', [
            'genres' => Genre::query()
                ->when(request()->input('search'), function ($query, $search) {
                    return $query->where('title', 'like', "%{$search}%");
                })
                ->paginate(request()->input('perPage', 5))
                ->withQueryString(),

            'filters' => request()->only(['perPage', 'search']),
        ]);
    }

    public function store(Request $request)
    {
        $tmdb_genres = Http::get(config('services.tmdb.endpoint') . 'genre/movie/list?api_key=' . config('services.tmdb.secret') . '&language=en-US');

        if ($tmdb_genres->successful()) {
            $tmdb_genres_json = $tmdb_genres->json();
            foreach ($tmdb_genres_json as $single_tmdb_genre) {
                foreach ($single_tmdb_genre as $tmdb_genre) {
                    $genre = Genre::where('tmdb_id', $tmdb_genre['id'])->first();
                    if (!$genre) {
                        Genre::create([
                            'tmdb_id' => $tmdb_genre['id'],
                            'title' => $tmdb_genre['name'],
                        ]);
                    }
                }
            }
            return redirect()
                ->back()
                ->with('flash.banner', 'Genres Genrated.');
        }
        return redirect()
            ->back()
            ->with('flash.banner', 'API Error.')
            ->with('flash.bannerStyle', 'danger');
    }

    public function edit(Genre $genre)
    {
        return Inertia::render('Genres/Edit', ['genre' => $genre]);
    }

    public function update(Request $request, Genre $genre)
    {
        $genre->update($request->validate([
            'title' => 'required',
        ]));

        return redirect()
                ->route('admin.genres.index')
                ->with('flash.banner', 'Genres Updated.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()
            ->back()
            ->with('flash.banner', 'Genre Deleted.')
            ->with('flash.bannerStyle', 'danger');
    }
}

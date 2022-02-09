<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class SeasonController extends Controller
{
    public function index(TvShow $tvShow)
    {
        return Inertia::render('TvShows/Seasons/Index', [
            'tvShow' => $tvShow,

            'seasons' => Season::query()
                        ->where('tv_show_id', $tvShow->id)
                        ->when(request()->input('search'), function ($query, $search) {
                            return $query->where('name', 'like', "%{$search}%");
                        })
                        ->paginate(request()->input('perPage', 5))
                        ->withQueryString(),

            'filters' => request()->only(['search', 'perPage']),
        ]);
    }

    public function store(Request $request, TvShow $tvShow)
    {
        $season = $tvShow->seasons()->where('season_number', $request->input('seasonNumber'))->exists();

        $tmdb_season = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . $tvShow->tmdb_id . '/season/' . $request->input('seasonNumber') . '?api_key=' . config('services.tmdb.secret') .'&language=en-US');

        if ($season) {
            return redirect()
            ->back()
            ->with('flash.banner', 'Season Exists.');
        }

        if ($tmdb_season->successful()) {
            Season::create([
                'tmdb_id' => $tmdb_season['id'],
                'tv_show_id' => $tvShow->id,
                'name' => $tmdb_season['name'],
                'slug' => Str::slug($tmdb_season['name']),
                'poster_path' => $tmdb_season['poster_path'],
                'season_number' => $tmdb_season['season_number'],
            ]);

            return redirect()
            ->back()
            ->with('flash.banner', 'Season Created.');
        } else {
            return redirect()
            ->back()
            ->with('flash.banner', 'API Error.')
            ->with('flash.bannerStyle', 'danger');
        }
    }

    public function edit(TvShow $tvShow, Season $season)
    {
        return Inertia::render('TvShows/Seasons/Edit', [
            'tvShow' => $tvShow,
            'season' => $season
        ]);
    }

    public function update(Request $request, TvShow $tvShow, Season $season)
    {
        $season->update($request->validate([
            'name' => 'required',
            'season_number' => 'required|numeric|min:1',
            'poster_path' => 'required',
        ]));

        return redirect()
                ->route('admin.seasons.index', $tvShow->id)
                ->with('flash.banner', 'Season Updated.');
    }

    public function destroy(TvShow $tvShow, Season $season)
    {
        $season->delete();

        return redirect()
            ->route('admin.seasons.index', $tvShow->id)
            ->with('flash.banner', 'Season Deleted.')
            ->with('flash.bannerStyle', 'danger');
    }
}

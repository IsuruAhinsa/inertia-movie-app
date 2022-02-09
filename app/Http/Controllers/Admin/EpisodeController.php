<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\Episode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TvShow;
use Illuminate\Support\Facades\Http;

class EpisodeController extends Controller
{
    public function index(TvShow $tvShow, Season $season)
    {
        return Inertia::render('TvShows/Seasons/Episodes/Index', [
            'season' => $season,

            'episodes' => Episode::query()
                        ->where('season_id', $season->id)
                        ->when(request()->input('search'), function ($query, $search) {
                            return $query->where('name', 'like', "%{$search}%");
                        })
                        ->paginate(request()->input('perPage', 5))
                        ->withQueryString(),

            'filters' => request()->only(['search', 'perPage']),

            'tvShow' => $tvShow,
        ]);
    }

    public function store(Request $request, TvShow $tvShow, Season $season)
    {
        $episode = $season->episodes()->where('episode_number', $request->input('episodeNumber'))->exists();

        $tmdb_episode = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . $tvShow->tmdb_id . '/season/' . $season->season_number . '/episode/' . $request->input('episodeNumber') . '?api_key=' . config('services.tmdb.secret') .'&language=en-US');

        if ($episode) {
            return redirect()
            ->back()
            ->with('flash.banner', 'Episode Exists.');
        }

        if ($tmdb_episode->successful()) {
            Episode::create([
                'tmdb_id' => $tmdb_episode['id'],
                'season_id' => $season->id,
                'name' => $tmdb_episode['name'],
                // 'poster_path' => $tmdb_episode['poster_path'],
                'episode_number' => $tmdb_episode['episode_number'],
                'overview' => $tmdb_episode['overview'],
            ]);

            return redirect()
            ->back()
            ->with('flash.banner', 'Episode Created.');
        } else {
            return redirect()
            ->back()
            ->with('flash.banner', 'API Error.')
            ->with('flash.bannerStyle', 'danger');
        }
    }

    public function edit(TvShow $tvShow, Season $season, Episode $episode)
    {
        return Inertia::render('TvShows/Seasons/Episodes/Edit', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episode' => $episode,
        ]);
    }

    public function update(Request $request, TvShow $tvShow, Season $season, Episode $episode)
    {
        $episode->update($request->validate([
            'name' => 'required',
            'episode_number' => 'required|numeric|min:1',
            'overview' => 'required|string',
            'is_public' => 'nullable|boolean',
        ]));

        return redirect()
                ->route('admin.episodes.index', [$tvShow->id, $season->id])
                ->with('flash.banner', 'Episode Updated.');
    }

    public function destroy(TvShow $tvShow, Season $season, Episode $episode)
    {
        $episode->delete();

        return redirect()
        ->route('admin.episodes.index', [$tvShow->id, $season->id])
            ->with('flash.banner', 'Episode Deleted.')
            ->with('flash.bannerStyle', 'danger');
    }
}

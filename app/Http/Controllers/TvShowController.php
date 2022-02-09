<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Season;
use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Http\Request;

class TvShowController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/TvShows/Index', [
            'tvShows' => TvShow::withCount('seasons')->orderBy('created_at', 'desc')->paginate(12),
        ]);
    }

    public function show(TvShow $tvShow)
    {
        return Inertia::render('Frontend/TvShows/Show', [
            'tvShow' => $tvShow,
            'seasons' => $tvShow->seasons,
            'latests' => TvShow::orderBy('created_at', 'desc')->take(6)->get(),
        ]);
    }

    public function showSeason(TvShow $tvShow, Season $season)
    {
        return Inertia::render('Frontend/TvShows/Seasons/Show', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episodes' => $season->episodes,
            'latests' => TvShow::orderBy('created_at', 'desc')->take(6)->get(),
        ]);
    }

    public function showEpisode(Episode $episode)
    {
        return Inertia::render('Frontend/TvShows/Seasons/Episodes/Show', [
            'episode' => $episode,
            'season' => $episode->season,
            'latests' => Episode::latest()->take(6)->get(),
        ]);
    }
}

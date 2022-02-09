<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\TvShow;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TvShowController extends Controller
{
    public function index()
    {
        return Inertia::render('TvShows/Index', [
            'tvShows' => TvShow::query()
                            ->when(request()->input('search'), function ($query, $search) {
                                return $query->where('name', 'like', "%{$search}%");
                            })
                            ->paginate(request()->input('perPage', 5))
                            ->withQueryString(),

            'filters' => request()->only(['search', 'perPage']),
        ]);
    }

    public function store(Request $request)
    {
        $tvShow = TvShow::where('tmdb_id', $request->input('tvShowTMDBId'))->first();

        $tmdb_tv_show = Http::asJson()->get(config('services.tmdb.endpoint') . 'tv/' . $request->input('tvShowTMDBId') . '?api_key=' . config('services.tmdb.secret') .'&language=en-US');

        if ($tvShow) {
            return redirect()
            ->back()
            ->with('flash.banner', 'Tv Show Exists.');
        }

        if ($tmdb_tv_show->successful()) {
            TvShow::create([
                'tmdb_id' => $tmdb_tv_show['id'],
                'name' => $tmdb_tv_show['name'],
                'slug' => Str::slug($tmdb_tv_show['name']),
                'poster_path' => $tmdb_tv_show['poster_path'],
                'created_year' => $tmdb_tv_show['first_air_date'],
            ]);

            return redirect()
            ->back()
            ->with('flash.banner', 'Tv Show Created.');
        } else {
            return redirect()
            ->back()
            ->with('flash.banner', 'API Error.')
            ->with('flash.bannerStyle', 'danger');
        }
    }

    public function edit(TvShow $tvShow)
    {
        return Inertia::render('TvShows/Edit', [
            'tvShow' => $tvShow,
        ]);
    }

    public function update(Request $request, TvShow $tvShow)
    {
        $tvShow->update($request->validate([
            'name' => 'required',
            'poster_path' => 'required',
            'created_year' => 'required|date',
        ]));

        return redirect()
                ->route('admin.tv-shows.index')
                ->with('flash.banner', 'TvShow Updated.');
    }

    public function destroy(TvShow $tvShow)
    {
        $tvShow->delete();

        return redirect()
            ->back()
            ->with('flash.banner', 'TvShow Deleted.')
            ->with('flash.bannerStyle', 'danger');
    }
}

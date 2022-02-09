<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cast;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CastController extends Controller
{
    public function index()
    {
        return Inertia::render('Casts/Index', [
            'casts' => Cast::query()
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
        $cast = Cast::where('tmdb_id', $request->input('castTMDBId'))->first();

        $tmdb_cast = Http::asJson()->get(config('services.tmdb.endpoint') . 'person/' . $request->input('castTMDBId') . '?api_key=' . config('services.tmdb.secret') .'&language=en-US');

        if ($cast) {
            return redirect()
            ->back()
            ->with('flash.banner', 'Cast Exists.');
        }

        if ($tmdb_cast->successful()) {
            Cast::create([
                'tmdb_id' => $tmdb_cast['id'],
                'name' => $tmdb_cast['name'],
                'slug' => Str::slug($tmdb_cast['name']),
                'poster_path' => $tmdb_cast['profile_path'],
            ]);

            return redirect()
            ->back()
            ->with('flash.banner', 'Cast Generated.');
        } else {
            return redirect()
            ->back()
            ->with('flash.banner', 'API Error.')
            ->with('flash.bannerStyle', 'danger');
        }
    }

    public function edit(Cast $cast)
    {
        return Inertia::render('Casts/Edit', [
            'cast' => $cast,
        ]);
    }

    public function update(Request $request, Cast $cast)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'poster_path' => 'required',
        ]);

        $cast->update($validatedData);

        return redirect()
            ->route('admin.casts.index')
            ->with('flash.banner', 'Cast Updated.');
    }

    public function destroy(Cast $cast)
    {
        $cast->delete();

        return redirect()
            ->route('admin.casts.index')
            ->with('flash.banner', 'Cast Deleted.')
            ->with('flash.bannerStyle', 'danger');
    }
}

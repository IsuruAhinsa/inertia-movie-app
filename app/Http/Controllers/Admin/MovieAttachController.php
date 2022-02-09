<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Movie;
use App\Models\TrailerUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Download;
use App\Models\Tag;

class MovieAttachController extends Controller
{
    public function index(Movie $movie)
    {
        return Inertia::render('Movies/Attach', [
            'movie' => $movie,
            'trailers' => $movie->trailers,
            'downloads' => $movie->downloads,
            'casts' => Cast::all('id', 'name'),
            'tags' => Tag::all('id', 'tag_name'),
            'movieCasts' => $movie->casts,
            'movieTags' => $movie->tags,
        ]);
    }

    public function addTrailer(Request $request, Movie $movie)
    {
        $movie->trailers()->create($request->validate([
            'name' => 'required',
            'embed_html' => 'required',
        ]));

        return redirect()
            ->back()
            ->with('flash.banner', 'Trailer Attached.');
    }

    public function destroyTrailer(TrailerUrl $trailerUrl)
    {
        $trailerUrl->delete();

        return redirect()
            ->back()
            ->with('flash.banner', 'Trailer Deleted.');
    }

    public function addCasts(Request $request, Movie $movie)    
    {
        $casts = $request->input('casts');

        $cast_ids = collect($casts)->pluck('id');

        $movie->casts()->sync($cast_ids);

        return redirect()
            ->back()
            ->with('flash.banner', 'Casts Attached.');
    }

    public function addTags(Request $request, Movie $movie)
    {
        $tags = $request->input('tags');

        $tag_ids = collect($tags)->pluck('id');

        $movie->tags()->sync($tag_ids);

        return redirect()
            ->back()
            ->with('flash.banner', 'Tags Attached.');
    }

    public function addDownload(Request $request, Movie $movie)
    {
        $movie->downloads()->create($request->validate([
            'name' => 'required',
            'web_url' => 'required',
        ]));

        return redirect()
            ->back()
            ->with('flash.banner', 'Download Attached.');
    }

    public function destroyDownload(Download $download)
    {
        $download->delete();

        return redirect()
            ->back()
            ->with('flash.banner', 'Download Deleted.');
    }
}

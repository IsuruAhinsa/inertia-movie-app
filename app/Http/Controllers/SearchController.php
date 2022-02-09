<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\Movie;
use App\Models\Season;
use App\Models\TvShow;
use App\Models\Episode;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function search()
    {
        $data = (new Search())
        ->registerModel(Movie::class, 'title')
        ->registerModel(TvShow::class, 'name')
        ->registerModel(Season::class, 'name')
        ->registerModel(Episode::class, 'name')
        ->registerModel(Cast::class, 'name')
        ->search(request()->input('search'));

        return response()->json($data);
    }
}

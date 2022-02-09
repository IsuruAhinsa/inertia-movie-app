<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        return Inertia::render('Frontend/Tags/Index', [
            'movies' => $tag->movies()->paginate(12),
            'tag' => $tag,
        ]);
    }
}

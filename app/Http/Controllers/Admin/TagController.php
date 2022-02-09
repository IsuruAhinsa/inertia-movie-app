<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index()
    {
        return Inertia::render('Tags/Index', [
            'tags' => Tag::query()
                ->when(request()->input('search'), function ($query, $search) {
                    $query->where('tag_name', 'like', "%{$search}%");
                })
                ->paginate(request()->input('perPage', 5))
                ->withQueryString(),

            'filters' => request()->only(['search', 'perPage']),
        ]);

        
    }

    public function create()
    {
        return Inertia::render('Tags/Create');
    }

    public function store(Request $request)
    {
        Tag::create([
            'tag_name' => $request->input('tagName'),
            'slug' => Str::slug($request->input('tagName'))
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('flash.banner', 'Tag Created.');
    }

    public function edit(Tag $tag)
    {
        return Inertia::render('Tags/Edit', [
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $tag->update([
            'tag_name' => $request->input('tagName'),
            'slug' => Str::slug($request->input('tagName'))
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('flash.banner', 'Tag Updated.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('flash.banner', 'Tag Deleted.')
            ->with('flash.bannerStyle', 'danger');
    }
}

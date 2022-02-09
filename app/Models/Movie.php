<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['tmdb_id', 'title', 'release_date', 'runtime', 'lang', 'video_format', 'slug', 'is_public', 'visits', 'rating', 'poster_path', 'backdrop_path', 'overview'];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('movies.show', $this->slug);
        
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
         );
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_movie');
    }

    public function trailers()
    {
        return $this->morphMany(TrailerUrl::class, 'trailerable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function casts()
    {
        return $this->belongsToMany(Cast::class, 'cast_movie');
    }

    public function downloads()
    {
        return $this->morphMany(Download::class, 'downloadable');
    }
}

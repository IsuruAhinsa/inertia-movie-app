<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['tmdb_id', 'season_id', 'name', 'episode_number', 'slug', 'is_public', 'visits', 'overview'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('episodes.show', $this->slug);
        
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
         );
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}

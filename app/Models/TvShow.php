<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TvShow extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['tmdb_id', 'name', 'slug', 'created_year', 'poster_path', 'visits'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('tv-shows.show', $this->slug);
        
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
         );
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

}

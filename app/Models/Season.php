<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;

class Season extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['tmdb_id', 'tv_show_id', 'name', 'season_number', 'slug', 'poster_path'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('seasons.show', $this->slug);
        
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
         );
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

}

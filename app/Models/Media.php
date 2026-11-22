<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'type',
        'title',
        'genres',
        'year',
        'score',
        'unit_count',
        'country',
        'author',
    ];

    protected $casts = [
        'genres'     => 'array',
        'year'       => 'integer',
        'score'      => 'float',
        'unit_count' => 'integer',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $keyword
            ? $query->where('title', 'like', "%{$keyword}%")
            : $query;
    }
}

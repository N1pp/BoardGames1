<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'rate',
        'comment'
    ];

    public function tags(): ?BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): ?HasMany
    {
        return $this->hasMany(Comment::class);
    }
}

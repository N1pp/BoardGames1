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

    public function tags(): ?HasMany
    {
        $this->hasManyThrough(Tag::class,ProductTag::class,'product_id','id','id','id');
    }

    public function comments(): HasMany
    {
        $this->hasMany(Comment::class);
    }
}

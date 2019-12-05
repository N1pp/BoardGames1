<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['value'];

    public function product()
    {
        $this->belongsToMany('/App/Product');
    }
}

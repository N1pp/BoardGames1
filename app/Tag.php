<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //TODO Разобраться со связями тегов
    protected $fillable = ['value'];

    public function product()
    {
        return $this->belongsToMany('/App/Product');
    }
}

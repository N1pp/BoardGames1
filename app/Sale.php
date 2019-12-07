<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // TODO Добавить возможность лайкать комменты и комментировать комменты
    protected $fillable = ['product_id','user_id','value'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable =[
        'user_id',
        'title',
        'image',
        'description',
        'price'
    ];
}

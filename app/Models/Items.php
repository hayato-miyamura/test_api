<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable =[
        'user_id',
        'title',
        'image',
        'description',
        'price'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}

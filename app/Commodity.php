<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'price',
        'stock',
        'unit',
        'type',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}

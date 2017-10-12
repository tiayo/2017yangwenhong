<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'commodity_id',
        'num',
        'price',
        'remark',
    ];

    public function commodity()
    {
        return $this->belongsTo('App\Commodity');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

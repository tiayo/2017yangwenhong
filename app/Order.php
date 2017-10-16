<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'business_id',
        'name',
        'address',
        'phone',
        'price',
        'type',
        'tracking',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function business()
    {
        return $this->belongsTo('App\User', 'business_id', 'id');
    }

    public function orderDetail()
    {
        return $this->hasMany('App\OrderDetail');
    }
}

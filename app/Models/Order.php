<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];


    public function details(){
        return $this->hasMany('App\Models\OrderDetail','order_id','id');
    }
    public function customer(){
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }
    public function country(){
        return $this->hasOne('App\Models\Country','id','country_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = 'customers';
    protected $guarded = ['id'];
    public function address(){
        return $this->belongsTo('App\Models\Address','id','customer_id');
    }
}

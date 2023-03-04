<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    public function country(){
        $country = $this->belongsTo('App\Models\Country', 'country_id', 'id')->first();
        return isset($country) ? $country->name : '';
    }
}

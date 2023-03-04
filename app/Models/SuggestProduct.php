<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestProduct extends Model
{
    protected $table = 'suggest_product';
    protected $guarded = ['id'];

    public function product(){
        return $this->hasOne('App\Models\Product','id','suggest_product_id');
    }
}

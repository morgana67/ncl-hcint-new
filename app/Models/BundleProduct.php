<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BundleProduct extends Model
{
    protected $table = 'bundle_product';
    protected $guarded = ['id'];

    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}

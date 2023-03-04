<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = ['id'];

    public function catalogs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\Catalog');
    }

    public function scopeActive($query){
        return $query->where('status','=',1);
    }

    public function scopeSimpleType($query){
        return $query->where('type','=','simple');
    }
    public function scopeBundleType($query){
        return $query->where('type','=','bundle');
    }

    public function scopeBundleFeatured($query){
        return $query->where('featured','=','1');
    }

    public function scopeAdditionalType($query){
        return $query->where('type','=','additional');
    }

    public function scopeNotIsAdditionalType($query){
        return $query->where('type','<>','additional');
    }

    public function productBundle() {
        return $this->belongsToMany('App\Models\BundleProduct', 'products', 'id', 'id', 'id', 'bundle_id');
    }

    public function productBundleTotalPrice() {
        $query = BundleProduct::select(DB::raw("SUM(IFNULL(products.sale_price, products.price)) as sum"))
                    ->join('products', 'products.id', '=', 'bundle_product.product_id')
                    ->where('bundle_id', $this->id);
        return !empty($query->first()->sum) ? $query->first()->sum : 0;
    }
}

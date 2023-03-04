<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $table = 'catalogs';
    protected $guarded = ['id'];


    public function catalog(){
        return $this->belongsTo(self::class,'parent_id','id');
    }

    public function children_catalogs(){
        return $this->hasMany(self::class,'parent_id','id');
    }

    public function scopeOnlyParent($query)
    {
        return $query->where('parent_id','=', 0)->orWhereNull('parent_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $table = "carts";
    protected $primaryKey = "id";
    protected $guarded=[];

    public function product(){
        return $this->hasOne('App\Product','id','product_id');
    }

}

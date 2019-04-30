<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryDetail extends Model
{
    //
    protected $table = "product_category_details";
    protected $primaryKey = "id";
    protected $guarded=[];

    public function product_category(){
        return $this->hasOne('App\ProductsCategory','id','category_id');
    }
}

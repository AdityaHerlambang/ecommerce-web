<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsCategory extends Model
{
    //
    protected $table = "product_categories";
    protected $primaryKey = "id";
    protected $guarded=[];

    public function detail(){
        return $this->hasMany('App\ProductCategoryDetail','category_id');
    }

}

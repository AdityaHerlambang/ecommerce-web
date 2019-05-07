<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "products";
    protected $primaryKey = "id";
    protected $guarded=[];

    public function product_category_detail(){
        $middle = $this->hasMany('App\ProductCategoryDetail', 'product_id');
        return $middle;
        // return $middle->getResults()->belongsTo('App\ProductCategory','id','category_id');
    }

    public function product_image(){
        return $this->hasMany('App\ProductImage', 'product_id');
    }

    public function discount(){
        return $this->hasMany('App\Discount', 'id_product');
    }

    public function product_review(){
        return $this->hasMany('App\ProductReview', 'product_id');
    }

}

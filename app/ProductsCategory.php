<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsCategory extends Model
{
    //
    protected $table = "product_categories";
    protected $primaryKey = "id";
    protected $guarded=[];

}

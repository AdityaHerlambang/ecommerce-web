<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    //
    protected $table = "product_reviews";
    protected $primaryKey = "id";
    protected $guarded=[];

    public function user(){
        return $this->hasOne('App\User','id','user_id');
    }

}

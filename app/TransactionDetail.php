<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    //
    protected $table = "transaction_details";
    protected $primaryKey = "id";
    protected $guarded=[];

    public function product(){
        return $this->hasOne('App\Product','id','product_id');
    }
}

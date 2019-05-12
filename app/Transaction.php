<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = "transactions";
    protected $primaryKey = "id";
    protected $guarded=[];

    public function detail(){
        return $this->hasMany('App\TransactionDetail','transaction_id');
    }
    public function courier(){
        return $this->hasOne('App\Courier','id','courier_id');
    }
    public function user(){
        return $this->hasOne('App\User','id','user_id');
    }
}

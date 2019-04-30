<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $table = "discounts";
    protected $primaryKey = "id";
    protected $guarded=[];
}

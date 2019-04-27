<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    //
    protected $table = "couriers";
    protected $primaryKey = "id";
    protected $guarded=[];
}

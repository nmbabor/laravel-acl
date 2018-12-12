<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventorySmallUnits extends Model
{
    protected $table='inventory_small_units';
    protected  $fillable=['id','unit_name','status','created_by','updated_by'];

}

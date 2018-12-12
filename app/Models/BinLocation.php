<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinLocation extends Model
{
    protected $table='bin_locations';
    protected $fillable=['location_name','details','status','created_by','updated_by'];


}

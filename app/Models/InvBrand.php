<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvBrand extends Model
{
    protected $table='inv_brands';
    protected $fillable=['brand_name','brand_description','brand_status','created_by','updated_by'];
}

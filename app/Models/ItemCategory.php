<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $table='item_categories';
    protected $fillable=['category_name','type','details','created_by','updated_by'];
}

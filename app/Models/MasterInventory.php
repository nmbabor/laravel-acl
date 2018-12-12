<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterInventory extends Model
{
    protected $table='master_inventories';
    protected $fillable=['item_id','model_id','available_qty','cost_price','sale_price','storage_id','created_by','updated_by','company_id','branch_id'];
}

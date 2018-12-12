<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected  $table='inventory_items';
    protected $fillable=['item_name','item_code','category_id','brand_id','item_unite_id','vendor_id','cost_price','sale_price','reorder_level','item_color','item_details','item_main_img','item_secondary_img','status','created_by','updated_by'];

    public function itemCategory(){
        return $this->belongsTo(ItemCategory::class,'category_id','id');
    }

    public function itemBrand(){
        return $this->belongsTo(InvBrand::class,'brand_id','id');
    }

    public function itemUnit(){
        return $this->belongsTo(InventorySmallUnits::class,'item_unite_id','id');
    }

    public function itemVendor(){
        return $this->belongsTo(InventoryVendor::class,'vendor_id','id');
    }
}

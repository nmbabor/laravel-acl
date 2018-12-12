<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryPurchaseOrderHistory extends Model
{
    protected $table='inventory_purchase_order_histories';
    protected $fillable=['inventory_purchase_order_id','inventory_item_id','inventory_item_id','item_order_qty','item_price','item_total','received_qty'];

    public function purchaseOrderItem(){
        return $this->belongsTo(InventoryItem::class,'inventory_item_id','id');
    }





}

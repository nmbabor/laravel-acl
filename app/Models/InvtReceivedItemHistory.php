<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvtReceivedItemHistory extends Model
{
    protected $table='invt_received_item_histories';
    protected $fillable=['master_received_id','inventory_id','item_id','received_qty','cost_price','item_total','storage_id','storage_id','storage_block_id','storage_block_self_id','available_qty','created_by','updated_by','company_id','branch_id'];

    public function receivedItem(){
        return $this->belongsTo(InventoryItem::class,'item_id','id');
    }
    public function itemReceivedStorage(){
        return $this->belongsTo(Storage::class,'storage_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvtMasterReceivedItem extends Model
{
    protected $table='invt_master_received_items';
    protected $fillable=['voucher_no','purchase_order_id','received_qty','sub_total','vat','shipping_charge','grand_total','received_date','notes','reference','received_img','received_by','created_by','updated_by','company_id','branch_id'];

    public function purchaseOrder(){
        return $this->belongsTo(InventoryPurchaseOrder::class,'purchase_order_id','id');
    }
}

<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class InventoryPurchaseOrder extends Model
{
    protected $table='inventory_purchase_orders';
    protected $fillable=['vendor_id','company_id','branch_id','purchase_order_no','date_of_purchase_order','date_of_shipment','billing_address','shipping_address','order_qty','sub_total','vat','shipping_charge','grand_total','paid_amount','due_amount','order_status','item_specification','priority','notes','reference','order_qr_code','created_by','update_by'];

    public function purchaseOrderToVendor(){
        return $this->belongsTo(InventoryVendor::class,'vendor_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}

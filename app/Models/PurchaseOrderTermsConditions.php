<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderTermsConditions extends Model
{
    protected $table='purchase_order_terms_conditions';
    protected $fillable=['inventory_purchase_order_id','terms_conditions_id'];


    public function purchaseOrderTermCondition(){
        return $this->belongsTo(CompanyTermsAndCondition::class,'terms_conditions_id','id');
    }
}

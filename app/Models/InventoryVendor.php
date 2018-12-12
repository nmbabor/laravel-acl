<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryVendor extends Model
{
    protected $table='inventory_vendors';
    protected $fillable=['vendor_is','vendor_name','vendorid','vendor_type','category_id','nid_no','trade_licence_no','vat_id','income_tax_id','primary_item','secondary_item','supply_item_details','office_address','storage_address','mobile_1','mobile_2','phone','fax','email_1','email_2','Skype','facebook','representative_name','representative_designation','representative_mobile','representative_phone','representative_email','representative_skype','status','vendor_img','nid_img','trade_licence_img','vat_img','income_tax_img','created_by','updated_by'];
}

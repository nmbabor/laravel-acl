<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCustomer extends Model
{
    protected $table='inventory_customers';
    protected $fillable=['id','customer_is','customer_name','customer_id','gender','customer_type','religion','present_address','permanent_address','shipping_address','mobile','phone','email','facebook','nit_no','city','region','zip_code','customer_img','nid_img','status','created_by','updated_by'];
}

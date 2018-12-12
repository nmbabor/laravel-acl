<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyList extends Model
{
    protected $table='company_list';
    protected $fillable=['company_name','logo','address','shipping_address','mobile_no','email','favicon','status'];

    public function branch(){
        return $this->hasMany(CompanyBranch::class,'company_id','id');
    }
    public function companyStorage(){
        return $this->hasMany(Storage::class,'company_id','id');
    }
    public function modules(){
        return $this->hasMany(CompanyModule::class,'company_id','id');
    }
}

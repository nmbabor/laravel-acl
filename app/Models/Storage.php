<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected  $table='storages';
    protected  $fillable=['company_id','branch_id','storage_name','address','status','created_by','updated_by'];

    public function storageCompany(){
        return $this->belongsTo(CompanyList::class,'company_id','id');
    }

    public function storageBranch(){
        return $this->belongsTo(CompanyBranch::class,'branch_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBranch extends Model
{
    protected $table = "company_branches";
    protected $fillable = ['branch_name','status','description','company_id'];
    public function company(){
        return $this->belongsTo(CompanyList::class,'company_id','id');
    }
}

<?php

namespace App\Models\Hrm;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "hrm_employees";
    protected $fillable = ['user_id','photo','employee_id','designation','section_id','basic_pay','house_rent','medical_allowance','status','created_by','updated_by','branch_id','company_id'];
    public function section(){
        return $this->belongsTo(EmployeeSection::class,'section_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}

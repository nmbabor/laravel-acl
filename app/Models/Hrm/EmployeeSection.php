<?php

namespace App\Models\Hrm;

use Illuminate\Database\Eloquent\Model;

class EmployeeSection extends Model
{
    protected $table = "hrm_employee_sections";
    protected $fillable = ['section_name','details','status','created_by','updated_by','branch_id','company_id'];
}

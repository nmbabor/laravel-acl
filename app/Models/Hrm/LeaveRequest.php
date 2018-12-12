<?php

namespace App\Models\Hrm;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';
    protected $fillable = ['employee_id','leave_type','is_approved','details','approval_details','created_by','updated_by','company_id','branch_id'];
}

<?php

namespace App\Models\Hrm;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected  $table ='hrm_attendances';
    protected $fillable = ['attendance_date','attendance','day_status','in_time','out_time','late','late_in','early_out','overtime','employee_id','created_by','updated_by','company_id','branch_id'];
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}

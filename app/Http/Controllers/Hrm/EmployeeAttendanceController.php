<?php

namespace App\Http\Controllers\Hrm;

use App\Models\Hrm\Attendance;
use App\Models\Hrm\Employee;
use App\Models\Hrm\EmployeeSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class EmployeeAttendanceController extends Controller
{
    public function index(){
        $section=EmployeeSection::where(['status'=>1,'hrm_employee_sections.branch_id'=>Auth::user()->branch_id,'hrm_employee_sections.company_id'=>Auth::user()->company_id])->pluck('section_name','id');
        $attns  = Attendance::groupBy('attendance_date')->select('attendance_date')->pluck('attendance_date');
        foreach($attns as $attn){
            $month[date('m',strtotime($attn))]=date('F',strtotime($attn));
            $year[date('Y',strtotime($attn))]=date('Y',strtotime($attn));
        }
        return view('hrm.attendance.employee',compact('section','month','year'));
    }
    public function loadEmployee($id){
        $employee = Employee::leftJoin('users','hrm_employees.user_id','users.id')->where(['hrm_employees.status'=>1,'hrm_employees.branch_id'=>Auth::user()->branch_id,'hrm_employees.company_id'=>Auth::user()->company_id,'section_id'=>$id])->pluck('users.name','hrm_employees.id');
        return view('hrm.attendance.loadEmployee',compact('employee'));
    }

    public function view(Request $request,$id){
        $employee = Employee::findOrFail($id);
        $month = $request->m;
        $year = $request->y;
        $allData = Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->leftJoin('hrm_employee_sections','hrm_employees.section_id','hrm_employee_sections.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->select('hrm_attendances.*')->whereMonth('attendance_date',$month)->whereYear('attendance_date',$year)->where('hrm_employees.id',$id)->orderBy('attendance_date','ASC')->get();
        return view('hrm.attendance.employeeAttendance',compact('allData','employee','month','year'));
    }
}

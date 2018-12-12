<?php

namespace App\Http\Controllers\Hrm;

use App\Models\Hrm\Attendance;
use App\Models\Hrm\Employee;
use App\Models\Hrm\EmployeeSection;
use App\Providers\MyHelperProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use DB;
use Datatables;
use Excel;
class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section=EmployeeSection::where(['status'=>1,'hrm_employee_sections.branch_id'=>Auth::user()->branch_id,'hrm_employee_sections.company_id'=>Auth::user()->company_id])->pluck('section_name','id');
        $attns  = Attendance::groupBy('attendance_date')->select('attendance_date')->pluck('attendance_date');
        foreach($attns as $attn){
            $month[date('m',strtotime($attn))]=date('F',strtotime($attn));
            $year[date('Y',strtotime($attn))]=date('Y',strtotime($attn));
        }
        return view('hrm.attendance.index',compact('section','month','year'));

    }

    public function all()
    {
        $allData = Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->leftJoin('hrm_employee_sections','hrm_employees.section_id','hrm_employee_sections.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->groupBy('attendance_date','section_id','section_name')->select(DB::raw('COUNT(hrm_attendances.employee_id) as total_employee'),'attendance_date','section_name','section_id');
        //return $allData;

        return Datatables::of($allData)
            ->addColumn('total_employee','{{$total_employee}}')
            ->addColumn('present',function($data){
                return $p = Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->groupBy('attendance_date','section_id')->where('hrm_attendances.attendance',1)->count();
            })
            ->addColumn('absent',function($data){
                return $p = Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->groupBy('attendance_date','section_id')->where('hrm_attendances.attendance',0)->count();
            })
            ->addColumn('leave',function($data){
                return $p = Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->groupBy('attendance_date','section_id')->where('hrm_attendances.attendance',2)->count();
            })
            ->addColumn('action','
            <td> <a href=\'{{URL::to("attendance/$section_id/edit?date=$attendance_date")}}\' class="btn btn-xs btn-success"> <i class="fa fa-pencil-square-o"></i></a>
                {!! Form::open(array("route"=> ["attendance.destroy",$section_id],"method"=>"DELETE","class"=>"deleteForm","id"=>"deleteForm$section_id")) !!}
                    {{ Form::hidden("date",$attendance_date)}}
                    <button type="button" onclick="return deleteConfirm(\'deleteForm{{$section_id}}\');" class="btn btn-xs btn-danger">
                      <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                {!! Form::close() !!}
            </td>
            ')
            ->rawColumns(['action','total_employee'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $section=EmployeeSection::where(['status'=>1,'hrm_employee_sections.branch_id'=>Auth::user()->branch_id,'hrm_employee_sections.company_id'=>Auth::user()->company_id])->pluck('section_name','id');

        if(isset($request->s)){
            $date = date('Y-m-d',strtotime($request->d));
            $employees = Employee::where('section_id',$request->s)->get();
            $attn = Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['attendance_date'=>$date,'section_id'=>$request->s])->first();
            $input = $request->only('s','d');
        }

        \Session::put('title','Attendance');
        return view('hrm.attendance.create',compact('section','input','employees','attn'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $info  = \MyHelper::hrmConfig();
        $input = $request->except('_token');

        $validator = Validator::make($input, [
            'section_id'=>'required',
            'attendance_date'=>'required',
            'in_time.*'=>'required',
            'out_time.*'=>'required',
            'attendance.*'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $offDays = explode(',',$info->off_days);
        DB::beginTransaction();
        $date = date('Y-m-d',strtotime($request->attendance_date));
        $today =  date('l',strtotime($request->attendance_date));
        if(in_array($today,$offDays)){
            $off=0;
        }else{
            $off=1;
        }


        foreach ($request->attendance as $i => $attn){
            $late_in=0;
            $early_out=0;
            $overTime = 0;
            $late = 0;
            $in_time='';
            $out_time='';
            if($attn==1){
                $intime = strtotime($request->in_time[$i]);
                $outtime = strtotime($request->out_time[$i]);
                $late_in = ($intime-strtotime($info->in_time))/60;
                $early_out = (strtotime($info->out_time)-$outtime)/60;
                $extraTime = ($late_in+$early_out)*(-1);

                if($extraTime>0){
                    $overTime = $extraTime;
                }else{
                    $late = $extraTime*(-1);
                }
                $in_time =  date('h:i:s',strtotime($request->in_time[$i]));
                $out_time =  date('h:i:s',strtotime($request->out_time[$i]));
            }

            Attendance::create([
                'attendance_date'=>$date,
                'attendance'=>$attn,
                'day_status'=>$off,
                'in_time'=>$in_time,
                'out_time'=>$out_time,
                'late_in'=>$late_in,
                'early_out'=>$early_out,
                'late'=>$late,
                'overtime'=>$overTime,
                'employee_id'=>$request->employee_id[$i],
                'created_by'=>Auth::user()->id,
                'company_id'=>Auth::user()->company_id,
                'branch_id'=>Auth::user()->branch_id,
            ]);
        }
        try{

            DB::commit();
            $bug=0;
        }catch(\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data Successfully Inserted');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$section_id)
    {
        if(!isset($request->date)){
            return redirect()->back();
        }
        $date = date('Y-m-d',strtotime($request->date));
        $section = EmployeeSection::findOrFail($section_id);
        $attendances = Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id,'section_id'=>$section_id,'attendance_date'=>$date])->select('hrm_attendances.*','employee_name','hrm_employees.employee_id as employeeId','designation')->get();
        return view('hrm.attendance.edit',compact('attendances','date','section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token','_method');
        $info  = \MyHelper::hrmConfig();

        $validator = Validator::make($input, [
            'attendance_date'=>'required',
            'in_time.*'=>'required',
            'out_time.*'=>'required',
            'attendance.*'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $offDays = explode(',',$info->off_days);
        DB::beginTransaction();
        $date = date('Y-m-d',strtotime($request->attendance_date));
        $today =  date('l',strtotime($request->attendance_date));
        if(in_array($today,$offDays)){
            $off=0;
        }else{
            $off=1;
        }


        foreach ($request->id as $i => $id){
            $attn = $request->attendance[$i];
            $late_in=0;
            $early_out=0;
            $overTime = 0;
            $late = 0;
            $in_time='';
            $out_time='';
            if($attn==1){
                $intime = strtotime($request->in_time[$i]);
                $outtime = strtotime($request->out_time[$i]);
                $late_in = ($intime-strtotime($info->in_time))/60;
                $early_out = (strtotime($info->out_time)-$outtime)/60;
                $extraTime = ($late_in+$early_out)*(-1);

                if($extraTime>0){
                    $overTime = $extraTime;
                }else{
                    $late = $extraTime*(-1);
                }
                $in_time =  date('h:i:s',strtotime($request->in_time[$i]));
                $out_time =  date('h:i:s',strtotime($request->out_time[$i]));
            }
            $attendance = Attendance::findOrFail($id);
            $attendance->update([
                'attendance'=>$attn,
                'in_time'=>$in_time,
                'out_time'=>$out_time,
                'late_in'=>$late_in,
                'early_out'=>$early_out,
                'late'=>$late,
                'overtime'=>$overTime,
                'updated_by'=>Auth::user()->id,
            ]);
        }
        try{

            DB::commit();
            $bug=0;
        }catch(\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data Successfully Updated');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        if(!isset($request->date)){
            return redirect()->back();
        }
        $date = date('Y-m-d',strtotime($request->date));

        try{
            Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['section_id'=>$id,'attendance_date'=>$date])->delete();
            $bug=0;
            $error='';
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }elseif($bug==1451){
            return redirect()->back()->with('error','This Data is Used anywhere ! ');

        }
        elseif($bug>0){
            return redirect()->back()->with('error','Error: '.$error);

        }
    }
    public function importAttendance(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'attendance_sheet'=>'required|mimes:csv,xlsx',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error','Invalid File!');
        }
        $info  = \MyHelper::hrmConfig();
        if ($request->hasFile('attendance_sheet')) {
            $realPath = $request->file('attendance_sheet')->getRealPath();
            $fileExt = $request->file('attendance_sheet')->getClientOriginalExtension();
            $allData=Excel::load($realPath,function ($reader){
                $reader->ignoreEmpty();
            })->get();

            $status =[];
            if(!empty($allData)){
                foreach($allData as $key => $data){
                    $employee = Employee::where('employee_id',$data->employee_id)->first();
                    $date = date('Y-m-d',strtotime($data->attendance_date));
                    if($employee!=null) {
                        $attendance = Attendance::where(['hrm_attendances.branch_id' => Auth::user()->branch_id, 'hrm_attendances.company_id' => Auth::user()->company_id, 'employee_id' => $employee->id, 'attendance_date' => $date])->first();

                        if ($attendance == null) {
                            if ($employee != null and $data->attendance_date != null and $data->attendance != null) {
                                $offDays = explode(',', $info->off_days);

                                $today = date('l', strtotime($data->attendance_date));
                                if (in_array($today, $offDays)) {
                                    $off = 0;
                                } else {
                                    $off = 1;
                                }

                                $late_in = 0;
                                $early_out = 0;
                                $overTime = 0;
                                $late = 0;
                                $in_time = '';
                                $out_time = '';
                                $attnd = $data->attendance;
                                if ($attnd == 'p' or $attnd == 'P') {
                                    $attn = 1;
                                } elseif ($attnd == 'l' or $attnd == 'L') {
                                    $attn = 2;
                                } else {
                                    $attn = 0;
                                }
                                if ($attn == 1) {
                                    $intime = strtotime($data->in_time);
                                    $outtime = strtotime($data->out_time);
                                    $late_in = ($intime - strtotime($info->in_time)) / 60;
                                    $early_out = (strtotime($info->out_time) - $outtime) / 60;
                                    $extraTime = ($late_in + $early_out) * (-1);

                                    if ($extraTime > 0) {
                                        $overTime = $extraTime;
                                    } else {
                                        $late = $extraTime * (-1);
                                    }
                                    $in_time = date('h:i:s', strtotime($data->in_time));
                                    $out_time = date('h:i:s', strtotime($data->out_time));
                                }


                               $result =  Attendance::create([
                                    'attendance_date' => $date,
                                    'attendance' => $attn,
                                    'day_status' => $off,
                                    'in_time' => $in_time,
                                    'out_time' => $out_time,
                                    'late_in' => $late_in,
                                    'early_out' => $early_out,
                                    'late' => $late,
                                    'overtime' => $overTime,
                                    'employee_id' => $employee->id,
                                    'created_by' => Auth::user()->id,
                                    'company_id' => Auth::user()->company_id,
                                    'branch_id' => Auth::user()->branch_id,
                                ]);
                                if($result){
                                    $status[] = 'Row  ' . ($key + 1) . ' is successfully Inserted.';
                                }
                            } else {
                                $status[] = 'Row  ' . ($key + 1) . ' has Invalid data found.';
                            }
                        } else {
                            $status[] = 'Row  ' . ($key + 1) . ' has Already exists.';
                        }
                    }else{
                        $status[]= 'Row  '.($key+1).' Employee ID '.$data->employee_id.' Not Found!';
                    }

                }
            }
            \Session::put('importStatus1',$status);
        }
        return redirect()->back()->with('importStatus',$status);
    }

    /* Attendance Export  */
    public function exportAttendance(Request $request){
        $month = $request->month;
        $year = $request->year;
        $allData = Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->leftJoin('hrm_employee_sections','hrm_employees.section_id','hrm_employee_sections.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->groupBy('attendance_date','section_id','section_name')->select(DB::raw('COUNT(hrm_attendances.employee_id) as total_employee'),'attendance_date','section_name','section_id')->whereMonth('attendance_date',$month)->whereYear('attendance_date',$year);
        if(isset($request->section_id)){
            $allData = $allData->where('hrm_employees.section_id',$request->section_id);
        }
        $allData = $allData->get();
        if(count($allData)==0){
            return redirect()->back()->with('error','No Attendance found!');
        }

        $attendance[] = array('Date','Section', 'Total Employee', 'Present', 'Absent','Leave');
        foreach($allData as $attn)
        {
            $attendance[] = array(
                'Date'=>$attn->attendance_date,
                'Section'=>$attn->section_name,
                'Total Employee'=>$attn->total_employee,
                'Present'=>Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->groupBy('attendance_date','section_id')->where('hrm_attendances.attendance',1)->count(),
                'Absent'=>Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->groupBy('attendance_date','section_id')->where('hrm_attendances.attendance',0)->count(),
                'Leave'=>Attendance::leftJoin('hrm_employees','hrm_attendances.employee_id','hrm_employees.id')->where(['hrm_attendances.branch_id'=>Auth::user()->branch_id,'hrm_attendances.company_id'=>Auth::user()->company_id])->groupBy('attendance_date','section_id')->where('hrm_attendances.attendance',2)->count(),

            );
        }

        Excel::create('Attendance', function($excel) use ($attendance){
            $excel->setTitle('Attendance');

            $excel->sheet('Attendance', function($sheet) use ($attendance){
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->fromArray($attendance, null, null, false, false);
            });
        })->download('csv');
    }
}

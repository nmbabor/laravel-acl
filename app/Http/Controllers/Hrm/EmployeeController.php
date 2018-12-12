<?php

namespace App\Http\Controllers\Hrm;

use App\Models\Hrm\Employee;
use App\Models\Hrm\EmployeeSection;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use DB;
use DataTables;
use Image;
use Yajra\Acl\Models\Role;
use Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section=EmployeeSection::where(['status'=>1,'hrm_employee_sections.branch_id'=>Auth::user()->branch_id,'hrm_employee_sections.company_id'=>Auth::user()->company_id])->pluck('section_name','id');
        return view('hrm.employee.index',compact('section'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::where('slug','employee')->first();
        if($role==null){
            return redirect()->back()->with('error','Create a Employee role!');
        }
        $section=EmployeeSection::where(['status'=>1,'hrm_employee_sections.branch_id'=>Auth::user()->branch_id,'hrm_employee_sections.company_id'=>Auth::user()->company_id])->pluck('section_name','id');
        return view('hrm.employee.create',compact('section','role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'phone_number'  => 'required|unique:users,phone_number',
            'email'  => 'required|unique:users',
            'employee_id'    => 'required|unique:hrm_employees',
            'designation' => 'required',
            'section_id' => 'required',
            'status' => 'required',
            'photo' => 'image',
            'role_id' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input = $request->except('_token');
        $input['created_by']=\Auth::user()->id;
        $input['company_id']=\Auth::user()->company_id;
        $input['branch_id']=\Auth::user()->branch_id;

        DB::beginTransaction();
        $user  = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt('123456'),
            'company_id'=>$input['company_id'],
            'branch_id'=>$input['branch_id'],
            'phone_number'=>$request->phone_number,
            'address'=>$request->address,
            'created_by'=>$input['created_by'],
        ]);
        DB::table('role_user')->insert([
           'role_id'=>$request->role_id,
           'user_id'=>$user->id,
        ]);

        if ($request->hasFile('photo')) {
            $photo=$request->file('photo');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $path=base_path().'/images/employee/'.date('Y/m/d');
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            /*$fileName=$photo->getClientOriginalName();*/
            $img = Image::make($photo);
            $img->resize(120,null,function($constraint){
                $constraint->aspectRatio();
            });
            $img->save('images/employee/'.date('Y/m/d/').$fileName);
            $input['photo']=date('Y/m/d/').$fileName;
        }
        $input['user_id']=$user->id;
        try {
            Employee::create($input);
            $bug = 0;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect('employees')->with('success','Created Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
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

        $allData = Employee::leftJoin('users','hrm_employees.user_id','users.id')->leftJoin('hrm_employee_sections','hrm_employees.section_id','hrm_employee_sections.id')->select('hrm_employees.*','hrm_employee_sections.section_name','users.name','users.phone_number')->where(['hrm_employees.branch_id'=>Auth::user()->branch_id,'hrm_employees.company_id'=>Auth::user()->company_id]);

        return Datatables::of($allData)
            ->editColumn('photo',function($data){
                if($data->photo!=null){
                    $photo='<img class="img-responsive" style="height:40px;" src='.asset("images/employee/$data->photo").'>';
                }else{
                    $photo='';
                }
                return $photo;
            })
            ->addColumn('action','
            <td> <a href=\'{{URL::to("employees/$id/edit")}}\' class="btn btn-xs btn-success"> <i class="fa fa-pencil-square-o"></i></a>
                {!! Form::open(array("route"=> ["employees.destroy",$id],"method"=>"DELETE","class"=>"deleteForm","id"=>"deleteForm$id")) !!}
                    {{ Form::hidden("id",$id)}}
                    <button type="button" onclick="return deleteConfirm(\'deleteForm{{$id}}\');" class="btn btn-xs btn-danger">
                      <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                {!! Form::close() !!}
            </td>
            ')
            ->rawColumns(['action','photo'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section=EmployeeSection::where(['status'=>1,'hrm_employee_sections.branch_id'=>Auth::user()->branch_id,'hrm_employee_sections.company_id'=>Auth::user()->company_id])->pluck('section_name','id');
        $data=Employee::findOrFail($id);
        if($data==null){
            return redirect()->back();
        }
        return view('hrm.employee.edit',compact('section','data'));
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
        $data = Employee::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'employee_id'    => "required|unique:hrm_employees,employee_id,$id",
            'name'  => 'required',
            'phone_number'  => "required|unique:users,phone_number,$data->user_id",
            'email'  => "required|unique:users,email,$data->user_id",
            'designation' => 'required',
            'section_id' => 'required',
            'status' => 'required',
            'photo' => 'image',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $input = $request->all();
        $input['updated_by']=\Auth::user()->id;
        if ($request->hasFile('photo')) {
            $photo=$request->file('photo');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $path=base_path().'/images/employee/'.date('Y/m/d');
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            /*$fileName=$photo->getClientOriginalName();*/
            $img = Image::make($photo);
            $img->resize(120,null,function($constraint){
                $constraint->aspectRatio();
            });
            $img->save('images/employee/'.date('Y/m/d/').$fileName);
            $input['photo']=date('Y/m/d/').$fileName;

            $img_path=base_path().'/images/employee/'.$data->photo;

            if($data->photo!=null){
                if(file_exists($img_path)){
                    unlink($img_path);
                }
            }
        }
        $user = User::findOrfail($data->user_id);
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'address'=>$request->address,
        ]);

        try {
            $data->update($input);
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Updated successFully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Employee::findOrFail($id);
        $user = User::findOrFail($data->user_id);
        $img_path=base_path().'/images/employee/'.$data->photo;

        if($data->photo!=null){
            if(file_exists($img_path)){
                unlink($img_path);
            }
        }


        try {

            $data->delete();
            $user->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success', 'Deleted Successfully .');
        }elseif($bug == 1451){
            return redirect()->back()->with('error','This Data Used AnyWhere.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }


    }

    /* Employee Export  */
    public function exportEmployee(Request $request){
        $section = $request->section_id;

        $employee = Employee::where(['hrm_employees.branch_id'=>Auth::user()->branch_id,'hrm_employees.company_id'=>Auth::user()->company_id]);
        if(isset($request->section_id)){
            $employee = $employee->where('section_id',$request->section_id);
        }
        $employee = $employee->get();
        if(count($employee)==0){
            return redirect()->back()->with('error','No employee found!');
        }

        $customer_array[] = array('Employee ID','Name', 'Email', 'Designation', 'Section');
        foreach($employee as $emp)
        {
            $customer_array[] = array(
                'Employee ID'=>$emp->employee_id,
                'Name'=>$emp->user->name,
                'Email'=>$emp->user->email,
                'Designation'=>$emp->designation,
                'Section'=>$emp->section->section_name,
            );
        }

        Excel::create('Employee List', function($excel) use ($customer_array){
            $excel->setTitle('Employee List');
            $excel->sheet('Employee List', function($sheet) use ($customer_array){
                $sheet->fromArray($customer_array, null, 'A1', false, false);
            });
        })->download('csv');
    }


}


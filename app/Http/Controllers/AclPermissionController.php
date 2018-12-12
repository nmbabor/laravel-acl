<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Yajra\Acl\Models\Permission;
use Validator;
use DB;
use Yajra\DataTables\DataTables;

class AclPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('primaryInfo.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allData=Permission::select('permissions.*');

        return DataTables::of($allData)
            ->addColumn('DT_Row_Index','')
            ->addIndexColumn()
            ->addColumn('status','
            @if($system==1)
            <b class="text-success">Active</b>
            @else
           <b class="text-danger">Inactive</b>
            @endif
            ')
            ->addColumn('action','
            <a href="#permissionModal<?php echo $id;?>" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <!-- #permissionModal -->
                        <div class="modal fade" id="permissionModal<?php echo $id;?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                {!! Form::open(array(\'route\' => [\'acl-permission.update\',$id],\'class\'=>\'form-horizontal author_form\',\'method\'=>\'PUT\',\'files\'=>\'true\', \'id\'=>\'commentForm\',\'role\'=>\'form\',\'data-parsley-validate novalidate\')) !!}
                                    <div class="modal-header">
                                        <h4 class="modal-title">Permission Edit</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <div class="form-group row">
                                            <label class="control-label col-md-4 col-sm-4" for="name">Name :</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="name" name="name" value="<?php echo $name; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-4 col-sm-4" for="slug">Slug :</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="slug" name="slug" value="<?php echo $slug; ?>" required />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-4 col-sm-4" for="resource">Resource :</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="resource" name="resource" value="<?php echo $resource; ?>" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="text-right col-md-4 col-sm-4">Status :</label>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="system" value="1" id="radio-required" data-parsley-required="true" @if($system=="1"){{"checked"}}@endif> Active
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="system" id="radio-required2" value="0" @if($system=="0"){{"checked"}}@endif> Inactive
                                                    </label>
                                                </div>
                                            </div> 
                                        </div>
	                                                           
	                                                        </div>
	                                                        
	                                                        <div class="modal-footer">
	                                                            <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
	                                                            <button type="submit" class="btn btn-sm btn-success">Update</button>
	                                                        </div>
	                                                    {!! Form::close(); !!}
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <!-- end edit section -->

	                                            <!-- delete section -->
	                                            {!! Form::open(array(\'route\'=> [\'acl-permission.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
	                                                {{ Form::hidden(\'id\',$id)}}
	                                                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="btn btn-danger btn-xs">
	                                                  <i class="fa fa-trash-o" aria-hidden="true"></i>
	                                                </button>
	                                            {!! Form::close() !!}
            ')
            ->rawColumns(['status','action'])
            ->make(true);
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
            'name' => 'required|unique:permissions,name'

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            if($request->type==1){
                Permission::createResource($request->name,1);
            }else{
                Permission::create([
                    'name'=>$request->name,
                    'slug'=>\MyHelper::slugify($request->name),
                    'resource'=>'',
                    'system'=>1,

                ]);
            }


            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Created Successfully.');
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
        return redirect('acl-role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $data = Permission::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name' => "required|unique:permissions,name,$id"

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();

        try {
            $data->update($input);

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Updated Successfully.');
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
        $data = Permission::findOrFail($id);

        try {
            $data->delete();

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Deleted Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }


    public function storeRole(Request $request)
    {
       $input=$request->except('_token');
        $validator = Validator::make($request->all(),[
            'role_id' => 'required',
            'permission_id' => 'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            DB::table('permission_role')->where('role_id',$input['role_id'])->delete();
            for ($i=0; $i <sizeof($input['permission_id']) ; $i++) {
                $permissionId=$input['permission_id'][$i];
                \DB::table('permission_role')->insert([
                    'role_id'=>$input['role_id'],
                    'permission_id'=>$permissionId
                ]);
            }
            Artisan::call('cache:clear');
            DB::commit();
            $bug = 0;

        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Created Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }
}

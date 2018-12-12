<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Yajra\Acl\Models\Permission;

class AclRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=DB::table('roles')->get();

        return view('primaryInfo.permission.roles',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|unique:roles,name'

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {

            DB::table('roles')->insert([
                'name'=>$request->name,
                'slug'=>\MyHelper::slugify($request->name),
                'description'=>$request->description,
                'system'=>1,

            ]);



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
        $resource=Permission::groupBy('resource')->where(['system'=>1])->where('resource','!=','')->pluck('resource');
        foreach ($resource as $res){
            $allResource[$res]=Permission::where(['system'=>1,'resource'=>$res])->get();
            //$allId[$res] =  Permission::where(['system'=>1,'resource'=>$res])->pluck('id');
            $oldPermission[$res] = \DB::table('permission_role')->leftJoin('permissions','permission_id','permissions.id')->where(['role_id'=>$id,'resource'=>$res])->select('permission_id')->get();
        }

        $normalPermission = Permission::where(['system'=>1,'resource'=>''])->get();

        $permissionRole=\DB::table('permission_role')->where('role_id',$id)->get()->keyBy('permission_id');
        $role=\DB::table('roles')->where('id',$id)->first();

        return view('primaryInfo.permission.rolePermission',compact('permissionRole','resource','role','allResource','normalPermission','oldPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = DB::table('roles')->where('id',$id)->first();
        $validator = Validator::make($request->all(),[
            'name' => "required|unique:roles,name,$id"

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();

        try {
            DB::table('roles')->where('id',$id)->update([
                'name'=>$request->name,
                'description'=>$request->description,
                'system'=>1,

            ]);

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
        try {
            DB::table('roles')->where('id',$id)->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Deleted Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }
}

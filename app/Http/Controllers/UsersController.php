<?php

namespace App\Http\Controllers;

use App\Models\CompanyBranch;
use App\Models\CompanyList;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\InventoryBranch;
use Validator;
use Hash;
use Auth;
use DB;
use Yajra\Acl\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allUsers=User::leftJoin('role_user','users.id','role_user.user_id')->leftJoin('roles','role_user.role_id','roles.id')->where('users.id','!=',1)//->where('users.company_id',\MyHelper::companyId())
            ->select('users.*','roles.name as role_name','role_id')->orderBy('users.id','DESC')->paginate(20);
        \Session::put('title','View All users');

        return view('primaryInfo.user.index',compact('allUsers'));
    }

    /**
     * Show the form for creating a new Admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::where('system',1)->pluck('name','id');
        $company=CompanyList::where('status',1)->pluck('company_name','id');
        \Session::put('title','Registration');

        return view('primaryInfo.user.create',compact('roles','company'));
    }

    /**
     * Store a newly created Admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required',
            /*enable   extension=php_fileinfo*/
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        $input['password']=bcrypt($input['password']);
        $input['created_by']=Auth::user()->id;
        DB::beginTransaction();
        try{
            $insertId= User::create($input)->id;
            $oldRole=DB::table('role_user')->where('user_id',$insertId)->first();
            if($oldRole!=null){
                DB::table('role_user')->where('user_id',$insertId)->update(['role_id'=>$request->role_id]);
            }else{
                DB::table('role_user')->insert(['role_id'=>$request->role_id,'user_id'=>$insertId]);
            }


            DB::commit();
            $bug=0;
        }catch(\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect('users')->with('success','Data Successfully Inserted');
        }elseif($bug==1062){
            return redirect('users')->with('error','The Email has already been taken.');
        }else{
            return redirect('users')->with('error','Something Error Found ! ');
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
        $data=User::leftJoin('role_user','users.id','role_user.user_id')->select('users.*','role_id')->where('users.id',$id)->first();
        if($data==null){
            return redirect()->back();
        }
        $roles=DB::table('roles')->where('system',1)->pluck('name','id');
        $company=CompanyList::where('status',1)->pluck('company_name','id');
        $branches=CompanyBranch::where('status',1)->pluck('branch_name','id');
        \Session::put('title','Edit User Profile');
        return view('primaryInfo.user.edit',compact('data','roles','company','branches'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=User::findOrFail($id);
        return view('primaryInfo.user.password',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //return $request->all();
        $data=User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => "email|required|unique:users,email,$id",
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input=$request->all();
        DB::beginTransaction();
        $data->update($input);
        if(isset($request->role_id)){
            $oldRole=DB::table('role_user')->where('user_id',$id)->first();
            if($oldRole!=null){
                DB::table('role_user')->where('user_id',$id)->update(['role_id'=>$request->role_id]);
            }else{
                DB::table('role_user')->insert(['role_id'=>$request->role_id,'user_id'=>$id]);
            }
        }
        try{
            DB::commit();
            $result=0;
        }catch(\Exception $e){
            DB::rollback();
            $result = $e->errorInfo[1];
        }

        if($result==0){
            return redirect()->back()->with('success','Profile Successfully Updated');
        }elseif($result==1062){
            return redirect()->back()->with('error','The name has already been taken.');
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


    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data=User::findOrFail($id);
            DB::table('role_user')->where('user_id',$id)->delete();
            $data->delete();
            $bug=0;
            $error=0;
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0){
            return redirect('users')->with('success','Data has been Successfully Deleted!');
        }elseif($bug==1451){
            return redirect('users')->with('error','This Data is Used anywhere ! ');

        }
        elseif($bug>0){
            return redirect('users')->with('error','Error : '.$error);

        }
    }

    public function password(Request $request){
        $input=$request->all();
        $newPass=$input['password'];
        $data=User::findOrFail($request->id);
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $input['password']=bcrypt($newPass);
        try{
            $data->update($input);
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Password Changed Successfully !');
        }else{
            return redirect()->back()->with('error','Something is wrong !');

        }
    }

    public function loadBranch($id=null){

        if($id!=null){
            $branches = CompanyBranch::where('company_id',$id)->pluck('branch_name','id');
        }else{
            $branches = [];
        }

        return view('primaryInfo.user.branch',compact('branches'));

    }


    public function profile(){
        $id=Auth::user()->id;
        $data=User::findOrFail($id);
        $type=DB::table('user_type')->where('type',Auth::user()->type)->pluck('type_name','type');
        return view('profile.show',compact('data','type'));
    }

    public function changePass()
    {
        $id=Auth::user()->id;
        $data=User::findOrFail($id);
        return view('profile.password',compact('data'));
    }
}

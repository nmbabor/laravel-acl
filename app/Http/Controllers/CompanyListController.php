<?php

namespace App\Http\Controllers;

use App\Models\CompanyList;
use App\Models\CompanyModule;
use App\Models\Menu;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;


class CompanyListController extends Controller
{

    //protected $customPermissionMap = ['method'=>'permission'];
    public function __construct()
    {
        //$this->authorizePermissionResource('company');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\MyHelper::info()->type!=1){
            return redirect('primary-info');
        }
        $allData = CompanyList::orderBy('id','DESC')->paginate(20);
        return view('primaryInfo.company.index',compact('allData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Menu::where('status',1)->where('type',1)->pluck('name','id');
        return view('primaryInfo.company.create',compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'company_name'=>'required',
            'logo'=>'required',
            'address'=>'required',
            'shipping_address'=>'required',
            'mobile_no'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //return $input;
        if ($request->hasFile('logo')) {
            $photo=$request->file('logo');
            $ext= $photo->getClientOriginalExtension();
                $name = date('Ymdhis').rand(1,100).$ext;
            $path=base_path().'/images/company';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo);
            $img->resize(180, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save('images/company/'.$name);
            $input['logo']='images/company/'.$name;
        }
        if ($request->hasFile('favicon')) {
            $photo=$request->file('favicon');
            $ext= $photo->getClientOriginalExtension();
            $name = date('Ymdhis').rand(1,100).'.'.$ext;
            $path=base_path().'/images/company';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(50,50);
            $img->save('images/company/'.$name);
            $input['favicon']='images/company/'.$name;
        }
        DB::beginTransaction();
        $input['status']=1;
        $data = CompanyList::create($input);
        if(isset($request->modules)){

            foreach ($request->modules as $mod){
                CompanyModule::create([
                    'module_id'=>$mod,
                    'company_id'=>$data->id,

                ]);
            }
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
    public function edit($id)
    {

        $data = CompanyList::findOrFail($id);
        $modules = Menu::where('status',1)->where('type',1)->pluck('name','id');
        return view('primaryInfo.company.edit',compact('data','modules'));
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
        $input = $request->all();
        $data=CompanyList::findOrFail($request->id);

        $validator = Validator::make($input, [
            'company_name'=>'required',
            'address'=>'required',
            'shipping_address'=>'required',
            'mobile_no'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('logo')) {
            $photo=$request->file('logo');
            $ext= $photo->getClientOriginalExtension();
            $name = date('Ymdhis').rand(1,100).'.'.$ext;
            $path=base_path().'/images/company';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo);
            $img->resize(180, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save('images/company/'.$name);
            $input['logo']='images/company/'.$name;
            if($data->logo!=null and file_exists($data->logo)){
                unlink($data->logo);
            }
        }
        if ($request->hasFile('favicon')){
            $photo=$request->file('favicon');
            $ext= $photo->getClientOriginalExtension();
                $name = date('Ymdhis').rand(1,100).'.'.$ext;
            $path=base_path().'/images/company';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(50,50);
            $img->save('images/company/'.$name);
            $input['favicon']='images/company/'.$name;
            if($data->favicon!=null and file_exists($data->favicon)){
                unlink($data->favicon);
            }
        }

        try{
            $data->update($input);
            if(isset($request->modules)){
                CompanyModule::where('company_id',$data->id)->delete();
                foreach ($request->modules as $mod){
                    CompanyModule::create([
                        'module_id'=>$mod,
                        'company_id'=>$data->id,
                    ]);
                }
            }


            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Update');
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
        $data=CompanyList::findOrFail($id);
        try{
            if($data->logo!=null and file_exists($data->logo)){
                unlink($data->logo);
            }
            if($data->favicon!=null and file_exists($data->favicon)){
                unlink($data->favicon);
            }
            $data->delete();
            $bug=0;
            $error=0;
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
            return redirect()->back()->with('error','Some thing error found !');

        }
    }
}

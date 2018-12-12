<?php

namespace App\Http\Controllers;

use App\Models\CompanyList;
use App\Models\CompanyModule;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isRole('super-admin')){
            $allCompany = CompanyList::where(['status'=>1])->get();
            return view('primaryInfo.dashboard.superAdmin.dashboard',compact('allCompany'));
        }else{

            return view('welcome');
        }
    }

    public function company($id){
        $data = CompanyList::findOrFail($id);
        $companyModules = CompanyModule::leftJoin('menu','module_id','menu.id')->select('menu.*','company_id','module_id')->where('company_id',$id)->get();
        return view('primaryInfo.dashboard.superAdmin.company',compact('data','companyModules'));
    }
    public function module($id,$moduleId){
        $company = CompanyList::findOrFail($id);
        $module = Menu::findOrFail($moduleId);
        $moduleDropDown =  CompanyModule::leftJoin('menu','module_id','menu.id')->select('menu.*','company_id','module_id')->where('company_id',$id)->get();

        return view('primaryInfo.dashboard.superAdmin.module',compact('module','company','moduleDropDown'));
    }
    public function subMenu($id){

        \Session::put('menu',$id);
        return view('layouts.subMenu');
    }
    public function query(){
        return view('primaryInfo.customQuery');
    }
    public function queryPost(Request $request){

        $query = $request->description;
        //return $query;
        DB::beginTransaction();
        try{
            $result = \DB::statement($query);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
            return redirect()->back()->with('error','Error: '.$bug1);
        }
        \Session::put('query',$query);
        return redirect()->back()->with('success','Successfully Done');
    }
}

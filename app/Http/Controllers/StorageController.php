<?php

namespace App\Http\Controllers;

use App\Models\CompanyBranch;
use App\Models\CompanyList;
use App\Models\Storage;
use Illuminate\Http\Request;
use Auth;
use Validator;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\MyHelper::info()->type==1){
            return redirect()->back();
        }
        $storages=Storage::orderBy('id','desc')->where('status',1)->paginate(12);
        $branches=CompanyBranch::orderBy('id','desc')->where('status',1)->pluck('branch_name','id');
        return view('primaryInfo.company.storage.index', compact('company','storages','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

            'storage_name' => 'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->except('_token');
        $input['created_by']=Auth::user()->id;

        try {
            Storage::create($input);

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','New Storage Created Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = CompanyList::findOrfail($id);
        $storages=Storage::orderBy('id','desc')->where('company_id',$id)->where('status',1)->paginate(12);
        $branches=CompanyBranch::orderBy('id','desc')->where('company_id',$id)->where('status',1)->pluck('branch_name','id');
        return view('primaryInfo.company.storage.index', compact('company','storages','branches'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function edit(Storage $storage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

         $getStorage =Storage::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'storage_name' => 'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->except('_token');
        $input['updated_by']=Auth::user()->id;

        try {
            $getStorage->update($input);

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Storage Updated Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $getStorage =Storage::findOrFail($id);

        try {
            $getStorage->delete();

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Storage Deleted Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }
}

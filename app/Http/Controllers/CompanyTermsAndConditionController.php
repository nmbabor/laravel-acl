<?php

namespace App\Http\Controllers;

use App\Models\CompanyTermsAndCondition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;

class CompanyTermsAndConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $termsConditions=CompanyTermsAndCondition::orderBy('id','desc')->paginate(12);
        return view('primaryInfo.company-terms-conditions.index',compact('termsConditions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('primaryInfo.company-terms-conditions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(),[
            'condition_type' => 'required',
            'condition_title' => 'required',
            'condition_status' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input['created_by']=Auth::user()->id;

        try{
            $lastInsertId=CompanyTermsAndCondition::create($input)->id;
            $bug=0;
        }catch (\Exception $e){
            $bug=$e->errorInfo['1'];
            $bug1=$e->errorInfo['2'];
        }

        if ($bug==0){
            return redirect()->back()->with('success','New Terms & Conditions Created Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong to create terms & conditions, try again'.$bug1);
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getTermsConditionsById=CompanyTermsAndCondition::findOrFail($id);
        return view('primaryInfo.company-terms-conditions.edit',compact('getTermsConditionsById'));
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
        $input = $request->except('_token');
        $validator = Validator::make($request->all(),[
            'condition_type' => 'required',
            'condition_title' => 'required',
            'condition_status' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input['updated_by']=Auth::user()->id;

        $getTermsConditionsById=CompanyTermsAndCondition::findOrFail($id);
        try{
            $update=$getTermsConditionsById->update($input);
            $bug=0;
        }catch (\Exception $e){
            $bug=$e->errorInfo['1'];
            $bug1=$e->errorInfo['2'];
        }

        if ($bug==0){
            return redirect()->back()->with('success','Old Terms & Conditions Update Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong to update old terms & conditions, try again'.$bug1);
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
        $getTermsConditionsById=CompanyTermsAndCondition::findOrFail($id);

        try{
            $getTermsConditionsById->delete();
            $bug=0;
        }catch (\Exception $e){
            $bug=$e->errorInfo['1'];
            $bug1=$e->errorInfo['2'];
        }

        if ($bug==0){
            return redirect()->back()->with('success','Old Terms & Conditions Update Successfully');
        }elseif ($bug==547){
            return redirect()->back()->with('error','This data con not be delete due to this data used already another table'.$bug1);
        }
        else{
            return redirect()->back()->with('error','Something went wrong to update old terms & conditions, try again'.$bug1);
        }
    }
}

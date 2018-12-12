<?php

namespace App\Http\Controllers;

use App\Models\BinLocation;
use Illuminate\Http\Request;
use Auth;
use Validator;

class BinLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $binLocations=BinLocation::orderBy('id','desc')->paginate(12);
        return view('primaryInfo.company.storage.bin-location.index',compact('binLocations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('primaryInfo.company.storage.bin-location.create');
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
            'location_name' => 'required',
            'details' => 'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->except('_token');
        $input['created_by']=Auth::user()->id;

        try {
            BinLocation::create($input);

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','New Bin location Created Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BinLocation  $binLocation
     * @return \Illuminate\Http\Response
     */
    public function show(BinLocation $binLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BinLocation  $binLocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $binLocationById=BinLocation::findOrFail($id);
        return view('primaryInfo.company.storage.bin-location.edit',compact('binLocationById'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BinLocation  $binLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'location_name' => 'required',
            'details' => 'required',
            'status' => 'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->except('_token');
        $input['updated_by']=Auth::user()->id;
        $binLocationById=BinLocation::findOrFail($id);

        try {
            $binLocationById->update($input);

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Old Bin location Info Update Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BinLocation  $binLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $binLocationById=BinLocation::findOrFail($id);

        try {
            $binLocationById->delete();

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Old Bin location Info Delete Successfully.');
        }elseif ($bug==547){
            return redirect()->back()->with('error','Sorry, This data already used another module');
        }
        else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }
}

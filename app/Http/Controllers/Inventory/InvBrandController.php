<?php

namespace App\Http\Controllers\Inventory;

use App\Models\InvBrand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Validator;
use Auth;
use DB;

class InvBrandController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands =InvBrand::orderBy('id','desc')->paginate(12);
        return view('inventory.brand.index')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->except('_token');
        $validator = Validator::make($input, [
            'brand_name'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input['created_by']=Auth::user()->id;
        try {
            InvBrand::create($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','New Brand Created Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found! '.$bug1);
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
        $getBrandById=InvBrand::findOrFail($id);
        return view('inventory.brand.edit',compact('getBrandById'));
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

        $input=$request->except('_token');
        $validator = Validator::make($input, [
            'brand_name'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input['updated_by']=Auth::user()->id;

        $getBrandById=InvBrand::findOrFail($id);

        try {
            $getBrandById->update($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Brand Update Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found! '.$bug1);
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
        $getBrandById=InvBrand::findOrFail($id);
        try {
            $getBrandById->delete();
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Brand Delete Successfully.');
        }elseif ($bug==547){
            return redirect()->back()->with('error','Already used another table.');
        }else{
            return redirect()->back()->with('error','Something Error Found! '.$bug1);
        }
    }
}

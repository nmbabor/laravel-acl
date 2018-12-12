<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryProductCategory;
use App\Models\InventoryVendor;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Validator;
use Auth;
use MyHelper;
use Yajra\DataTables\DataTables;
use DB;

class InventoryVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.vendors.index',compact('vendors'));
    }

    public function getAllVendors(){
        $vendors=InventoryVendor::leftjoin('item_categories','inventory_vendors.category_id','item_categories.id')
        ->select('item_categories.category_name','inventory_vendors.*');

        return Datatables::of($vendors)
            ->addColumn(
                'action','
            {!!Form::open(array(\'route\'=>[\'inventory-vendor.destroy\',"$id"],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id"))!!}
                <a href="{{URL::to("inventory-vendor/$id/")}}" title=\'Click here to view all info \' class="btn btn-info btn-xs"> <i class="fa fa-eye"></i></a>
                <a href="{{URL::to("inventory-vendor/$id/edit")}}" title=\'Click here to edit \' class="btn btn-warning btn-xs"> <i class="fa fa-pencil-square"></i></a>
                <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm(\'deleteForm{{ $id}}\')"><i class="fa fa-trash"></i></button>
           {!! Form::close() !!}' )
            ->rawColumns(['action'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendorSamplefile="public/download/vendor-inport-file.csv";

        $categories=ItemCategory::orderBy('id','desc')->pluck('category_name','id');
        return view('inventory.vendors.create',compact('vendorSamplefile','categories'));
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

        $validator = Validator::make($request->all(), [
            'vendor_is'=>'required|numeric',
            'vendor_name'=>'required|max:200',
            'vendorid' => 'unique:inventory_vendors,vendorid|max:100',
            'mobile_1' => 'required|unique:inventory_vendors,mobile_1|max:20|min:11|regex:/(01)[0-9]{9}/',
            'vendor_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'nid_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'trade_licence_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'vat_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'income_tax_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // generate unique vendorid;
        if ($request->vendor_type ==1) {
            $lastInsertId = InventoryVendor::orderBy('id', 'desc')->first();
            if (!empty($lastInsertId)) {
                $input['vendorid'] = 'GV' . (1000 + $lastInsertId->id);
            } else {
                $input['vendorid'] = 'GV' . "1000";
            }
        } elseif ($request->vendor_type ==2) {
            $lastInsertId = InventoryVendor::orderBy('id', 'desc')->first();
            if (!empty($lastInsertId)) {
                $input['vendorid'] = 'SV' . (1000 + $lastInsertId->id);
            } else {
                $input['vendorid'] = 'SV' . "1000";
            }
        }

        if ($request->hasFile('vendor_img')){
            $input['vendor_img']=MyHelper::photoUpload($request->file('vendor_img'),'images/vendor-img/');
        }
        if ($request->hasFile('nid_img')){
            $input['nid_img']=MyHelper::photoUpload($request->file('nid_img'),'images/vendor-nid_img/');
        }
        if ($request->hasFile('trade_licence_img')){
            $input['trade_licence_img']=MyHelper::photoUpload($request->file('trade_licence_img'),'images/vendor-trade_licence_img/');
        }
        if ($request->hasFile('vat_img')){
            $input['vat_img']=MyHelper::photoUpload($request->file('vat_img'),'images/vendor-vat_img/');
        }
        if ($request->hasFile('income_tax_img')){
            $input['income_tax_img']=MyHelper::photoUpload($request->file('income_tax_img'),'images/vendor-income_tax_img/');
        }


        $input['created_by'] = Auth::user()->id;

        try {
            InventoryVendor::create($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'New Vendor Created Successfully.');
        } else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryVendor  $inventoryVendor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories=ItemCategory::orderBy('id','desc')->pluck('category_name','id');
        $getVendorById=InventoryVendor::findOrFail($id);
        return view('inventory.vendors.show',compact('categories','getVendorById'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryVendor  $inventoryVendor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories=ItemCategory::orderBy('id','desc')->pluck('category_name','id');
        $getVendorById=InventoryVendor::findOrFail($id);
        return view('inventory.vendors.edit',compact('categories','getVendorById'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryVendor  $inventoryVendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token');

        $validator = Validator::make($request->all(), [
            'vendor_is'=>'required|numeric',
            'vendor_name'=>'required|max:200',
            'vendorid' => "unique:inventory_vendors,vendorid,$id|max:100",
            'mobile_1' => "required|unique:inventory_vendors,mobile_1,$id|max:20|min:11|regex:/(01)[0-9]{9}/",
            'vendor_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'nid_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'trade_licence_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'vat_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'income_tax_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $getVendorById=InventoryVendor::findOrFail($id);

        // updating unique vendorid;
        if ($request->vendor_type ==1) {
            $input['vendorid'] = 'GV' .substr($getVendorById->vendorid,2);
        } elseif ($request->vendor_type ==2) {
            $input['vendorid'] = 'SV' .substr($getVendorById->vendorid,2);
        }


        if ($request->hasFile('vendor_img')){
            $input['vendor_img']=MyHelper::photoUpload($request->file('vendor_img'),'images/vendor-img/');
            if (file_exists($getVendorById->vendor_img)){
                unlink($getVendorById->vendor_img);
            }
        }
        if ($request->hasFile('nid_img')){
            $input['nid_img']=MyHelper::photoUpload($request->file('nid_img'),'images/vendor-nid_img/');
            if (file_exists($getVendorById->nid_img)){
                unlink($getVendorById->nid_img);
            }
        }
        if ($request->hasFile('trade_licence_img')){
            $input['trade_licence_img']=MyHelper::photoUpload($request->file('trade_licence_img'),'images/vendor-trade_licence_img/');

            if (file_exists($getVendorById->trade_licence_img)){
                unlink($getVendorById->trade_licence_img);
            }
        }
        if ($request->hasFile('vat_img')){
            $input['vat_img']=MyHelper::photoUpload($request->file('vat_img'),'images/vendor-vat_img/');

            if (file_exists($getVendorById->vat_img)){
                unlink($getVendorById->vat_img);
            }
        }
        if ($request->hasFile('income_tax_img')){
            $input['income_tax_img']=MyHelper::photoUpload($request->file('income_tax_img'),'images/vendor-income_tax_img/');
            if (file_exists($getVendorById->income_tax_img)){
                unlink($getVendorById->income_tax_img);
            }
        }




        $input['updated_by'] = Auth::user()->id;

        try {
            $getVendorById->update($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'Old Vendor Info Created Successfully.');
        } else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryVendor  $inventoryVendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getVendorById=InventoryVendor::findOrFail($id);

        DB::beginTransaction();
        try {

            $getVendorById->delete();

            if (file_exists($getVendorById->vendor_img)){
                unlink($getVendorById->vendor_img);
            }

            if (file_exists($getVendorById->nid_img)){
                unlink($getVendorById->nid_img);
            }

            if (file_exists($getVendorById->trade_licence_img)){
                unlink($getVendorById->trade_licence_img);
            }


            if (file_exists($getVendorById->vat_img)){
                unlink($getVendorById->vat_img);

            }

            if (file_exists($getVendorById->income_tax_img)){
                unlink($getVendorById->income_tax_img);
            }

            $bug = 0;
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', ' Vendor Info Deleted Successfully.');
        }elseif ($bug==547){
            return redirect()->back()->with('error', 'Sorry this vendor can not be delete due to used another module');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }
}

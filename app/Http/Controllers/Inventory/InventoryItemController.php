<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InvBrand;
use App\Models\InventoryItem;
use App\Models\InventorySmallUnits;
use App\Models\InventoryVendor;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use MyHelper;
use Yajra\DataTables\DataTables;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.items.index');
    }

    public function showAllInventoryItems(){
        $items=InventoryItem::leftjoin('item_categories','inventory_items.category_id','item_categories.id')
            ->leftjoin('inv_brands','inventory_items.brand_id','inv_brands.id')
            ->leftjoin('inventory_small_units','inventory_items.item_unite_id','inventory_small_units.id')
            ->leftjoin('inventory_vendors','inventory_items.vendor_id','inventory_vendors.id')
            ->select('item_categories.category_name','inv_brands.brand_name','inventory_small_units.unit_name',
                'inventory_vendors.vendor_name','inventory_items.id','inventory_items.item_name','inventory_items.item_code');

        return DataTables::of($items)
            ->addColumn('action','{!!Form::open(array(\'route\'=>[\'inventory-item.destroy\',"$id"],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id"))!!}
                <a href="{{URL::to("inventory-item/$id/")}}" title=\'Click here to view all info \' class="btn btn-info btn-xs"> <i class="fa fa-eye"></i></a>
                <a href="{{URL::to("inventory-item/$id/edit")}}" title=\'Click here to edit \' class="btn btn-warning btn-xs"> <i class="fa fa-pencil-square"></i></a>
                <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm(\'deleteForm{{ $id}}\')"><i class="fa fa-trash"></i></button>
           {!! Form::close() !!}')
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
        $categories=ItemCategory::orderBy('id','desc')->pluck('category_name','id');
        $brands=InvBrand::orderBy('id','desc')->pluck('brand_name','id');
        $unites=InventorySmallUnits::orderBy('id','desc')->pluck('unit_name','id');
        $vendors=InventoryVendor::orderBy('id','desc')->pluck('vendor_name','id');
        return view('inventory.items.create',compact('categories','brands','unites','vendors'));
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
        $validator = Validator::make($input,[
            'item_name' => 'required|max:100',
            'cost_price' => 'numeric|nullable',
            'sale_price'=>'numeric|nullable',
            'reorder_level'=>'numeric|nullable',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // generate unique item_code;
        $lastItemId=$invtItemId=InventoryItem::latest()->value('id');
        if (!empty($lastItemId)){
            $input['item_code']=1000+$lastItemId;
        }else{

            $input['item_code']=1000;
        }


        if ($request->hasFile('item_main_img')){
            $input['item_main_img']=MyHelper::photoUpload($request->file('item_main_img'),'images/item-img/item-main-img/');
        }
        if ($request->hasFile('item_secondary_img')){
            $input['item_secondary_img']=MyHelper::photoUpload($request->file('item_secondary_img'),'images/item-img/item-secondary-img/');
        }

        $input['created_by']=Auth::user()->id;

        try {

            InventoryItem::create($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','New Item Created Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getItemById=InventoryItem::findOrFail($id);

        return view('inventory.items.show',compact('getItemById'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getItemById=InventoryItem::findOrFail($id);
        $categories=ItemCategory::orderBy('id','desc')->pluck('category_name','id');
        $brands=InvBrand::orderBy('id','desc')->pluck('brand_name','id');
        $unites=InventorySmallUnits::orderBy('id','desc')->pluck('unit_name','id');
        $vendors=InventoryVendor::orderBy('id','desc')->pluck('vendor_name','id');
        return view('inventory.items.edit',compact('getItemById','categories','brands','unites','vendors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $input=$request->except('_token');
        $validator = Validator::make($input,[
            'item_name' => 'required|max:100',
            'cost_price' => 'numeric|nullable',
            'sale_price'=>'numeric|nullable',
            'reorder_level'=>'numeric|nullable',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $getItemById=InventoryItem::findOrFail($id);
        // generate unique item_code;

        if ($request->hasFile('item_main_img')){
            $input['item_main_img']=MyHelper::photoUpload($request->file('item_main_img'),'images/item-img/item-main-img/');
            if (file_exists($getItemById->item_main_img)){
                unlink($getItemById->item_main_img);
            }
        }
        if ($request->hasFile('item_secondary_img')){
            $input['item_secondary_img']=MyHelper::photoUpload($request->file('item_secondary_img'),'images/item-img/item-secondary-img/');
            if (file_exists($getItemById->item_secondary_img)){
                unlink($getItemById->item_secondary_img);
            }
        }

        $input['updated_by']=Auth::user()->id;

        try {

            $getItemById->update($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Item Old Info Updated Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getItemById=InventoryItem::findOrFail($id);
        try {

            $getItemById->delete();
            if (file_exists($getItemById->item_main_img)){
                unlink($getItemById->item_main_img);
            }

            if (file_exists($getItemById->item_secondary_img)){
                unlink($getItemById->item_secondary_img);
            }
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Item Old Info Deleted Successfully.');
        }else{
            return redirect()->back()->with('error','Error: '.$bug1);
        }

    }
}

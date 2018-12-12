<?php

namespace App\Http\Controllers\Inventory;

use App\Models\InventoryCustomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use DB;
use MyHelper;
use Yajra\DataTables\DataTables;


class InventoryCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.customers.index');
    }

    public function showAllInventoryCustomers(){
         $customers=InventoryCustomer::select('id','customer_name','customer_id','mobile','email','customer_type');

         return Datatables::of($customers)
             ->addColumn('action','
            {!!Form::open(array(\'route\'=>[\'inventory-customer.destroy\',"$id"],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id"))!!}
                <a href="{{URL::to("inventory-customer/$id/")}}" title=\'Click here to view all info \' class="btn btn-info btn-xs"> <i class="fa fa-eye"></i></a>
                <a href="{{URL::to("inventory-customer/$id/edit")}}" title=\'Click here to edit \' class="btn btn-warning btn-xs"> <i class="fa fa-pencil-square"></i></a>
                <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm(\'deleteForm{{ $id}}\')"><i class="fa fa-trash"></i></button>
           {!! Form::close() !!}')
             ->addColumn('customer_type','<span>
                                @if($customer_type==1)
                                    <b>{{\'General Vendor\'}}</b>
                                    @else
                                    <b>{{\'Special Vendor\'}}</b>
                                @endif
                            </span>')
             ->rawColumns(['action','customer_type'])
             ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.customers.create');
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
            'customer_is'=>'required|numeric',
            'customer_name'=>'required|max:150',
            'customer_id' => 'unique:inventory_customers,customer_id|max:100',
            'customer_type' => 'required|numeric',
            'mobile' => 'required|unique:inventory_customers,mobile|max:20|min:11|regex:/(01)[0-9]{9}/',
            'zip_code' => 'nullable|max:8|min:3',
            'customer_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'nid_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // generate unique customer ID;
        if ($request->customer_type ==1) {
            $lastInsertId = InventoryCustomer::orderBy('id', 'desc')->first();
            if (!empty($lastInsertId)) {
                $input['customer_id'] = 'GV' . (1000 + $lastInsertId->id);
            } else {
                $input['customer_id'] = 'GV' . "1000";
            }
        } elseif ($request->customer_type ==2) {
            $lastInsertId = InventoryCustomer::orderBy('id', 'desc')->first();
            if (!empty($lastInsertId)) {
                $input['customer_id'] = 'SV' . (1000 + $lastInsertId->id);
            } else {
                $input['customer_id'] = 'SV' . "1000";
            }
        }

        if ($request->hasFile('customer_img')){
            $input['customer_img']=MyHelper::photoUpload($request->file('customer_img'),'images/customer-img/');
        }
        if ($request->hasFile('nid_img')){
            $input['nid_img']=MyHelper::photoUpload($request->file('nid_img'),'images/customer-nid_img/');
        }




        $input['created_by'] = Auth::user()->id;

        try {
            InventoryCustomer::create($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'New Customer Created Successfully.');
        } else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryCustomer  $inventoryCustomer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getCustomerById=InventoryCustomer::findOrFail($id);
        return view('inventory.customers.show',compact('getCustomerById'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryCustomer  $inventoryCustomer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getCustomerById=InventoryCustomer::findOrFail($id);
        return view('inventory.customers.edit',compact('getCustomerById'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryCustomer  $inventoryCustomer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token');

        $validator = Validator::make($request->all(), [
            'customer_is'=>'required|numeric',
            'customer_name'=>'required|max:150',
            'customer_id' => "unique:inventory_customers,customer_id,$id|max:100",
            'customer_type' => 'required|numeric',
            'mobile' => "required|unique:inventory_customers,mobile,$id|max:20|min:11|regex:/(01)[0-9]{9}/",
            'zip_code' => 'nullable|numeric|max:8|min:3',
            'customer_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
            'nid_img' => 'nullable|mimes:jpg,jpeg,png,gif|max:4000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $getCustomerById=InventoryCustomer::findOrFail($id);
        // update unique customer ID;
        if ($request->customer_id ==1) {
            $input['customer_id'] = 'GV' .substr($getCustomerById->customer_id,2);
        } elseif ($request->customer_id ==2) {
            $input['customer_id'] = 'SV' .substr($getCustomerById->customer_id,2);
        }

        if ($request->hasFile('customer_img')){
            $input['customer_img']=MyHelper::photoUpload($request->file('customer_img'),'images/customer-img/');
            if (file_exists($getCustomerById->customer_img)){
                unlink($getCustomerById->customer_img);
            }
        }
        if ($request->hasFile('nid_img')){
            $input['nid_img']=MyHelper::photoUpload($request->file('nid_img'),'images/customer-nid_img/');
            if (file_exists($getCustomerById->nid_img)){
                unlink($getCustomerById->nid_img);
            }
        }


        $input['updated_by'] = Auth::user()->id;

        try {
            $getCustomerById->update($input);
            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'Old Customer Info Update Successfully.');
        } else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryCustomer  $inventoryCustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getCustomerById=InventoryCustomer::findOrFail($id);

        DB::beginTransaction();
        try {

            $getCustomerById->delete();

            if (file_exists($getCustomerById->customer_img)){
                unlink($getCustomerById->customer_img);
            }

            if (file_exists($getCustomerById->nid_img)){
                unlink($getCustomerById->nid_img);
            }


            $bug = 0;
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', ' Custoemer Info Deleted Successfully.');
        }elseif ($bug==547){
            return redirect()->back()->with('error', 'Sorry this customer can not be delete due to used another module');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }
}

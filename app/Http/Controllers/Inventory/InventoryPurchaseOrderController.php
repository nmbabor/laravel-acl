<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\CompanyTermsAndCondition;
use App\Models\InventoryItem;
use App\Models\InventoryPurchaseOrder;
use App\Models\InventoryPurchaseOrderHistory;
use App\Models\InventoryVendor;
use App\Models\PurchaseOrderTermsConditions;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use QRCode;
use PDF;
use MyHelper;
use Yajra\DataTables\DataTables;

class InventoryPurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.inventory-purchase-order.index');
    }

    public  function inventoryPuraseOrdersList(){
        $purchaseOrders=InventoryPurchaseOrder::leftjoin('inventory_vendors','inventory_purchase_orders.vendor_id','inventory_vendors.id')
        ->select('inventory_vendors.vendor_name','inventory_vendors.id as vendorPrimaryId','inventory_purchase_orders.*');
        return DataTables::of($purchaseOrders)
            ->addColumn('date_of_purchase_order','<?php echo date(\'d-m-Y\',strtotime("$date_of_purchase_order"))?>')
            ->addColumn('date_of_shipment','<?php echo date(\'d-m-Y\',strtotime("$date_of_shipment"))?>')
            ->addColumn('vendor_name','<a href="{{URL::to("inventory-vendor/$vendorPrimaryId")}}" title=\'Click here to edit\'  target="_blank"> {{$vendor_name}}</a>')
            ->addColumn('action',' {!!Form::open(array(\'route\'=>[\'inventory-purchase-order.destroy\',"$id"],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id"))!!}
                <a href="{{URL::to("inventory-purchase-order/$id/")}}" title=\'Click here to view all info \' class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-eye"></i></a>
                <a href="{{URL::to("inventory-purchase-order/$id/edit")}}" title=\'Click here to edit \' class="btn btn-warning btn-xs"> <i class="fa fa-pencil-square"></i></a>
                <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm(\'deleteForm{{ $id}}\')"><i class="fa fa-trash"></i></button>
           {!! Form::close() !!}')
            ->rawColumns(['date_of_purchase_order','date_of_shipment','vendor_name','action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function inventoryItemSearch(Request $request){
        //return response()->json($request);
        $invItems=InventoryItem::where('item_name','like',$request->name.'%')->where('status',1)->select('item_name','id')->get();
        return response()->json($invItems);
    }

    public function create()
    {
        $lastPurchaseOrderId=InventoryPurchaseOrder::latest()->value('id');
        $vendors=InventoryVendor::orderBy('id','desc')->pluck('vendor_name','id');
        $termsConditions=CompanyTermsAndCondition::orderBy('id','desc')->where('condition_type',1)->pluck('condition_title','id');
        return view('inventory.inventory-purchase-order.create',compact('lastPurchaseOrderId','vendors','termsConditions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'vendor_id'=>'required|numeric',
            'purchase_order_no'=>'required|unique:inventory_purchase_orders,purchase_order_no',
            'date_of_purchase_order'=>'required',
            'date_of_shipment'=>'required',
            'billing_address'=>'required',
            'shipping_address'=>'required',
            'order_qty'=>'required',
            'sub_total'=>'required|numeric',

        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $qrCodeLink=$this->purchaseOrderQrCode($request);


        DB::beginTransaction();
        try{
            // insert into Main Purchase order Table --------------------
            $puchaseOrderId=InventoryPurchaseOrder::create(
                [
                    'purchase_order_no'=>$request->purchase_order_no,
                    'vendor_id'=>$request->vendor_id,
                    'order_qty'=>$request->order_qty,
                    'sub_total'=>$request->sub_total,
                    'shipping_charge'=>$request->shipping_charge,
                    'grand_total'=>$request->grand_total,
                    'reference'=>$request->reference,
                    'billing_address'=>$request->billing_address,
                    'shipping_address'=>$request->shipping_address,
                    'item_specification'=>$request->item_specification,
                    'date_of_purchase_order'=>date('Y-m-d',strtotime($request->date_of_purchase_order)),
                    'date_of_shipment'=>date('Y-m-d',strtotime($request->date_of_shipment)),
                    'order_qr_code'=>$qrCodeLink,
                    'created_by'=>Auth::user()->id
                ]
            )->id;


            // insert into Purchase order history Table --------------------
            for ($i=0;$i<sizeof($request->inventory_item_id);$i++){
                $input=$request->except('_token');
                $input['inventory_purchase_order_id']=$puchaseOrderId;
                $input['inventory_item_id']=$request->inventory_item_id[$i];
                $input['item_order_qty']=$request->item_order_qty[$i];
                $input['item_price']=$request->item_price[$i];
                $input['item_total']=$request->item_total[$i];
                InventoryPurchaseOrderHistory::create($input);
            }

            if ($request->terms_conditions_id){
                foreach ($request->terms_conditions_id as $terms_conditions_id){
                    PurchaseOrderTermsConditions::create(
                        [
                            'inventory_purchase_order_id'=>$puchaseOrderId,
                            'terms_conditions_id'=>$terms_conditions_id
                        ]);
                }
            }
            $bug=0;
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
            $bug1=$e->errorInfo[2];
        }

        if ($bug==0){
            return redirect('/inventory-purchase-order/'.$puchaseOrderId);
        }else{
            return redirect()->back()->with('error','Something went wrong !'.$bug1);
        }
    }



    public function purchaseOrderQrCode($request,$id=null){

        $vendorInfo=InventoryVendor::findOrFail($request->vendor_id);
        $codeName=mt_rand(1,1000).date('Y-m-d');
        $qrCodeLink='public/purchase-qr-code/'.date('Y-m-d').'/';
        if (!is_dir($qrCodeLink)){
            mkdir("$qrCodeLink",077,true);
        }
        $qrCodeLink=$qrCodeLink.$codeName.'.png';

        QRCode::text(
            'Purchase Order no: '.$request-> purchase_order_no.
            ', Vendor: '.$vendorInfo->vendor_name.
            ', Date of PO.: '.date('m/d/Y',strtotime($request->purchase_order_date)).
            ', Date of shipment: '.date('m/d/Y',strtotime($request->shipment_date)).
            ', Ordered Qty: '.$request->order_qty.
            ', Sub Total: '.$request->sub_total.
            ', Grand Total: '.$request->grand_amount.
            ', '
        )->setOutfile($qrCodeLink)->png();
        if (!empty($id)){
            $getPurchaseOrder=InventoryPurchaseOrder::findOrFail($id);
            if (file_exists($getPurchaseOrder->order_qr_code)){
                unlink($getPurchaseOrder->order_qr_code);
            }
        }
        return $qrCodeLink;
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getPurchaseOrder=InventoryPurchaseOrder::findOrFail($id);
        $purchaseOrderDetails=InventoryPurchaseOrderHistory::where('inventory_purchase_order_id',$id)->get();
        $purchaseTermsConditions=PurchaseOrderTermsConditions::where('inventory_purchase_order_id',$id)->get();
        return view('inventory.inventory-purchase-order.show',
            compact('getPurchaseOrder','purchaseOrderDetails','purchaseTermsConditions'));
    }


    public function inventoryPuraseOrdersPdfPrint($id){

        $getPurchaseOrder=InventoryPurchaseOrder::findOrFail($id);
        $purchaseOrderDetails=InventoryPurchaseOrderHistory::where('inventory_purchase_order_id',$id)->get();
        $purchaseTermsConditions=PurchaseOrderTermsConditions::where('inventory_purchase_order_id',$id)->get();


        //return view('inventory.inventory-purchase-order.purchase-order-pdf-print',
            //compact('getPurchaseOrder','purchaseOrderDetails','purchaseTermsConditions'));

        $orderPdf=PDF::loadView('inventory.inventory-purchase-order.purchase-order-pdf-print',
            compact('getPurchaseOrder','purchaseOrderDetails','purchaseTermsConditions'));
        return $orderPdf->stream($getPurchaseOrder->purchase_order_no.'.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryPurchaseOrder  $inventoryPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendors=InventoryVendor::orderBy('id','desc')->pluck('vendor_name','id');
        $termsConditions=CompanyTermsAndCondition::orderBy('id','desc')->where('condition_type',1)->pluck('condition_title','id');
         $getPurchaseOrder=InventoryPurchaseOrder::findOrFail($id);

         $getOrderHistories=InventoryPurchaseOrderHistory::where('inventory_purchase_order_id',$id)->get();
         $oldTermConditions=PurchaseOrderTermsConditions::select('terms_conditions_id')->where('inventory_purchase_order_id',$id)->pluck('terms_conditions_id')->toArray();
        return view('inventory.inventory-purchase-order.edit',compact('vendors','termsConditions','getPurchaseOrder','getOrderHistories','oldTermConditions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryPurchaseOrder  $inventoryPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'vendor_id'=>'required|numeric',
            'purchase_order_no'=>"required|unique:inventory_purchase_orders,purchase_order_no,$id",
            'date_of_purchase_order'=>'required',
            'date_of_shipment'=>'required',
            'billing_address'=>'required',
            'shipping_address'=>'required',
            'order_qty'=>'required',
            'sub_total'=>'required|numeric',

        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $getPurchaseOrder=InventoryPurchaseOrder::findOrFail($id);

        $qrCodeLink=$this->purchaseOrderQrCode($request,$id);

        DB::beginTransaction();
        try{
            // insert into Main Purchase order Table --------------------
            $getPurchaseOrder->update(
                [
                    'purchase_order_no'=>$request->purchase_order_no,
                    'vendor_id'=>$request->vendor_id,
                    'order_qty'=>$request->order_qty,
                    'sub_total'=>$request->sub_total,
                    'shipping_charge'=>$request->shipping_charge,
                    'grand_total'=>$request->grand_total,
                    'reference'=>$request->reference,
                    'billing_address'=>$request->billing_address,
                    'shipping_address'=>$request->shipping_address,
                    'item_specification'=>$request->item_specification,
                    'date_of_purchase_order'=>date('Y-m-d',strtotime($request->date_of_purchase_order)),
                    'date_of_shipment'=>date('Y-m-d',strtotime($request->date_of_shipment)),
                    'order_qr_code'=>$qrCodeLink,
                    'updated_by'=>Auth::user()->id
                ]);


            // (New Item) insert into Purchase order history Table --------------------
            if (isset($request->new_inventory_item_id)){
                for ($i=0;$i<sizeof($request->new_inventory_item_id);$i++){
                    $input=$request->except('_token');
                    $input['inventory_purchase_order_id']=$id;
                    $input['inventory_item_id']=$request->new_inventory_item_id[$i];
                    $input['item_order_qty']=$request->new_item_order_qty[$i];
                    $input['item_price']=$request->new_item_price[$i];
                    $input['item_total']=$request->new_item_total[$i];
                    InventoryPurchaseOrderHistory::create($input);
                }
            }

            // update old ordered item  info -------------
            if (isset($request->old_order_history_id)){
                for ($i=0;$i<sizeof($request->old_order_history_id);$i++){
                    $newData=[];
                    $oldOrderItem=InventoryPurchaseOrderHistory::where('id',$request->old_order_history_id[$i])->first();
                    $oldOrderItem->update(
                        [$oldOrderItem->item_order_qty=$request->old_item_order_qty[$i],
                        $oldOrderItem->item_price=$request->old_item_price[$i],
                        $oldOrderItem->item_total=$request->old_item_total[$i]
                            ]
                    );
                }
            }

            // delete old ordered Item info -----------
            if (isset($request->delete_Order_historyId_id)){
                $oldOrderItem=InventoryPurchaseOrderHistory::whereIn('id',$request->delete_Order_historyId_id)->delete();
            }



            // purchase order terms & conditions -------------------

            $oldPurchaserTermConditions=PurchaseOrderTermsConditions::where('inventory_purchase_order_id',$id)->get();

            if (isset($request->terms_conditions_id)){
                $newPurchaserTermConditions=$request->terms_conditions_id;
            }else{
                $newPurchaserTermConditions=[];
            }

            foreach ($oldPurchaserTermConditions as $key=>$oldPurchaserTermCondition) {

                foreach ($newPurchaserTermConditions as $newkey=> $newPurchaserTermCondition){

                    if ($oldPurchaserTermCondition->terms_conditions_id==$newPurchaserTermCondition){
                        unset($oldPurchaserTermConditions[$key]);
                        unset($newPurchaserTermConditions[$newkey]);

                    }

                }

            }

            // delete old purchase term & condition -----------------------
            if (count($oldPurchaserTermConditions)>0){
                foreach ($oldPurchaserTermConditions as $oldPurchaserTermCondition){
                    PurchaseOrderTermsConditions::where('id',$oldPurchaserTermCondition->id)->delete();
                }

            }

            // insert new purchase order term & conditions ----------------
            if (count($newPurchaserTermConditions)>0){
                foreach ($newPurchaserTermConditions as $terms_conditions_id){
                    PurchaseOrderTermsConditions::create(
                        [
                            'inventory_purchase_order_id'=>$id,
                            'terms_conditions_id'=>$terms_conditions_id
                        ]);
                }
            }


            $bug=0;
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
            $bug1=$e->errorInfo[2];
        }

        if ($bug==0){
            return redirect('/inventory-purchase-order/'.$id);
        }else{
            return redirect()->back()->with('error','Something went wrong !'.$bug1);
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryPurchaseOrder  $inventoryPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $id;
    }
}

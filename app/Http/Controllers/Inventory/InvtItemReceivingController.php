<?php

namespace App\Http\Controllers\Inventory;

use App\Models\InventoryPurchaseOrder;
use App\Models\InventoryPurchaseOrderHistory;
use App\Models\InvtMasterReceivedItem;
use App\Models\InvtReceivedItemHistory;
use App\Models\MasterInventory;
use App\Models\SelfOfStorageBlock;
use App\Models\Storage;
use App\Models\StorageBlock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Validator;
use App\Models\InventoryItem;
use PDF;
use Yajra\DataTables\DataTables;
use MyHelper;

class InvtItemReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.received-item.index');
    }

    public function showAllReceivedItems(){

        $receivedItems=InvtMasterReceivedItem::leftjoin('inventory_purchase_orders','invt_master_received_items.purchase_order_id','inventory_purchase_orders.id')
            ->leftjoin('inventory_vendors','inventory_purchase_orders.vendor_id','inventory_vendors.id')
            ->select('inventory_purchase_orders.purchase_order_no','inventory_vendors.vendor_name','inventory_vendors.id as vendorPrimaryId','invt_master_received_items.*')->get();
        return DataTables::of($receivedItems)

            ->addColumn('vendor_name','<a href="{{URL::to("inventory-vendor/$vendorPrimaryId")}}" title=\'Click here to view vendor all info\'  target="_blank"> {{$vendor_name}}</a>')
            ->addColumn('received_img','<a href="{{asset($received_img)}}" title=\'Voucher Image\' data-toggle="lightbox" data-gallery="example-gallery"> <img src="{{asset($received_img)}}" width="50"></a>')
            ->addColumn('received_qty','{{round($received_qty,2)}}')
            ->addColumn('grand_total','{{round($grand_total,2)}} Tk')
            ->addColumn('received_date','<?php echo date(\'d-m-Y\',strtotime("$received_date"))?>')
            ->addColumn('action',' {!!Form::open(array(\'route\'=>[\'inventory-item-receiving.destroy\',"$id"],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id"))!!}
                <a href="{{URL::to("inventory-item-receiving/$id/")}}" title=\'Click here to view all info \' class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-eye"></i></a>
                <a href="{{URL::to("inventory-item-receiving/$id/edit")}}" title=\'Click here to edit \' class="btn btn-warning btn-xs"> <i class="fa fa-pencil-square"></i></a>
                <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm(\'deleteForm{{ $id}}\')"><i class="fa fa-trash"></i></button>
           {!! Form::close() !!}')
            ->rawColumns(['created_at','date_of_shipment','received_qty','grand_total','vendor_name','received_img','action'])
            ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->id){
            $getPurchaseOrder=InventoryPurchaseOrder::findOrFail($request->id);
            $purchaseOrderItems=InventoryPurchaseOrderHistory::where('inventory_purchase_order_id',$request->id)->get();
            $storage=Storage::where('branch_id',Auth::user()->branch_id)->first();
            if (!empty($storage)){  // identify storage by login user ------------
                $storageBloks=StorageBlock::where('storage_id',$storage->id)->pluck('block_name','id');
            }else{
                return redirect('')->with('error','You have no storage! Create storage.');
            }
        }

        $purchaseOrderNo=InventoryPurchaseOrder::orderBy('purchase_order_no','desc')->where('order_status','1')->orWhere('order_status','3')->orWhere('order_status','4')->take(150)->pluck('purchase_order_no','id');
        return view('inventory.received-item.create',compact('purchaseOrderNo','getPurchaseOrder','purchaseOrderItems','storage','storageBloks'));
    }

    public function loadSelfOfStorageBlock($storageBlockId,$purchaseOrderItemId){
        $selfsOfBlock=SelfOfStorageBlock::where('storage_block_id',$storageBlockId)->pluck('self_of_block','id');
        return view('inventory.received-item.load-self-block',compact('selfsOfBlock','purchaseOrderItemId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $validator = Validator::make($request->all(),[
            'purchase_order_id' => 'required',
            'voucher_no' => 'required',
            'received_date' => 'required',
            'sub_total' => 'required|min:1',
            'grand_total' => 'required|min:1',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //return $request;

        DB::beginTransaction();
        try{
            $masterData=$request->except('_token');
            $masterData['received_date']=date('Y-m-d',strtotime($request->received_date));
            $masterData['received_by']=Auth::user()->id;
            $masterData['created_by']=Auth::user()->id;

            if ($request->hasFile('received_img')){
                $masterData['received_img']=MyHelper::photoUpload($request->file('received_img'),'images/item-received-img/');
            }

            $masterItemReceivedId=InvtMasterReceivedItem::create($masterData)->id;

                // insert into received history table ------------------------
                foreach ($request->receive_ordered_item as $key=>$orderItem){

                    //insert / update into Master inventory table -------------------------
                    $oldMasterInventory=MasterInventory::where('item_id',$request->item_id[$key])->where('storage_id',$request->storage_id[$key])->first();

                    if ($oldMasterInventory!=null){
                        $oldMasterInventory->update([
                            $oldMasterInventory->available_qty=$oldMasterInventory->available_qty+$request->item_received_qty[$key],
                            $oldMasterInventory->updated_by=Auth::user()->id
                        ]);
                    }else {
                        $masterInventoryId = MasterInventory::create([
                            'item_id' => $request->item_id[$key],
                            //'model_id' => '',
                            'available_qty' => $request->item_received_qty[$key],
                            'cost_price' => $request->cost_price[$key],
                            'storage_id' =>$request->storage_id[$key],
                            'created_by' => Auth::user()->id,
                            'company_id' => Auth::user()->company_id,
                            'branch_id' => Auth::user()->branch_id,
                        ])->id;
                    } // end else ------

                    $input=$request->except('_token');
                    $input['master_received_id']=$masterItemReceivedId;
                    $input['inventory_id']=isset($oldMasterInventory->id)?$oldMasterInventory->id:$masterInventoryId; // old Or new inventory id ----
                    $input['item_id']=$request->item_id[$key];
                    $input['received_qty']=$request->item_received_qty[$key];
                    $input['cost_price']=$request->cost_price[$key];
                    $input['item_total']=$request->item_total[$key];
                    $input['storage_id']=$request->storage_id[$key];
                    $input['storage_block_id']=isset($request->storage_block_id[$key])?$request->storage_block_id[$key]:'';
                    $input['storage_block_self_id']=isset($request->storage_block_self_id[$key])?$request->storage_block_self_id[$key]:'';
                    $input['available_qty']=$request->item_received_qty[$key];
                    $input['storage_id']=$request->storage_id[$key];
                    $input['created_by'] = Auth::user()->id;
                    $input ['company_id'] = Auth::user()->company_id;
                    $input ['branch_id']= Auth::user()->branch_id;
                    $save=InvtReceivedItemHistory::create($input);
                } // end foreach ---------------------------------------------


            // change purchase order status ---------------------------------
            $getPurchaseOrderInfo=InventoryPurchaseOrder::findOrFail($request->purchase_order_id)->update(['order_status'=>5]);
            //$getPurchaseOrderInfo->update(['order_status'=>5]);
            DB::commit();
            $bug=0;
        }catch (Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
            $bug1=$e->errorInfo[2];
        }
        if ($bug==0){
            return redirect('/item-receiving-print-pdf/'.$masterItemReceivedId);
        }else{
            return redirect()->back()->with('error','Something went wrong to save received item !'.$bug1);
        }
    }

    public function itemReceivingPrintPdf($masterId){
        return 'Good Job-'.$masterId;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $masterInfo=InvtMasterReceivedItem::findOrFail($id);
        if (!empty($masterInfo)){
            $itemDetails=InvtReceivedItemHistory::where('master_received_id',$masterInfo->id)->get();
        }
        return view('inventory.received-item.show',compact('masterInfo','itemDetails'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('inventory.received-item.edit');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

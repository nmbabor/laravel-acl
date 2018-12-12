@extends('layouts.app')
@section('style')
    <link href="{{asset('public/assets/css/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/easy-autocomplete.min.css')}}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{URL::to('inventory-item-receiving')}}"> Received Item Details</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                    <i class="fa fa-info-circle"></i> View Received Items Details
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-item-receiving')}}" title="View All Purchase Order" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View Received Item</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="address-area" style="margin-bottom: 10px">

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg3">
                                <label class="text-danger">Purchase Order No <sup>*</sup></label>
                                <div>
                                    {{Form::text('purchase_order_id',$masterInfo->purchaseOrder->purchase_order_no,['id'=>'purchase_order_id','class'=>'form-control','readonly'=>true])}}
                                </div>
                            </div>

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg3">
                                    <label>Vendor <sup>*</sup></label>
                                    <div class="">
                                        {{Form::text('vendor',$masterInfo->purchaseOrder->purchaseOrderToVendor->vendor_name,['class'=>'form-control','readonly'=>true])}}
                                    </div>
                                </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg3">
                                <label>Voucher No <sup>*</sup></label>
                                <div class="">
                                    {{Form::text('voucher_no',$masterInfo->voucher_no,['class'=>'form-control','readonly'=>true])}}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg3">
                                <label >Date of Received <sup>*</sup></label>
                                <div class="">
                                    {{Form::text('received_date',$value=date('m-d-Y',strtotime($masterInfo->received_date)),['class'=>'form-control'])}}
                                </div>
                            </div>

                        </div><!-- end form-group row -->
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered tabcontent-border" id="auto_table">
                                <thead>
                                <tr class="bg-success">
                                    <th width="20%">Item Name</th>
                                    <th width="3%">Qty</th>
                                    <th width="4%">Unit Price</th>
                                    <th width="5%">Item Total</th>
                                    <th width="5%">Storage info</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($itemDetails))
                                    @foreach($itemDetails as $item)
                                        <tr>
                                            <td>
                                                <input type="text"  value="{{$item->receivedItem->item_name}}" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="text"  value="{{round($item->received_qty,2)}}" class="form-control itemQty ">
                                            </td>
                                            <td>
                                                <input type="number" value="{{round($item->cost_price,2)}}" class="form-control item_price"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" value="{{round($item->item_total,2)}}"  class="form-control item_total"  readonly>
                                            </td>
                                            <td>
                                                <input type="text"  value="{{$item->itemReceivedStorage->storage_name}}" class="form-control" readonly>
                                                {{--<a href="#storageModal_{{$purchaseOrderItem->id}}" data-toggle="modal" class="btn btn-info btn-xs"><i class="fa fa-archive" aria-hidden="true"></i></a>--}}
                                                {{--<!-- #modal-dialog -->--}}
                                                {{--<div class="modal fade" id="storageModal_{{$purchaseOrderItem->id}}">--}}
                                                    {{--<div class="modal-dialog">--}}
                                                        {{--<div class="modal-content">--}}
                                                            {{--<div class="modal-header">--}}
                                                                {{--<h5 class="modal-title"> Stored this item specific storage <u>block</u> & <u>Self</u></h5>--}}
                                                                {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="modal-body">--}}
                                                                {{--<div class="form-group row">--}}
                                                                    {{--<label class="control-label col-md-4 col-sm-4"> Storage <sup>*</sup> :</label>--}}
                                                                    {{--<div class="col-md-8 col-sm-8">--}}
                                                                        {{--{{Form::select("storage_id[$purchaseOrderItem->id]",["$storage->id"=>"$storage->storage_name"],[],['class'=>'form-control','required'=>true])}}--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                                {{--<div class="form-group row">--}}
                                                                    {{--<label class="control-label col-md-4 col-sm-4"> Block of Storage <sup>*</sup> :</label>--}}
                                                                    {{--<div class="col-md-8 col-sm-8">--}}
                                                                        {{--{{Form::select("storage_block_id[$purchaseOrderItem->id]",$storageBloks,[],["id"=>"storageBlock_$purchaseOrderItem->id",'onchange'=>'storageBlocks(this.id)','class'=>'form-control select','placeholder'=>'Select Block','required'=>true])}}--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}

                                                                {{--<div class="form-group row">--}}
                                                                    {{--<label class="control-label col-md-4 col-sm-4"> Self of Block <sup>*</sup></label>--}}
                                                                    {{--<div class="col-md-8 col-sm-8" id="selfOfBlock_{{$purchaseOrderItem->id}}">--}}
                                                                        {{--{{Form::select("storage_block_self_id[$purchaseOrderItem->id]",[],[],['class'=>'form-control select','placeholder'=>'Select Self/Rack','required'=>true])}}--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}

                                                            {{--</div>--}}
                                                            {{--<div class="modal-footer">--}}
                                                                {{--<a href="javascript:;" class="btn btn-sm btn-success" data-dismiss="modal">Confirm</a>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div> <!--  =================== End modal ===================  -->--}}
                                            </td>
                                            {{--<td>--}}
                                            {{--<span style="cursor: pointer" class="delete-row" id="delete_row_1"><i class="fa fa-trash text-danger" title="Delete Product"></i>--}}
                                            {{--</span>--}}
                                            {{--</td>--}}
                                        </tr>
                                    @endforeach
                                @endif

                                </tbody>
                            </table>

                        </div>
                    </div> <!--end item display row-->
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <label>Item Receiving Notes</label>
                                    <div>
                                        {{Form::textarea('notes',$masterInfo->notes,['class'=>'form-control','rows'=>3]) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <label>Reference</label>
                                    <div>
                                        {{Form::text('reference',$masterInfo->reference,['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div><!--end row-->
                        </div>

                        <div class="col-md-5">
                            <table class="table table-bordered amount-summery" style="background-color: #ffffff;margin-top: 10px">
                                <tbody>
                                <tr>
                                    <th width="40"> <b>Subtotal</b></th>
                                    <th width="60">
                                        <input type="text" name="sub_total" value="{{round($masterInfo->sub_total,2)}} Tk" id="sub_total"  class="form-control" readonly>
                                    </th>
                                </tr>
                                {{--<tr>--}}
                                    {{--<th width="40"> <b>Shipping Charge</b></th>--}}
                                    {{--<th width="60"><input type="number" name="shipping_charge" value="{{round($masterInfo->shipping_charge,2)}}" id="shipping_charg" min="0" class="form-control balanceChange" readonly></th>--}}
                                {{--</tr>--}}
                                <tr>
                                    <th width="40"> <b>Grand Total</b></th>
                                    <th width="60"><input type="text" name="grand_total" value="{{round($masterInfo->grand_total,2)}} Tk" id="total_amount" class="form-control" readonly></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{--<br>--}}
                    {{--<span received_voucher_img title="Add More Product" class="btn btn-info btn-xs pull-right"><i class="fa fa-plus-circle"></i> Add More </span>--}}

                    <div class="form-group row">
                        <div class="col-md-7 col-xs-6 col-sm-6 col-md-7">
                            <label>Voucher Img</label>
                            <div class="">
                                @if($masterInfo->received_img!=null)
                                    <label class="upload_photo"  for="receivedVoucherImg">
                                        <a href="{{asset($masterInfo->received_img)}}" data-toggle="lightbox" data-gallery="example-gallery"><img id="receivedVoucherImgLoad" src="{{asset($masterInfo->received_img)}}" width="150" height="120" title="Voucher Image"></a>
                                    </label>
                                @else
                                    <label class="upload_photo"  for="receivedVoucherImg">
                                        <img id="receivedVoucherImgLoad" src="{{asset('images/default/photo.png')}}" width="150" height="120" title="Voucher Image">
                                    </label>
                                    @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('public/bower_components/ekko-lightbox/js/ekko-lightbox.js')}}"></script>
    <script src="{{asset('public/bower_components/lightbox2/js/lightbox.js')}}"></script>
    <script type="text/javascript">
        //light box
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
    @endsection
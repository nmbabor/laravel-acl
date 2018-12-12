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
            <a href="{{URL::to('inventory-item-receiving')}}"> Item Receiving</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                    Create new item receiving
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-item-receiving')}}" title="View All Purchase Order" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View Received Item</a>
                    </div>
                </div>

                {!! Form::open(array('route' =>'inventory-item-receiving.store','method'=>'POST','files'=>'true','onsubmit'=>'itemReceivedSubmit()','target'=>'_blank','class'=>'vertical')) !!}
                <div class="card-body">
                    <div class="address-area" style="margin-bottom: 10px">

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg3">
                                <label class="text-danger">Purchase Order No <sup>*</sup></label>
                                <div>
                                    {{Form::select('purchase_order_id',$purchaseOrderNo,isset($getPurchaseOrder->id)?$getPurchaseOrder->id:'',['id'=>'purchase_order_id','class'=>'form-control','placeholder'=>'Select','required'=>true])}}
                                </div>
                            </div>

                            @if(isset($getPurchaseOrder->purchaseOrderToVendor->vendor_name))
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg3">
                                <label>Vendor <sup>*</sup></label>
                                <div class="">
                                    {{Form::text('vendor',$value=$getPurchaseOrder->purchaseOrderToVendor->vendor_name,['class'=>'form-control','readonly'=>true])}}
                                </div>
                            </div>
                            @endif
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg3">
                                <label>Voucher No <sup>*</sup></label>
                                <div class="">
                                    {{Form::text('voucher_no',$value=old('voucher_no'),['class'=>'form-control','required'=>true])}}
                                    <span class="text-danger">
                                        {{$errors->has('voucher_no')?$errors->first('voucher_no'):''}}
                                    </span>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg3">
                                <label >Date of Received <sup>*</sup></label>
                                <div class="">
                                    {{Form::text('received_date',$value=date('m-d-Y'),['class'=>'form-control datepicker'])}}
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
                                    <th width="2%"><i class="fa fa-check-circle-o"></i></th>
                                    <th width="20%">Item Name</th>
                                    <th width="3%">Qty</th>
                                    <th width="4%">Unit Price</th>
                                    <th width="5%">Item Total</th>
                                    <th width="5%">Storage info</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($purchaseOrderItems))
                                    @foreach($purchaseOrderItems as $purchaseOrderItem)
                                        <tr>
                                            <td><input type="checkbox"  name="receive_ordered_item[{{$purchaseOrderItem->id}}]" value="" class="delete-row" id="checkBox_{{$purchaseOrderItem->id}}" checked></td>
                                            <td>
                                                <input type="text" name="item_name[{{$purchaseOrderItem->id}}]" value="{{$purchaseOrderItem->purchaseOrderItem->item_name}}" id="itemName_{{$purchaseOrderItem->id}}" class="form-control" readonly>
                                                <input type="hidden" name="item_id[{{$purchaseOrderItem->id}}]" value="{{$purchaseOrderItem->inventory_item_id}}" id="hideIditemName_{{$purchaseOrderItem->id}}">
                                            </td>
                                            <td>
                                                <input type="text" name="item_received_qty[{{$purchaseOrderItem->id}}]" value="{{round($purchaseOrderItem->item_order_qty,2)}}" id="itemQty_{{$purchaseOrderItem->id}}"  onkeyup="itemTotal(this.id)" onkeyup="totalOrderedQty()" class="form-control itemQty ">
                                                <input type="hidden"  value="{{round($purchaseOrderItem->item_order_qty,2)}}" id="hideItemQty_{{$purchaseOrderItem->id}}" min="0" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <input type="number" name="cost_price[{{$purchaseOrderItem->id}}]" value="{{round($purchaseOrderItem->item_price,2)}}" id="itemPrice_{{$purchaseOrderItem->id}}" min="0" class="form-control item_price"  readonly>
                                                <input type="hidden" value="{{round($purchaseOrderItem->item_price,2)}}" id="hideItemPrice_{{$purchaseOrderItem->id}}" min="0" class="form-control" readonly disabled>
                                            </td>
                                            <td>
                                                <input type="number" name="item_total[{{$purchaseOrderItem->id}}]" value="{{round($purchaseOrderItem->item_total,2)}}" id="itemTotal_{{$purchaseOrderItem->id}}" min="0" class="form-control item_total"  readonly>
                                                <input type="hidden"  value="{{round($purchaseOrderItem->item_total,2)}}" id="hideItemTotal_{{$purchaseOrderItem->id}}" min="0" class="form-control" readonly disabled>
                                            </td>
                                            <td><a href="#storageModal_{{$purchaseOrderItem->id}}" data-toggle="modal" class="btn btn-info btn-xs"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                                <!-- #modal-dialog -->
                                                <div class="modal fade" id="storageModal_{{$purchaseOrderItem->id}}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"> Stored this item specific storage <u>block</u> & <u>Self</u></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label class="control-label col-md-4 col-sm-4"> Storage <sup>*</sup> :</label>
                                                                    <div class="col-md-8 col-sm-8">
                                                                        {{Form::select("storage_id[$purchaseOrderItem->id]",["$storage->id"=>"$storage->storage_name"],[],['class'=>'form-control','required'=>true])}}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="control-label col-md-4 col-sm-4"> Block of Storage <sup>*</sup> :</label>
                                                                    <div class="col-md-8 col-sm-8">
                                                                        {{Form::select("storage_block_id[$purchaseOrderItem->id]",$storageBloks,[],["id"=>"storageBlock_$purchaseOrderItem->id",'onchange'=>'storageBlocks(this.id)','class'=>'form-control select','placeholder'=>'Select Block','required'=>true])}}
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="control-label col-md-4 col-sm-4"> Self of Block <sup>*</sup></label>
                                                                    <div class="col-md-8 col-sm-8" id="selfOfBlock_{{$purchaseOrderItem->id}}">
                                                                        {{Form::select("storage_block_self_id[$purchaseOrderItem->id]",[],[],['class'=>'form-control select','placeholder'=>'Select Self/Rack','required'=>true])}}
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:;" class="btn btn-sm btn-success" data-dismiss="modal">Confirm</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!--  =================== End modal ===================  -->
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
                                        {{Form::textarea('notes',$value=old('notes'),['class'=>'form-control','rows'=>4]) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <label>Reference</label>
                                    <div>
                                        {{Form::text('reference',$value=old('reference'),['class'=>'form-control','rows'=>4]) }}
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
                                        <input type="number" name="sub_total" value="{{isset($getPurchaseOrder->sub_total)?round($getPurchaseOrder->sub_total,2):''}}" id="sub_total" min="0" class="form-control" readonly>
                                        <input type="number" name="received_qty"  value="{{isset($getPurchaseOrder->order_qty)?round($getPurchaseOrder->order_qty):''}}" id="receivedQty">
                                    </th>
                                </tr>
                                <tr>
                                    <th width="40"> <b>Shipping Charge</b></th>
                                    <th width="60"><input type="number" name="shipping_charge" value="{{isset($getPurchaseOrder->shipping_charge)?round($getPurchaseOrder->shipping_charge,2):''}}" id="shipping_charg" min="0" class="form-control balanceChange" readonly></th>
                                </tr>
                                <tr>
                                    <th width="40"> <b>Grand Total</b></th>
                                    <th width="60"><input type="number" name="grand_total" value="{{isset($getPurchaseOrder->grand_total)?round($getPurchaseOrder->grand_total,2):''}}" id="total_amount" min="0" class="form-control" readonly></th>
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
                                <label class="upload_photo"  for="receivedVoucherImg">
                                    <img id="receivedVoucherImgLoad" src="{{asset('images/default/photo.png')}}" width="150" height="120" title="Voucher Image">
                                </label>
                                <input type="file" id="receivedVoucherImg" name="received_img" onchange="loadReceivedVoucherImg(this,this.id)" class="form-control" accept="image/*" style="display: none">
                            </div>
                            <span class="text-danger">
                                {{$errors->has('received_img')?$errors->first('received_img'):''}}
                            </span>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary btn-block">Save Item <i class="fa fa-download"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).on('change','#purchase_order_id',function () {
            var purchaseOrderId=$('#purchase_order_id').val();
            window.location.replace('{{url("/inventory-item-receiving/create?")}}id='+purchaseOrderId);
        })
    </script>

    <script>
        function totalOrderedQty() {
            var itemQty=0;
            $('.itemQty').each(function () {
                itemQty+=Number($(this).val());
            });
            $('#receivedQty').val(itemQty);
        }

        function itemTotal(id) {
            var id=id;
            var itemQty=$('#'+id).val();
            var idNumber=id.split('_')[1];
            var itemPrice=$('#itemPrice_'+idNumber).val();
            var itemTotal=Number(itemQty)*Number(itemPrice);
            $('#itemTotal_'+idNumber).val(itemTotal);
            itemQtyWiseAmount();
            totalOrderedQty();
        }

        function itemQtyWiseAmount() {
            var subTotal=0;
            $('.item_total').each(function () {
                subTotal+=Number($(this).val());
            });

            var shippingCharg=0;
            shippingCharg=$('#shipping_charg').val();

            grandTotal=Number(subTotal)+Number(shippingCharg);

            $('#sub_total').val(subTotal);
            $('#total_amount').val(grandTotal);
        }

        $(document).on('click','.delete-row',function () {
            var attrs=$(this).attr('checked');
            if (attrs=='checked'){
                $(this).removeAttr('checked');
                var idNumber=$(this).attr('id').split('_')[1];
                $('#itemQty_'+idNumber).val('');
                $('#itemPrice_'+idNumber).val('');
                $('#itemTotal_'+idNumber).val('');
                itemQtyWiseAmount();
                totalOrderedQty();
            }else {
                $(this).attr('checked','checked');
                var idNumber=$(this).attr('id').split('_')[1];
                $('#itemQty_'+idNumber).val($('#hideItemQty_'+idNumber).val());

                $('#itemPrice_'+idNumber).val($('#hideItemPrice_'+idNumber).val());
                $('#itemTotal_'+idNumber).val($('#hideItemTotal_'+idNumber).val());
                itemQtyWiseAmount();
                totalOrderedQty();
            }

        });


        // if shipping charge change ---------------
        $(document).on('keyup change','.balanceChange',function () {
            itemQtyWiseAmount()
        });

    </script>

    <script>
        function loadReceivedVoucherImg(input,receivedVoucherImgLoad) {
            var target_image='#'+$('#'+receivedVoucherImgLoad).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        function itemReceivedSubmit() {
            setTimeout(function () {
                window.location.replace('{{url("/inventory-item-receiving/create")}}');
            },3000);
        }

    </script>

    <script>
        function storageBlocks(id) {
            var storageBlockId=$('#'+id).val();
            var idNum=id.split('_')[1];
            $('#selfOfBlock_'+idNum).load('{{URL::to("/load-self-of-storage-block")}}/'+storageBlockId+'/'+idNum);

        }
    </script>

@endsection
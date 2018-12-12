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
            <a href="{{URL::to('inventory-purchase-order')}}">Inventory Purchase Order</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                    <i class="fa fa-edit"></i> Edit new Purchase Order
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-purchase-order')}}" title="View All Purchase Order" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View Purchase Order</a>
                    </div>
                </div>

                {!! Form::open(array('route' =>['inventory-purchase-order.update',$getPurchaseOrder->id],'method'=>'PUT','class'=>'form-horizontals','files'=>true)) !!}
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="">
                                <label>Select Vendor <sup>*</sup></label>
                                <div>
                                    {{Form::select('vendor_id',$vendors,$getPurchaseOrder->vendor_id,['class'=>'form-control select','placeholder'=>'Select','required'=>true])}}
                                    <span class="text-danger">
                                        {{$errors->has('vendor_id')?$errors->first('vendor_id'):''}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <label>Purchase Order No</label>
                                <div>
                                    {{Form::text('purchase_order_no',$value=$getPurchaseOrder->purchase_order_no,['class'=>'form-control','required'=>true,'readonly'=>true])}}
                                    <span class="text-danger">
                                        {{$errors->has('purchase_order_no')?$errors->first('purchase_order_no'):''}}
                                    </span>
                                </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <label>Order Date</label>
                            <div>
                                {{Form::text('date_of_purchase_order',$value=date('d-m-Y',strtotime($getPurchaseOrder->date_of_purchase_order)),['class'=>'form-control datepicker','required'=>true])}}
                                <span class="text-danger">
                                        {{$errors->has('date_of_purchase_order')?$errors->first('date_of_purchase_order'):''}}
                                    </span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <label>Shipment Date</label>
                            <div>
                                {{Form::text('date_of_shipment',$value=date('d-m-Y',strtotime($getPurchaseOrder->date_of_shipment)),['class'=>'form-control datepicker','required'=>true])}}
                                <span class="text-danger">
                                        {{$errors->has('date_of_shipment')?$errors->first('date_of_shipment'):''}}
                                    </span>
                            </div>
                        </div>
                    </div><!--end row -->

                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label>Billing Address Address</label>
                            <div class="">
                                {{Form::textarea('billing_address',$value=$getPurchaseOrder->billing_address,['class'=>'form-control','required'=>true,'rows'=>2])}}
                                <span class="text-danger">
                                    {{$errors->has('billing_address')?$errors->first('billing_address'):''}}
                                    </span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label>Shipping Address</label>
                            <div class="">
                                {{Form::textarea('shipping_address',$value=$getPurchaseOrder->shipping_address,['class'=>'form-control','required'=>true,'rows'=>2])}}
                                <span class="text-danger">
                                    {{$errors->has('shipping_address')?$errors->first('shipping_address'):''}}
                                </span>
                            </div>
                        </div>
                    </div><!--end row-->
                    <!-- ==================item displaying================= -->
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="auto_table">
                                <thead>
                                <tr style="background-color: rgba(118,131,134,0.29)">
                                    <th width="20%">Item Name</th>
                                    <th width="3%">Qty</th>
                                    <th width="4%">Unit Price</th>
                                    <th width="5%">Item Total</th>
                                    <th width="1%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                               <?php $i=0?>
                            @foreach($getOrderHistories as $getOrderHistory)
                                <?php $i++?>
                                <tr>
                                    <td>
                                        <input type="text" value="{{$getOrderHistory->purchaseOrderItem->item_name}}" id="itemName_{{$i}}" class="form-control" autocomplete="off" onclick="autoCompleteItemSearch(this.id)" placeholder="Type item" required>
                                        <input type="hidden" name="old_order_history_id[]" value="{{$getOrderHistory->id}}" id="OrderHistoryId_{{$i}}">
                                    </td>
                                    <td>
                                        <input type="number" name="old_item_order_qty[]"  value="{{round($getOrderHistory->item_order_qty,2)}}" id="itemQty_{{$i}}"  onkeyup="qtyXItemPrice(this.id)" onkeyup="totalOrderedQty()" min="0" class="form-control itemQty">
                                    </td>
                                    <td>
                                        <input type="number" name="old_item_price[]" value="{{round($getOrderHistory->item_price,2)}}" id="itemPrice_{{$i}}"  onkeyup="itemTotal(this.id)" onkeydown="totalOrderedQty()" min="0" class="form-control itemPrice" required>
                                    </td>
                                    <td>
                                        <input type="number" name="old_item_total[]" value="{{round($getOrderHistory->item_total,2)}}" id="itemTotal_{{$i}}" min="0" class="form-control itemTotal" readonly required>
                                    </td>
                                    <td>
                                            <span style="cursor: pointer" class="delete-row" id="deleteRow_{{$i}}" onclick="collectDelteId(this.id)"><i class="fa fa-trash text-danger" title="Delete Product"></i>
                                            </span>
                                    </td>
                                </tr>
                                @endforeach

                                <div id="deleteIdList">

                                </div>
                                </tbody>
                            </table>
                            <br>
                            <button type="button" class="btn btn-warning btn-sm" title="Add More Item" id="addMoreItem"><i class="fa fa-plus-circle"></i> Add More</button>
                        </div>
                    </div> <!--end item display row-->

                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Item Specification</label>
                                    <div>
                                        {{Form::textarea('item_specification',$value=$getPurchaseOrder->item_specification,['class'=>'form-control','rows'=>4]) }}
                                    </div>
                                </div>
                                <div class="col-md-12" >
                                    <label>Terms & Condition</label>
                                    <div style="border: 1px solid #c0c0c0;padding: 5px">
                                        @foreach($termsConditions as $key => $value)
                                            @if(in_array($key,$oldTermConditions))
                                            <label >{{Form::checkbox('terms_conditions_id[]',$key,true )}} {{$value}}</label>
                                            @else
                                                <label >{{Form::checkbox('terms_conditions_id[]',$key,false )}} {{$value}}</label>
                                                @endif
                                        @endforeach
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
                                        <input type="number" name="sub_total" value="{{round($getPurchaseOrder->sub_total,2)}}" id="sub_total" min="0" class="form-control">
                                        <input type="hidden" name="order_qty" value="{{round($getPurchaseOrder->order_qty,2)}}" id="totalOrderQty">
                                    </th>
                                </tr>
                                <tr>
                                    <th width="40"> <b>Shipping Charge</b></th>
                                    <th width="60"><input type="number" name="shipping_charge" value="{{round($getPurchaseOrder->shipping_charge,2)}}" id="shipping_charg" min="0" class="form-control balanceChange"></th>
                                </tr>
                                <tr>
                                    <th width="40"> <b>Gtand Total</b></th>
                                    <th width="60"><input type="number" name="grand_total" value="{{round($getPurchaseOrder->grand_total,2)}}" id="total_amount" min="0" class="form-control"></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!--end row-->
                    <div class="row form-group">
                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-primary btn-block ">Create Order</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        // search Item name -----------
        function autoCompleteItemSearch(id){
            $('#'+id).autocomplete({
                source: function( request, response ) {
                    console.log(request);
                    $.ajax({
                        url: '{{URL::to('/search-inventory-item')}}',
                        type: "GET",
                        dataType: "json",
                        data: {
                            name: request.term
                        },
                        success: function( data ) {
                            response( $.map( data, function( item ) {
                                return {
                                    value: item['item_name'],
                                    label: item['item_name'],
                                    data:item
                                }
                            }));

                        }
                    });
                },
                autoFocus: true ,
                minLength: 0,
                select: function( event, ui ) {
                    var names = ui.item.data;
                    var id = $(this).attr('id').split('_')[1];
                    $('#hideId_'+id).val(names['id']);
                }
            });
        }
    </script>

    <script>
        $(document).on('click','#addMoreItem',function () {
            var i=$('#auto_table tr').length;
            var htmltr='<tr>\n' +
                '                                        <td>\n' +
                '                                            <input type="text"  id="itemName_'+i+'" class="form-control" autocomplete="off" onclick="autoCompleteItemSearch(this.id)" placeholder="Type item" required>\n' +
                '                                            <input type="hidden" name="new_inventory_item_id[]" id="hideId_'+i+'">'+
                '                                        </td>\n' +
                '                                        <td>\n' +
                '                                            <input type="number" name="new_item_order_qty[]"  value="1" id="itemQty_'+i+'"   onkeyup="qtyXItemPrice(this.id)" onkeyup="totalOrderedQty()" min="0" class="form-control itemQty">\n' +
                '                                        </td>\n' +
                '                                        <td>\n' +
                '                                            <input type="number" name="new_item_price[]" value="" id="itemPrice_'+i+'"  onkeyup="itemTotal(this.id)" onkeydown="totalOrderedQty()" min="0" class="form-control itemPrice" required>\n' +
                '                                        </td>\n' +
                '                                        <td>\n' +
                '                                            <input type="number" name="new_item_total[]" value="" id="itemTotal_'+i+'" min="0" class="form-control itemTotal" readonly required>\n' +
                '                                        </td>\n' +
                '                                        <td>\n' +
                '                                            <span style="cursor: pointer" class="delete-row" id="deleteRow_'+i+'"><i class="fa fa-trash text-danger" title="Delete Product"></i>\n' +
                '                                            </span>\n' +
                '                                        </td>\n' +
                '                                    </tr>';
            $('#auto_table').append(htmltr);
        })
    </script>

    <script>

        function collectDelteId(id) {
            var old_inventory_item_id=$('#OrderHistoryId_'+(id).split('_')[1]).val();

            $('#deleteIdList').append('<input type="hidden" name="delete_Order_historyId_id[]" value="'+old_inventory_item_id+'">');
        }


        $(document).on('click','.delete-row',function () {

            $(this).parents('tr').remove();
            amountCalculation();
            totalOrderedQty();
        });

        function itemTotal(id) { // item total calculation ------
            var id=id;
            idNumber=id.split("_");
            itemQty=$('#itemQty_'+idNumber[1]).val();

            var itemPrice=$('#'+id).val();
            var itemTotal=Number(itemQty)*Number(itemPrice);
            $('#itemTotal_'+idNumber[1]).val(itemTotal);

            var subTotal=0;
            $('.itemTotal').each(function () {
                subTotal+=Number($(this).val());
            });

            var shippingCharg=0;
            shippingCharg=$('#shipping_charg').val();

            grandTotal=Number(subTotal)+Number(shippingCharg);
            $('#sub_total').val(subTotal);
            $('#total_amount').val(grandTotal);
        }


        function amountCalculation() {
            var subTotal=0;
            $('.itemTotal').each(function () {
                subTotal+=Number($(this).val());
            });

            $('#sub_total').val(subTotal);
            // ----------------

            var shippingCharg=0;
            shippingCharg=$('#shipping_charg').val();


            var totalAmount=0;
            totalAmount=Number(shippingCharg)+Number(subTotal);
            $('#total_amount').val(totalAmount);
        }



        function totalOrderedQty() {
            var itemQty=0;
            $('.itemQty').each(function () {
                itemQty+=Number($(this).val());
            });
            $('#totalOrderQty').val(itemQty);

        }


        // it work when change item qty ---------
        function qtyXItemPrice(id) {
            var id=id;
            //alert(id);
            idNumber=id.split("_");
            var  itemPrice=$('#itemPrice_'+idNumber[1]).val();

            var itemQty=$('#'+id).val();
            console.log(itemQty);
            var itemTotal=Number(itemQty)*Number(itemPrice);
            $('#itemTotal_'+idNumber[1]).val(itemTotal);

            var subTotal=0;
            $('.itemTotal').each(function () {
                subTotal+=Number($(this).val());
            });

            var shippingCharg=0;
            shippingCharg=$('#shipping_charg').val();

            grandTotal=Number(subTotal)+Number(shippingCharg);
            $('#sub_total').val(subTotal);
            $('#total_amount').val(grandTotal);
            totalOrderedQty();
        }

        $(document).on('keyup change','.balanceChange',function () {
            amountCalculation();
        });
    </script>

    <script>

        // After submiting this form page auto reload (reset all field)
        function purchaseOrderSubmit() {
            setTimeout(function(){
                window.location.reload();
            },2000);
        }
    </script>

@endsection
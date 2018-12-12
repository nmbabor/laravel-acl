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
                    <i class="fa fa-info-circle"></i> View Purchase Order Detais ({{$getPurchaseOrder->purchase_order_no}})
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('/purchase-order-pdf-print/'.$getPurchaseOrder->id)}}" class="btn btn-sm btn-danger" title="Make This PDF & Print"><i class="fa fa-file-pdf-o"></i></a>
                        <a href="{{URL::to('inventory-purchase-order')}}" title="View All Purchase Order" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View Purchase Order</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="header "> <!--company info-->
                        <table cellpadding="5" width="100%" >
                            <tr>
                                <td width="50%">
                                    <h4>Purchase Order</h4>
                                    <p><strong>PO. No.:</strong> {{$getPurchaseOrder->purchase_order_no}}</p>
                                    <p><strong>Vendor:</strong> {{$getPurchaseOrder->purchaseOrderToVendor->vendor_name}}</p>
                                </td>
                                <td  width="50%" align="right">
                                    <?php $info = MyHelper::info(); ?>
                                    <img src="{{asset($info->logo)}}" alt="Company Logo" title="Company Logo" width="50" height="50" style="margin-top:15px;padding-bottom:5px;outline: 0">
                                    <p>{{$info->company_name}}</p>
                                    <p>{{$info->address}}</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="table table-responsive"> <!-- header part-->
                        <table cellpadding="5" cellspacing="0" border="1" width="100%">
                            <tr style="background-color: silver">
                                <th>Vendor Information</th>
                                <th>PO Information</th>
                                <th>Shipping Information</th>
                            </tr>

                            <tr>
                                <td>
                                    <strong>Vendor:</strong> {{ucwords($getPurchaseOrder->purchaseOrderToVendor->vendor_name)}}<br>
                                    <strong>Vendor Id:</strong> {{$getPurchaseOrder->purchaseOrderToVendor->vendorid}}<br>
                                    <strong>Mobile:</strong> &nbsp;{{$getPurchaseOrder->purchaseOrderToVendor->mobile_1}}<br>
                                    <strong>Email.:</strong> &nbsp;&nbsp;{{$getPurchaseOrder->purchaseOrderToVendor->email_1}}<br>
                                    <strong>Office.:</strong> &nbsp;&nbsp;{{$getPurchaseOrder->purchaseOrderToVendor->office_address}}<br>
                                </td>

                                <td>
                                    <strong>PO. No.:</strong> {{$getPurchaseOrder->purchase_order_no}}<br>
                                    <strong>Date of Order:</strong> {{date('d-m-Y',strtotime($getPurchaseOrder->date_of_purchase_order))}}<br>
                                    <strong>Quantity.:</strong> {{number_format($getPurchaseOrder->order_qty)}}<br>
                                    <strong>Total Value.:</strong> {{number_format($getPurchaseOrder->grand_total)}} Tk<br>
                                </td>

                                <td>
                                    <strong>Place of shipping:</strong>{{$getPurchaseOrder->shipping_address}}<br>
                                    <strong>Date of shipment:</strong>{{date('d-m-Y',strtotime($getPurchaseOrder->date_of_shipment))}}<br>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </div><!--end header -->

                    <div class="table table-responsive"> <!--item part-->
                        <table cellpadding="5" cellspacing="0" align="center" border="1" width="100%">
                            <tr style="background-color: silver">
                                <th align="center">Sl</th>
                                <th  align="center">Item name</th>
                                <th  align="center">Qty</th>
                                <th  align="center">Item Price</th>
                                <th  align="center">Item Total</th>
                            </tr>
                            <?php $i=1;?>
                            @foreach($purchaseOrderDetails as $itemDetail)
                                <tr>
                                    <td align="center">{{$i++}}</td>
                                    <td align="center">{{$itemDetail->purchaseOrderItem->item_name}}</td>
                                    <td align="center">{{number_format($itemDetail->item_order_qty)}} ({{$itemDetail->purchaseOrderItem->itemUnit->unit_name}}) </td>
                                    <td align="center">{{number_format($itemDetail->item_price)}} Tk</td>
                                    <td align="center">{{number_format($itemDetail->item_total)}} Tk</td>

                                </tr>
                            @endforeach
                        </table>
                    </div> <!--end item pard-->
                    <div class="table table-responsive"> <!--Amount summery-->
                        <table cellpadding="5" cellspacing="0" width="100%">
                            <tr>
                                <!--left part-->
                                <td>
                                    <b>Reference:</b>
                                    <p> {{$getPurchaseOrder->reference}}</p>
                                </td>

                                <!--right side-->

                                <td width="40%">
                                    <table cellpadding="5" cellspacing="0" align="right" border="1" width="100%">
                                        <tr>
                                            <th align="right">Sub Total: </th>
                                            <td bgcolor="silver">{{number_format($getPurchaseOrder->sub_total)}} Tk</td>
                                        </tr>
                                        <tr>
                                            <th align="right">Shipping Charge: </th>
                                            <td bgcolor="silver">{{number_format($getPurchaseOrder->shipping_charge)}} Tk</td>
                                        </tr>
                                        <tr>
                                            <th align="right">Grand Total:</th>
                                            <td bgcolor="silver">{{number_format($getPurchaseOrder->grand_total)}} Tk</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div> <!--end Amount summery-->

                    <div class="table table-responsive"> <!--Item Specification & Purchase order terms & Conditions -->
                        <h4>Notes:</h4>
                        <table cellpadding="5" cellspacing="0" border="1" width="100%">
                            <tr style="background-color: silver">
                                <th width="50%">Item Specification</th>
                                <th width="50%">Terms & Condition</th>
                            </tr>
                            <tr>
                                <td><p>{{$getPurchaseOrder->item_specification}}</p>
                                </td>
                                <td>
                                    <ul>
                                        @foreach($purchaseTermsConditions as $termsCondition)
                                            <li>
                                                <p><strong>{{$termsCondition->purchaseOrderTermCondition->condition_title.':'}}</strong>
                                                    {{$termsCondition->purchaseOrderTermCondition->condition_details}}
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div><!--end item specification & purchase order terms & Conditions-->

                    <br class="page-break">

                    <div class="footers table table-responsive"> <!--footer area-->
                        <div> <!--authentication part-->
                            <table cellpadding="5" cellspacing="5" width="100%">
                                <tr>
                                    <th>Order Prepared By</th>
                                    <th align="center">Authorized By</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td align="left">---------------------------- <br> <b>{{$getPurchaseOrder->user->name}}</b></td>
                                    <td align="left">--------------------------- <br><b>Purchase Manager</b></td>
                                    <td align="right"><img src="{{asset($getPurchaseOrder->order_qr_code)}}" style="margin: 0;padding: 0"  alt="Purchase QR-Code" title="Purchase Order QR-COde" width="150" height="150"></td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <span class="pagenum"></span>
                        </div>
                    </div>

                </div><!--end card-body-->

            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>

        // After submiting this form page auto reload (reset all field)
        function purchaseOrderSubmit() {
            setTimeout(function(){
                window.location.reload();
            },2000);
        }
    </script>

@endsection
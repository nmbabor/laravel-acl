@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>All Items</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-info">
                    All purchase orders
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-purchase-order/create')}}" title="Add New Purchase Order" class="btn btn-primary btn-sm" > <i class="fa fa-plus-circle"></i> Add New</a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="allPurchaseOrders" class="table  table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>PO No.</th>
                                <th>Date of order</th>
                                <th>Date of shipment</th>
                                <th>Shipping To</th>
                                <th>Qty</th>
                                <th>Vendor Name</th>
                                <th width="7%">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <a target="_blank"></a>

@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('#allPurchaseOrders').DataTable( {
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: '{{url('/show-all-purchase-orders')}}',
                columns: [
                    { data: 'id',name:'id'},
                    { data: 'purchase_order_no',name:'purchase_order_no'},
                    { data: 'date_of_purchase_order',name:'date_of_purchase_order'},
                    { data: 'date_of_shipment',name:'date_of_shipment'},
                    { data: 'shipping_address',name:'shipping_address'},
                    { data: 'order_qty',name:'order_qty'},
                    { data: 'vendor_name',name:'inventory_vendors.vendor_name'},
                    { data: 'action'}
                ]
            });

        });
    </script>
@endsection
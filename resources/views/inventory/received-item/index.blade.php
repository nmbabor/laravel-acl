@extends('layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/ekko-lightbox/css/ekko-lightbox.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/lightbox2/css/lightbox.css')}}">
@endsection
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>All Received Items</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-info">
                    All Received Items
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-item-receiving/create')}}" title="Add New Item Received" class="btn btn-primary btn-sm" > <i class="fa fa-plus-circle"></i> Add New</a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="allReceivedItems" class="table  table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Order No</th>
                                <th>Voucher No</th>
                                <th>Vendor</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Received Date</th>
                                <th>Received Photo</th>
                                <th width="16%;">Action</th>
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
            $('#allReceivedItems').DataTable( {
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: '{{url('/show-all-received-items')}}',
                columns: [
                    { data: 'id',name:'id'},
                    { data: 'purchase_order_no',name:'inventory_purchase_orders.purchase_order_no'},
                    { data: 'voucher_no',name:'voucher_no'},
                    { data: 'vendor_name',name:'inventory_vendors.vendor_name'},
                    { data: 'received_qty',name:'received_qty'},
                    { data: 'grand_total',name:'grand_total'},
                    { data: 'received_date',name:'received_date'},
                    { data: 'received_img',name:'received_img'},
                    { data: 'action'}
                ]
            });

        });
    </script>

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
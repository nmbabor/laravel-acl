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
                    All Inventory Items
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-item/create')}}" title="Add New Customer" class="btn btn-primary btn-sm" > <i class="fa fa-plus-circle"></i> Add New</a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="allItems" class="table  table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Unite</th>
                                <th>Vendor</th>
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

@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('#allItems').DataTable( {
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: '{{url('/show-all-inventory-items')}}',
                columns: [
                    { data: 'id',name:'id'},
                    { data: 'item_name',name:'item_name'},
                    { data: 'item_code',name:'item_code'},
                    { data: 'category_name',name:'item_categories.category_name'},
                    { data: 'brand_name',name:'inv_brands.brand_name'},
                    { data: 'unit_name',name:'inventory_small_units.unit_name'},
                    { data: 'vendor_name',name:'inventory_vendors.vendor_name'},
                    { data: 'action'}
                ]
            });

        });
    </script>
@endsection
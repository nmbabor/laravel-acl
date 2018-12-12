@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>All Customers</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-info">
                    All Customers
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-customer/create')}}" title="Add New Customer" class="btn btn-primary btn-sm" > <i class="fa fa-plus-circle"></i> Add New</a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="allCustomers" class="table  table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Customer Name</th>
                                <th>Customer Id</th>
                                <th>Mobile No</th>
                                <th>Email</th>
                                <th>Customer Type</th>
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
            $('#allCustomers').DataTable( {
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: '{{url('/show-all-customers')}}',
                columns: [
                    { data: 'id',name:'id'},
                    { data: 'customer_name',name:'customer_name'},
                    { data: 'customer_id',name:'customer_id'},
                    { data: 'mobile',name:'mobile'},
                    { data: 'email',name:'email'},
                    { data: 'customer_type',name:'customer_type'},
                    { data: 'action'}
                ]
            });

        });
    </script>
@endsection
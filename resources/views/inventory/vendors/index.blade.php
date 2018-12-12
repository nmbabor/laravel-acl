@extends('layouts.app')
@section('breadcrumb')
	<ul class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{URL::to('/')}}">
				<i class="feather icon-home"></i>
			</a>
		</li>

		<li class="breadcrumb-item">
			<a>All Vendors</a>
		</li>
	</ul>
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header card-info">
					All Vendors
					<div class="card-btn pull-right">
						<a href="{{URL::to('inventory-vendor/create')}}" title="Add New Vendor" class="btn btn-primary btn-sm" > <i class="fa fa-plus-circle"></i> Add New</a>

					</div>
				</div>
				<div class="card-body">
						<div class="table-responsive">

							<table id="allVendors" class="table  table-striped table-bordered table-hover">
								<thead>
								<tr>
									<th>SL</th>
									<th>Vendor Name</th>
									<th>Vendor Id</th>
									<th>Mobile No</th>
									<th>Category</th>
									<th width="7%">Action</th>
								</tr>
								</thead>
								<tbody>
                                <?php $i=0; ?>

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
            $('#allVendors').DataTable( {
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: '{{url('/show-all-vendors')}}',
                columns: [
                    { data: 'id',name:'id'},
                    { data: 'vendor_name',name:'vendor_name'},
                    { data: 'vendorid',name:'vendorid'},
                    { data: 'mobile_1',name:'mobile_1'},
                    { data: 'category_name',name:'item_categories.category_name'},
                    { data: 'action'}
                ]
            });

        });
	</script>
	@endsection
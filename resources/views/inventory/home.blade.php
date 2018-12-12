@extends('inventory.inventoryapp')
@section('inventory_content')
    <div class="page-wrapper bg-grey">
	  <!-- Bread crumb -->
	  <div class="row page-titles border-bottom border-custome">
		<div class="col-md-5 align-self-center">
		    <h3 class="text-custome"><i class="fa fas fa-braille"></i> Inventory Management</h3> </div>
		<div class="col-md-7 align-self-center">
		    <ol class="breadcrumb">
			  <li class="breadcrumb-item">
				<a href="" class="btn btn-sm btn-warning">Inventory</a>
			  </li>
			  <li class="breadcrumb-item active">
				<a href="" class="btn btn-sm btn-primary">Acounts</a>
			  </li>
			  <li class="breadcrumb-item active">
				<a href="" class="btn btn-sm btn-success">Extra</a>
			  </li>
		    </ol>
		</div>
	  </div>
	  <!-- End Bread crumb -->
	  <!-- Container fluid  -->
	  <div class="container-fluid">
		<!-- Start Page Content -->
		<div class="row">
		    <div class="col-md-3">
			  <div class="card bg-primary p-20">
				<div class="media widget-ten">
				    <div class="media-left meida media-middle">
					  <span><i class="ti-align-justify f-s-40"></i></span>
				    </div>
				    <div class="media-body media-text-right">
					  <h2 class="color-white text-center">EMPLOYEE</h2>
				    </div>
				</div>
			  </div>
		    </div>
		    <div class="col-md-3">
			  <div class="card bg-warning p-20">
				<div class="media widget-ten">
				    <div class="media-left meida media-middle">
					  <span><i class="ti-align-justify f-s-40"></i></span>
				    </div>
				    <div class="media-body media-text-right">
					  <h2 class="color-white text-center">LEAVE</h2>
				    </div>
				</div>
			  </div>
		    </div>
		    <div class="col-md-3">
			  <div class="card bg-info p-20">
				<div class="media widget-ten">
				    <div class="media-left meida media-middle">
					  <span><i class="ti-align-justify f-s-40"></i></span>
				    </div>
				    <div class="media-body media-text-right">
					  <h2 class="color-white text-center">TASK</h2>
				    </div>
				</div>
			  </div>
		    </div>
		    <div class="col-md-3">
			  <div class="card bg-danger p-20">
				<div class="media widget-ten">
				    <div class="media-left meida media-middle">
					  <span><i class="ti-align-justify f-s-40"></i></span>
				    </div>
				    <div class="media-body media-text-right">
					  <h2 class="color-white text-center"> PROJECT</h2>
				    </div>
				</div>
			  </div>
		    </div>
		    <div class="col-lg-6">
			  <div class="card">
				<div class="card-title">
				    <h4>Visitor in Device</h4>
				</div>
				<div class="card-body">
				    <div class="table-responsive">
					  <table class="table table-hover ">
						<thead>
						<tr>
						    <th>Device</th>
						    <th>Visits</th>
						    <th>Avg. time</th>
						</tr>
						</thead>
						<tbody>
						<tr>
						    <td>Unknown</td>
						    <td>2,456</td>
						    <td>00:02:36</td>
						</tr>
						<tr>
						    <td>Apple iPad</td>
						    <td>1,006</td>
						    <td>00:03:41</td>
						</tr>
						<tr>
						    <td>Apple iPhone</td>
						    <td>68</td>
						    <td>00:04:10</td>
						</tr>
						<tr>
						    <td>HTC Desire</td>
						    <td>38</td>
						    <td>00:01:40</td>
						</tr>
						<tr>
						    <td>Samsung</td>
						    <td>20</td>
						    <td>00:04:54</td>
						</tr>
						<tr>
						    <td>Apple iPad</td>
						    <td>1,006</td>
						    <td>00:03:41</td>
						</tr>
						</tbody>
					  </table>
				    </div>
				</div>
			  </div>
		    </div>
		    <div class="col-lg-6">
			  <div class="card">
				<div class="card-title">
				    <h4>Visitor in Device</h4>
				</div>
				<div class="card-body">
				    <div class="table-responsive">
					  <table class="table table-hover ">
						<thead>
						<tr>
						    <th>Device</th>
						    <th>Visits</th>
						    <th>Avg. time</th>
						</tr>
						</thead>
						<tbody>
						<tr>
						    <td>Unknown</td>
						    <td>2,456</td>
						    <td>00:02:36</td>
						</tr>
						<tr>
						    <td>Apple iPad</td>
						    <td>1,006</td>
						    <td>00:03:41</td>
						</tr>
						<tr>
						    <td>Apple iPhone</td>
						    <td>68</td>
						    <td>00:04:10</td>
						</tr>
						<tr>
						    <td>HTC Desire</td>
						    <td>38</td>
						    <td>00:01:40</td>
						</tr>
						<tr>
						    <td>Samsung</td>
						    <td>20</td>
						    <td>00:04:54</td>
						</tr>
						<tr>
						    <td>Apple iPad</td>
						    <td>1,006</td>
						    <td>00:03:41</td>
						</tr>
						</tbody>
					  </table>
				    </div>
				</div>
			  </div>
		    </div>
		</div>
		<div class="col-lg-12">
		    <div class="card">
			  <div class="card-body">
				<h4 class="card-title">Bar Chart</h4>
				<div id="morris-bar-chart"></div>
			  </div>
		    </div>
		</div>
	  </div>
    </div>
    </div>
    </div>
@endsection

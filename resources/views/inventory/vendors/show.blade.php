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
			<a href="{{URL::to('inventory-vendor')}}">Vendor</a>
		</li>
	</ul>
@endsection
@section('content')
	<div class="row ">
		<div class="col-lg-12">
			<div class="card ">
				<div class="card-header card-info">
					All info about - {{$getVendorById->vendor_name}}
					<div class="card-btn pull-right">
						<a href="{{URL::to('inventory-vendor')}}" title="View All Vendors" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View All</a>
					</div>
				</div>


				<div class="card-body">
					<!-- end person or company identification-->
					<div class="form-group row">
						<label class="control-label col-md-3 col-sm-3">Vendor Is :</label>
						<div class="col-md-4 col-sm-4">
							<div class="radio">
								<label>
									<input type="radio" name="vendor_is" class="vendor-is" value="1" id="radio-required" required {{($getVendorById->vendor_is==1)?'checked':''}}> Company
								</label>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="radio">
								<label>
									<input type="radio" name="vendor_is" class="vendor-is" value="2" id="radio-required2" required {{($getVendorById->vendor_is==2)?'checked':''}}> Person
								</label>
							</div>
						</div>
					</div> <!-- end person or company identification-->


					<fieldset>
						<legend class="personal-info">Vendor Identity Info</legend>

						<div class="form-group row">
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label>Vendor Name <sup>*</sup></label>
								{{Form::text('vendor_name',$value=$getVendorById->vendor_name,['class'=>'form-control','readonly'=>true])}}
							</div>

							<div class="col-xs-12 col-sm-6 col-md-3">
								<label>Vendor Id</label>
								<div class="">
									{{Form::text('vendorid',$value=$getVendorById->vendorid,['class'=>'form-control','readonly'=>true])}}
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Vendor Type<sub>*</sub></label>
								<div class="">
									{{Form::select('vendor_type',['1'=>'General Vendor','2'=>'Special Vendor'],$getVendorById->vendor_type,['class'=>'form-control','placeholder'=>'Select one','readonly'=>true])}}
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Vendor Category</label>
								<div class="">
									{{Form::select('category_id',$categories,$getVendorById->category_id,['class'=>'form-control js-example-data-array select2-hidden-accessible','placeholder'=>'Select one','readonly'=>true])}}
								</div>
							</div>
						</div><!--end row-->
						<div class="form-group row">
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>National ID No</label>
								<div class="">
									{{Form::text('nid_no',$value=$getVendorById->nid_no,['class'=>'form-control','readonly'=>true])}}
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Trade License</label>
								<div class="">
									{{Form::text('trade_licence_no',$value=$getVendorById->trade_licence_no,['class'=>'form-control','readonly'=>true])}}
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Vat Id</label>
								<div class="">
									{{Form::text('vat_id',$value=$getVendorById->vat_id,['class'=>'form-control','readonly'=>true])}}
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Income Tax Id</label>
								<div class="">
									{{Form::text('income_tax_id',$value=$getVendorById->income_tax_id,['class'=>'form-control','readonly'=>true])}}
								</div>
							</div>
						</div><!--end row-->

						<div class="form-group row">
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>National ID Img</label>
								<div class="">
									<label class="upload_photo"  for="vendorNidFile">
										@if($getVendorById->nid_img)
											<a href="{{asset($getVendorById->nid_img)}}" data-toggle="lightbox" data-gallery="example-gallery" >
												<img id="vendor_nid_img_load" src="{{asset($getVendorById->nid_img)}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
											</a>
										@else
											<img id="vendor_img_load" src="{{asset('images/default/photo.png')}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
										@endif
									</label>
								</div>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Trade Licence Img</label>
								<div class="">
									<label class="upload_photo"  for="vendorTinFile">
										@if($getVendorById->trade_licence_img)
											<a href="{{asset($getVendorById->trade_licence_img)}}" data-toggle="lightbox" data-gallery="example-gallery" >
												<img id="vendor_tin_img_load" src="{{asset($getVendorById->trade_licence_img)}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
											</a>
										@else
											<img id="vendor_img_load" src="{{asset('images/default/photo.png')}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
										@endif
									</label>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Vat Id Img</label>
								<div class="">

										<label class="upload_photo"  for="vendorVatFile">
											@if($getVendorById->vat_img)
											<a href="{{asset($getVendorById->vat_img)}}"  data-toggle="lightbox" data-gallery="example-gallery">
												<img id="vendor_vat_img_load" src="{{asset($getVendorById->vat_img)}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
											</a>
											@else
												<img id="vendor_img_load" src="{{asset('images/default/photo.png')}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
												@endif
										</label>






								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Income Tax Img</label>
								<div class="">
									<label class="upload_photo"  for="vendorIncomeTaxFile">
										@if($getVendorById->income_tax_img)
											<a href="{{asset($getVendorById->income_tax_img)}}"  data-toggle="lightbox" data-gallery="example-gallery">
												<img id="vendor_incometax_img_load" src="{{asset($getVendorById->income_tax_img)}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
											</a>
											@else
											<img id="vendor_img_load" src="{{asset('images/default/photo.png')}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
											@endif
									</label>
								</div>
							</div>
						</div><!--end row-->

						<div class="form-group row">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<label>Primary Supply Item</label>
								<div class="">
									{{Form::textarea('primary_item',$value=$getVendorById->primary_item,['class'=>'form-control','rows'=>3,'readonly'=>true])}}
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<label>Secondary Supply Item</label>
								<div class="">
									{{Form::textarea('secondary_item',$value=$getVendorById->secondary_item,['class'=>'form-control','rows'=>3,'readonly'=>true])}}
								</div>
							</div>
						</div><!--end row-->

						<div class="form-group row">
							<div class="col-md-12">
								<label>Supply Item Details</label>
								<div class="">
									{{Form::textarea('supply_item_details',$value=$getVendorById->supply_item_details,['class'=>'form-control','rows'=>3,'readonly'=>true])}}
								</div>
							</div>
						</div> <!--end row-->

						<div class="form-group row">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
								<label>Office Address</label>
								<div class="">
									{{Form::textarea('office_address',$value=$getVendorById->office_address,['class'=>'form-control','rows'=>3,'readonly'=>true])}}
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<label>Storage Address</label>
								<div class="">
									{{Form::textarea('storage_address',$value=$getVendorById->storage_address,['class'=>'form-control','rows'=>3,'readonly'=>true])}}
								</div>
							</div>
						</div> <!--end row-->
					</fieldset><!--  End Business Information  -->


					<fieldset>
						<legend class="personal-info">Contact Info</legend>
						<div class="form-group row">
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>First Mobile <sub>*</sub></label>
								{{Form::number('mobile_1',$value=$getVendorById->mobile_1,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Second Mobile</label>
								{{Form::number('mobile_2',$value=$getVendorById->mobile_2,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Phone</label>
								{{Form::text('phone',$value=$getVendorById->phone,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Fax</label>
								{{Form::text('fax',$value=$getVendorById->fax,['class'=>'form-control','readonly'=>true])}}
							</div>
						</div><!--end row-->
						<div class="form-group row">
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>First Email</label>
								{{Form::email('email_1',$value=$getVendorById->email_1,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Second Email</label>
								{{Form::text('email_2',$value=$getVendorById->email_2,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Skype</label>
								{{Form::text('Skype',$value=$getVendorById->Skype,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Facebook</label>
								{{Form::text('facebook',$value=$getVendorById->facebook,['class'=>'form-control','readonly'=>true])}}
							</div>
						</div><!--end row-->
						<div class="form-group row">
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Representative Name</label>
								{{Form::text('representative_name',$value=$getVendorById->representative_name,['class'=>'form-control','readonly'=>true])}}
							</div>

							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Representative Designation</label>
								{{Form::text('representative_designation',$value=$getVendorById->representative_designation,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Representative Mobile</label>
								{{Form::text('representative_mobile',$value=$getVendorById->representative_mobile,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Representative Phone</label>
								{{Form::text('representative_phone',$value=$getVendorById->representative_phone,['class'=>'form-control','readonly'=>true])}}
								<span class="text-danger">
							</div>
						</div><!--end row-->
						<div class="form-group row">


							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Representative Email</label>
								{{Form::text('representative_email',$value=$getVendorById->representative_email,['class'=>'form-control','readonly'=>true])}}

							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Representative Skype</label>
								{{Form::text('representative_skype',$value=$getVendorById->representative_skype,['class'=>'form-control','readonly'=>true])}}
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<div class="">
									<label>Status</label>
									@if($getVendorById->status==0)
										{{Form::select('status',['1'=>'Active','0'=>'Inactive'],$getVendorById->status,['class'=>'form-control','required'=>true])}}
									@else
										{{Form::select('status',['1'=>'Active','0'=>'Inactive'],$getVendorById->status,['class'=>'form-control','required'=>true])}}
										@endif
									<span class="text-danger">
									{{$errors->has('status')?$errors->first('status'):''}}
								</span>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label>Vendor Image</label>
								<div class="">
									<label class="upload_photo"  for="vendorFile">
									@if($getVendorById->vendor_img)
										<img id="vendor_img_load" src="{{asset($getVendorById->vendor_img)}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>

									@else
										<img id="vendor_img_load" src="{{asset('images/default/photo.png')}}" ><i class="upload_hover ion ion-ios-camera-outline"></i>
									@endif
									</label>
								</div>
							</div>
						</div><!--end row-->
					</fieldset>
					<!--  End Contact Information -->
				</div><!--  card-body -->

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






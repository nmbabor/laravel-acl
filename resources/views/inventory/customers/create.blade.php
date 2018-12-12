@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{URL::to('inventory-customer')}}">Customer</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                    Create new customer
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-customer')}}" title="View All Customer" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View All</a>
                    </div>
                </div>

                {!! Form::open(array('route' =>'inventory-customer.store','method'=>'POST','class'=>'form-horizontals','files'=>true)) !!}
                <div class="card-body">
                    <!-- end person or company identification-->
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">Customer Is :</label>
                        <div class="col-md-4 col-sm-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="customer_is" class="vendor-is" value="1" id="radio-required" required checked> Company
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="customer_is" class="vendor-is" value="2" id="radio-required2" required> Person
                                </label>
                            </div>
                        </div>
                    </div> <!-- end person or company identification-->


                    <fieldset>
                        <legend class="personal-info">Customer Identity Info</legend>

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-3 col-md-3">
                                <label>Customer Name <sup>*</sup></label>
                                {{Form::text('customer_name',$value=old('customer_name'),['class'=>'form-control','required'=>true])}}
                                <span class="text-danger">
									{{$errors->has('customer_name')?$errors->first('customer_name'):''}}
								</span>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Customer Id</label>
                                <div class="">
                                    {{Form::text('customer_id',$value=old('customer_id'),['class'=>'form-control','placeholder'=>'Auto Generate','readonly'=>true,'disable'=>true])}}
                                    <span class="text-danger">
									{{$errors->has('customer_id')?$errors->first('customer_id'):''}}
									</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Customer Type<sub>*</sub></label>
                                <div class="">
                                    {{Form::select('customer_type',['1'=>'General Customer','2'=>'Special Customer'],[],['class'=>'form-control','placeholder'=>'Select one','required'=>true])}}
                                    <span class="text-danger">
                                        {{$errors->has('customer_type')?$errors->first('customer_type'):''}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label for="religion" class="">Religion(If Person)</label>
                                <div class="">
                                    {{Form::select('religion',['Muslim'=>'Muslim','Hindo'=>'Hindo','Bodish'=>'Bodish','krishna'=>'krishna','Other'=>'Other'],[],['class'=>'form-control','placeholder'=>'Select'])}}
                                    <span class="text-danger">
                                    {{$errors->has('religion')?$errors->first('religion'):''}}
                                    </span>
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Present Address</label>
                                <div class="">
                                    {{Form::textarea('present_address',$value=old('present_address'),['class'=>'form-control','rows'=>3])}}
                                    <span class="text-danger">
                                    {{$errors->has('present_address')?$errors->first('present_address'):''}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Permanent Address</label>
                                <div class="">
                                    {{Form::textarea('permanent_address',$value=old('permanent_address'),['class'=>'form-control','rows'=>3])}}
                                    <span class="text-danger">
                                    {{$errors->has('permanent_address')?$errors->first('permanent_address'):''}}
                                </span>
                                </div>
                            </div>
                        </div><!--end row-->

                    </fieldset><!--  End Identity Information  -->

                    <fieldset>
                        <legend class="personal-info">Contact Info</legend>
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Mobile <sub>*</sub></label>
                                {{Form::number('mobile',$value=old('mobile'),['class'=>'form-control','required'=>true])}}
                                <span class="text-danger">
							{{$errors->has('mobile')?$errors->first('mobile'):''}}
					  	</span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Phone</label>
                                {{Form::text('phone',$value=old('phone'),['class'=>'form-control'])}}
                                <span class="text-danger">
							{{$errors->has('phone')?$errors->first('phone'):''}}
					  	</span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Email</label>
                                {{Form::email('email',$value=old('email'),['class'=>'form-control'])}}
                                <span class="text-danger">
							{{$errors->has('email')?$errors->first('email'):''}}
					  	</span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Facebook</label>
                                {{Form::text('facebook',$value=old('facebook'),['class'=>'form-control'])}}
                                <span class="text-danger">
							{{$errors->has('facebook')?$errors->first('facebook'):''}}
					  	</span>
                            </div>

                        </div><!--end row-->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>National Id:</label>
                                {{Form::text('nit_no',$value=old('nit_no'),['class'=>'form-control'])}}
                                <span class="text-danger">
							{{$errors->has('nit_no')?$errors->first('nit_no'):''}}
					  	</span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>City</label>
                                {{Form::text('city',$value=old('city'),['class'=>'form-control'])}}
                                <span class="text-danger">
                                    {{$errors->has('city')?$errors->first('city'):''}}
                                </span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Region</label>
                                {{Form::text('region',$value=old('region'),['class'=>'form-control'])}}
                                <span class="text-danger">
                                    {{$errors->has('region')?$errors->first('region'):''}}
                                </span>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Zip Code</label>
                                {{Form::text('zip_code',$value=old('zip_code'),['class'=>'form-control'])}}
                                <span class="text-danger">
                                    {{$errors->has('zip_code')?$errors->first('zip_code'):''}}
                                </span>
                            </div>
                        </div><!--end row-->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Shipping Address</label>
                                <div class="">
                                    {{Form::textarea('shipping_address',$value=old('shipping_address'),['class'=>'form-control','rows'=>3])}}
                                    <span class="text-danger">
                                    {{$errors->has('shipping_address')?$errors->first('shipping_address'):''}}
                                    </span>
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Customer Image</label>
                                <div class="">
                                    <label class="slide_upload"  for="customerImg">
                                        <img id="customer_img_load" src="{{asset('images/default/photo.png')}}" width="150" height="120" title="Customer Image">
                                    </label>
                                    <input type="file" id="customerImg" name="customer_img" onchange="loadCustomerImg(this,this.id)" class="form-control" accept="image/*" style="display: none">
                                </div>
                                <span class="text-danger">
                                    {{$errors->has('customer_img')?$errors->first('customer_img'):''}}
                                </span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>National Id Image</label>
                                <div class="">
                                    <label class="slide_upload"  for="customerNidImg">
                                        <img id="customer_nid_img_load" src="{{asset('images/default/photo.png')}}" width="150" height="120" title="Customer Image">
                                    </label>
                                    <input type="file" id="customerNidImg" name="nid_img" onchange="loadCustomerNidImg(this,this.id)" class="form-control" accept="image/*" style="display: none">
                                </div>
                                <span class="text-danger">
                                    {{$errors->has('nid_img')?$errors->first('nid_img'):''}}
                                </span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Status</label>
                                <div class="">
                                    {{Form::select('status',['1'=>'Active','0'=>'Inactive'],[],['class'=>'form-control','required'=>true])}}
                                </div>
                                <span class="text-danger">
                                    {{$errors->has('status')?$errors->first('status'):''}}
                                </span>
                            </div>
                        </div><!--end row-->
                    </fieldset>
                    <!--  End Contact Information -->

                    <div class="form-group row">

                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">Save Customer</button>
                        </div>
                    </div>
                </div><!--  card-body -->
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function loadCustomerImg(input,customer_img_load) {
            var target_image='#'+$('#'+customer_img_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function loadCustomerNidImg(input,customer_nid_img_load) {
            var target_image='#'+$('#'+customer_nid_img_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection






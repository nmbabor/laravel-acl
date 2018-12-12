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
            <a href="{{URL::to('inventory-customer')}}">Customer</a>
        </li>
    </ul>

@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                     View customer info about - {{$getCustomerById->customer_name}}
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-customer')}}" title="View All Customer" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View All</a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- end person or company identification-->
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">Customer Is :</label>
                        <div class="col-md-4 col-sm-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="customer_is" class="vendor-is" value="1" id="radio-required" @if($getCustomerById->customer_is==1)checked @endif required > Company
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="customer_is" class="vendor-is" value="2" id="radio-required2" @if($getCustomerById->customer_is==2)checked @endif required> Person
                                </label>
                            </div>
                        </div>
                    </div> <!-- end person or company identification-->


                    <fieldset>
                        <legend class="personal-info">Customer Identity Info</legend>

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-3 col-md-3">
                                <label>Customer Name <sup>*</sup></label>
                                {{Form::text('customer_name',$value=$getCustomerById->customer_name,['class'=>'form-control','required'=>true,'readonly'=>true])}}
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Customer Id</label>
                                <div class="">
                                    {{Form::text('customer_id',$value=$getCustomerById->customer_id,['class'=>'form-control','placeholder'=>'Auto Generate','readonly'=>true])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Customer Type<sub>*</sub></label>
                                <div class="">
                                    {{Form::select('customer_type',['1'=>'General Customer','2'=>'Special Customer'],$getCustomerById->customer_type,['class'=>'form-control','placeholder'=>'Select one','readonly'=>true])}}
                                    <span class="text-danger">
                                        {{$errors->has('customer_type')?$errors->first('customer_type'):''}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label for="religion" class="">Religion(If Person)</label>
                                <div class="">
                                    {{Form::select('religion',['Muslim'=>'Muslim','Hindo'=>'Hindo','Bodish'=>'Bodish','krishna'=>'krishna','Other'=>'Other'],$getCustomerById->religion,['class'=>'form-control','placeholder'=>'Select','readonly'=>true])}}
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Present Address</label>
                                <div class="">
                                    {{Form::textarea('present_address',$value=$getCustomerById->present_address,['class'=>'form-control','rows'=>3,'readonly'=>true])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Permanent Address</label>
                                <div class="">
                                    {{Form::textarea('permanent_address',$value=$getCustomerById->permanent_address,['class'=>'form-control','rows'=>3,'readonly'=>true])}}
                                </div>
                            </div>
                        </div><!--end row-->

                    </fieldset><!--  End Identity Information  -->

                    <fieldset>
                        <legend class="personal-info">Contact Info</legend>
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Mobile <sup>*</sup></label>
                                {{Form::number('mobile',$value=$getCustomerById->mobile,['class'=>'form-control','required'=>true,'readonly'=>true])}}
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Phone</label>
                                {{Form::text('phone',$value=$getCustomerById->phone,['class'=>'form-control','readonly'=>true])}}
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Email</label>
                                {{Form::email('email',$value=$getCustomerById->email,['class'=>'form-control','readonly'=>true])}}
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Facebook</label>
                                {{Form::text('facebook',$value=$getCustomerById->facebook,['class'=>'form-control','readonly'=>true])}}
                            </div>

                        </div><!--end row-->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>National Id:</label>
                                {{Form::text('nit_no',$value=$getCustomerById->nit_no,['class'=>'form-control','readonly'=>true])}}
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>City</label>
                                {{Form::text('city',$value=$getCustomerById->city,['class'=>'form-control','readonly'=>true])}}
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Region</label>
                                {{Form::text('region',$value=$getCustomerById->region,['class'=>'form-control','readonly'=>true])}}
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Zip Code</label>
                                {{Form::text('zip_code',$value=$getCustomerById->zip_code,['class'=>'form-control','readonly'=>true])}}
                            </div>
                        </div><!--end row-->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Shipping Address</label>
                                <div class="">
                                    {{Form::textarea('shipping_address',$value=$getCustomerById->shipping_address,['class'=>'form-control','rows'=>3,'readonly'=>true])}}
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Customer Image</label>
                                <div class="">
                                    <label class="slide_upload"  for="customerImg">
                                        @if($getCustomerById->customer_img)
                                            <a href="{{asset($getCustomerById->customer_img)}}" data-toggle="lightbox" data-gallery="example-gallery"> <img id="customer_img_load" src="{{asset($getCustomerById->customer_img)}}" width="150" height="120" title="Customer Image"></a>

                                        @else
                                            <img id="customer_img_load" src="{{asset('images/default/photo.png')}}" width="150" height="120" title="Customer Image">
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>National Id Image</label>
                                <div class="">
                                    <label class="slide_upload"  for="customerNidImg">
                                        @if($getCustomerById->nid_img)
                                            <a href="{{asset($getCustomerById->nid_img)}}" data-toggle="lightbox" data-gallery="example-gallery">
                                                <img id="customer_nid_img_load" src="{{asset($getCustomerById->nid_img)}}" width="150" height="120" title="Customer Image">
                                            </a>
                                        @else
                                            <img id="customer_nid_img_load" src="{{asset('images/default/photo.png')}}" width="150" height="120" title="Customer Image">
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label>Status</label>
                                <div class="">
                                    {{Form::select('status',['1'=>'Active','0'=>'Inactive'],$getCustomerById->status,['class'=>'form-control','readonly'=>true])}}
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
                            <button type="submit" class="btn btn-primary">Update Customer</button>
                        </div>
                    </div>
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






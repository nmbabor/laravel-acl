
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
            <a href="{{URL::to('inventory-item')}}">Item Info</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                    <i class="fa fa-info-circle"></i> Item details about - {{$getItemById->item_name}}
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-item')}}" title="View All Customer" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View All</a>
                    </div>
                </div>

                <div class="card-body">
                    <fieldset>
                        <legend class="personal-info">Item Basic Info</legend>

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-8 col-md-8">
                                <label for="item_name" class="">Item Name <sup>*</sup></label>
                                {{Form::text('item_name',$value=$getItemById->item_name,['class'=>'form-control','readonly'=>true])}}
                            </div>

                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label>Item Code</label>
                                <div class="">
                                    {{Form::text('item_code',$value=$getItemById->item_code,['class'=>'form-control','readonly'=>true,'disable'=>true])}}
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="category_id" class="">Category</label>
                                <div class="">
                                    {{Form::text('category_id',$getItemById->itemCategory->category_name,['class'=>'form-control select','readonly'=>true])}}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Brand</label>
                                <div class="">
                                    {{Form::text('brand_id',$getItemById->itemBrand->brand_name,['class'=>'form-control select','readonly'=>true])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="item_unite_id" class="">Item Unit </label>
                                <div class="">
                                    {{Form::text('item_unite_id',$getItemById->itemUnit->unit_name,['class'=>'form-control select','placeholder'=>'Select','readonly'=>true])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="vendor_id" class="">Vendor </label>
                                <div class="">
                                    {{Form::text('vendor_id',$getItemById->itemVendor->vendor_name,['class'=>'form-control select','placeholder'=>'Select','readonly'=>true])}}
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="cost_price" class="">Cost Price <sup>*</sup></label>
                                <div class="">
                                    {{Form::number('cost_price',$value=$getItemById->cost_price,['min'=>0,'class'=>'form-control','readonly'=>true])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="sale_price" class="">Sale Price <sup>*</sup></label>
                                <div class="">
                                    {{Form::number('sale_price',$value=$getItemById->sale_price,['min'=>0,'class'=>'form-control','readonly'=>true])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="reorder_level" class="">Reorder Lavel</label>
                                <div class="">
                                    {{Form::number('reorder_level',$value=$getItemById->reorder_level,['min'=>0,'class'=>'form-control','readonly'=>true])}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="item_color" class="">Color</label>
                                <div class="">
                                    {{Form::color('item_color',$value=$getItemById->item_color,['class'=>'form-control','readonly'=>true])}}
                                </div>
                            </div>
                        </div><!--end row-->
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12">
                                <label for="present_address" class="">Item Details</label>
                                <div class="">
                                    {{Form::textarea('item_details',$value=$getItemById->item_details,['class'=>'form-control','rows'=>4,'readonly'=>true])}}
                                </div>
                            </div>
                        </div> <!--end row-->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Item Main Image</label>
                                <div class="">
                                    <label class="upload_photo"  for="itemMainImg">
                                        @if($getItemById->item_main_img)
                                            <a href="{{asset($getItemById->item_main_img)}}" data-toggle="lightbox" data-gallery="example-gallery"><img id="item_main_img_load" src="{{asset($getItemById->item_main_img)}}"><i class="upload_hover ion ion-ios-camera-outline"></i></a>
                                        @else
                                            <img id="item_main_img_load" src="{{asset('images/default/photo.png')}}" title="Item Main Image"><i class="upload_hover ion ion-ios-camera-outline"></i>
                                        @endif
                                    </label>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Item Secondary Image</label>
                                <div class="">
                                    <label class="upload_photo"  for="itemSecondateyImg">
                                        @if($getItemById->item_secondary_img)
                                            <a href="{{asset($getItemById->item_secondary_img)}}" data-toggle="lightbox" data-gallery="example-gallery"><img id="item_secondary_img_load" src="{{asset($getItemById->item_secondary_img)}}" title="Item Secondary Images"><i class="upload_hover ion ion-ios-camera-outline"></i></a>
                                        @else
                                            <img id="item_secondary_img_load" src="{{asset('images/default/photo.png')}}" title="Item Secondary Images"> <i class="upload_hover ion ion-ios-camera-outline"></i>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <label>Item Status</label>
                                <div class="">
                                    {{Form::select('status',['1'=>'Active','0'=>'Inactive'],$getItemById->status,['class'=>'form-control'])}}
                                </div>
                            </div>

                        </div><!--end row-->

                    </fieldset><!--  End Identity Information  -->
                    <div class="form-group row">

                        <div class="col-md-8">
                            <a href="{{URL::to('inventory-item')}}"><button class="btn btn-primary btn-sm"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back</button></a>
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





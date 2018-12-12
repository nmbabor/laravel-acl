@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{URL::to('inventory-item')}}">Item Edit</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                    <i class="fa fa-edit"></i> Edit old inventory item
                    <div class="card-btn pull-right">
                        <a href="{{URL::to('inventory-item')}}" title="View All Customer" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View All</a>
                    </div>
                </div>

                {!! Form::open(array('route' =>['inventory-item.update',$getItemById->id],'method'=>'PUT','class'=>'form-horizontals','files'=>true)) !!}
                <div class="card-body">

                    <fieldset>
                        <legend class="personal-info">Item Basic Info</legend>

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-8 col-md-8">
                                <label for="item_name" class="">Item Name <sup>*</sup></label>
                                {{Form::text('item_name',$value=$getItemById->item_name,['class'=>'form-control','required'=>true])}}
                                <span class="text-danger">
                                        {{$errors->has('item_name')?$errors->first('item_name'):''}}
                                    </span>
                            </div>

                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label>Item Code</label>
                                <div class="">
                                    {{Form::text('item_code',$value=$getItemById->item_code,['class'=>'form-control','readonly'=>true,'disable'=>true])}}
                                    <span class="text-danger">
									{{$errors->has('item_code')?$errors->first('item_code'):''}}
									</span>
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="category_id" class="">Category</label>
                                <div class="">
                                    {{Form::select('category_id',$categories,$getItemById->category_id,['class'=>'form-control select','placeholder'=>'Select'])}}
                                    <span class="text-danger">
                                    {{$errors->has('category_id')?$errors->first('category_id'):''}}
                                    </span>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Brand</label>
                                <div class="">
                                    {{Form::select('brand_id',$brands,$getItemById->brand_id,['class'=>'form-control select','placeholder'=>'Select'])}}
                                    <span class="text-danger">
                                    {{$errors->has('brand_id')?$errors->first('brand_id'):''}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="item_unite_id" class="">Item Unit </label>
                                <div class="">
                                    {{Form::select('item_unite_id',$unites,$getItemById->item_unite_id,['class'=>'form-control select','placeholder'=>'Select','required'=>true])}}
                                    <span class="text-danger">
                                    {{$errors->has('item_unite_id')?$errors->first('item_unite_id'):''}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="vendor_id" class="">Vendor </label>
                                <div class="">
                                    {{Form::select('vendor_id',$vendors,$getItemById->vendor_id,['class'=>'form-control select','placeholder'=>'Select','required'=>true])}}
                                    <span class="text-danger">
                                    {{$errors->has('vendor_id')?$errors->first('vendor_id'):''}}
                                    </span>
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="cost_price" class="">Cost Price <sup>*</sup></label>
                                <div class="">
                                    {{Form::number('cost_price',$value=$getItemById->cost_price,['min'=>0,'class'=>'form-control'])}}
                                    <span class="text-danger">
                                    {{$errors->has('cost_price')?$errors->first('cost_price'):''}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="sale_price" class="">Sale Price <sup>*</sup></label>
                                <div class="">
                                    {{Form::number('sale_price',$value=$getItemById->sale_price,['min'=>0,'class'=>'form-control'])}}
                                    <span class="text-danger">
                                    {{$errors->has('sale_price')?$errors->first('sale_price'):''}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="reorder_level" class="">Reorder Lavel</label>
                                <div class="">
                                    {{Form::number('reorder_level',$value=$getItemById->reorder_level,['min'=>0,'class'=>'form-control'])}}
                                    <span class="text-danger">
                                    {{$errors->has('reorder_level')?$errors->first('reorder_level'):''}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label for="item_color" class="">Color</label>
                                <div class="">
                                    {{Form::color('item_color',$value=$getItemById->item_color,['class'=>'form-control'])}}
                                    <span class="text-danger">
                                    {{$errors->has('item_color')?$errors->first('item_color'):''}}
                                    </span>
                                </div>
                            </div>
                        </div><!--end row-->
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12">
                                <label for="present_address" class="">Item Details</label>
                                <div class="">
                                    {{Form::textarea('item_details',$value=$getItemById->item_details,['class'=>'form-control','rows'=>4])}}
                                    <span class="text-danger">
                                            {{$errors->has('item_details')?$errors->first('item_details'):''}}
                                        </span>
                                </div>
                            </div>
                        </div> <!--end row-->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Item Main Image</label>
                                <div class="">
                                    <label class="upload_photo"  for="itemMainImg">
                                        @if($getItemById->item_main_img)
                                            <img id="item_main_img_load" src="{{asset($getItemById->item_main_img)}}"><i class="upload_hover ion ion-ios-camera-outline"></i>
                                        @else
                                            <img id="item_main_img_load" src="{{asset('images/default/photo.png')}}" title="Item Main Image"><i class="upload_hover ion ion-ios-camera-outline"></i>
                                            @endif
                                    </label>
                                    <input type="file" id="itemMainImg" name="item_main_img" onchange="loadItemMainImg(this,this.id)" class="form-control" accept="image/*" style="display: none">
                                    <span class="text-danger">
                                            {{$errors->has('item_main_img')?$errors->first('item_main_img'):''}}
                                        </span>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <label>Item Secondary Image</label>
                                <div class="">
                                    <label class="upload_photo"  for="itemSecondateyImg">
                                        @if($getItemById->item_secondary_img)
                                            <img id="item_secondary_img_load" src="{{asset($getItemById->item_secondary_img)}}" title="Item Secondary Images"><i class="upload_hover ion ion-ios-camera-outline"></i>
                                            @else
                                            <img id="item_secondary_img_load" src="{{asset('images/default/photo.png')}}" title="Item Secondary Images"> <i class="upload_hover ion ion-ios-camera-outline"></i>
                                        @endif

                                    </label>
                                    <input type="file" id="itemSecondateyImg" name="item_secondary_img" onchange="loadItemSecondaryImg(this,this.id)" class="form-control" accept="image/*" style="display: none">
                                    <span class="text-danger">
                                            {{$errors->has('item_secondary_img')?$errors->first('item_secondary_img'):''}}
                                        </span>
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
                            <button type="submit" class="btn btn-primary">Update Item</button>
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
        function loadItemMainImg(input,item_main_img_load) {
            var target_image='#'+$('#'+item_main_img_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function loadItemSecondaryImg(input,item_secondary_img_load) {
            var target_image='#'+$('#'+item_secondary_img_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection






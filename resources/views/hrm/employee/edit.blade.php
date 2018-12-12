@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Employee</a>
        </li>
    </ul>
@endsection
		@section('content')
		<!-- begin #content -->
		<div id="content" class="content">
			
			<div class="row">
			    <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-info">
                            Edit Employee Information
                            <div class="card-heading-btn pull-right">
                                <a class="btn btn-primary btn-sm" href="{{URL::to('/employees')}}">All Employee</a>

                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(array('route' => ['employees.update',$data->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true)) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label class="col-md-12" for="name">Employe Name <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            {{Form::text('name',$data->user->name,['class'=>'form-control','placeholder'=>'Employe Name','required'])}}
                                            @if ($errors->has('name'))
                                                <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                                        <label class="col-md-12" for="number">Moblie No. <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            {{Form::number('phone_number',$data->user->phone_number,['class'=>'form-control','placeholder'=>'Mobile Number','min'=>0])}}
                                            @if ($errors->has('phone_number'))
                                                <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('phone_number') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('designation') ? 'has-error' : '' }}">
                                        <label class="col-md-12" for="designation">Designation <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">

                                            {{Form::text('designation',$data->designation,['class'=>'form-control','placeholder'=>'Employe Designation','required'])}}
                                            @if ($errors->has('designation'))
                                                <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('designation') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12" for="basic_pay">Basic Pay :</label>
                                        <div class="col-md-12">

                                            {{Form::number('basic_pay',$data->basic_pay,['class'=>'form-control','placeholder'=>'Basic Pay','required','min'=>0])}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12" for="medical_allowance">Medical Allowance :</label>
                                        <div class="col-md-12">

                                            {{Form::number('medical_allowance',$data->medical_allowance,['class'=>'form-control','placeholder'=>'Medical Allowance','min'=>0])}}
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('photo') ? 'has-error' : ''}} ">
                                        <label class="col-sm-12">Photo </label>
                                        <div class="col-md-5">
                                            <label class="upload_photo profile" for="file">
                                                @if($data->photo!=null)
                                                   {{-- <img id="image_load" src='{{asset("images/employee/$data->photo")}}'>--}}<img id="image_load">
                                                @else

                                                    <img id="image_load">
                                                @endif
                                            </label>
                                            <input type="file" id="file" name="photo" onchange="readURL(this,this.id)" style="display:none">
                                            @if ($errors->has('photo'))
                                                <span class="help-block" style="display:block">
                                              <strong>{{ $errors->first('photo') }}</strong>
                                          </span>
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            @if($data->photo!=null)
                                                <img src='{{asset("images/employee/$data->photo")}}' class="img-responsive pull-right border-1">
                                                @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label class="col-md-12" for="email">Email <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            {{Form::text('email',$data->user->email,['class'=>'form-control','placeholder'=>'@'])}}
                                            @if ($errors->has('email'))
                                                <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                                        <label class="col-md-12" for="employee_id">Employe ID <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            {{Form::text('employee_id',$data->employee_id,['class'=>'form-control','placeholder'=>'Employe ID','required'])}}
                                            @if ($errors->has('employee_id'))
                                                <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('employee_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('section_id') ? 'has-error' : '' }}">
                                        <label class="col-md-12">Section <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            {{Form::select('section_id',$section,$data->section_id,['class'=>'form-control select','placeholder'=>'Select Section','required'])}}
                                            @if ($errors->has('section_id'))
                                                <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('section_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12" for="house_rent">House Rent :</label>
                                        <div class="col-md-12">
                                            {{Form::number('house_rent',$data->house_rent,['class'=>'form-control','placeholder'=>'House Rent','min'=>0])}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12" for="address">Address  :</label>
                                        <div class="col-md-12">

                                            {{Form::textArea('address',$data->user->address,['class'=>'form-control','placeholder'=>'Address','rows'=>2])}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2">Status :</label>
                                        <div class="col-md-4">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" {{($data->status==1)?'checked':''}} /> Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" id="radio-required2" value="0" {{($data->status==0)?'checked':''}} /> Inactive
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-12"></label>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close(); !!}
                        </div>
                    </div>
			    </div>
			</div>
		</div>
		<!-- end #content -->
    @endsection
@section('script')
<script type="text/javascript">

 /*end chosen select option */
    function readURL(input,image_load) {
      var target_image='#'+$('#'+image_load).prev().children().attr('id');

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

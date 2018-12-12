@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{URL::to('primary-info')}}">Primary Info</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                    Primary Information
                    <div class="card-btn pull-right">

                    </div>
                </div>

                <div class="card-body">
                    {!! Form::open(array('route' =>['primary-info.update', $data->id],'method'=>'PUT','class'=>'form-horizontals','files'=>true)) !!}

                    <div class="row">
                        <div class="col-md-12 no-padding">
                            <div class="form-group col-md-12 no-padding">
                                <label class="col-md-4"> <input type="radio" {{($data->type==1)?'checked':''}} checked name="type" value="1"> Group of company </label>
                                <label class="col-md-4"> <input type="radio" name="type" {{($data->type==2)?'checked':''}} value="2"> Single company </label>
                            </div>
                        </div>
                        <div class="col-md-8">

                            <div class="row">

                                <div class="form-group col-md-6 no-padding {{ $errors->has('company_name') ? 'has-error' : '' }}">
                                    {{Form::label('company_name', 'Name of Organization', array('class' => 'col-md-12'))}}
                                    <div class="col-md-12">
                                        {{Form::text('company_name',$data->company_name,array('class'=>'form-control','placeholder'=>'Name of Organization'))}}
                                        @if ($errors->has('company_name'))
                                            <span class="help-block">
                            <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group  col-md-6 no-padding {{ $errors->has('address') ? 'has-error' : '' }}">
                                    {{Form::label('address', 'Organization Address', array('class' => 'col-md-12'))}}
                                    <div class="col-md-12">
                                        {{Form::text('address',$data->address,array('class'=>'form-control','placeholder'=>'Organization Address'))}}
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-6 no-padding  {{ $errors->has('mobile_no') ? 'has-error' : '' }}">
                                    {{Form::label('mobile_no', 'Contact Number', array('class' => 'col-md-12'))}}
                                    <div class="col-md-12">
                                        {{Form::text('mobile_no',$data->mobile_no,array('class'=>'form-control','placeholder'=>'Contact Number'))}}
                                        @if ($errors->has('mobile_no'))
                                            <span class="help-block">
                            <strong>{{ $errors->first('mobile_no') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-6 no-padding  {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {{Form::label('email', 'Email', array('class' => 'col-md-12'))}}
                                    <div class="col-md-12">
                                        {{Form::email('email',$data->email,array('class'=>'form-control','placeholder'=>'Email'))}}
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 no-padding ">
                            <div class="row">
                                <div class="form-group  col-md-8 no-padding {{ $errors->has('logo') ? 'has-error' : '' }}">
                                    {{Form::label('logo', 'Organization Logo', array('class' => 'col-md-12'))}}
                                    <div class="col-md-12">
                                        <label class="upload_photo upload client_logo_upload" for="file">
                                            <!--  -->
                                            <img src="{{asset($data->logo)}}" id="image_load">
                                            <i class="upload_hover ion ion-ios-camera-outline"></i>
                                        </label>
                                        {{Form::file('logo',array('id'=>'file','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load")'))}}
                                        @if ($errors->has('logo'))
                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('logo') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-4 no-padding {{ $errors->has('favicon') ? 'has-error' : '' }}">
                                    {{Form::label('favicon', ' Icon', array('class' => 'col-md-12'))}}
                                    <div class="col-md-12">
                                        <label class="upload_photo upload client_favicon_upload" for="file2">
                                            <!--  -->
                                            <img src="{{asset($data->favicon)}}" id="image_load2">
                                            <i class="upload_hover ion ion-ios-camera-outline"></i>
                                        </label>
                                        {{Form::file('favicon',array('id'=>'file2','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load2")'))}}
                                        @if ($errors->has('favicon'))
                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('favicon') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{Form::hidden('id',$data->id)}}
                        <div class="form-group col-md-12 no-padding">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    @if($data->type==1)
                    <div class="row">
                        <div class="col-md-12 box-header">
                            Company List
                            <div class="pull-right">
                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#myModal"> <i class="fa fa-plus-circle"></i> Add new company </a>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add New Company</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    {!! Form::open(array('route' =>'company.store','method'=>'POST','class'=>'form-horizontals','files'=>true)) !!}
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12">

                                                <div class="row">

                                                    <div class="form-group col-md-6 no-padding {{ $errors->has('company_name') ? 'has-error' : '' }}">
                                                        {{Form::label('company_name', 'Name of Organization', array('class' => 'col-md-12','required'))}}
                                                        <div class="col-md-12">
                                                            {{Form::text('company_name','',array('class'=>'form-control','placeholder'=>'Name of Organization','required'))}}
                                                            @if ($errors->has('company_name'))
                                                                <span class="help-block">
                            <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group  col-md-6 no-padding {{ $errors->has('address') ? 'has-error' : '' }}">
                                                        {{Form::label('address', 'Organization Address', array('class' => 'col-md-12'))}}
                                                        <div class="col-md-12">
                                                            {{Form::text('address','',array('class'=>'form-control','placeholder'=>'Organization Address','required'))}}
                                                            @if ($errors->has('address'))
                                                                <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6 no-padding  {{ $errors->has('mobile_no') ? 'has-error' : '' }}">
                                                        {{Form::label('mobile_no', 'Contact Number', array('class' => 'col-md-12'))}}
                                                        <div class="col-md-12">
                                                            {{Form::text('mobile_no','',array('class'=>'form-control','placeholder'=>'Contact Number','required'))}}
                                                            @if ($errors->has('mobile_no'))
                                                                <span class="help-block">
                            <strong>{{ $errors->first('mobile_no') }}</strong>
                        </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 no-padding  {{ $errors->has('email') ? 'has-error' : '' }}">
                                                        {{Form::label('email', 'Email', array('class' => 'col-md-12'))}}
                                                        <div class="col-md-12">
                                                            {{Form::email('email','',array('class'=>'form-control','placeholder'=>'Email'))}}
                                                            @if ($errors->has('email'))
                                                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group  col-md-6 no-padding {{ $errors->has('shipping_address') ? 'has-error' : '' }}">
                                                        {{Form::label('shipping_address', 'Shipping Address', array('class' => 'col-md-12'))}}
                                                        <div class="col-md-12">
                                                            {{Form::text('shipping_address','',array('class'=>'form-control','placeholder'=>'Shipping Address','required'))}}
                                                            @if ($errors->has('shipping_address'))
                                                                <span class="help-block">
                            <strong>{{ $errors->first('shipping_address') }}</strong>
                        </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group  col-md-6 no-padding {{ $errors->has('modules') ? 'has-error' : '' }}">
                                                        {{Form::label('modules', 'Modules', array('class' => 'col-md-12'))}}
                                                        <div class="col-md-12">
                                                            {{Form::select('modules[]',$modules,'',['class'=>'form-control select','multiple','required'])}}
                                                            @if ($errors->has('modules'))
                                                                <span class="help-block">
                            <strong>{{ $errors->first('modules') }}</strong>
                        </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                <div class="form-group row col-md-6 {{ $errors->has('logo') ? 'has-error' : '' }}">
                                                    {{Form::label('logo', 'Organization Logo', array('class' => 'col-md-12'))}}
                                                    <div class="col-md-8">
                                                        <label class="upload_photo upload client_logo_upload no-margin" for="file4">
                                                            <img id="image_load4">
                                                        </label>
                                                        {{Form::file('logo',array('id'=>'file4','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load4")'))}}
                                                        @if ($errors->has('logo'))
                                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('logo') }}</strong>
                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="upload_photo upload client_favicon_upload" for="file5">
                                                            <img id="image_load5">
                                                            <i class="upload_hover ion ion-ios-camera-outline"></i>
                                                        </label>
                                                        {{Form::file('favicon',array('id'=>'file5','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load5")'))}}
                                                        <span> Icon </span>
                                                        @if ($errors->has('favicon'))
                                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('favicon') }}</strong>
                        </span>
                                                        @endif

                                                    </div>
                                                </div>

                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        {{-- End of Model --}}
                        <div class="table-responsive">
                            @if(count($allCompany)>0)
                                <table class="table  table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="5%">SL</th>
                                        <th>Company Name</th>
                                        <th>Mobile No</th>
                                        <th>Address</th>
                                        <th>Branch</th>
                                        <th>Depot</th>
                                        <th width="7%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; ?>
                                    @foreach($allCompany as $company)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$company->company_name}}</td>
                                            <td>{{$company->mobile_no}}</td>
                                            <td>{{$company->address}}</td>
                                            <td> <a class="btn btn-xs btn-info" href='{{URL::to("company-branch/$company->id   ")}}'> Branch <span class="badge"> {{count($company->branch)}} </span> </a> </td>
                                            <td>
                                                <a class="btn btn-xs btn-success" href='{{URL::to("storage-info/$company->id   ")}}' title="View All Storage"> Depot <span class="badge"> {{count($company->companyStorage)}} </span> </a>
                                            </td>
                                            <td style="text-align: center">
                                                {{Form::open(array('route'=>['company.destroy',$company->id],'method'=>'DELETE','id'=>"deleteForm$company->id"))}}
                                                <a href='{{URL::to("company/$company->id/edit")}}' class="btn btn-info btn-xs"> <i class="fa fa-pencil-square"></i></a>
                                                <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm('deleteForm{{$company->id}}')"><i class="fa fa-trash"></i></button>
                                                {!! Form::close() !!}

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                        </div>
                        @else
                            <h2 class="text-danger text-center"> No data available here. </h2>
                        @endif
                    </div>
                    {{$allCompany->render()}}
                    @else
                        <br>
                        <a class="btn btn-success" href="{{URL::to('company-branch')}}"><i class="fa fa-plus-circle"></i> Branches </a>
                        <a class="btn btn-info" href="{{URL::to('storage-info')}}"><i class="fa fa-plus-circle"></i> Depot </a>
                    @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection


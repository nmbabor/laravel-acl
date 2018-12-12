@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Edit Module</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-info">
                    Edit Module
                    <div class="card-btn pull-right">
                        <a href="{{route('menu.index')}}" class="btn btn-primary pull-right"> <i class="fa fa-list"></i> View All </a>
                    </div>
                </div>

                {!! Form::open(array('route' => ['menu.update', $data->id],'method'=>'PUT','class'=>'form-horizontal','files'=>true)) !!}
                <div class="card-body">

                    <div class="form-group row   {{ $errors->has('name') ? 'has-error' : '' }}">
                        {{Form::label('name', ' Name', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            {{Form::text('name',$data->name,array('class'=>'form-control','placeholder'=>'Name','required'))}}
                        </div>
                    </div>
                    <div class="form-group row  {{ $errors->has('url') ? 'has-error' : '' }}">

                        {{Form::label('url', 'URL', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            <div class="input-group">
                                 <span class="input-group-prepend">
                                    <label class="input-group-text">{{URL::to('/')}}/</label>
                                </span>
                                {{Form::text('url',$data->url,array('class'=>'form-control','placeholder'=>'URL','required'))}}
                            </div>
                            @if ($errors->has('url'))
                                <span class="help-block">
                        <strong>{{ $errors->first('url') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('slug', 'Permission', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                            {{Form::select('slug[]', $permissions,json_decode($data->slug,true), ['class' => 'form-control select','multiple','required'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('serial_num', 'Others', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-2">
                            <?php $max=$max_serial+1; ?>
                            {{Form::number('serial_num',$data->serial_num,array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max",'min'=>'0'))}}
                            <small> Serial </small>
                        </div>
                        <div class="col-md-3">
                            {{Form::select('status', array('1' => 'Active', '2' => 'Inactive'),$data->status, ['class' => 'form-control'])}}
                            <small> Status </small>
                        </div>
                        <div class="col-md-3">
                            {{Form::text('icon_class',$data->icon_class, ['class' => 'form-control','placeholder'=>'Ex: fa fa-folder'])}}
                            <small> Icon Class </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('type', 'Type', array('class' => 'col-md-3 control-label'))}}

                        <div class="col-md-3">
                            {{Form::select('type', array('1' => 'Module', '2' => 'Menu'),$data->type, ['class' => 'form-control'])}}
                        </div>

                    </div>

                    {{Form::hidden('id',$data->id)}}
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection


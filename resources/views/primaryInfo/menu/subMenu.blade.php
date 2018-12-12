@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{URL::to('menu')}}">Module</a>
        </li>
        <li class="breadcrumb-item">
            <a>Sub Menu</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-info ">
                    Sub Menu of <u>{{$menu->name}}</u>
                    <div class="card-btn pull-right">
                        <a href="{{route('menu.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-list"></i>All Module</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="menu_form left">
                        {!! Form::open(array('route' => 'sub-menu.store','class'=>'form-horizontal','files'=>true)) !!}
                        <div class="form-group row   {{ $errors->has('name') ? 'has-error' : '' }}">
                            {{Form::label('name', ' Name', array('class' => 'col-md-3 control-label'))}}
                            <div class="col-md-8">
                                {{Form::text('name','',array('class'=>'form-control','placeholder'=>'Name','required'))}}
                            </div>
                        </div>
                        <div class="form-group row  {{ $errors->has('url') ? 'has-error' : '' }}">

                            {{Form::label('url', 'URL', array('class' => 'col-md-3 control-label'))}}
                            <div class="col-md-8">
                                <div class="input-group">
                                   <span class="input-group-prepend">
                                    <label class="input-group-text">{{URL::to('/')}}/</label>
                                </span>
                                    {{Form::text('url','',array('class'=>'form-control','placeholder'=>'URL','required'))}}
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
                                {{Form::select('slug[]', $permissions,'', ['class' => 'form-control select','multiple','required'])}}
                            </div>
                        </div>
                        <input type="hidden" name="fk_menu_id" value="{{$menu->id}}">
                        <div class="form-group row">
                            {{Form::label('serial_num', 'Serial', array('class' => 'col-md-3 control-label'))}}
                            <div class="col-md-4">
                                <?php $max=$max_serial+1; ?>
                                {{Form::number('serial_num',"$max",array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max",'min'=>'0'))}}
                            </div>
                            <div class="col-md-4">
                                {{Form::select('status', array('1' => 'Active', '2' => 'Inactive'),'1', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Menu</th>
                            @if(!isset($subMenu))
                                <th>Sub Sub Menu</th>
                            @endif
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @foreach($allData as $data)
                            <tr>
                                <td>{{$i++}}</td>
                                <td><b>{{$data->name}}</b></td>
                                <td><a href="{{URL::to($data->url)}}" target="_blank">{{URL::to($data->url)}}</a></td>
                                <td><a href="{{route('menu.edit',$data->fk_menu_id)}}" class="label label-primary" style="color: #fff;">{{$data->menu_name}}</a></td>
                                @if(!isset($subMenu))
                                    <td><a href="{{URL::to('sub-sub-menu',$data->id)}}" class="label label-primary" style="color: #fff;">+ Sub Sub Menu</a></td>
                                @endif
                                <td><i class="{{($data->status==1)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>
                                    <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-info btn-xs action_btn"><i class="fa fa-edit"></i></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Sub Menu : <b> {{$data->name}} </b></h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                {!! Form::open(array('route' => ['sub-menu.update', $data->id],'method'=>'PUT','class'=>'form-horizontal','files'=>true)) !!}
                                                <br>
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
                                                    {{Form::label('serial_num', 'Serial', array('class' => 'col-md-3 control-label'))}}
                                                    <div class="col-md-8">
                                                        <? $max=$max_serial+1; ?>
                                                        {{Form::number('serial_num',$data->serial_num,array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max",'min'=>'0'))}}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {{Form::label('status', 'Status', array('class' => 'col-md-3 control-label'))}}

                                                    <div class="col-md-8">
                                                        {{Form::select('status', array('1' => 'Active', '2' => 'Inactive'),$data->status, ['class' => 'form-control'])}}
                                                    </div>
                                                </div>
                                                {{Form::hidden('id',$data->id)}}

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                                    <input class="btn btn-info btn-sm" type="submit" value="Save changes">
                                                </div>
                                                {!! Form::close() !!}
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    {!! Form::open(array('route' => ['sub-menu.destroy',$data->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$data->id")) !!}
                                    <button type="button" class="btn btn-danger btn-xs action_btn" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="fa fa-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">
                        {{$allData->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

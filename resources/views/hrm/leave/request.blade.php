@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Leave Request</a>
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
                        Leave Request
                        <div class="card-heading-btn pull-right">
                            <a class="btn btn-primary btn-sm" href="{{URL::to('/employees')}}">Leave Status</a>

                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => 'leave.store','class'=>'form-horizontal author_form','method'=>'POST')) !!}
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group row {{ $errors->has('leave_type') ? 'has-error' : '' }}">
                                    <label class="col-md-12" for="leave_type">Leave type <span class="text-danger">*</span> :</label>
                                    <div class="col-md-3">
                                        {{Form::select('leave_type',['1'=>'Paid','0'=>'Unpaid'],'1',['class'=>'form-control','required'])}}
                                        @if ($errors->has('leave_type'))
                                            <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('leave_type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('subject') ? 'has-error' : '' }}">
                                    <label class="col-md-12" for="subject">Leave Subject <span class="text-danger">*</span> :</label>
                                    <div class="col-md-12">
                                        {{Form::text('subject','',['class'=>'form-control','placeholder'=>'Leave Subject','required'])}}
                                        @if ($errors->has('subject'))
                                            <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('subject') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row {{ $errors->has('details') ? 'has-error' : '' }}">
                                    <label class="col-md-12" for="details">Details <span class="text-danger">*</span> :</label>
                                    <div class="col-md-12">

                                        {{Form::textArea('details','',['class'=>'form-control tinymceSimple','placeholder'=>'Employe Designation'])}}
                                        @if ($errors->has('details'))
                                            <span class="help-block" style="display:block">
                                                <strong>{{ $errors->first('details') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-5 no-padding">
                                        <label class="col-md-12" for="start_leave">Leave Start Date :</label>
                                        <div class="col-md-12">

                                            {{Form::text('start_leave','',['class'=>'form-control datepicker','placeholder'=>'Leave Start Date','required'])}}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label> &nbsp; </label>
                                        <span class="form-control text-center bg-info"> TO </span>
                                    </div>
                                    <div class="col-md-5 no-padding">
                                        <label class="col-md-12" for="end_leave">Leave End Date :</label>
                                        <div class="col-md-12">

                                            {{Form::text('end_leave','',['class'=>'form-control datepicker','placeholder'=>'Leave End Date','required'])}}
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="col-md-6">


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


@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Attendance</a>
        </li>
    </ul>
@endsection
@section('content')
    <style type="text/css">

        .all-emp{display: none;}
    </style>
    <!-- begin #content -->
    <div id="content" class="content">
        <div class="row">
            <div class="col-md-12 no-padding">
                <div class="card">
                    <div class="card-header card-info">
                        All Attendance
                        <div class="card-heading-btn pull-right">
                            <a class="btn btn-primary btn-sm" href="" data-toggle="modal" data-target="#exportAttendance"> <i class="fa fa-file-excel-o"></i> Export </a>
                            <a class="btn btn-success btn-sm" href="" data-toggle="modal" data-target="#importAttendance"> <i class="fa fa-file-excel-o"></i> Import </a>

                            <a class="btn btn-primary btn-sm" href="{{URL::to('/attendance/create')}}"> <i class="fa fa-plus-circle"></i> Add New </a>

                        </div>


                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exportAttendance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Export Attendance Sheet</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                {!! Form::open(['url'=>'export-attendance','method'=>'GET','files'=>true]) !!}
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <label> Select Section : </label>
                                        {{Form::select('section_id',$section,'',['class'=>'form-control','placeholder'=>'All'])}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label> Select Month : </label>
                                            {{Form::select('month',$month,date('m'),['class'=>'form-control'])}}
                                        </div>
                                        <div class="col-md-6">
                                            <label> Select Year : </label>
                                            {{Form::select('year',$year,date('Y'),['class'=>'form-control'])}}
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="importAttendance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Import Attendance Sheet</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                {!! Form::open(['url'=>'attendance-import','method'=>'POST','files'=>true]) !!}
                                <div class="modal-body">

                                    <label> Upload your excel sheet: </label>
                                    <input type="file" name="attendance_sheet">
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-success" href="{{asset('public/files/attendence_sheet.xlsx')}}"> <i class="fa fa-download"></i>Download Excel Sample </a>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-body min-padding">
                        @if(Session::has('importStatus'))
                        <table class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th>Import Status</th>
                                </tr>
                                </thead>
                            <tbody>
                            <?php
                                $allStatus = Session::get('importStatus');
                            ?>
                            @foreach($allStatus as $status)
                                <tr>
                                    <td> {{$status}} </td>
                                </tr>
                            @endforeach
                            </tbody>

                            </table>
                        @else
                            <div class="table-responsive">
                                <table id="all_data" class="table table-striped table-bordered nowrap" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="5%">Date</th>
                                        <th>Section</th>
                                        <th> Total Employee </th>
                                        <th> Present </th>
                                        <th> Absent  </th>
                                        <th> Leave  </th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            $('#all_data').DataTable( {
                processing: true,
                serverSide: true,
                ajax: '{!! URL::asset("attendance-all") !!}',
                columns: [
                    { data: 'attendance_date'},
                    { data: 'section_name',name:'hrm_employee_sections.section_name'},
                    { data: 'total_employee'},
                    { data: 'present'},
                    { data: 'absent'},
                    { data: 'leave'},
                    { data: 'action'}
                ]
            });
        });
    </script>
@endsection

@extends('layouts.app')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{URL::to('/')}}">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Employee Attendance</a>
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
                        Employee wise Attendance Sheet
                        <div class="card-heading-btn pull-right">
                            <a href="javascript:;" onclick="printPage('print_body')" class="printbtn btn btn-success btn-sm"><i class="fa fa-print"></i> Print</a>
                            <a class="btn btn-primary btn-sm" href="{{URL::to('/employee-attendance')}}"> Employee Attendance </a>

                        </div>
                    </div>
                    <div class="card-body min-padding">
                        <div id="print_body" style="width: 100%;overflow: hidden;">
                            <style>
                                .employee_info p{
                                    margin-bottom: 5px;
                                }
                            </style>
                            @include('pad.header')
                            <div class="col-md-12" style="overflow: hidden">
                                <div class="employee_info" style="width: 90%;float: left">
                                    <p> <b>Employee Name:</b> {{$employee->user->name}} </p>
                                    <p><b>Employee ID:</b> {{$employee->employee_id}}</p>
                                    <p> <b>Designation:</b> {{$employee->designation}}</p>
                                    <p><b>Section Name:</b> {{$employee->section->section_name}}</p>
                                    <h5 style="text-align: center">  Attendance of {{date('F, Y',strtotime('01-'.$month.'-'.$year))}} </h5>
                                </div>
                                <div style="width: 10%;float: right">
                                    <img class="img-responsive" style="float: right;height: 120px;border:1px solid #ddd;padding: 2px;" src='{{asset("images/employee/$employee->photo")}}'>
                                </div>

                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr style="background: #efefef;">
                                        <th width="12%"> Date </th>
                                        <th> Attendance </th>
                                        <th> In Time </th>
                                        <th> Out Time </th>
                                        <th> Late In </th>
                                        <th> Early Out </th>
                                        <th> Late </th>
                                        <th> Overtime </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $late_in = 0;
                                    $early_out = 0;
                                    $late = 0;
                                    $overtime = 0;
                                    ?>
                                    @foreach($allData as $data)
                                        <?php
                                        $late_in += $data->late_in;
                                        $early_out += $data->early_out;
                                        $late += $data->late;
                                        $overtime += $data->overtime;
                                        ?>
                                        <tr>
                                            <td>{{date('d-m-Y',strtotime($data->attendance_date))}}</td>
                                            <td>@if($data->attendance==1) <b class="text-success"> Prsent </b> @elseif($data->attendance==0) <b class="text-danger"> Absent </b> @else <b class="text-warning"> Leave </b> @endif </td>
                                            <td>@if($data->attendance==1) {{date('h:i A',strtotime($data->in_time))}} @endif</td>
                                            <td>@if($data->attendance==1) {{date('h:i A',strtotime($data->out_time))}} @endif</td>

                                            <td>{{$data->late_in}}</td>
                                            <td>{{$data->early_out}} {{--{{($data->early_out>0)?$data->early_out:0}}--}}</td>
                                            <td>{{$data->late}}</td>
                                            <td>{{$data->overtime}}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="background: #eee;">
                                        <th colspan="4" style="text-align: right"> Total =  </th>
                                        <th> {{$late_in}} </th>
                                        <th> {{$early_out}} </th>
                                        <th> {{$late}} </th>
                                        <th> {{$overtime}} </th>
                                    </tr>
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->
@endsection
@section('script')
    <script src="{{asset('public/js/printThis.js')}}"></script>
    <script type="text/javascript">
        function printPage(id){
            $('#'+id).printThis();
        }
    </script>

@endsection


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
    <!-- begin #content -->
    <div id="content" class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-info">
                        Attendance Submit
                        <div class="card-heading-btn pull-right">
                            <a class="btn btn-primary btn-sm" href="{{URL::to('/attendance')}}">View All</a>

                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="text-center"><span style="margin-right: 40px;"> <b class="text-success"> Section Name: </b> {{$section->section_name}} </span> <span> <b class="text-success"> Date: </b> {{date('d-m-Y',strtotime($date))}}  </span></h5>
                        {!! Form::open(array('route' => ['attendance.update',$section->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                        <input type="hidden" value="{{$date}}" name="attendance_date">
                        @if(isset($attendances))
                            <div class="col-md-12">
                                <div class="table-responsive">
                                        @if(count($attendances)>0)
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <td width="10%"> ID </td>
                                                    <td width="20%"> Name </td>
                                                    <td width="15%"> Designation </td>
                                                    <td width="12%"> In Time </td>
                                                    <td width="12%"> Out Time </td>
                                                    <td width="5%"> <label> Present <input type="checkbox" class="wh-17 allChecked"> </label></td>
                                                    <td width="5%"> Absance </td>
                                                    <td width="5%"> Leave </td>
                                                </tr>
                                                </thead>
                                                <?php $i=0; ?>
                                                @foreach($attendances as $employee)
                                                    <?php $i++; ?>
                                                    <tr>
                                                        <td> {{$employee->employeeId}} <input type="hidden" value="{{$employee->employee_id}}" name="employee_id[]"> <input type="hidden" value="{{$employee->id}}" name="id[]"> </td>
                                                        <td> {{$employee->employee_name}} </td>
                                                        <td> {{$employee->designation}} </td>
                                                        <td> <input required name="in_time[]" type="text" placeholder="In Time" class="form-control min-height timepicker" value="@if($employee->in_time>0){{date('h:i A',strtotime($employee->in_time))}} @else '09:00 AM' @endif"> </td>
                                                        <td> <input required name="out_time[]" type="text" placeholder="Out Time" class="form-control min-height timepicker" value="@if($employee->out_time>0){{date('h:i A',strtotime($employee->out_time))}} @else '06:00 PM' @endif"> </td>
                                                        <td><label class="w-100"> <input name="attendance[]" class="wh-17 checked checkbox-{{$i}} pointer present" type="checkbox" id="p-{{$i}}" {{($employee->attendance==1)?'checked':''}} value="1">  </label> </td>
                                                        <td><label class="w-100"> <input name="attendance[]" class="wh-17 checked checkbox-{{$i}} pointer" type="checkbox" id="a-{{$i}}" value="0" {{($employee->attendance==0)?'checked':''}}>  </label> </td>
                                                        <td><label class="w-100"> <input name="attendance[]" class="wh-17 checked checkbox-{{$i}} pointer" type="checkbox" id="l-{{$i}}" value="2" {{($employee->attendance==2)?'checked':''}}>  </label> </td>
                                                    </tr>
                                                @endforeach




                                            </table>
                                        @else
                                            <hr>
                                            <h2 class="text-center text-danger"> Employee not found! </h2>
                                        @endif
                                </div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <button class="btn btn-info pull-right"> Submit  </button>
                                    </div>
                                </div>
                            </div>
                        @endif
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
        $(document).on('click','#load-attendance',function(){
            var section = $('select[name=section_id]').val();
            var date = $('input[name=attendance_date]').val();
            window.location.href='{{URL::to("attendance/create")}}?s='+section+'&d='+date;
        });
        $(document).on('click','.allChecked',function(){
            $('.checked').each(function(){
                $(this).prop('checked', false);
                $(this).attr('required', true);
            });
            if($(this).is(':checked')){
                $('.checked').each(function(){
                    $(this).attr('required', false);
                });
                $('.present').each(function(){
                    $(this).prop('checked', true);
                    $(this).attr('required', true);
                });
            }
        });
        $(document).on('click','.checked',function(){
            var id = $(this).attr('id').split('-')[1];
            if($(this).is(':checked')){
                $('.checkbox-'+id).each(function(){
                    $(this).prop('checked', false);
                    $(this).attr('required', false);
                });
                $(this).attr('required', true);
                $(this).prop('checked',true);
            }else{
                return false;
            }

        });

    </script>
@endsection

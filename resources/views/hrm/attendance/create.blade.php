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
                            {!! Form::open(array('route' => 'attendance.store','class'=>'form-horizontal','method'=>'POST')) !!}
                                <div class="form-group row {{ $errors->has('section_id') ? 'has-error' : '' }}">
                                    <div class="col-md-4">
                                        <?php
                                            if(isset($input['s'])){
                                                $sectionId = $input['s'];
                                            }else{
                                                $sectionId ='';
                                            }
                                            if(isset($input['d'])){
                                                $date = date('d-m-Y',strtotime($input['d']));
                                            }else{
                                                $date =date('d-m-Y');
                                            }
                                        ?>
                                        <label class="col-md-12" for="section_id">Select Section:</label>
                                        <div class="col-md-12">
                                            {{Form::select('section_id',$section,$sectionId,['class'=>'form-control select','placeholder'=>'Select Section','required'])}}
                                            @if ($errors->has('section_id'))
                                                <span class="help-block" style="display:block">
                                                    <strong>{{ $errors->first('section_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-md-12" for="attendance_date">Select Date:</label>
                                        <div class="col-md-12">
                                            {{Form::text('attendance_date',$date,['class'=>'form-control datepicker','placeholder'=>'Select Date','required'])}}
                                            @if ($errors->has('attendance_date'))
                                                <span class="help-block" style="display:block">
                                                    <strong>{{ $errors->first('attendance_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label col-md-12"> &nbsp; </label>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary btn-sm" id="load-attendance" title="Click for load employee">Load</button>
                                        </div>
                                    </div>
                                </div>
                            @if(isset($employees))
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    @if($attn==null)
                                    @if(count($employees)>0)
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
                                            @foreach($employees as $employee)
                                            <?php $i++; ?>
                                            <tr>
                                                <td> {{$employee->employee_id}} <input type="hidden" value="{{$employee->id}}" name="employee_id[]"> </td>
                                                <td> {{$employee->user->name}} </td>
                                                <td> {{$employee->designation}} </td>
                                                <td> <input required name="in_time[]" type="text" placeholder="In Time" class="form-control min-height timepicker" value="09:00 AM"> </td>
                                                <td> <input required name="out_time[]" type="text" placeholder="Out Time" class="form-control min-height timepicker" value="06:00 PM"> </td>
                                           <td><label class="w-100"> <input name="attendance[]" required class="wh-17 checked checkbox-{{$i}} pointer present" type="checkbox" id="p-{{$i}}" value="1">  </label> </td>
                                           <td><label class="w-100"> <input required name="attendance[]" class="wh-17 checked checkbox-{{$i}} pointer" type="checkbox" id="a-{{$i}}" value="0">  </label> </td>
                                           <td><label class="w-100"> <input required name="attendance[]" class="wh-17 checked checkbox-{{$i}} pointer" type="checkbox" id="l-{{$i}}" value="2">  </label> </td>
                                            </tr>
                                            @endforeach




                                    </table>
                                    @else
                                        <hr>
                                        <h2 class="text-center text-danger"> Employee not found! </h2>
                                    @endif
                                @else
                                        <hr>
                                    <h2 class="text-center text-danger"> The presence has already been submitted! </h2>
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

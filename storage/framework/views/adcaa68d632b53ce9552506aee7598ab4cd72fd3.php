<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Employee Attendance</a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- begin #content -->
    <div id="content" class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-info">
                        Employee wise Attendance Sheet
                        <div class="card-heading-btn pull-right">
                            <a class="btn btn-primary btn-sm" href="<?php echo e(URL::to('/attendance')); ?>">View All</a>

                        </div>
                    </div>
                    <div class="card-body min-padding">
                        <?php echo Form::open(array('route' => 'attendance.store','class'=>'form-horizontal','method'=>'POST')); ?>

                        <div class="form-group row <?php echo e($errors->has('section_id') ? 'has-error' : ''); ?>">
                            <div class="col-md-3">
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
                                    <?php echo e(Form::select('section_id',$section,$sectionId,['class'=>'form-control select','placeholder'=>'Select Section','required','id'=>'section_id'])); ?>

                                </div>
                            </div>

                            <div class="col-md-3 no-padding">
                                <label class="col-md-12" for="month">Select Employee:</label>
                                <div class="col-md-12" id="loadEmployee">
                                    <span class="form-control text-danger"> Select section first! </span>
                                </div>
                            </div>
                            <div class="col-md-2 no-padding">
                                <label class="col-md-12" for="month">Select Month:</label>
                                <div class="col-md-12">
                                    <?php echo e(Form::select('month',$month,date('m'),['class'=>'form-control'])); ?>

                                </div>
                            </div>
                            <div class="col-md-2 no-padding">
                                <label class="col-md-12" for="year">Select Year:</label>
                                <div class="col-md-12">
                                    <?php echo e(Form::select('year',$year,date('Y'),['class'=>'form-control'])); ?>


                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label col-md-12"> &nbsp; </label>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-sm" id="load-attendance" title="Click for load Attendance">Load</button>
                                </div>
                            </div>
                        </div>

                        <?php echo Form::close();; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $(document).on('change','#section_id',function(){
            var id =  $(this).val();
            $('#loadEmployee').load('<?php echo e(URL::to("load-employee")); ?>/'+id);

        });

        $(document).on('click','#load-attendance',function(){
            var id = $('select[name=employee_id]').val();
            var month = $('select[name=month]').val();
            var year = $('select[name=year]').val();
            window.location.href='<?php echo e(URL::to("employee-attendance")); ?>/'+id+'?m='+month+'&y='+year;
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
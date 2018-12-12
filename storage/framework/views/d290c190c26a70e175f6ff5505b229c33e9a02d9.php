<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Leave Request</a>
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
                        Leave Request
                        <div class="card-heading-btn pull-right">
                            <a class="btn btn-primary btn-sm" href="<?php echo e(URL::to('/employees')); ?>">Leave Status</a>

                        </div>
                    </div>
                    <div class="card-body">
                        <?php echo Form::open(array('route' => 'leave.store','class'=>'form-horizontal author_form','method'=>'POST')); ?>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group row <?php echo e($errors->has('leave_type') ? 'has-error' : ''); ?>">
                                    <label class="col-md-12" for="leave_type">Leave type <span class="text-danger">*</span> :</label>
                                    <div class="col-md-3">
                                        <?php echo e(Form::select('leave_type',['1'=>'Paid','0'=>'Unpaid'],'1',['class'=>'form-control','required'])); ?>

                                        <?php if($errors->has('leave_type')): ?>
                                            <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('leave_type')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row <?php echo e($errors->has('subject') ? 'has-error' : ''); ?>">
                                    <label class="col-md-12" for="subject">Leave Subject <span class="text-danger">*</span> :</label>
                                    <div class="col-md-12">
                                        <?php echo e(Form::text('subject','',['class'=>'form-control','placeholder'=>'Leave Subject','required'])); ?>

                                        <?php if($errors->has('subject')): ?>
                                            <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('subject')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>


                                <div class="form-group row <?php echo e($errors->has('details') ? 'has-error' : ''); ?>">
                                    <label class="col-md-12" for="details">Details <span class="text-danger">*</span> :</label>
                                    <div class="col-md-12">

                                        <?php echo e(Form::textArea('details','',['class'=>'form-control tinymceSimple','placeholder'=>'Employe Designation'])); ?>

                                        <?php if($errors->has('details')): ?>
                                            <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('details')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-5 no-padding">
                                        <label class="col-md-12" for="start_leave">Leave Start Date :</label>
                                        <div class="col-md-12">

                                            <?php echo e(Form::text('start_leave','',['class'=>'form-control datepicker','placeholder'=>'Leave Start Date','required'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label> &nbsp; </label>
                                        <span class="form-control text-center bg-info"> TO </span>
                                    </div>
                                    <div class="col-md-5 no-padding">
                                        <label class="col-md-12" for="end_leave">Leave End Date :</label>
                                        <div class="col-md-12">

                                            <?php echo e(Form::text('end_leave','',['class'=>'form-control datepicker','placeholder'=>'Leave End Date','required'])); ?>

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
                        <?php echo Form::close();; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                            <a href="javascript:;" onclick="printPage('print_body')" class="printbtn btn btn-success btn-sm"><i class="fa fa-print"></i> Print</a>
                            <a class="btn btn-primary btn-sm" href="<?php echo e(URL::to('/employee-attendance')); ?>"> Employee Attendance </a>

                        </div>
                    </div>
                    <div class="card-body min-padding">
                        <div id="print_body" style="width: 100%;overflow: hidden;">
                            <style>
                                .employee_info p{
                                    margin-bottom: 5px;
                                }
                            </style>
                            <?php echo $__env->make('pad.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <div class="col-md-12" style="overflow: hidden">
                                <div class="employee_info" style="width: 90%;float: left">
                                    <p> <b>Employee Name:</b> <?php echo e($employee->user->name); ?> </p>
                                    <p><b>Employee ID:</b> <?php echo e($employee->employee_id); ?></p>
                                    <p> <b>Designation:</b> <?php echo e($employee->designation); ?></p>
                                    <p><b>Section Name:</b> <?php echo e($employee->section->section_name); ?></p>
                                    <h5 style="text-align: center">  Attendance of <?php echo e(date('F, Y',strtotime('01-'.$month.'-'.$year))); ?> </h5>
                                </div>
                                <div style="width: 10%;float: right">
                                    <img class="img-responsive" style="float: right;height: 120px;border:1px solid #ddd;padding: 2px;" src='<?php echo e(asset("images/employee/$employee->photo")); ?>'>
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
                                    <?php $__currentLoopData = $allData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $late_in += $data->late_in;
                                        $early_out += $data->early_out;
                                        $late += $data->late;
                                        $overtime += $data->overtime;
                                        ?>
                                        <tr>
                                            <td><?php echo e(date('d-m-Y',strtotime($data->attendance_date))); ?></td>
                                            <td><?php if($data->attendance==1): ?> <b class="text-success"> Prsent </b> <?php elseif($data->attendance==0): ?> <b class="text-danger"> Absent </b> <?php else: ?> <b class="text-warning"> Leave </b> <?php endif; ?> </td>
                                            <td><?php if($data->attendance==1): ?> <?php echo e(date('h:i A',strtotime($data->in_time))); ?> <?php endif; ?></td>
                                            <td><?php if($data->attendance==1): ?> <?php echo e(date('h:i A',strtotime($data->out_time))); ?> <?php endif; ?></td>

                                            <td><?php echo e($data->late_in); ?></td>
                                            <td><?php echo e($data->early_out); ?> </td>
                                            <td><?php echo e($data->late); ?></td>
                                            <td><?php echo e($data->overtime); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="background: #eee;">
                                        <th colspan="4" style="text-align: right"> Total =  </th>
                                        <th> <?php echo e($late_in); ?> </th>
                                        <th> <?php echo e($early_out); ?> </th>
                                        <th> <?php echo e($late); ?> </th>
                                        <th> <?php echo e($overtime); ?> </th>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('public/js/printThis.js')); ?>"></script>
    <script type="text/javascript">
        function printPage(id){
            $('#'+id).printThis();
        }
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
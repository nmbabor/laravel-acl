<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>All Company</a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-info">
                    All Company
                    <div class="card-btn pull-right">
                        <a href="<?php echo e(URL::to('company/create')); ?>" class="btn btn-primary btn-sm" > <i class="fa fa-plus"></i> Add New</a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if(count($allData)>0): ?>
                        <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="5%">SL</th>
                            <th>Company Name</th>
                            <th>Mobile No</th>
                            <th>Address</th>
                            <th>Branch</th>
                            <th>Depot</th>
                            <th width="7%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; ?>
                        <?php $__currentLoopData = $allData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $i++; ?>
                            <tr>
                                <td><?php echo e($i); ?></td>
                                <td><?php echo e($data->company_name); ?></td>
                                <td><?php echo e($data->mobile_no); ?></td>
                                <td><?php echo e($data->address); ?></td>
                                <td> <a class="btn btn-xs btn-info" href='<?php echo e(URL::to("company-branch/$data->id   ")); ?>'> Branch <span class="badge"> <?php echo e(count($data->branch)); ?> </span> </a> </td>
                                <td>
                                    <a class="btn btn-xs btn-success" href='<?php echo e(URL::to("storage-info/$data->id   ")); ?>' title="View All Storage"> Depot <span class="badge"> <?php echo e(count($data->companyStorage)); ?> </span> </a>
                                </td>
                                <td style="text-align: center">
                                    <?php echo e(Form::open(array('route'=>['company.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id"))); ?>

                                    <a href='<?php echo e(URL::to("company/$data->id/edit")); ?>' class="btn btn-info btn-xs"> <i class="fa fa-pencil-square"></i></a>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm('deleteForm<?php echo e($data->id); ?>')"><i class="fa fa-trash"></i></button>
                                    <?php echo Form::close(); ?>


                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                        </div>
                    <?php else: ?>
                        <h2 class="text-danger text-center"> No data available here. </h2>
                    <?php endif; ?>
                </div>
                <?php echo e($allData->render()); ?>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-lg-12 -->
    </div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
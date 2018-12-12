<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a> Dashboard </a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <?php
                $color = ['yellow','green','red','blue'];
                $c=0;
                ?>
                <?php $__currentLoopData = $allCompany; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                        <!-- Modal -->
                                        <div class="modal fade" id="company-<?php echo e($company->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">  Information </h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="list-group">
                                                            <li class="list-group-item"><b> Company Name : </b><?php echo e($company->company_name); ?> </li>
                                                            <li class="list-group-item"><b> Address : </b><?php echo e($company->address); ?> </li>
                                                            <li class="list-group-item"><b>Shipping Address : </b><?php echo e($company->shipping_address); ?> </li>
                                                            <li class="list-group-item"><b>Mobile Number : </b><?php echo e($company->mobile_no); ?> </li>
                                                            <li class="list-group-item"><b>Email : </b><?php echo e($company->email); ?> </li>
                                                            <li class="list-group-item">  <b> Logo : </b>
                                                                <img src="<?php echo e(asset($company->logo)); ?>" alt="<?php echo e($company->company_name); ?>">  <b> Favicon : </b>
                                                                <img src="<?php echo e(asset($company->favicon)); ?>" alt="<?php echo e($company->company_name); ?>"></li>
                                                        </ul>
                                                        <li class="list-group-item">
                                                            <b> Modules : </b>

                                                            <?php $__currentLoopData = $company->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php echo e(($key>0)?', ':''); ?> <?php echo e($module->menu->name); ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <h6 class="text-muted m-b-0"><?php echo e($company->company_name); ?></h6>
                                </div>
                                <div class="col-4 text-right">
                                    <a title="Click for show details" data-toggle="modal"href="#company-<?php echo e($company->id); ?>">
                                <?php if($company->favicon!=null): ?>
                                    <img src="<?php echo e(asset($company->favicon)); ?>" class="img-responsive">
                                    <?php else: ?>
                                    <i class="feather icon-file-text f-28"></i>
                                    <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-<?php echo e($color[$c]); ?>">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0"> <?php echo e($company->company_name); ?> </p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                        $c++;
                        if($c>3){
                            $c=0;
                        }
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- project and updates end -->
        </div>
        <!-- [ page content ] end -->
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
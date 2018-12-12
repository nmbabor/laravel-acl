<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('company')); ?>">
                Company
            </a>
        </li>

        <li class="breadcrumb-item">
            <a> Depot</a>
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
                        <div class="card-btn pull-right">
                            <a  href="#modal-dialog" class="btn btn-primary btn-sm" data-toggle="modal" > <i class="fa fa-plus"></i> Add New</a>

                        </div>
                        <h4 class="card-title">Depot <?php if(isset($company)): ?> of <?php echo e($company->company_name); ?> <?php endif; ?> </h4>
                    </div>
                    <div class="card-body">
                        <!-- #modal-dialog -->
                        <div class="modal fade" id="modal-dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <?php echo Form::open(array('route' => 'storage-info.store','class'=>'form-horizontal','method'=>'POST')); ?>

                                    <div class="modal-header">
                                        <h4 class="modal-title">Add New Depot</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3"> Branch <sup>*</sup> :</label>
                                            <div class="col-md-8 col-sm-8">
                                                <?php echo e(Form::select('branch_id',$branches,[],['class'=>'form-control','placeholder'=>'Select one'])); ?>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3">  Name <sup>*</sup>:</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input type="text" value="" name="storage_name" class="form-control" placeholder="Enter storage/depot name">
                                                <input type="hidden" value=" <?php if(isset($company)): ?> <?php echo e($company->id); ?> <?php endif; ?> " name="company_id">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3"> Address <sup>*</sup>:</label>
                                            <div class="col-md-8 col-sm-8">
                                                <textarea class="form-control" name="address" rows="3" placeholder="Write some description about storage" required></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
                                        <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                    </div>
                                    <?php echo Form::close();; ?>

                                </div>
                            </div>
                        </div> <!--  =================== End modal ===================  -->

                        <!--  -->
                        <div class="view_branch_set">

                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="15%">Depot Name</th>
                                    <th width="20%">Branch Name</th>
                                    <th width="25%">address</th>
                                    <th width="8%">status</th>
                                    <th width="8%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0; ?>
                                <?php $__currentLoopData = $storages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $i++; ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo e($i); ?></td>
                                        <td><?php echo e($storage->storage_name); ?></td>

                                        <td><?php if(isset($storage->storageBranch->branch_name)): ?> <?php echo e($storage->storageBranch->branch_name); ?> <?php endif; ?></td>
                                        <td><?php echo e($storage->address); ?></td>
                                        <td>
                                            <?php if($storage->status=="1"): ?>
                                                <?php echo e("Active"); ?>

                                            <?php else: ?>
                                                <?php echo e("Inactive"); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- edit section -->
                                            <a href="#modal-dialog<?php echo $storage->id;?>" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <!-- #modal-dialog -->

                                            <div class="modal fade" id="modal-dialog<?php echo $storage->id;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <?php echo Form::open(array('route' => ['storage-info.update',$storage->id],'class'=>'form-horizontal','method'=>'PUT')); ?>

                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Depot</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                <label class="control-label col-md-3 col-sm-3">Status :</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" <?php if($storage->status=="1"): ?><?php echo e("checked"); ?><?php endif; ?>> Active
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" id="radio-required2" value="0" <?php if($storage->status=="0"): ?><?php echo e("checked"); ?><?php endif; ?>> Inactive
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="control-label col-md-3 col-sm-3"> Branch <sub>*</sub> :</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <?php echo e(Form::select('branch_id',$branches,$storage->branch_id,['class'=>'form-control','placeholder'=>'Select one'])); ?>

                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="control-label col-md-3 col-sm-3">Name <sup>*</sup>:</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <input type="text" value="<?php echo e($storage->storage_name); ?>" name="storage_name" class="form-control" placeholder="Enter storage/depot name">
                                                                    <input type="hidden" value="<?php echo e($storage->company_id); ?>" name="company_id">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="control-label col-md-3 col-sm-3"> Address <sup>*</sup>:</label>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <textarea class="form-control" name="address" rows="3" placeholder="Write some description about storage"><?php echo e($storage->address); ?></textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
                                                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                        </div>
                                                        <?php echo Form::close();; ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end edit section -->

                                            <!-- delete section -->
                                            <?php echo e(Form::open(array('route'=>['storage-info.destroy',$storage->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$storage->id"))); ?>

                                            <button type="button" class="btn btn-danger btn-xs" onclick='return deleteConfirm("deleteForm<?php echo e($storage->id); ?>")'><i class="fa fa-trash"></i></button>
                                        <?php echo Form::close(); ?>

                                        <!-- delete section end -->
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php echo e($storages->render()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end #content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
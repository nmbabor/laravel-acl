<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Profile</a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>My Profile</h5>
                </div>
                <div class="card-block">
                    <div class="j-wrapper j-wrapper-640">
                        <?php echo Form::open(['route'=>'profile.store','method'=>'POST','class'=>'j-pro','id'=>'j-pro']); ?>

                            <div class="j-content">
                                <!-- start name -->
                                <div class="j-unit <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                                    <label class="j-label">Your name</label>
                                    <div class="j-input">
                                        <label class="j-icon-right" for="name">
                                            <i class="icofont icofont-ui-user"></i>
                                        </label>
                                        <input type="text" value="<?php echo e($data->name); ?>" required id="name" name="name">
                                        <span class="j-tooltip j-tooltip-right-top">Your Full Name</span>
                                        <?php if($errors->has('name')): ?>
                                            <span class="help-block">
                                            <small><?php echo e($errors->first('name')); ?></small>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- end name -->
                                <!-- start email phone -->
                                <div class="j-row">
                                    <div class="j-span6 j-unit <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                                        <label class="j-label">Your email</label>
                                        <div class="j-input">
                                            <label class="j-icon-right" for="email">
                                                <i class="icofont icofont-envelope"></i>
                                            </label>
                                            <input type="email" value="<?php echo e($data->email); ?>" required id="email" name="email">
                                            <span class="j-tooltip j-tooltip-right-top">Email Address</span>
                                            <?php if($errors->has('email')): ?>
                                                <span class="help-block">
                                                    <small><?php echo e($errors->first('email')); ?></small>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="j-span6 j-unit <?php echo e($errors->has('phone_number') ? 'has-error' : ''); ?>">
                                        <label class="j-label">Phone/Mobile</label>
                                        <div class="j-input">
                                            <label class="j-icon-right" for="phone">
                                                <i class="icofont icofont-phone"></i>
                                            </label>
                                            <input type="text" value="<?php echo e($data->phone_number); ?>" id="phone" name="phone_number">
                                            <span class="j-tooltip j-tooltip-right-top">Mobile Number</span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="j-unit">
                                        <label class="j-label">Address</label>
                                        <div class="j-input">
                                            <label class="j-icon-right" for="adults">
                                                <i class="icofont icofont-location-pin"></i>
                                            </label>
                                            <input type="text" id="adults" value="<?php echo e($data->address); ?>" name="address">
                                            <span class="j-tooltip j-tooltip-right-top">Your Address</span>
                                        </div>
                                    </div>
                            </div>
                            <!-- end /.content -->
                            <div class="j-footer">
                                <a class="btn btn-warning" href="<?php echo e(URL::to('profile/password')); ?>"> Change Password </a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            <!-- end /.footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
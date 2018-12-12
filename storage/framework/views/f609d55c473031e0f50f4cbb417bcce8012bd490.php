<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Create Company</a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-info">
                    Create New Company
                    <div class="card-btn pull-right">
                        <a href="<?php echo e(URL::to('company')); ?>" class="btn btn-primary btn-sm" > <i class="fa fa-list"></i> View All</a>
                    </div>
                </div>

                <?php echo Form::open(array('route' =>'company.store','method'=>'POST','class'=>'form-horizontal','files'=>true)); ?>

                <div class="card-body">
                    <div class="form-group row <?php echo e($errors->has('logo') ? 'has-error' : ''); ?>">
                        <?php echo e(Form::label('logo', 'Organization Logo', array('class' => 'col-md-3 control-label'))); ?>

                        <div class="col-md-8">
                            <label class="upload_photo upload client_logo_upload" for="file">
                                <!--  -->
                                <img id="image_load">
                                
                            </label>
                            <?php echo e(Form::file('logo',array('id'=>'file','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load")'))); ?>

                            <?php if($errors->has('logo')): ?>
                                <span class="help-block" style="display:block">
                            <strong><?php echo e($errors->first('logo')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo e($errors->has('favicon') ? 'has-error' : ''); ?>">
                        <?php echo e(Form::label('favicon', 'Organization Icon', array('class' => 'col-md-3 control-label'))); ?>

                        <div class="col-md-8">
                            <label class="upload_photo upload client_favicon_upload" for="file2">
                                <!--  -->
                                <img id="image_load2">
                            </label>
                            <?php echo e(Form::file('favicon',array('id'=>'file2','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load2")'))); ?>

                            <?php if($errors->has('favicon')): ?>
                                <span class="help-block" style="display:block">
                            <strong><?php echo e($errors->first('favicon')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row  <?php echo e($errors->has('company_name') ? 'has-error' : ''); ?>">
                        <?php echo e(Form::label('company_name', 'Name of Organization', array('class' => 'col-md-3 control-label'))); ?>

                        <div class="col-md-8">
                            <?php echo e(Form::text('company_name','',array('class'=>'form-control','placeholder'=>'Name of Organization'))); ?>

                            <?php if($errors->has('company_name')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('company_name')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row  <?php echo e($errors->has('address') ? 'has-error' : ''); ?>">
                        <?php echo e(Form::label('address', 'Organization Address', array('class' => 'col-md-3 control-label'))); ?>

                        <div class="col-md-8">
                            <?php echo e(Form::text('address','',array('class'=>'form-control','placeholder'=>'Organization Address'))); ?>

                            <?php if($errors->has('address')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('address')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row  <?php echo e($errors->has('mobile_no') ? 'has-error' : ''); ?>">
                        <?php echo e(Form::label('mobile_no', 'Contact Number', array('class' => 'col-md-3 control-label'))); ?>

                        <div class="col-md-8">
                            <?php echo e(Form::text('mobile_no','',array('class'=>'form-control','placeholder'=>'Contact Number'))); ?>

                            <?php if($errors->has('mobile_no')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('mobile_no')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row  <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                        <?php echo e(Form::label('email', 'Email', array('class' => 'col-md-3 control-label'))); ?>

                        <div class="col-md-8">
                            <?php echo e(Form::email('email','',array('class'=>'form-control','placeholder'=>'Email'))); ?>

                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row  <?php echo e($errors->has('shipping_address') ? 'has-error' : ''); ?>">
                        <?php echo e(Form::label('shipping_address', 'Shipping Address', array('class' => 'col-md-3 control-label'))); ?>

                        <div class="col-md-8">
                            <?php echo e(Form::text('shipping_address','',array('class'=>'form-control','placeholder'=>'Shipping Address'))); ?>

                            <?php if($errors->has('shipping_address')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('shipping_address')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group  row <?php echo e($errors->has('modules') ? 'has-error' : ''); ?>">
                        <?php echo e(Form::label('modules', 'Modules', array('class' => 'col-md-3 control-label'))); ?>

                        <div class="col-md-8">
                            <?php echo e(Form::select('modules[]',$modules,'',['class'=>'form-control select','multiple','required'])); ?>

                            <?php if($errors->has('modules')): ?>
                                <span class="help-block">
                            <strong><?php echo e($errors->first('modules')); ?></strong>
                        </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>


            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a>Employee</a>
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
                            Add New Employee
                            <div class="card-heading-btn pull-right">
                                <a class="btn btn-primary btn-sm" href="<?php echo e(URL::to('/employees')); ?>">All Employee</a>

                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo Form::open(array('route' => 'employees.store','class'=>'form-horizontal author_form','method'=>'POST','files'=>true)); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                                        <label class="col-md-12" for="name">Employe Name <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            <?php echo e(Form::text('name','',['class'=>'form-control','placeholder'=>'Employe Name','required'])); ?>

                                            <?php if($errors->has('name')): ?>
                                                <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group row <?php echo e($errors->has('phone_number') ? 'has-error' : ''); ?>">
                                        <label class="col-md-12" for="number">Moblie No. <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            <?php echo e(Form::number('phone_number','',['class'=>'form-control','placeholder'=>'Mobile Number','min'=>0])); ?>

                                            <?php if($errors->has('phone_number')): ?>
                                                <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('phone_number')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo e($errors->has('designation') ? 'has-error' : ''); ?>">
                                        <label class="col-md-12" for="designation">Designation <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">

                                            <?php echo e(Form::text('designation','',['class'=>'form-control','placeholder'=>'Employe Designation','required'])); ?>

                                            <?php if($errors->has('designation')): ?>
                                                <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('designation')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12" for="basic_pay">Basic Pay :</label>
                                        <div class="col-md-12">

                                            <?php echo e(Form::number('basic_pay','',['class'=>'form-control','placeholder'=>'Basic Pay','required','min'=>0])); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12" for="medical_allowance">Medical Allowance :</label>
                                        <div class="col-md-12">

                                            <?php echo e(Form::number('medical_allowance','',['class'=>'form-control','placeholder'=>'Medical Allowance','min'=>0])); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo e($errors->has('photo') ? 'has-error' : ''); ?> ">
                                        <label class="col-sm-12">Photo </label>
                                        <div class="col-md-5">
                                            <label class="upload_photo profile" for="file">
                                                <!--  -->
                                                <img id="image_load">
                                            </label>
                                            <input type="file" id="file" name="photo" onchange="readURL(this,this.id)" style="display:none">
                                            <?php if($errors->has('photo')): ?>
                                                <span class="help-block" style="display:block">
                                              <strong><?php echo e($errors->first('photo')); ?></strong>
                                          </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                                        <label class="col-md-12" for="email">Email <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            <?php echo e(Form::text('email','',['class'=>'form-control','placeholder'=>'@'])); ?>

                                            <?php if($errors->has('email')): ?>
                                                <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('email')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group row <?php echo e($errors->has('employee_id') ? 'has-error' : ''); ?>">
                                        <label class="col-md-12" for="employee_id">Employe ID <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            <?php echo e(Form::text('employee_id','',['class'=>'form-control','placeholder'=>'Employe ID','required'])); ?>

                                            <?php if($errors->has('employee_id')): ?>
                                                <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('employee_id')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo e($errors->has('section_id') ? 'has-error' : ''); ?>">
                                        <label class="col-md-12">Section <span class="text-danger">*</span> :</label>
                                        <div class="col-md-12">
                                            <?php echo e(Form::select('section_id',$section,'',['class'=>'form-control select','placeholder'=>'Select Section','required'])); ?>

                                            <?php if($errors->has('section_id')): ?>
                                                <span class="help-block" style="display:block">
                                                <strong><?php echo e($errors->first('section_id')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12" for="house_rent">House Rent :</label>
                                        <div class="col-md-12">
                                            <?php echo e(Form::number('house_rent','',['class'=>'form-control','placeholder'=>'House Rent','min'=>0])); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12" for="address">Address  :</label>
                                        <div class="col-md-12">

                                            <?php echo e(Form::textArea('address','',['class'=>'form-control','placeholder'=>'Address','rows'=>2])); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2">Status :</label>
                                        <div class="col-md-4">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1" id="radio-required" required checked /> Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" id="radio-required2" value="0" /> Inactive
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?php echo e($role->id); ?>" name="role_id">
                                    <div class="form-group row">
                                        <label class="col-md-12"></label>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <br>
                                            <br>
                                            <p class="text-danger"> Default password for this employee : <b class="text-success">123456</b> </p>
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
<?php $__env->startSection('script'); ?>
<script type="text/javascript">

 /*end chosen select option */
    function readURL(input,image_load) {
      var target_image='#'+$('#'+image_load).prev().children().attr('id');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(target_image).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
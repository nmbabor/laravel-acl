<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('/')); ?>">
                <i class="feather icon-home"></i>
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="<?php echo e(URL::to('primary-info')); ?>">Primary Info</a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header card-info">
                    Primary Information
                    <div class="card-btn pull-right">

                    </div>
                </div>

                <div class="card-body">
                    <?php echo Form::open(array('route' =>['primary-info.update', $data->id],'method'=>'PUT','class'=>'form-horizontals','files'=>true)); ?>


                    <div class="row">
                        <div class="col-md-12 no-padding">
                            <div class="form-group col-md-12 no-padding">
                                <label class="col-md-4"> <input type="radio" <?php echo e(($data->type==1)?'checked':''); ?> checked name="type" value="1"> Group of company </label>
                                <label class="col-md-4"> <input type="radio" name="type" <?php echo e(($data->type==2)?'checked':''); ?> value="2"> Single company </label>
                            </div>
                        </div>
                        <div class="col-md-8">

                            <div class="row">

                                <div class="form-group col-md-6 no-padding <?php echo e($errors->has('company_name') ? 'has-error' : ''); ?>">
                                    <?php echo e(Form::label('company_name', 'Name of Organization', array('class' => 'col-md-12'))); ?>

                                    <div class="col-md-12">
                                        <?php echo e(Form::text('company_name',$data->company_name,array('class'=>'form-control','placeholder'=>'Name of Organization'))); ?>

                                        <?php if($errors->has('company_name')): ?>
                                            <span class="help-block">
                            <strong><?php echo e($errors->first('company_name')); ?></strong>
                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group  col-md-6 no-padding <?php echo e($errors->has('address') ? 'has-error' : ''); ?>">
                                    <?php echo e(Form::label('address', 'Organization Address', array('class' => 'col-md-12'))); ?>

                                    <div class="col-md-12">
                                        <?php echo e(Form::text('address',$data->address,array('class'=>'form-control','placeholder'=>'Organization Address'))); ?>

                                        <?php if($errors->has('address')): ?>
                                            <span class="help-block">
                            <strong><?php echo e($errors->first('address')); ?></strong>
                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 no-padding  <?php echo e($errors->has('mobile_no') ? 'has-error' : ''); ?>">
                                    <?php echo e(Form::label('mobile_no', 'Contact Number', array('class' => 'col-md-12'))); ?>

                                    <div class="col-md-12">
                                        <?php echo e(Form::text('mobile_no',$data->mobile_no,array('class'=>'form-control','placeholder'=>'Contact Number'))); ?>

                                        <?php if($errors->has('mobile_no')): ?>
                                            <span class="help-block">
                            <strong><?php echo e($errors->first('mobile_no')); ?></strong>
                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 no-padding  <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                                    <?php echo e(Form::label('email', 'Email', array('class' => 'col-md-12'))); ?>

                                    <div class="col-md-12">
                                        <?php echo e(Form::email('email',$data->email,array('class'=>'form-control','placeholder'=>'Email'))); ?>

                                        <?php if($errors->has('email')): ?>
                                            <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 no-padding ">
                            <div class="row">
                                <div class="form-group  col-md-8 no-padding <?php echo e($errors->has('logo') ? 'has-error' : ''); ?>">
                                    <?php echo e(Form::label('logo', 'Organization Logo', array('class' => 'col-md-12'))); ?>

                                    <div class="col-md-12">
                                        <label class="upload_photo upload client_logo_upload" for="file">
                                            <!--  -->
                                            <img src="<?php echo e(asset($data->logo)); ?>" id="image_load">
                                            <i class="upload_hover ion ion-ios-camera-outline"></i>
                                        </label>
                                        <?php echo e(Form::file('logo',array('id'=>'file','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load")'))); ?>

                                        <?php if($errors->has('logo')): ?>
                                            <span class="help-block" style="display:block">
                            <strong><?php echo e($errors->first('logo')); ?></strong>
                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 no-padding <?php echo e($errors->has('favicon') ? 'has-error' : ''); ?>">
                                    <?php echo e(Form::label('favicon', ' Icon', array('class' => 'col-md-12'))); ?>

                                    <div class="col-md-12">
                                        <label class="upload_photo upload client_favicon_upload" for="file2">
                                            <!--  -->
                                            <img src="<?php echo e(asset($data->favicon)); ?>" id="image_load2">
                                            <i class="upload_hover ion ion-ios-camera-outline"></i>
                                        </label>
                                        <?php echo e(Form::file('favicon',array('id'=>'file2','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load2")'))); ?>

                                        <?php if($errors->has('favicon')): ?>
                                            <span class="help-block" style="display:block">
                            <strong><?php echo e($errors->first('favicon')); ?></strong>
                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <?php echo e(Form::hidden('id',$data->id)); ?>

                        <div class="form-group col-md-12 no-padding">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                    <?php if($data->type==1): ?>
                    <div class="row">
                        <div class="col-md-12 box-header">
                            Company List
                            <div class="pull-right">
                                <a class="btn btn-primary btn-xs" data-toggle="modal" href="#myModal"> <i class="fa fa-plus-circle"></i> Add new company </a>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add New Company</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <?php echo Form::open(array('route' =>'company.store','method'=>'POST','class'=>'form-horizontals','files'=>true)); ?>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12">

                                                <div class="row">

                                                    <div class="form-group col-md-6 no-padding <?php echo e($errors->has('company_name') ? 'has-error' : ''); ?>">
                                                        <?php echo e(Form::label('company_name', 'Name of Organization', array('class' => 'col-md-12','required'))); ?>

                                                        <div class="col-md-12">
                                                            <?php echo e(Form::text('company_name','',array('class'=>'form-control','placeholder'=>'Name of Organization','required'))); ?>

                                                            <?php if($errors->has('company_name')): ?>
                                                                <span class="help-block">
                            <strong><?php echo e($errors->first('company_name')); ?></strong>
                        </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  col-md-6 no-padding <?php echo e($errors->has('address') ? 'has-error' : ''); ?>">
                                                        <?php echo e(Form::label('address', 'Organization Address', array('class' => 'col-md-12'))); ?>

                                                        <div class="col-md-12">
                                                            <?php echo e(Form::text('address','',array('class'=>'form-control','placeholder'=>'Organization Address','required'))); ?>

                                                            <?php if($errors->has('address')): ?>
                                                                <span class="help-block">
                            <strong><?php echo e($errors->first('address')); ?></strong>
                        </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6 no-padding  <?php echo e($errors->has('mobile_no') ? 'has-error' : ''); ?>">
                                                        <?php echo e(Form::label('mobile_no', 'Contact Number', array('class' => 'col-md-12'))); ?>

                                                        <div class="col-md-12">
                                                            <?php echo e(Form::text('mobile_no','',array('class'=>'form-control','placeholder'=>'Contact Number','required'))); ?>

                                                            <?php if($errors->has('mobile_no')): ?>
                                                                <span class="help-block">
                            <strong><?php echo e($errors->first('mobile_no')); ?></strong>
                        </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 no-padding  <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                                                        <?php echo e(Form::label('email', 'Email', array('class' => 'col-md-12'))); ?>

                                                        <div class="col-md-12">
                                                            <?php echo e(Form::email('email','',array('class'=>'form-control','placeholder'=>'Email'))); ?>

                                                            <?php if($errors->has('email')): ?>
                                                                <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  col-md-6 no-padding <?php echo e($errors->has('shipping_address') ? 'has-error' : ''); ?>">
                                                        <?php echo e(Form::label('shipping_address', 'Shipping Address', array('class' => 'col-md-12'))); ?>

                                                        <div class="col-md-12">
                                                            <?php echo e(Form::text('shipping_address','',array('class'=>'form-control','placeholder'=>'Shipping Address','required'))); ?>

                                                            <?php if($errors->has('shipping_address')): ?>
                                                                <span class="help-block">
                            <strong><?php echo e($errors->first('shipping_address')); ?></strong>
                        </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  col-md-6 no-padding <?php echo e($errors->has('modules') ? 'has-error' : ''); ?>">
                                                        <?php echo e(Form::label('modules', 'Modules', array('class' => 'col-md-12'))); ?>

                                                        <div class="col-md-12">
                                                            <?php echo e(Form::select('modules[]',$modules,'',['class'=>'form-control select','multiple','required'])); ?>

                                                            <?php if($errors->has('modules')): ?>
                                                                <span class="help-block">
                            <strong><?php echo e($errors->first('modules')); ?></strong>
                        </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                <div class="form-group row col-md-6 <?php echo e($errors->has('logo') ? 'has-error' : ''); ?>">
                                                    <?php echo e(Form::label('logo', 'Organization Logo', array('class' => 'col-md-12'))); ?>

                                                    <div class="col-md-8">
                                                        <label class="upload_photo upload client_logo_upload no-margin" for="file4">
                                                            <img id="image_load4">
                                                        </label>
                                                        <?php echo e(Form::file('logo',array('id'=>'file4','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load4")'))); ?>

                                                        <?php if($errors->has('logo')): ?>
                                                            <span class="help-block" style="display:block">
                            <strong><?php echo e($errors->first('logo')); ?></strong>
                        </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="upload_photo upload client_favicon_upload" for="file5">
                                                            <img id="image_load5">
                                                            <i class="upload_hover ion ion-ios-camera-outline"></i>
                                                        </label>
                                                        <?php echo e(Form::file('favicon',array('id'=>'file5','style'=>'display:none','onchange'=>'loadPhoto(this,"image_load5")'))); ?>

                                                        <span> Icon </span>
                                                        <?php if($errors->has('favicon')): ?>
                                                            <span class="help-block" style="display:block">
                            <strong><?php echo e($errors->first('favicon')); ?></strong>
                        </span>
                                                        <?php endif; ?>

                                                    </div>
                                                </div>

                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <?php if(count($allCompany)>0): ?>
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
                                    <?php $__currentLoopData = $allCompany; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $i++; ?>
                                        <tr>
                                            <td><?php echo e($i); ?></td>
                                            <td><?php echo e($company->company_name); ?></td>
                                            <td><?php echo e($company->mobile_no); ?></td>
                                            <td><?php echo e($company->address); ?></td>
                                            <td> <a class="btn btn-xs btn-info" href='<?php echo e(URL::to("company-branch/$company->id   ")); ?>'> Branch <span class="badge"> <?php echo e(count($company->branch)); ?> </span> </a> </td>
                                            <td>
                                                <a class="btn btn-xs btn-success" href='<?php echo e(URL::to("storage-info/$company->id   ")); ?>' title="View All Storage"> Depot <span class="badge"> <?php echo e(count($company->companyStorage)); ?> </span> </a>
                                            </td>
                                            <td style="text-align: center">
                                                <?php echo e(Form::open(array('route'=>['company.destroy',$company->id],'method'=>'DELETE','id'=>"deleteForm$company->id"))); ?>

                                                <a href='<?php echo e(URL::to("company/$company->id/edit")); ?>' class="btn btn-info btn-xs"> <i class="fa fa-pencil-square"></i></a>
                                                <button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm('deleteForm<?php echo e($company->id); ?>')"><i class="fa fa-trash"></i></button>
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
                    <?php echo e($allCompany->render()); ?>

                    <?php else: ?>
                        <br>
                        <a class="btn btn-success" href="<?php echo e(URL::to('company-branch')); ?>"><i class="fa fa-plus-circle"></i> Branches </a>
                        <a class="btn btn-info" href="<?php echo e(URL::to('storage-info')); ?>"><i class="fa fa-plus-circle"></i> Depot </a>
                    <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
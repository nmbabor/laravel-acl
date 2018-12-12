<?php $__env->startSection('breadcrumb'); ?>
	<ul class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?php echo e(URL::to('/')); ?>">
				<i class="feather icon-home"></i>
			</a>
		</li>
		<li class="breadcrumb-item">
			<a href="<?php echo e(URL::to('acl-permission')); ?>">
				Permission
			</a>
		</li>

		<li class="breadcrumb-item">
			<a> ACL Roles</a>
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
							ACL Roles
							<div class="card-btn pull-right">
								<a  href="#modal-dialog" class="btn btn-primary btn-sm" data-toggle="modal" > <i class="fa fa-plus"></i> Add New</a>

							</div>

						</div>

                        <div class="view_uom_set">
							<!-- #modal-dialog -->
							<div class="modal fade" id="modal-dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<?php echo Form::open(array('route' => 'acl-role.store','class'=>'form-horizontal','method'=>'POST')); ?>

										<div class="modal-header">
											<h4 class="modal-title">Add New Role</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">

											<div class="form-group row">
												<label class="control-label col-md-3 col-sm-3"> Name *:</label>
												<div class="col-md-8 col-sm-8">
													<input type="text" class="form-control" name="name" value="" placeholder="Name">
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3 col-sm-3"> Description :</label>
												<div class="col-md-8 col-sm-8">
													<textarea class="form-control" name="description" rows="3" placeholder="Write some description about role"></textarea>
												</div>
											</div>

										</div>
										<div class="modal-footer">
											<a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Close</a>
											<button type="submit" class="btn btn-sm btn-success">Submit</button>
										</div>
										<?php echo Form::close();; ?>

									</div>
								</div>
							</div>
							
                        	<div class="card-body">
	                            <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
	                                <thead>
	                                    <tr>
	                                        <th width="5%">Sl</th>
	                                        <th width="40%">Role Name</th>
											<th width="20%">Slug</th>
											<th width="10%">Status</th>
											<th width="10%">Action</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                <?php $i=0; ?>
	                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                <?php $i++; ?>
	                                    <tr>
	                                        <td><?php echo e($i); ?></td>
	                                        <td><?php echo e($role->name); ?></td>
	                                        <td><?php echo e($role->slug); ?></td>
	                                        <td><?php echo e(($role->system==1)?'Active':'Inactive'); ?></td>
	                                        <td>
												<a href='<?php echo e(URL::to("acl-role/$role->id")); ?>' class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>


												<a  href="#roleModal<?php echo e($role->id); ?>" class="btn btn-primary btn-xs" data-toggle="modal" > <i class="fa fa-pencil-square"></i></a>
												<!-- #roleModal -->
												<div class="modal fade" id="roleModal<?php echo e($role->id); ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<?php echo Form::open(array('route' => ['acl-role.update',$role->id],'class'=>'form-horizontal','method'=>'PUT')); ?>

															<div class="modal-header">
																<h4 class="modal-title">Edit Role</h4>
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															</div>
															<div class="modal-body">

																<div class="form-group row">
																	<label class="control-label col-md-3 col-sm-3"> Name *:</label>
																	<div class="col-md-8 col-sm-8">
																		<input type="text" class="form-control" name="name" value="<?php echo e($role->name); ?>" placeholder="Name">
																	</div>
																</div>
																<div class="form-group row">
																	<label class="control-label col-md-3 col-sm-3"> Description :</label>
																	<div class="col-md-8 col-sm-8">
																		<textarea class="form-control" name="description" rows="3" placeholder="Write some description about role"><?php echo e($role->description); ?></textarea>
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
												
												<?php echo e(Form::open(array('route'=>['acl-role.destroy',$role->id],'method'=>'DELETE','id'=>"deleteForm$role->id",'class'=>'deleteForm'))); ?>

												<button type="button" class="btn btn-danger btn-xs" onclick="return deleteConfirm('deleteForm<?php echo e($role->id); ?>')"><i class="fa fa-trash"></i></button>
												<?php echo Form::close(); ?>

	                                        </td>
	                                    </tr>
	                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                </tbody>
	                            </table>
	                        </div>	
                        </div>
                    </div>
			    </div>
			</div>
		</div>
		<!-- end #content -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
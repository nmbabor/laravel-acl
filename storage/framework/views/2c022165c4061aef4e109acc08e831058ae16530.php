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
			<a> Branch</a>
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
						<h4 class="card-title">Branches <?php if(isset($company)): ?> of <?php echo e($company->company_name); ?> <?php endif; ?> </h4>
					</div>
					<div class="card-body">
						<!-- #modal-dialog -->
						<div class="modal fade" id="modal-dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<?php echo Form::open(array('route' => 'company-branch.store','class'=>'form-horizontal','method'=>'POST')); ?>

									<div class="modal-header">
										<h4 class="modal-title">Add New Branch</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									</div>
									<div class="modal-body">
										<div class="form-group row">
											<label class="control-label col-md-3 col-sm-3">Status :</label>
											<div class="col-md-4 col-sm-4">
												<div class="radio">
													<label>
														<input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" checked /> Active
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
										<div class="form-group row">
											<input type="hidden" value="<?php if(isset($company)): ?> <?php echo e($company->id); ?> <?php endif; ?>" name="company_id">
											<label class="control-label col-md-3 col-sm-3"> Name *:</label>
											<div class="col-md-8 col-sm-8">
												<input type="text" class="form-control" name="branch_name" value="" placeholder="Enter Branch Name">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-3 col-sm-3"> Description :</label>
											<div class="col-md-8 col-sm-8">
												<textarea class="form-control" name="description" rows="3" placeholder="Write some description about branch"></textarea>
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
						</div>

						<!--  -->
						<div class="view_branch_set">

							<table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
								<thead>
								<tr>
									<th width="5%">Sl</th>
									<th width="50%">Branch Name</th>

									<th width="15%">status</th>
									<th width="15%">Action</th>
								</tr>
								</thead>
								<tbody>
                                <?php $i=0; ?>
								<?php $__currentLoopData = $allData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $i++; ?>
									<tr class="odd gradeX">
										<td><?php echo e($i); ?></td>
										<td><?php echo e($branch->branch_name); ?></td>

										<td>
											<?php if($branch->status=="1"): ?>
												<?php echo e("Active"); ?>

											<?php else: ?>
												<?php echo e("Inactive"); ?>

											<?php endif; ?>
										</td>
										<td>
											<!-- edit section -->
											<a href="#modal-dialog<?php echo $branch->id;?>" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											<!-- #modal-dialog -->
											<div class="modal fade" id="modal-dialog<?php echo $branch->id;?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<?php echo Form::open(array('route' => ['company-branch.update',$branch->id],'class'=>'form-horizontal author_form','method'=>'PUT','files'=>'true', 'id'=>'commentForm','role'=>'form','data-parsley-validate novalidate')); ?>

														<div class="modal-header">
															<h4 class="modal-title">Edit Branch</h4>
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														</div>
														<div class="modal-body">

															<div class="form-group row">
																<label class="control-label col-md-3 col-sm-3" for="branch_name">Name * :</label>
																<div class="col-md-8 col-sm-8">
																	<input class="form-control" type="text" id="branch_name" name="branch_name" value="<?php echo $branch->branch_name; ?>" data-parsley-required="true" />
																</div>
															</div>

															<div class="form-group row">
																<label class="control-label col-md-3 col-sm-3">Status :</label>
																<div class="col-md-4 col-sm-4">
																	<div class="radio">
																		<label>
																			<input type="radio" name="status" value="1" id="radio-required" data-parsley-required="true" <?php if($branch->status=="1"): ?><?php echo e("checked"); ?><?php endif; ?>> Active
																		</label>
																	</div>
																</div>
																<div class="col-md-4 col-sm-4">
																	<div class="radio">
																		<label>
																			<input type="radio" name="status" id="radio-required2" value="0" <?php if($branch->status=="0"): ?><?php echo e("checked"); ?><?php endif; ?>> Inactive
																		</label>
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label col-md-3 col-sm-3"> Description :</label>
																<div class="col-md-8 col-sm-8">
																	<textarea class="form-control" name="description" rows="3" placeholder="Write some description about branch"><?php echo e($branch->description); ?></textarea>
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
											<?php echo e(Form::open(array('route'=>['company-branch.destroy',$branch->id],'method'=>'DELETE','class'=>'deleteForm','id'=>"deleteForm$branch->id"))); ?>


											<button type="button" class="btn btn-danger btn-xs" onclick='return deleteConfirm("deleteForm<?php echo e($branch->id); ?>")'><i class="fa fa-trash"></i></button>
										<?php echo Form::close(); ?>

										<!-- delete section end -->
										</td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
							<?php echo e($allData->render()); ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- end #content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
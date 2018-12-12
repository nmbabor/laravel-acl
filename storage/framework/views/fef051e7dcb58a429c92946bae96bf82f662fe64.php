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
        <style type="text/css">

            .all-emp{display: none;}
        </style>
		<!-- begin #content -->
		<div id="content" class="content">
			<div class="row">
			    <div class="col-md-12 no-padding">
                    <div class="card">
                        <div class="card-header card-info">
                            All Employee
                            <div class="card-heading-btn pull-right">

                                <a class="btn btn-primary btn-sm" href="<?php echo e(URL::to('export-employee')); ?>" data-toggle="modal" data-target="#exportEmployee"> <i class="fa fa-file-excel-o"></i> Export </a>
                                <a class="btn btn-primary btn-sm" href="<?php echo e(URL::to('/employees/create')); ?>"> <i class="fa fa-plus-circle"></i> Add New Employee </a>
                                <a href="javascript:;" onclick="printPage('print_body')" class="printbtn btn btn-success btn-sm"><i class="fa fa-print"></i> Print</a>
                                
                            </div>

                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exportEmployee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Export Employee List</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <?php echo Form::open(['url'=>'export-employee','method'=>'GET','files'=>true]); ?>

                                    <div class="modal-body">
                                        <label> Select Section : </label>
                                        <?php echo e(Form::select('section_id',$section,'',['class'=>'form-control','placeholder'=>'All'])); ?>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                        <div class="card-body min-padding">
                             <div id="print_body" style="width: 100%;overflow: hidden;">
                

                            <?php echo $__env->make('pad.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <style type="text/css">
                              @media  print {
                                      @page  {
                                          size: auto;   /* auto is the initial value */
                                          margin: 5mm;  /* this affects the margin in the printer settings */
                                      }
                                      .invoice_top_left{display: block;}
                                  .btn-group {display: none;}
                                  
                                  .printbtn {display: none;}
                                  .unprint {display: none;}
                                  .dataTables_length {display: none;}
                                  .dataTables_filter {display: none;}
                                  .dataTables_info {display: none;}
                                  .dataTables_paginate{display: none;}
                                  .card-title {display: none;}
                                  table.dataTable thead .sorting_asc:after {display: none;}
                                  table tr td:last-child{display: none;}
                                  .all-emp{display: block;}
                              }
                            </style>
                            <h5 align="center" class="all-emp">All Employee</h5>
                                 <div class="table-responsive">
                                     <table id="all_data" class="table table-striped table-bordered nowrap" width="100%">
                                         <thead>
                                         <tr>
                                             <th width="5%">#ID</th>
                                             <th>Employee Name</th>
                                             <th>Designation</th>
                                             <th>Section</th>
                                             <th>Mobile</th>
                                             <th width="10%">Photo</th>
                                             <th class="no-print">Action</th>
                                         </tr>
                                         </thead>

                                     </table>
                                 </div>
                        </div>
                        </div>
                    </div>
			    </div>
			</div>
		</div>		
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('public/js/printThis.js')); ?>"></script>
<script type="text/javascript">
    function printPage(id){
        $('#'+id).printThis();
    }
</script>
<script type="text/javascript">
    $(function() {
        $('#all_data').DataTable( {
            processing: true,
            serverSide: true,
            ajax: '<?php echo URL::asset("employees/show"); ?>',
            columns: [
                { data: 'employee_id'},
                { data: 'name',name:'users.name'},
                { data: 'designation'},
                { data: 'section_name',name:'hrm_employee_sections.section_name'},
                { data: 'phone_number',name:'users.phone_number'},
                { data: 'photo'},
                { data: 'action'}
            ]
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
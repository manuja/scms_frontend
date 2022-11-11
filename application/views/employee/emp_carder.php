<section class="content">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-briefcase text-orange"></i>
                    <h3 class="box-title">Employee Carder</h3>
                    <div class="box-tools">
                        <?php if ($this->userpermission->checkUserPermissions2('emp_update_carder')) { ?>
                            
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_emp_carder">
                                Edit Carder
                              </button>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <table class="table table-striped emp_carder_table" id="emp_carder_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>                                       
                                        <th style="width: 20%">Designation</th>
                                        <th style="width: 20%">No of designation allowed</th>
                                        <th style="width: 55%">No of filled</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

<div class="modal fade" id="edit_emp_carder"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Update Employee Carder</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_emp_promotion" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/updateEmployeeCarder') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Designation</label><br />
                                <select class="select-dropdown-tags form-control" name="designation" id="designation" style="width: 100%">
                                    <option value="">Select...</option>
                                    <?php
                                    foreach ($designation_list as $designation) {?>
                                        <option value="<?php echo $designation->designation_id; ?>"><?php echo $designation->designation; ?></option>
                                    <?php }
                                    ?>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No of designation allowed</label>
                                <input value="" class="form-control" name="no_allowed" id="no_allowed"/> 
                            </div>
                        </div>
                    </div>
                </div>
             
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
<!-- /.content-wrapper -->
<section class="content">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-users text-orange"></i>
                    <h3 class="box-title">Employees</h3>
                    <div class="box-tools">
                        <?php if ($this->userpermission->checkUserPermissions2('emp_create')) { ?>
                            <a href="<?php echo site_url('employee/employee-details'); ?>" class="btn btn-primary"> Add Employee</a>
                        <?php } ?>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <table class="table table-striped emp_list_table" id="emp_list_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Employee ID</th>                                       
                                        <th style="width: 20%">Employee Name</th>
                                        <th style="width: 10%">Division</th>
                                        <th style="width: 10%">Job Title</th>
                                        <th style="width: 10%">Employment Status</th>
                                        <th style="width: 20%">Actions</th>
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

<div class="modal fade" id="emp_promotion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Employee Promotions</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_emp_promotion" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/savePromotion') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input value="" class="form-control" name="pomo_emp_name" id="pomo_emp_name" readonly/> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee ID</label>
                                <input value="" class="form-control" name="promo_emp_id" id="promo_emp_id" readonly/> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>New Designation *</label>
                                <select class="form-control" name="designation" id="designation" required="">
                                    <option value="">Select...</option>
                                    <?php 
                                        foreach ($designation_list as $designation){?>
                                       <option value="<?php echo $designation->designation_id ?>" ><?php echo $designation->designation; ?></option>
                                        <?php }
                                       ?>
                                </select>
                                 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>From *</label>
                                <input value="" class="form-control datepicker" name="promo_from" id="promo_from" required=""/> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Salary Code *</label>
                                <input value="" class="form-control" name="salary_code" id="salary_code" required=""/> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>New Grade *</label>
                                <select  name="new_grade" id="new_grade" class="form-control" required>
                                    <option value="">Select...</option>
                                    <?php foreach ($grade_list as $grade){ ?>
                                        <option value="<?php echo $grade->emp_grade_id; ?>" ><?php echo $grade->grade; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comment *</label>
                                <textarea class="form-control" name="promo_comment" id="promo_comment" required=""> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Uploads <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                <input type="file" value="" class="form-control-file" name="promo_doc" id="promo_doc"/> 
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="promo_emp_profile_id" id="promo_emp_profile_id" value=""/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="emp_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Employee Leave Update</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_emp_leave" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/saveEmployeeLeave') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input value="" class="form-control" name="emp_name" id="leave_emp_name" readonly/> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee ID</label>
                                <input value="" class="form-control" name="emp_id" id="leave_emp_id" readonly/> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Leave Type *</label>
                                <select class="form-control" name="leave_type" required="">
                                    <option value="">Select...</option>
                                    <option value="1">Annual leave</option>
                                    <option value="2">Casual leave</option>
                                    <option value="3">Medical leave</option>
                                    <option value="4">Maternity leave</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>From *</label>
                                <input value="" class="form-control datepicker" name="leave_from" required=""/> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>To *</label>
                                <input value="" class="form-control datepicker" name="leave_to" required=""/> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comment *</label>
                                <textarea class="form-control" name="comment" required=""> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Uploads <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                <input type="file" value="" class="form-control-file" name="leave_doc" id="leave_doc"/> 
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="leave_emp_profile_id" id="leave_emp_profile_id" value=""/>
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
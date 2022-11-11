
<section class="content">
    <?php $this->load->view('employee/emp_form_tab'); ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!--/<i class="fa fa-users text-orange"></i>-->
                    <h3 class="box-title">Academic / Professional Qualification</h3>

                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <form id="form_emp_academic" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/saveAcademicQualification') ?>">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Degree Level *</label>
                                                    <select  name="degree_level" id="degree_level" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <?php foreach ($degree_levels as $degree_level) { ?>
                                                            <option value="<?php echo $degree_level->emp_degree_level_id; ?>"><?php echo $degree_level->degree_level; ?></option>
                                                        <?php }
                                                        ?>

                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Field *</label>
                                                    <input type="text" name="field" id="field" class="form-control" value="" required />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">University *</label>
                                                    <input type="text" name="university" id="university" class="form-control" value="" required />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Started on *</label>
                                                    <input type="text" name="start_date" id="start_date" class="form-control datepicker" required=""  value="">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Upload Document <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                                    <input type="file" name="academic_doc" class="form-control-file" value="">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Ended on *</label>
                                                    <input type="text" name="end_date" id="end_date" class="form-control datepicker" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <input  name="profile_id" value="<?php echo $profile_id; ?>" type="hidden"/>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group  pull-right">
                                                    <a href="<?php echo base_url('employee/employment_details/' . $profile_id); ?>" class="btn btn-danger"><i class="fa fa-step-backward" aria-hidden="true"></i> Back</a>&nbsp;
                                                    <button type="submit" class="btn btn-success">Save</button>&nbsp;                                                    
                                                    <a href="<?php echo base_url('employee/former-employee-details/' . $profile_id); ?>" class="btn btn-info"> Next <i class="fa fa-step-forward" aria-hidden="true"></i></a></a>&nbsp;                                                    
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="panel-body">
                                    <h4>Added Records</h4>
                                    <?php if ($academic_data) { ?>
                                        <table class="table">
                                            <tr>
                                                <th>Degree Level</th>
                                                <th>Field</th>
                                                <th>University</th>
                                                <th>Started on</th>
                                                <th>Ended on</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php foreach ($academic_data as $row) { ?>
                                                <tr>
                                                    <td><?php echo $row->emp_degree_level; ?></td>
                                                    <td><?php echo $row->field; ?></td>
                                                    <td><?php echo $row->university; ?></td>
                                                    <td><?php echo $row->start_date; ?></td>
                                                    <td><?php echo $row->end_date; ?></td>
                                                    <td>
                                                        <button class="btn btn-info btn_view" data-id="<?php echo $row->emp_academic_id; ?>" id="btn_view" title="View"><i class="fa fa-eye"></i></button>
                                                        <?php if($this->userpermission->checkUserPermissions2('emp_edit_academic')){ ?>
                                                        <button class="btn btn-warning btn_view" data-id="<?php echo $row->emp_academic_id; ?>" id="btn_edit" title="Edit"><i class="fa fa-pencil"></i></button>
                                                        <?php } ?>
                                                        <?php if($this->userpermission->checkUserPermissions2('emp_delete_academic')){ ?>
                                                        <button class="btn btn-danger delete_btn" data-id="<?php echo $row->emp_academic_id; ?>" id="delete_btn" title="Delete"><i class="fa fa-trash"></i></button>
                                                        <?php } ?>
                                                    </td>

                                                </tr> 
                                            <?php }
                                            ?>

                                        </table>
                                        <?php
                                        } else {
                                            echo "There is no added records.";
                                        }
                                        ?>
                                </div>  

                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
<div class="modal fade" id="academic_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Academic / Professional Qualification</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_emp_academic" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/updateAcademicQualification') ?>">                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Degree Level *</label>
                                <select  name="degree_level" id="old_degree_level" class="form-control" required>
                                    <option value="">Select...</option>
                                    <?php foreach ($degree_levels as $degree_level) { ?>
                                        <option value="<?php echo $degree_level->emp_degree_level_id; ?>"><?php echo $degree_level->degree_level; ?></option>
                                    <?php }
                                    ?>

                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Field *</label>
                                <input type="text" name="field" id="old_field" class="form-control" value="" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">University *</label>
                                <input type="text" name="university" id="old_university" class="form-control" value="" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Started on *</label>
                                <input type="text" name="start_date" id="old_start_date" class="form-control datepicker"  value="">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Upload Document <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                <input type="file" name="academic_doc" id="academic_doc" class="form-control-file">
                                <input type="hidden" name="old_academic_doc" value=""/>
                                <span id="view_doc"></span>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Ended on *</label>
                                <input type="text" name="end_date" id="old_end_date" class="form-control datepicker" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <input  name="emp_academic_id" id="emp_academic_id" value="" type="hidden"/>
                    <input  name="profile_id" value="<?php echo $profile_id; ?>" type="hidden"/>
                    
                </div>               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success update_btn" id="update_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
<!-- /.content-wrapper -->
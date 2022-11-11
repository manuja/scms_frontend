
<section class="content">
    <?php $this->load->view('employee/emp_form_tab'); ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!--/<i class="fa fa-users text-orange"></i>-->
                    <h3 class="box-title">Employment Details</h3>
                   
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <form id="form_employment_dtails" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php if($is_edit){ echo base_url('EmployeeController/updateEmploymentDetails'); }else { echo base_url('EmployeeController/saveEmploymentDetails');} ?>">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Joined Date *</label>
                                                    <input type="text" name="joined_date" id="joined_date" class="form-control datepicker" value="<?php if($is_edit){ echo $emplyment_data[0]->joined_date; } ?>" required >
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Permanency Date *</label>
                                                    <input type="text" name="permanency_date" id="permanency_date" class="form-control datepicker" value="<?php if($is_edit){ echo $emplyment_data[0]->permanency_date; } ?>" required />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Job Title *</label>
                                                    <select  name="job_title" id="job_title" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <?php 
                                                         foreach ($designation_list as $designation){?>
                                                        <option value="<?php echo $designation->designation_id ?>" <?php if($is_edit){ if($designation->designation_id == $emplyment_data[0]->job_title){ echo 'selected';} } ?>><?php echo $designation->designation; ?></option>
                                                         <?php }
                                                        ?>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Employment Status *</label>
                                                    <select  name="emp_status" id="emp_status" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <option value="1" <?php if($is_edit){ if($emplyment_data[0]->employment_status == '1'){ echo 'selected';} } ?>>Temporary</option>
                                                        <option value="2"  <?php if($is_edit){ if($emplyment_data[0]->employment_status == '2'){ echo 'selected';} } ?>>Full time</option>
                                                        <option value="3"  <?php if($is_edit){ if($emplyment_data[0]->employment_status == '3'){ echo 'selected';} } ?>>Contract</option>
                                                        <option value="4"  <?php if($is_edit){ if($emplyment_data[0]->employment_status == '4'){ echo 'selected';} } ?>>Permanent</option>
                                                        <option value="5"  <?php if($is_edit){ if($emplyment_data[0]->employment_status == '5'){ echo 'selected';} } ?>>Probation</option>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Division *</label>
                                                    <select  name="division" id="division" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <?php foreach ($divisions as $division){ ?>
                                                            <option value="<?php echo $division['division_id']; ?>"  
                                                                <?php if($is_edit){ 
                                                                        if($division['division_id'] == $emplyment_data[0]->division){ echo 'selected'; }
                                                                        }else if($division['division_id'] == $emp_division){ echo 'selected'; } ?>
                                                                    ><?php echo $division['division_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Sub Division *</label>
                                                    <select  name="sub_division" id="sub_division" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <?php foreach ($sub_divisions as $sub_division){ ?>
                                                            <option value="<?php echo $sub_division['sub_division_id']; ?>"
                                                                    <?php if($is_edit){ 
                                                                        if($sub_division['sub_division_id'] == $emplyment_data[0]->sub_division){ echo 'selected'; }
                                                                        }else if($sub_division['sub_division_id'] == $emp_sub_division){ echo 'selected'; } ?>
                                                                    ><?php echo $sub_division['sub_division_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Grade *</label>
                                                    <select  name="grade" id="grade" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <?php foreach ($grade_list as $grade){ ?>
                                                            <option value="<?php echo $grade->emp_grade_id; ?>"  <?php if($is_edit){ if($grade->emp_grade_id == $emplyment_data[0]->grade){ echo 'selected';} } ?>><?php echo $grade->grade; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Class *</label>
                                                    <select  name="class" id="class" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <?php foreach ($class_list as $class){ ?>
                                                            <option value="<?php echo $class->emp_class_id; ?>" <?php if($is_edit){ if($class->emp_class_id == $emplyment_data[0]->class){ echo 'selected';} } ?>><?php echo $class->class; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Salary Code *</label>
                                                    <input type="text" name="salary_code" id="salary_code" class="form-control" value="<?php if($is_edit){ echo $emplyment_data[0]->salary_code; } ?>" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Effective From *</label>
                                                    <input type="text" name="salary_effective_from" id="salary_effective_from" class="form-control datepicker" required value="<?php if($is_edit){ echo $emplyment_data[0]->effective_from; } ?>">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Supervisor *</label>
                                                     <select  name="supervisor[]" id="supervisor" multiple="multiple" class="form-control js-multiple" required>
                                                        <?php
                                                        if($supervisor_list){
                                                            foreach ($supervisor_list as $supervisor){?>
                                                         <option value="<?php echo $supervisor->user_profile_id; ?>" <?php if (in_array($supervisor->user_profile_id, $supervisor_arr)) { echo 'selected'; } ?>><?php echo $supervisor->employee_no.' | '.$supervisor->name_w_initials ?></option> 
                                                         <?php   }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Office ID Issue Date</label>
                                                    <input type="text" name="id_issue_date" id="id_issue_date" class="form-control datepicker" value="<?php if($is_edit){ echo $emplyment_data[0]->ID_issue_date; } ?>">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label><input type="checkbox" name="add_contract_details" id="add_contract_details" <?php if($is_edit && $emplyment_data[0]->contract_start_date != '0000-00-00'){ echo 'checked'; } ?>/>&nbsp; Include Contract Details</label>
                                                <div class="col-sm-12 contact_details" <?php if(!$is_edit || $emplyment_data[0]->contract_start_date == '0000-00-00'){?>style="display: none"<?php } ?>>
                                                    <div class="form-group">
                                                        <label for="">Start Date *</label>
                                                        <input type="text" name="contract_start" id="contract_start" class="form-control datepicker" value="<?php if($is_edit){ echo $emplyment_data[0]->contract_start_date; } ?>"> 
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 contact_details" <?php if(!$is_edit || $emplyment_data[0]->contract_start_date == '0000-00-00'){?>style="display: none"<?php } ?>>
                                                    <div class="form-group">
                                                        <label for="">End Date *</label>
                                                        <input type="text" name="contract_end" id="contract_end" class="form-control datepicker" value="<?php if($is_edit){ echo $emplyment_data[0]->contract_end_date; } ?>">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <?php if($is_edit){?>
                                            <input name="emp_employment_id" value="<?php echo $emplyment_data[0]->emp_employment_id; ?>" type="hidden"/>
                                        <?php }else{ ?>
                                            <input name="emp_employment_id" value="0" type="hidden"/>
                                        <?php } ?>
                                            <input name="profile_id" value="<?php echo $profile_id ?>" type="hidden"/>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group  pull-right">
                                                    <a href="<?php echo base_url('employee/employee-details/'.$profile_id); ?>" class="btn btn-danger"><i class="fa fa-step-backward" aria-hidden="true"></i> Back</a>&nbsp;
                                                    <button type="submit" id="save_employment" class="btn btn-success">Save & Continue</button>&nbsp; 
                                                    <a href="<?php echo base_url('employee/academic-details/'.$profile_id); ?>" class="btn btn-info">Next <i class="fa fa-step-forward" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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



</div>
<!-- /.content-wrapper -->
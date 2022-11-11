
<section class="content">
    <?php $this->load->view('employee/emp_form_tab'); ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!--/<i class="fa fa-users text-orange"></i>-->
                    <h3 class="box-title">Employee Details</h3>
                   
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <form id="form_employee_details" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php if($is_edit){ echo base_url('EmployeeController/updateEmployee'); }else{ echo base_url('EmployeeController/saveEmployee'); } ?>">
                                        <input type="hidden" name="profile_id" value="<?php echo $profile_id; ?>"/>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Employee ID *</label>
                                                    <input type="text" name="emp_id" id="emp_id" class="form-control" value="<?php if($is_edit){ echo $profile_data->employee_no;} ?>" required <?php if($is_edit){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">NIC </label>
                                                    <input type="text" name="nic" id="nic" class="form-control" value="<?php if($is_edit){ echo $profile_data->nic;} ?>" 
                                                           pattern="([0-9]{9})([0-9]{3}|V|v|X|x)"
                                                        data-pattern-error="Please enter a valid NIC number"/>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Initials *</label>
                                                    <input type="text" name="name_initials" id="name_initials" class="form-control" value="<?php if($is_edit){ echo $profile_data->initials;} ?>" required />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Last Name *</label>
                                                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?php if($is_edit){ echo $profile_data->last_name;} ?>" required />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Name denoted by initials *</label>
                                                    <input type="text" name="name_donoted_initial" id="name_donoted_initial" class="form-control" value="<?php if($is_edit){ echo $profile_data->name_by_initials;} ?>" required="">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Email Address</label>
                                                    <input type="email" name="email" id="email" class="form-control" value="<?php if($is_edit){ echo $profile_data->email;} ?>" 
                                                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                           data-pattern-error="Please enter a valid Email Address">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Gender *</label>
                                                    <select  name="gender" id="gender" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <option value="1" <?php if($is_edit){ if($profile_data->gender == '1'){echo 'selected'; }} ?>>Male</option>
                                                        <option value="2" <?php if($is_edit){ if($profile_data->gender == '2'){echo 'selected'; }} ?>>Female</option>
                                                    </select>
                                                    <!--<input type="text" name="sub_division" id="sub_division" class="form-control">-->
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">DOB *</label>
                                                    <input type="text" name="dob" id="dob" class="form-control datepicker" value="<?php if($is_edit){ echo $profile_data->dob;} ?>" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Martial Status *</label>
                                                    <select  name="marital_status" id="marital_status" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <option value="1" <?php if($is_edit){ if($profile_data->marital_status == '1'){echo 'selected'; }} ?>>Single</option>
                                                        <option value="2" <?php if($is_edit){ if($profile_data->marital_status == '2'){echo 'selected'; }} ?>>Married</option>
                                                        <option value="3" <?php if($is_edit){ if($profile_data->marital_status == '3'){echo 'selected'; }} ?>>Separate</option>
                                                        <option value="4" <?php if($is_edit){ if($profile_data->marital_status == '4'){echo 'selected'; }} ?>>Divorced</option>
                                                        
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Contact Number</label>
                                                    <input type="text" name="contact_number" id="contact_number" class="form-control" value="<?php if($is_edit){ echo $profile_data->contact_number;} ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Address 1 *</label>
                                                    <input type="text" name="add_1" id="add_1" class="form-control" value="<?php if($is_edit){ echo $profile_data->address_1;} ?>" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Address 2</label>
                                                    <input type="text" name="add_2" id="add_2" class="form-control" value="<?php if($is_edit){ echo $profile_data->address_2;} ?>" >
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Province *</label>
                                                    <select  name="province" id="province" class="form-control" required>
                                                        <option value="">Select...</option>
                                                        <?php foreach ($sl_province as $provice){?>
                                                            <option value="<?php echo $provice->sl_provinces_id; ?>" <?php if($is_edit){ if($provice->sl_provinces_id == $profile_data->province){echo 'selected'; }} ?>><?php echo $provice->province_name; ?></option>
                                                        <?php } ?>
                                                        
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">City *</label>
                                                    <input type="text" name="city" id="city" class="form-control" value="<?php if($is_edit){ echo $profile_data->city;} ?>" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Zip Code *</label>
                                                    <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?php if($is_edit){ echo $profile_data->zip_code;} ?>" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Nationality *</label>
                                                    <select  name="nationality" id="nationality" class="form-control select-dropdown-tags" required>
                                                        <option value="">Select...</option>
                                                        <?php foreach ($nationalities as $nationality){?>
                                                            <option value="<?php echo $nationality->nationality_id; ?>" <?php if($is_edit){ if($nationality->nationality_id == $profile_data->nationality){echo 'selected'; }} ?>><?php echo $nationality->nationality; ?></option>
                                                        <?php } ?>
                                                        
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Blood group</label>
                                                    <select  name="blood_group" id="blood_group" class="form-control">
                                                        <option value="">Select...</option>
                                                        <?php foreach ($blood_groups as $blood_group){?>
                                                            <option value="<?php echo $blood_group->blood_group_id; ?>" <?php if($is_edit){ if($blood_group->blood_group_id == $profile_data->blood_group){echo 'selected'; }} ?>><?php echo $blood_group->blood_group; ?></option>
                                                        <?php } ?>
                                                        
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group  pull-right">
                                                    <a href="<?php echo base_url('employees'); ?>" class="btn btn-danger">Cancel</a>&nbsp;
                                                    <button type="submit" id="save_emp_details" class="btn btn-success">Save & Continue</button>&nbsp;                                                    
                                                    <?php if($profile_id){ ?><a href="<?php echo base_url('employee/employment_details/'.$profile_id); ?>" class="btn btn-info"> Next <i class="fa fa-step-forward" aria-hidden="true"></i></a><?php } ?>
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
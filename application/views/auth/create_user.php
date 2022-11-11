
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
          <div class="box-header">
            <i class="fa fa-users text-orange"></i>
            <h3 class="box-title">Add User</h3>
          </div>
          <div class="box-body">
            <div class="container col-12 col-sm-10 col-md-9 d-flex flex-column align-items-center">
              <?php 
                  //Errors generated after validation
                  $errors=$this->form_validation->error_array();

                  $attributes = array('class' => 'col-sm-10');
              ?>
            
                <form id="reg_form" method="post" action="<?php echo base_url("auth/create_user") ?>">
                <!-- Validation error for first name-->
                <div class="row">
                  <label class="col-form-label col-sm-4 col-md-3 col-lg-2"></label>
                  <div class="input-group col-sm-8 col-md-9 col-lg-10">
                    <div style="color: red;"><?php if(isset($errors['first_name'])){ echo $errors['first_name'];} ?></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-sm-4 col-md-3 col-lg-2">First Name *</label>
                  <div class="col-sm-8 col-md-9 col-lg-10">
                      <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <?php echo form_input($first_name);?>
                      </div>
                       <div class="help-block with-errors"></div>
                  </div>
                </div>
                

                <!-- Validation error for last name-->
                <div class="row">
                  <label class="col-form-label col-sm-4 col-md-3 col-lg-2"></label>
                  <div class="input-group col-sm-8 col-md-9 col-lg-10">
                    <div style="color: red;"><?php if(isset($errors['last_name'])){ echo $errors['last_name'];} ?></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-sm-4 col-md-3 col-lg-2">Last Name *</label>
                  <div class="col-sm-8 col-md-9 col-lg-10">
                      <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <?php echo form_input($last_name);?>
                  </div>
                       <div class="help-block with-errors"></div>
                  </div>
                </div>
                
                <!-- Validation error for name with initials-->
                <div class="row">
                  <label class="col-form-label col-sm-4 col-md-3 col-lg-2"></label>
                  <div class="input-group col-sm-8 col-md-9 col-lg-10">
                    <div style="color: red;"><?php if(isset($errors['name_initials'])){ echo $errors['name_initials'];} ?></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-sm-4 col-md-3 col-lg-2">Name with Initials *</label>
                  <div class="col-sm-8 col-md-9 col-lg-10">
                      <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <?php echo form_input($name_initials);?> 
                      </div>
                       <div class="help-block with-errors"></div>
                  </div>
                </div>
                
     
                <!-- Validation error for nic-->
                <div class="row">
                  <label class="col-form-label col-sm-4 col-md-3 col-lg-2"></label>
                  <div class="input-group col-sm-8 col-md-9 col-lg-10">
                    <div style="color: red;"><?php if(isset($errors['nic'])){ echo $errors['nic'];} ?></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-sm-4 col-md-3 col-lg-2">NIC/Passport *</label>
                  <div class="xcol-sm-8 col-md-9 col-lg-10">
                      <div class="input-group">
                        <span class="input-group-addon">
                        <i class="fa fa-id-card-o"></i>
                        </span>
                        <?php echo form_input($nic);?> 
                      </div>
                    <div class="help-block with-errors"></div>
                  </div>
                   
                </div>
                
                <!-- Validation error for email-->
                <div class="row">
                  <label class="col-form-label col-sm-4 col-md-3 col-lg-2"></label>
                  <div class="input-group col-sm-8 col-md-9 col-lg-10">
                    <div style="color: red;"><?php if(isset($errors['email'])){ echo $errors['email'];} ?></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-sm-4 col-md-3 col-lg-2">Email </label>
                  <div class="col-sm-8 col-md-9 col-lg-10">
                      <div class="input-group">
                            <span class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                          </span>
                          <?php echo form_input($email);?> 
                      </div>
                      <div class="help-block with-errors"></div>
                  </div>
                </div>
                
                <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group  pull-right">
                                                <a href="<?php echo base_url().'users/'?>" class="btn btn-danger">cancel</a>
                                                    <button type="button" id="form_submit"  class="btn btn-success">Save User</button>&nbsp;                                                    
                                                </div>
                                            </div>
                                        </div>
                
                </form>
          </div>

          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


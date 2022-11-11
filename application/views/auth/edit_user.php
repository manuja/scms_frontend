<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-users text-orange"></i>

            <h3 class="box-title"><?php echo $pagetitle; ?></h3>


        </div>

        <?php
//            echo '<pre>';
//            print_r();
//            exit;
        ?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div id="infoMessage"><?php echo $message; ?></div>
                    <?php
                    //print_r($this->form_validation->error_array());
                    $errors = $this->form_validation->error_array();
                    ?>
                    <?php //  echo form_open(uri_string()); ?>
                    <form id="reg_form" method="post" action="<?php echo base_url('auth/edit_user/'.$user->id) ?>">
                    <div class="form-group">
                        <label>First Name *</label> <br />
                        <input name="first_name" value="<?php echo $user->first_name; ?>" id="first_name" class="form-control" required=""/>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label>Last Name *</label> <br />
                        <input name="last_name" value="<?php echo $user->last_name; ?>" id="last_name" class="form-control" required=""/>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label>Name with initials *</label> <br />
                        <input name="name_initials" value="<?php echo $user->name_initials; ?>" id="name_initials" class="form-control" required=""/>
                        <div class="help-block with-errors"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">NIC</label>
                          <input type="text" id="nic" class="form-control"
                              name="nic" pattern="([0-9]{9})([0-9]{3}|V|v|X|x)"
                              data-pattern-error="Please enter a valid NIC number"
                              value="<?php echo $user->nic ?>" required="">
                      
                         <div class="help-block with-errors"></div>
                      </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                          <input type="text" id="email" class="form-control"
                              name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                              data-pattern-error="Please enter a valid Email"
                              <input type="text" id="email" class="form-control"
                              name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                              data-pattern-error="Please enter a valid Email Address"
                              value="<?php echo $user->username ?>" >
                      
                         <div class="help-block with-errors"></div>
                      </div>

                    <?php echo form_hidden('id', $user->id); ?>
<?php echo form_hidden($csrf); ?>
                        <br />
                        <!-- <button class="btn btn-primary  btn-flat" id="form_submit">Save User</button>      -->
                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group  pull-right">
                                                <a href="<?php echo base_url().'users/'?>" class="btn btn-danger">cancel</a>
                                                    <button type="button" id="form_submit"  class="btn btn-info btn-flat">Update User</button>&nbsp;                                                    
                                                </div>
                                            </div>
                                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

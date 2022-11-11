<?php
$success = $this->session->userdata('success');
if ($success != "") {
?>

  <div class="alert alert-success " role="alert">
    <?php echo $success; ?>
    <button type="button" id="alertbtt" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php
}
?>

<?php
$failure = $this->session->userdata('failure');
if ($failure != "") {
?>
  <div class="alert alert-warning " role="alert">
    <?php echo $failure; ?>
    <button type="button" id="alertbtt" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php
}
?>

<style>
 #loader-4 span{
  display: inline-block;
  width: 20px;
  height: 20px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 5px;
  opacity: 0;
}

#loader-4 span:nth-child(1){
  animation: opacitychange 1s ease-in-out infinite;
}

#loader-4 span:nth-child(2){
  animation: opacitychange 1s ease-in-out 0.33s infinite;
}

#loader-4 span:nth-child(3){
  animation: opacitychange 1s ease-in-out 0.66s infinite;
}

@keyframes opacitychange{
  0%, 100%{
    opacity: 0;
  }

  60%{
    opacity: 1;
  }
}
    </style>
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
        $errors = $this->form_validation->error_array();

        $attributes = array('class' => 'col-sm-10');
        ?>

        <form id="form_member_registration" method="POST" enctype="multipart/form-data" data-toggle="validator" action="<?php echo base_url('index.php/add-members') ?>" role="form">







          <div class="row">





            <div class="col-sm-6">

              <label></label>
              <div class="input-group">
                <div style="color: red;"><?php if (isset($errors['title'])) {
                                            echo $errors['title'];
                                          } ?></div>
              </div>



              <div class="form-group">
                <label>Title *</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </span>
                  <?php echo form_input($title); ?>
                </div>
                <div class="help-block with-errors"></div>
              </div>
            </div>






            <div class="col-sm-6">


              <label></label>
              <div class="input-group">
                <div style="color: red;"><?php if (isset($errors['firstname'])) {
                                            echo $errors['firstname'];
                                          } ?></div>
              </div>


              <div class="form-group">
                <label>First Name *</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </span>
                  <?php echo form_input($first_name); ?>
                </div>
                <div class="help-block with-errors"></div>
              </div>


            </div>

          </div>


          <div class="row">


            <div class="col-sm-6">

              <label></label>
              <div class="input-group">
                <div style="color: red;"><?php if (isset($errors['lastname'])) {
                                            echo $errors['lastname'];
                                          } ?></div>
              </div>



              <div class="form-group">
                <label>Last Name *</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </span>
                  <?php echo form_input($last_name); ?>
                </div>
                <div class="help-block with-errors"></div>
              </div>
            </div>






            <div class="col-sm-6">


              <label></label>
              <div class="input-group">
                <div style="color: red;"><?php if (isset($errors['intialname'])) {
                                            echo $errors['intialname'];
                                          } ?></div>
              </div>


              <div class="form-group">
                <label>Name With Intials *</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </span>
                  <?php echo form_input($name_initials); ?>
                </div>
                <div class="help-block with-errors"></div>
              </div>


            </div>


          </div>


          <div class="row">


            <div class="col-sm-6">

              <label></label>
              <div class="input-group">
                <div style="color: red;"><?php if (isset($errors['address1'])) {
                                            echo $errors['address1'];
                                          } ?></div>
              </div>



              <div class="form-group">
                <label>Address 1 *</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                  </span>
                  <?php echo form_input($Address1); ?>
                </div>
                <div class="help-block with-errors"></div>
              </div>
            </div>






            <div class="col-sm-6">


              <label></label>
              <div class="input-group">
                <div style="color: red;"><?php if (isset($errors['address2'])) {
                                            echo $errors['address2'];
                                          } ?></div>
              </div>


              <div class="form-group">
                <label>Address 2 *</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                  </span>
                  <?php echo form_input($Address2); ?>
                </div>
                <div class="help-block with-errors"></div>
              </div>


            </div>


          </div>






          <div class="row">


            <div class="col-sm-6">

              <label></label>
              <div class="input-group">
                <div style="color: red;"><?php if (isset($errors['nic'])) {
                                            echo $errors['nic'];
                                          } ?></div>
              </div>



              <div class="form-group">
                <label>NIC/Passport No *</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-id-card-o"></i>
                  </span>
                  <?php echo form_input($Nic); ?>
                </div>
                <div class="help-block with-errors"></div>
              </div>
            </div>






            <div class="col-sm-6">


              <label></label>
              <div class="input-group">
                <div style="color: red;"><?php if (isset($errors['pcode'])) {
                                            echo $errors['pcode'];
                                          } ?></div>
              </div>


              <div class="form-group">
                <label>Postcode/ Zip code *</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-code"></i>
                  </span>
                  <?php echo form_input($postal_code); ?>
                </div>
                <div class="help-block with-errors"></div>
              </div>


            </div>


          </div>





          <div style="padding-bottom: 15px;" class="row">

            <div class="col-sm-6">
              <div class="form-check">
                <input type="checkbox" id="checkbox1" value="1" class="form-check-input" name="issrilankan">
                <label class="form-check-label">Is Sri Lankan *</label>
                <div class="help-block with-errors"></div>
              </div>
            </div>

          </div>

          <div id="panel2" style="display:true" class="panel panel-default">
            <div class="panel-heading">Foreginers Only </div>
            <div class="panel-body">

            <div class="row">


<div class="col-sm-6">

  <label></label>
  <div class="input-group">
    <div style="color: red;"><?php if (isset($errors['F_country'])) {
                                echo $errors['F_country'];
                              } ?></div>
  </div>



  <div class="form-group">
    <label>Country *</label>
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-globe"></i>
      </span>
      <?php echo form_input($country); ?>
    </div>
    <div class="help-block with-errors"></div>
  </div>
</div>






<div class="col-sm-6">


  <label></label>
  <div class="input-group">
    <div style="color: red;"><?php if (isset($errors['F_province'])) {
                                echo $errors['F_province'];
                              } ?></div>
  </div>


  <div class="form-group">
    <label>Province /Estate/ Region *</label>
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-globe"></i>
      </span>
      <?php echo form_input($province); ?>
    </div>
    <div class="help-block with-errors"></div>
  </div>


</div>


</div>


<div class="row">


<div class="col-sm-6">

  <label></label>
  <div class="input-group">
    <div style="color: red;"><?php if (isset($errors['F_city'])) {
                                echo $errors['F_city'];
                              } ?></div>
  </div>



  <div class="form-group">
    <label>City *</label>
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-globe"></i>
      </span>
      <?php echo form_input($city); ?>
    </div>
    <div class="help-block with-errors"></div>
  </div>
</div>






<div class="col-sm-6">


  <label></label>
  <div class="input-group">
    <div style="color: red;"><?php if (isset($errors['F_pasport_country'])) {
                                echo $errors['F_pasport_country'];
                              } ?></div>
  </div>


  <div class="form-group">
    <label>Passport Issued Country *</label>
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-globe"></i>
      </span>
      <?php echo form_input($passport_country); ?>
    </div>
    <div class="help-block with-errors"></div>
  </div>


</div>


</div>




            </div>





          </div>

          <div style="padding-top: 15px;" class="row">


<div class="col-sm-6">

  <label></label>
  <div class="input-group">
    <div style="color: red;"><?php if (isset($errors['conmobile'])) {
                                echo $errors['conmobile'];
                              } ?></div>
  </div>



  <div class="form-group">
    <label>Contact - Mobile No *</label>
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-mobile"></i>
      </span>
      <?php echo form_input($contact_mobile); ?>
    </div>
    <div class="help-block with-errors"></div>
  </div>
</div>






<div class="col-sm-6">


  <label></label>
  <div class="input-group">
    <div style="color: red;"><?php if (isset($errors['confix'])) {
                                echo $errors['confix'];
                              } ?></div>
  </div>


  <div class="form-group">
    <label>Contact - Fix Line No *</label>
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-phone"></i>
      </span>
      <?php echo form_input($contact_fix); ?>
    </div>
    <div class="help-block with-errors"></div>
  </div>


</div>


</div>






          <div class="row">

            <div class="col-sm-6">
            <label></label>
  <div class="input-group">
    <div style="color: red;"><?php if (isset($errors['email'])) {
                                echo $errors['email'];
                              } ?></div>
  </div>



  <div class="form-group">
    <label>Email *</label>
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-envelope-o"></i>
      </span>
      <?php echo form_input($Email); ?>
    </div>
    <div style=" color: red;" class="help-block with-errors"><?php  if(isset($emilerr)){ echo $emilerr; } ?></div>
  </div>
            </div>

            <div class="col-sm-6">

            <label></label>
  <div class="input-group">
    <div style="color: red;"><?php if (isset($errors['upload_file'])) {
                                echo $errors['upload_file'];
                              } ?></div>
  </div>

  <div class="form-group">
    <label>Upload Profile Picture *</label>
    <div class="input-group">
      <?php echo form_input($Upload_file); ?>
    </div>
    <div class="help-block with-errors"></div>
  </div>
            </div>

          </div>

          <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6" data-toggle="tooltip" title="Allowed file types - JPG/JPEG/PNG"><i class="fa fa-info-circle" aria-hidden="true"></i></div>

          </div>

         

                                   <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group  pull-right">
                                                <a href="<?php echo base_url().'member-management/'?>" class="btn btn-danger">cancel</a>
                                                <button type="submit" value="submit" id="register_member" name="submit" class="btn btn-success">Submit</button>&nbsp;                                                    
                                                </div>
                                            </div>
                                        </div>

        </form>
        <div id="processdiv" class="row">
<div class="col-md-3 bg">
        <div class="loader" id="loader-4">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
</div>  
                                                 
      </div>

    </div>
  </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
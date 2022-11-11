<!-- Main content -->
<style>
  img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
  }
</style>



<section class="content">
  <div class="box box-primary">
    <div class="box-header">
      <i class="fa fa-users text-blue"></i>

      <h3 class="box-title"><?php echo $pagetitle; ?></h3>


    </div>

    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div id="infoMessage"><?php echo $message; ?></div>
          <?php
          //print_r($this->form_validation->error_array());
          $errors = $this->form_validation->error_array();
          ?>
          <?php //  echo form_open(uri_string()); 
          ?>

        </div>
      </div>


      <form id="form_member_registration" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="">

        <div class="row">

          

          <?php if (file_exists('uploads/member_profile_image/' . $user->id . '/' . $user_pro->upload) && $user_pro->upload != "") {

          ?>

            <div id="displayProfil" class="col-sm-6 pull-left">
              <img class="pull-left" style="width: 200px;height: 150px;" src="<?php echo base_url('uploads/member_profile_image/' . $user->id . '/' . $user_pro->upload); ?>" alt="">

            </div>

          <?php } else { ?>

            <div id="displayProfil" class="col-sm-6 pull-left">
              <img class="pull-left" style="width: 200px;height: 150px;" src="<?php echo base_url('assets/images/user_prof.png'); ?>" alt="">

            </div>



          <?php } ?>


          <div class="col-sm-6">
          </div>

        </div>





        <div class="row">

          <input type="hidden" id="issri" value="<?php echo $user_pro->is_srilankan; ?>" class="form-control" name="issri">
          <input type="hidden" id="editstatus" value="<?php echo $edit_status; ?>" class="form-control">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Title *</label>
              <input type="text" value="<?php echo $user_pro->title; ?>" class="form-control" name="title" id="title" placeholder="Title - Mr./Mrs. etc" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>


          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">First Name *</label>
              <input type="text" class="form-control" value="<?php echo $user_pro->first_name; ?>" id="firstname" name="firstname" placeholder="First Name" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Last Name *</label>
              <input type="text" class="form-control" value="<?php echo $user_pro->last_name; ?>" id="lastname" name="lastname" placeholder="Last Name" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Name with initials *</label>
              <input type="text" class="form-control" value="<?php echo $user->name_initials; ?>" id="iname" name="iname" placeholder="Name with initials" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>


        </div>


        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Address 1 *</label>
              <input type="text" class="form-control" value="<?php echo $user_pro->address1; ?>" name="address1" id="address1" placeholder="Address 1" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Address 2 *</label>
              <input type="text" class="form-control" value="<?php echo $user_pro->address2; ?>" name="address2" id="address2" placeholder="Address 2" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>
        </div>


        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">NIC/Passport No *</label>
              <input type="text" class="form-control" value="<?php echo $user_pro->nic; ?>" name="nic" id="nic" placeholder="NIC/Passport No" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Postcode/ Zip code *</label>
              <input type="text" class="form-control" value="<?php echo $user_pro->postal_code; ?>" name="pcode" id="pcode" placeholder="Postcode/ Zip code" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>


          <!-- <div class="col-sm-6">
<div class="form-check">
  <input type="checkbox" id="checkbox1" class="form-check-input" name="issrilankan" required>
  <label class="form-check-label" for="exampleCheck1">Is Sri Lankan</label>
  <div class="help-block with-errors"></div>
</div>
</div> -->


        </div>

        <div id="panel2" style="display:true" class="panel panel-default">
          <div class="panel-heading">Foreginers Only </div>
          <div class="panel-body">

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Country *</label>
                  <input type="text" id="f1" value="<?php echo $user_pro->country; ?>" class="form-control" name="F_country" placeholder="Country" required>
                  <div class="help-block with-errors"></div>
                </div>
              </div>


              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Province /Estate/ Region *</label>
                  <input type="text" id="f2" value="<?php echo $user_pro->Province; ?>" class="form-control" name="F_province" placeholder="Province /Estate/ Region" required>
                  <div class="help-block with-errors"></div>
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">City *</label>
                  <input type="text" id="f3" value="<?php echo $user_pro->city; ?>" class="form-control" name="F_city" placeholder="City" required>
                  <div class="help-block with-errors"></div>
                </div>
              </div>


              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Passport Issued Country *</label>
                  <input type="text" id="f4" value="<?php echo $user_pro->passport_country; ?>" class="form-control" name="F_pasport_country" placeholder="Passport issued Country" required>
                  <div class="help-block with-errors"></div>
                </div>
              </div>

            </div>


          </div>
        </div>



        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Contact - Mobile No *</label>
              <input type="text" class="form-control" value="<?php echo $user_pro->contact_mobile; ?>" name="conmobile" id="conmobile" placeholder="Contact - Mobile No" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>


          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Contact - Fix Line No *</label>
              <input type="text" class="form-control" value="<?php echo $user_pro->contact_home; ?>" name="confix" id="confix" placeholder="Contact - Fix Line No" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>

        </div>


        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Email *</label>
              <input type="email" class="form-control" value="<?php echo $user->username; ?>" name="email" id="email" iconv_mime_decode="email" placeholder="Email" required>
              <div class="help-block with-errors"></div>
            </div>
            <div id="emailinfo" class="col-sm-6" data-toggle="tooltip" title="Email used as a User Name of account. When change Email Username also changed acording to Email"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
          </div>


          <div id="uploadin" class="col-sm-6">
            <div class="form-group">
              <label for="exampleInputPassword1">Upload</label>
              <input type="file" class="form-control" name="upload_file" id="upload_file" placeholder="Chose Your Photography">
              <div class="help-block with-errors"></div>
            </div>
            <div class="col-sm-6" data-toggle="tooltip" title="Allowed file types - JPG/JPEG/PNG"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
          </div>


        </div>


        <div class="row">
          <div class="col-sm-12">
            <div class="form-group  pull-right">
              <a href="<?php echo base_url() . 'member-management/' ?>" class="btn btn-danger">cancel</a>
              <button type="submit" value="submit" id="but01" name="submit" class="btn btn-info">Submit</button>&nbsp;
            </div>
          </div>
        </div>

    </div>


    </form>






  </div>
  </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
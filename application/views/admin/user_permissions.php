  <?php //print_r($groups); die(); ?>
<!-- Main content -->
    <section class="content">
        <div class="box box-primary">
          <div class="box-header">
            <i class="fa fa-users text-blue"></i>

            <h3 class="box-title">User Permissions</h3>

            
          </div>
          <div class="box-body">
            
            <!--<div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="" style="font-size: 16px;">Groups</label>
                  <select id="group" name="group" class="form-control">
                    <option value="0">Please select</option>
                    <?php 
                      foreach($groups as $group) {
                    ?>
                      <option value="<?php echo $group['group_id']; ?>">
                        <?php echo $group['parent'].'->'.$group['gname']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div> -->


            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="" style="font-size: 16px;">Users</label>
                  <select id="user" name="user" class="form-control input-sm">
                    <option value="0">Please select</option>
                    <?php 
                      foreach($users as $user) {
                    ?>
                      <option value="<?php echo $user['id']; ?>">
                        <?php echo $user['first_name']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3" id="groupBlock">

              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="" style="font-size: 16px;">Please select a group</label>
                  <select name="group_id" id="group_id" class="form-control input-sm">

                  </select>
                </div>
              </div>
            </div>

            <div style="max-height: 400px; overflow-y: scroll;">
                <div id="tree"></div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-3" id="btnBlock">
                
              </div>
              <input type="hidden" id="hdn_group_id" value="" />
            </div>

          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
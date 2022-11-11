    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
          <div class="box-header">
            <i class="fa fa-users text-blue"></i>

            <h3 class="box-title">Add Group</h3>

            
          </div>
          <div class="box-body">

            <div class="row">
              <div class="col-md-3">

                <div id="msg" style="color: red"></div>

              <form id="addGroup" method="post" action="<?php echo site_url('add_groups');?>" onsubmit="return validateForm()">

                <div class="form-group">
                  <?php foreach($groups as $group) { ?>
                  <div class="checkbox">
                    <label for=""><input type="checkbox" name="group_id[]" id="group_id[]" value="<?php echo $group['group_id']; ?>"> <?php echo $group['parent'].'>'.$group['gname']; ?></label>
                  </div>
                  <?php } ?>
                </div>

                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                <?php echo form_hidden('id', $user_id);?>

                <p>
                  <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-primary  btn-flat'), lang('edit_user_submit_btn'));?>
                </p>

              <?php echo form_close();?>
              </div>
            </div>

          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


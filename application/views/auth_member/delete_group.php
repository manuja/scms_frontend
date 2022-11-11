    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Delete Group</h3>
              <p>Are you sure you want to delete the group <?php echo $group->name; ?>?</p>
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-sm-1">
                <?php echo form_open('auth/delete_parent_group');?>
                  <button type="submit" class="btn btn-danger">Yes</button>
                  <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
                <?php echo form_close();?>
              </div>
              <div class="col-sm-1">
                <a href="<?php echo site_url('auth/groups'); ?>" class="btn btn-primary">No</a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>



    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
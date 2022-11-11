
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Create sub group</h3>

              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 <div class="row">
                   <div class="col-md-3">

                   <form name="addSubGroup" method="post" action="<?php echo site_url('create_sub_group');?>" onsubmit="return validateForm()">

                      <input type="hidden" name="group_id" value="<?php echo $group_id;?>">
                     <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter name">
                        <div id="errNameMsg" style="color: red;"></div>
                      </div>
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" id="desc" name="desc" class="form-control" placeholder="Enter description">
                        <?php echo form_error('desc', '<div class="error">', '</div>'); ?>
                      </div>
                      <div class="form-group">
                        <input type="submit" name="submit" value="Save" class="btn btn-primary">
                      </div>

                    </form>

                   </div>
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
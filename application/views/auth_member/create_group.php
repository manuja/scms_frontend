    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Create group</h3>

              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
           				<?php echo form_open(current_url());?>

           					    <div class="form-group">
          			          <?php echo lang('create_group_name_label', 'group_name');?>
          			          <?php echo form_input($group_name);?>
                          <div id="infoMessage" style="color: red;"><?php echo $message;?></div>
                  			</div>

                  			<div class="form-group">
          			          <?php echo lang('create_group_desc_label', 'description');?>
          			          <?php echo form_input($description);?>
                  			</div>

                  			<?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-primary  btn-flat'), lang('create_group_submit_btn'));?>

           				<?php echo form_close();?>
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


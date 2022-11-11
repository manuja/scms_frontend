
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><?php echo lang('deactivate_heading');?></h3>
              <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

 				<?php echo form_open("auth/deactivate/".$user->id);?>
          <div style="margin-left: 10px;">
            <div class="radio">
              <label for="">
                <input type="radio" name="confirm" value="yes" checked="checked" /> Yes
              </label>
            </div>

            <div class="radio">
              <label for="">
                <input type="radio" name="confirm" value="no" /> No
              </label>
            </div>

            <?php echo form_hidden($csrf); ?>
            <?php echo form_hidden(array('id'=>$user->id)); ?>

            <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-primary  btn-flat'), lang('deactivate_submit_btn'));?>
          </div>

        <?php echo form_close();?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>



    </section>

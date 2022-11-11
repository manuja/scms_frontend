  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Permissions</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
          <div class="box-header">
            <i class="fa fa-users text-blue"></i>

            <h3 class="box-title">Select a Root Permission</h3>

            
          </div>
          <div class="box-body">
            
            <?php echo form_open('permissions/select_root_sub_permission'); ?>
              <?php echo validation_errors(); ?>
                <div class="form-group">
                  <label for="" style="font-size: 16px;">Root Permission</label>
                  <select name="parent_permission" id="parent_permission" class="form-control">
                    <option value="" selected disabled hidden>Please select...</option>
                    <?php foreach($parent_permissions as $parent_permission) { ?>
                      <option value="<?php echo $parent_permission->id ?>"><?php echo $parent_permission->name ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="submit" name="submit" value="Submit" class="btn btn-success">
                </div>
              </form>

          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
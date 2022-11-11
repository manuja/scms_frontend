  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Permissions</a></li>
        <li class="active">Add Child Permission</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-key text-blue"></i>

              <h3 class="box-title">Add a New Permission</h3>

              
            </div>
            <div class="box-body">
               
              <div class="box-footer">

                <div class="col-sm-4">
                  <?php echo form_open('permissions/create_permission'); ?>
                  <?php echo validation_errors(); ?>
                    <div class="form-group">
                      <label for="" style="font-size: 16px;">Please select a parent permission</label>
                      <select name="parent_permission" id="parent_permission" class="form-control">
                        <option value="" selected>Please select...</option>
                        <?php foreach($parent_permissions as $parent_permission) { ?>
                          <option value="<?php echo $parent_permission->id ?>"><?php echo $parent_permission->name ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="" style="font-size: 16px;">Please select the permission type</label>
                      <select id="perm_type" class="form-control">
                        <option value="" selected>Please select...</option>
                        <option value="Child">Child Permission</option>
                        <option value="Grandchild">Grandchild Permission</option>
                      </select>
                    </div>

                    <div class="form-group" id="child_permissions_div">
                      <label for="" style="font-size: 16px;">Child Permission</label>
                      <select name="child_permission" id="child_permission" class="form-control">
                      </select>
                    </div>

                    <div class="form-group" id="new_child_permission_div">
                      <label for="" style="font-size: 16px;">Child Permission</label>
                      <input type="text" name="new_child_permission" class="form-control">
                    </div>

                    <div class="form-group" id="grandchild_permission_div">
                      <label for="" style="font-size: 16px;">Grandchild Permission</label>
                      <input type="text" name="new_grandchild_permission" class="form-control">
                    </div>
                    <div class="form-group" id="submit_div">
                      <input type="submit" name="submit" value="Save" class="btn btn-success">
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
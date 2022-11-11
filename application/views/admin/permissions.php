<?php $CI = & get_instance(); ?>
<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-key text-blue"></i>

            <h3 class="box-title">Permissions</h3>


        </div>
        <div class="box-body">


            <div class="row">
                <div class="col-md-6">
                    <?php if($this->userpermission->checkUserPermissions2('add_permission')){?>
                    <span class="update_project" data-toggle="modal" data-target="#modal-add-parent">
                        <a data-toggle="tooltip" data-placement="top" title="Add parent permission!" class="btn btn-success">
                            Add parent permission
                            <span class="label label-success">
                                <span class="fa fa-plus"></span>
                            </span>
                        </a>
                    </span>
                    <?php } ?>

                    <div class="modal fade" id="modal-add-parent">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Add parent permission</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="parent_permission_data">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size: 16px;">Parent Permission</label>
                                                    <input type="text" name="parent_permission" id="parent_permission" class="form-control">
                                                    <div id="errParentPerm" style="color: red;"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="save_parent_permission">Save changes</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php if($this->userpermission->checkUserPermissions2('add_permission')){?>
                    <span class="update_project" data-toggle="modal" data-target="#modal-add-child">
                        <a data-toggle="tooltip" data-placement="top" title="Add child permission!" class="btn btn-success">
                            Add child permission
                            <span class="label label-success">
                                <span class="fa fa-plus"></span>
                            </span>
                        </a>
                    </span>
                     <?php } ?>

                    <div class="modal fade" id="modal-add-child">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Add child permission</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="child_permission_data" data-toggle="validator">

                                        <div class="form-group">
                                            <label  style="font-size: 16px;">Please select a parent permission</label>
                                            <select name="parent_permission2" id="parent_permission2" class="form-control" required>
                                                <option value="0" required selected>Please select...</option>
                                                <?php
                                                foreach ($parent_permissions as $parent_permission)
                                                {
                                                    ?>
                                                    <option value="<?= $parent_permission->id ?>"><?php echo $parent_permission->name; ?></option>
<?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="" style="font-size: 16px;">Please select the permission type</label>
                                            <select id="perm_type" class="form-control" required>
                                                <option value="0" selected>Please select...</option>
                                                <option value="Child">Child Permission</option>
                                                <option value="Grandchild">Grandchild Permission</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="child_permissions_div">
                                            <label for="" style="font-size: 16px;">Child Permission</label>
                                            <select name="child_permission" id="child_permission" class="form-control">
                                            </select>
                                            <div id="errChildPermDropDown" style="color: red;"></div>
                                        </div>

                                        <div class="form-group" id="new_child_permission_div">
                                            <label for="" style="font-size: 16px;">Child Permission</label>
                                            <input type="text" name="new_child_permission"  id="new_child_permission" class="form-control">
                                            <div id="errChildPerm" style="color: red;"></div>
                                        </div>

                                        <div class="form-group" id="grandchild_permission_div">
                                            <label for="" style="font-size: 16px;">Grandchild Permission</label>
                                            <input type="text" name="new_grandchild_permission" id="new_grandchild_permission" class="form-control">
                                            <div id="errGrandChildPerm" style="color: red;"></div>
                                        </div>

                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="save_child_permission">Save changes</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <br><br>


            <div class="col-md-3">
                <div class="form-group">
                    <label>Sort by</label>
                    <select class="form-control" onchange="load_data(this.value);">
                        <option value="permissions1">Parent</option>
                        <option value="permissions2">Child</option>
                        <option value="permissions3">Grand child</option>
                    </select>
                </div>
            </div>

            <div id="data_div">

            </div>

            <ul id="pagination-demo" class="pagination-sm"></ul>

        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


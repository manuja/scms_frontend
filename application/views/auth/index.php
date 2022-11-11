<?php
$success = $this->session->userdata('success');
if ($success != "") {
?>

  <div class="alert alert-success " role="alert">
    <?php echo $success; ?>
    <button type="button" id="alertbtt" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php
}
?>

<?php
$failure = $this->session->userdata('failure');
if ($failure != "") {
?>
  <div class="alert alert-warning " role="alert">
    <?php echo $failure; ?>
    <button type="button" id="alertbtt" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php
}
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-users text-purple"></i>
                    <h3 class="box-title">Users</h3>
                    <div class="box-tools">
                        <?php if ($this->ion_auth->is_admin() || $this->userpermission->checkUserPermissions2('user_add')) { ?>
                            <a href="<?php echo site_url('auth/create_user'); ?>" class="btn btn-primary"> Add user</a>
                        <?php } ?>
                    </div>
                </div>
               
                <div class="box-body" style="overflow-x: scroll">

                    <div class="row">
                        <div class="col-xs-4" style="padding-bottom: 10px;">

                            <select id="search_By_user_group" class="form-control">
                                <option value=" " selected>All Groups</option>
                                <?php

                                foreach ($system_groups as $group) {
                                    if ($group->group_id != 6) {


                                ?>


                                        <?php
                                        $parent_id = $group->group_id;
                                        $sub_items = sub_items($parent_id);

                                        foreach ($sub_items as $value) {
                                        ?>
                                           <option value="<?php echo $value['group_id']; ?>"><?php echo $value['sname']; ?></option>
                                        <?php } ?>
                                        </optgroup>
                                <?php }
                                } ?>
                            </select>


                        </div>
                    </div>

                    <table class="table" id="user_table">
                        <thead style="font-size: 16px;">
                            <tr>
                                <th>No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th style="display:none;" ></th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($users as $user) {
                                // print_r();
                                if ($user->active != 6 && $user->id != 17) {


                            ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <?php
                                            $group_name = '';
                                            $group_size = sizeof($user->groups);

                                            if (sizeof($user->groups) > 0) { ?>
                                                <?php echo $user->groups[0]['gname']; // anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;
                                                ?><br />
                                            <?php

                                            } else {
                                            ?>
                                                -
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($user->active == 1 ||  $user->active == 4 ) { ?>
                                                <p style="padding:0px; width: 65px; height: 20px;" class="btn btn-success">Active</p>
                                            <?php } else if ($user->active == 0 || $user->active == 5 | $user->active == 7  ) { ?>
                                                <p style="padding:0px;width: 65px;" class="btn btn-danger">Inactive</p>
                                            <?php } ?>
                                        </td>
                                        
                                        <td style="display:none;">
                                            <?php
                                            $group_name = '';
                                            $group_size = sizeof($user->groups);

                                            if (sizeof($user->groups) > 0) { ?>
                                                <?php echo $user->groups[0]['group_id']; // anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;
                                                ?><br />
                                            <?php

                                            } else {
                                            ?>
                                                -
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($this->userpermission->checkUserPermissions2('user_view')) { ?>

                                                <?php if ($user->in_source == 1) { ?>
                                                    <button class="btn btn-success view_staff" fname="<?php echo $user->first_name; ?>" lname="<?php echo $user->last_name; ?>" email="<?php echo $user->username; ?>" nic="<?php echo $user->nic; ?>" iname="<?php echo $user->name_initials; ?>" data-toggle="tooltip" tooltip="View" title="View"><i class="fa fa-eye"></i></button>


                                                <?php } else {  ?>
                                                    <a href="<?php echo site_url('view_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                <?php }  ?>


                                            <?php }
                                            ?>

                                            <?php
                                            if ($this->userpermission->checkUserPermissions2('user_active')) { ?>
                                                <button class="btn btn-info edit_user" groupstatus="<?php echo $group_size; ?>" id="<?php echo $user->id; ?>" title="Active/Deactive Users"><i class="fa fa-lock"></i></button>
                                            <?php }
                                            ?>

                                            <?php
                                            if ($this->userpermission->checkUserPermissions2('edit_all')) { ?>

                                                <?php if ($user->in_source == 1) { ?>

                                                    <a href="<?php echo site_url('auth/edit_user/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                    <!-- <?php echo site_url('edit_member/' . $user->id); ?> -->
                                                <?php } else {  ?>
                                                    <a href="#" disabled data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>


                                                <?php }  ?>


                                            <?php }
                                            ?>

                                        </td>
                                    </tr>
                            <?php

                                    $i++;
                                }
                            }


                            ?>
                        </tbody>
                    </table>











                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="modal fade" id="user_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?php echo base_url('Auth/userActivation'); ?>" id="edit_user_form">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input value="" class="form-control" id="employee_name" name="employee_name" readonly="" />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <input type="hidden" name="update_type" value="1" id="update_type" />

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>User Group</label>
                                    <select class="form-control" id="user_group" name="user_group" required="">
                                        <option value="">Select</option>
                                        <?php

                                        foreach ($system_groups as $group) {
                                            if ($group->group_id != 6) {


                                        ?>
                                                <optgroup label="<?php echo $group->gname; ?>">

                                                    <?php
                                                    $parent_id = $group->group_id;
                                                    $sub_items = sub_items($parent_id);

                                                    foreach ($sub_items as $value) {
                                                    ?>
                                                        <option value="<?php echo $value['group_id']; ?>"><?php echo $value['sname']; ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                        <?php }
                                        } ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" id="user_status" name="user_status" required="">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Comment</label> <br />
                                    <input name="status_comment" id="status_comment" class="form-control"/>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Status Upload</label>
                                    <input type="file" class="form-control" name="upload" id="upload" placeholder="Chose Your Photography">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div> -->
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <br />
                                    <label><input type="checkbox" id="change_password" name="change_password" value="1" /> Change Password</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div> -->
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Status Comment</label>
                                    <textarea name="status_comment" id="status_comment" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="" id="user_id" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="save_user_btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- view modal -->
    <div class="modal fade" id="view_stff_member_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Staff Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="view_stff_member">
                    <div class="modal-body">


                        <div class="form-group">
                            <label>First Name</label> <br />
                            <input name="first_name" id="v_first_name" class="form-control" readonly />

                        </div>
                        <div class="form-group">
                            <label>Last Name</label> <br />
                            <input name="last_name" id="v_last_name" class="form-control" readonly />

                        </div>
                        <div class="form-group">
                            <label>Name with initials</label> <br />
                            <input name="name_initials" id="v_name_initials" class="form-control" readonly />

                        </div>

                        <div class="form-group">
                            <label class="control-label">NIC</label>
                            <input type="text" id="v_nic" class="form-control" name="nic" readonly />


                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" id="v_email" class="form-control" name="email" readonly />


                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
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

<style>
    #loader-4 span {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 100%;
        background-color: #3498db;
        margin: 35px 5px;
        opacity: 0;
    }

    #loader-4 span:nth-child(1) {
        animation: opacitychange 1s ease-in-out infinite;
    }

    #loader-4 span:nth-child(2) {
        animation: opacitychange 1s ease-in-out 0.33s infinite;
    }

    #loader-4 span:nth-child(3) {
        animation: opacitychange 1s ease-in-out 0.66s infinite;
    }

    @keyframes opacitychange {

        0%,
        100% {
            opacity: 0;
        }

        60% {
            opacity: 1;
        }
    }
</style>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-users text-purple"></i>
                    <h3 class="box-title">Member Management</h3>
                    <div class="box-tools">
                        <?php if ($this->ion_auth->is_admin() || $this->userpermission->checkUserPermissions2('add_member')) { ?>
                            <a href="<?php echo site_url('add-members'); ?>" class="btn btn-primary"> Add Member</a>
                        <?php } ?>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-3">
                        <label>Search Employee Number</label>
                        <input type="text" id="search_emp_id" placeholder="Search Employee Number" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Search Email</label>
                        <input type="text" id="search_email" placeholder="Search Email" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Search Group</label>
                        <select id="search_groups" class="form-control">
                            <option value="" selected>Please select a group</option>
                            <?php
                            foreach ($groups as $group) {
                            ?>
                                <option value="<?php echo $group->name; ?>"><?php echo $group->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Search Status</label>
                        <input type="text" id="search_status" placeholder="Search Status" class="form-control">
                    </div>
                    </div>
                </div> -->
                <div class="box-body" style="overflow-x: scroll">

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#member_table">Members</a></li>
                        <li><a data-toggle="tab" href="#confirmation_pending_table">To be Approved Member</a></li>
                        <li><a data-toggle="tab" href="#payment_pending_table">Application approved Member</a></li>
                        <li><a data-toggle="tab" href="#renew_table">To be renewed Member</a></li>
                        <li><a data-toggle="tab" href="#terminate_table">Terminated Member</a></li>
                    </ul>


                    <div class="tab-content">
                        <div id="member_table" class="tab-pane fade in active">
                            <table class="table" id="mem_table">
                                <thead style="font-size: 16px;">
                                    <tr>
                                        <th>No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Group</th>
                                        <th>Status</th>
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
                                                    <?php if ($user->active == 1) { ?>
                                                        <p style="padding:0px; width: 65px; height: 20px;" class="btn btn-success">Active</p>
                                                    <?php } else if ($user->active == 0) { ?>
                                                        <p style="padding:0px;width: 65px;" class="btn btn-danger">Inactive</p>
                                                    <?php } else if ($user->active == 2) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">To be Approved</p>
                                                    <?php } else if ($user->active == 3) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">Application approved</p>
                                                    <?php } else if ($user->active == 5) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">Terminated</p>
                                                    <?php } else if ($user->active == 4) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">To be renewed</p>
                                                    <?php } else if ($user->active == 7) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">Paid</p>
                                                    <?php }  ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('view_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/view_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success">
                                                            <i class="fa fa-eye"></i>
                                                        </a>




                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('status_change_member')) { ?>
                                                        <button class="btn btn-info edit_user" groupstatus="<?php echo $group_size; ?>" id="<?php echo $user->id; ?>" title="Active/Deactive Users"><i class="fa fa-lock"></i></button>
                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('edit_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/edit_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </a>


                                                    <?php }
                                                    ?>

<?php
                                                    if ($this->userpermission->checkUserPermissions2('payment_history')) { ?>


                                                        <a href="<?php echo site_url('member-management/payment_history/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="Payment" class="btn btn-primary">
                                                            <i class="fa fa-money"></i>
                                                        </a>


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

                        <!-- confirmation pending -->
                        <div id="confirmation_pending_table" class="tab-pane fade">
                            <table class="table" id="mem2_table">
                                <thead style="font-size: 16px;">
                                    <tr>
                                        <th>No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Group</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $j = 1;
                                    foreach ($users as $user) {

                                        if ($user->active == 2) {


                                    ?>
                                            <tr>
                                                <td><?= $j ?></td>
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
                                                    <?php if ($user->active == 1) { ?>
                                                        <p style="padding:0px; width: 65px; height: 20px;" class="btn btn-success">Active</p>
                                                    <?php } else if ($user->active == 2) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">To be Approved Member</p>
                                                    <?php } else { ?>
                                                        <p style="padding:0px;width: 65px;" class="btn btn-danger">Inactive</p>
                                                    <?php } ?>
                                                    <?php // echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); 
                                                    ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('view_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/view_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success">
                                                            <i class="fa fa-eye"></i>
                                                        </a>




                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('status_change_member')) { ?>
                                                        <button class="btn btn-info edit_user" groupstatus="<?php echo $group_size; ?>" id="<?php echo $user->id; ?>" title="Active/Deactive Users"><i class="fa fa-lock"></i></button>
                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('edit_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/edit_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </a>


                                                    <?php }
                                                    ?>

                                                </td>
                                            </tr>
                                    <?php
                                            $j++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>



                        <!-- payment pending -->
                        <div id="payment_pending_table" class="tab-pane fade">
                            <table class="table" id="mem3_table">
                                <thead style="font-size: 16px;">
                                    <tr>
                                        <th>No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Group</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $k = 1;
                                    foreach ($users as $user) {

                                        if ($user->active == 3) {


                                    ?>
                                            <tr>
                                                <td><?= $k ?></td>
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
                                                    <?php if ($user->active == 1) { ?>
                                                        <p style="padding:0px; width: 65px; height: 20px;" class="btn btn-success">Active</p>
                                                    <?php } else if ($user->active == 3) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">Application approved</p>
                                                    <?php } else { ?>
                                                        <p style="padding:0px;width: 65px;" class="btn btn-danger">Inactive</p>
                                                    <?php } ?>
                                                    <?php // echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); 
                                                    ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('view_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/view_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success">
                                                            <i class="fa fa-eye"></i>
                                                        </a>




                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('status_change_member')) { ?>
                                                        <button class="btn btn-info edit_user" groupstatus="<?php echo $group_size; ?>" id="<?php echo $user->id; ?>" title="Active/Deactive Users"><i class="fa fa-lock"></i></button>
                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('edit_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/edit_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </a>


                                                    <?php }
                                                    ?>

                                                </td>
                                            </tr>
                                    <?php

                                            $k++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Renew -->
                        <div id="renew_table" class="tab-pane fade">
                            <table class="table" id="mem4_table">
                                <thead style="font-size: 16px;">
                                    <tr>
                                        <th>No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Group</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $l = 1;
                                    foreach ($users as $user) {

                                        if ($user->active == 4) {


                                    ?>
                                            <tr>
                                                <td><?= $l ?></td>
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
                                                    <?php if ($user->active == 1) { ?>
                                                        <p style="padding:0px; width: 65px; height: 20px;" class="btn btn-success">Active</p>
                                                    <?php } else if ($user->active == 4) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">To be renewed</p>
                                                    <?php } else { ?>
                                                        <p style="padding:0px;width: 65px;" class="btn btn-danger">Inactive</p>
                                                    <?php } ?>
                                                    <?php // echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); 
                                                    ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('view_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/view_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success">
                                                            <i class="fa fa-eye"></i>
                                                        </a>




                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('status_change_member')) { ?>
                                                        <button class="btn btn-info edit_user" groupstatus="<?php echo $group_size; ?>" id="<?php echo $user->id; ?>" title="Active/Deactive Users"><i class="fa fa-lock"></i></button>
                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('edit_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/edit_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </a>


                                                    <?php }
                                                    ?>

                                                </td>
                                            </tr>
                                    <?php

                                            $l++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>


                        <!-- terminate member -->
                        <div id="terminate_table" class="tab-pane fade">
                            <table class="table" id="mem5_table">
                                <thead style="font-size: 16px;">
                                    <tr>
                                        <th>No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Group</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $m = 1;
                                    foreach ($users as $user) {

                                        if ($user->active == 5) {


                                    ?>
                                            <tr>
                                                <td><?= $m ?></td>
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
                                                    <?php if ($user->active == 1) { ?>
                                                        <p style="padding:0px; width: 65px; height: 20px;" class="btn btn-success">Active</p>
                                                    <?php } else if ($user->active == 5) { ?>
                                                        <p style="padding:0px;" class="btn btn-warning">Terminated</p>
                                                    <?php } else { ?>
                                                        <p style="padding:0px;width: 65px;" class="btn btn-danger">Inactive</p>
                                                    <?php } ?>
                                                    <?php // echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); 
                                                    ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('view_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/view_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success">
                                                            <i class="fa fa-eye"></i>
                                                        </a>




                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('status_change_member')) { ?>
                                                        <button class="btn btn-info edit_user" groupstatus="<?php echo $group_size; ?>" id="<?php echo $user->id; ?>" title="Active/Deactive Users"><i class="fa fa-lock"></i></button>
                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if ($this->userpermission->checkUserPermissions2('edit_member')) { ?>


                                                        <a href="<?php echo site_url('member-management/edit_member/' . $user->id); ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </a>


                                                    <?php }
                                                    ?>

                                                </td>
                                            </tr>
                                    <?php

                                            $m++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
















                    </div>






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
                    <div id="processdiv" class="row">
                        <div class="col-md-3 bg">
                            <div class="loader" id="loader-4">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="post" action="<?php echo base_url('MemberManagementController/MemberActivation'); ?>" id="edit_user_form">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input value="" class="form-control" id="employee_name" name="employee_name" readonly="" />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" id="user_status" name="user_status" required="">
                                        <option value="2">To be Approved</option>
                                        <option value="3">Application approved</option>
                                        <option value="7">paid</option>
                                        <option value="4">To be renewed</option>
                                        <option value="5">Terminated</option>
                                        <option value="6">Reject</option>
                                        <option disabled value="1">Active</option>
                                        <option disabled value="0">Inactive</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <input type="hidden" name="user_group" value="" id="user_group" />
                            <input type="hidden" name="payment_status" value="0" id="payment_status" />
                            <input type="hidden" name="update_type" value="0" id="update_type" />


                        </div>

                        <div id="payment_div" style="display:none">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group ">
                                    <label for="">Payment Year</label>
                                    <input style="border-radius:2px" type="text" name="payment_year" id="payment_year" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group ">
                                    <label for="">Payment Amount</label>
                                    <input class="form-control" type="text" name="payment_amount" value="" id="payment_amount" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group ">
                                    <label for="">Payment Comment</label>
                                    <input class="form-control" type="text" name="payment_comment" value="" id="payment_comment" />
                                </div>
                            </div>
                        </div>
                        <div id="payment_slip_input" class="row" style="display:true" >
                            <div class="col-sm-12">
                                <div class="form-group ">
                                    <label for="">Payment Slip</label>
                                    <input type="file" name="payment_slip" id="payment_slip" class="form-control">
                                    <div data-toggle="tooltip" title="Allowed file types - jpg , jpeg , png , PDF Max File Size - 5MB"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div id="payment_slip_div">

                        </div>

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
<!-- Main content -->
<style>
    .group_positon {
        margin: 0 !important;
    }
</style>
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-users text-blue"></i>
            <h3 class="box-title">Group Positions</h3>
        </div>
        <?php
//echo '<pre>';
//print_r($mem_groups);
//exit;
        ?>
        <div class="box-body">
            <div class="row" id="msg_create_notifications_div"></div>
            <div class="row">
                <form action="post" name="position_form" id="position_form">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-6">

                                <input id="hidden_group_id" name="hidden_group_id" type="hidden" value="<?php
                                if (!empty($group_id)) {
                                    echo $group_id;
                                }
                                ?>">

                                <div class="form-group">
                                    <label for="">Group</label>

                                    <?php
                                    echo form_dropdown('group_id" id="group_id" class="form-control text-left"', $mem_groups, isset($group_id) ? $group_id : '');
                                    ?>  
                                </div>



                            </div>
                            <div class="col-md-6">

                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Group Members</label>

                    </div>
                    <div class="col-md-4">
                        <label for="">Position</label>

                    </div>
                    <div class="col-md-4">
                        <label for="">Order</label>

                    </div>
                    <?php
                    foreach ($group_members as $value)
                    {
//                        print_r($value);
                        ?>
                    <div class="row group_positon">
                        <div class="col-md-4">
                            <div class="form-group">


                                <lable><?php echo $value['user_name_w_initials'] ?></lable>
                                <input type="hidden" name="gp_name[]" value="<?php echo $value['assigned_mem_id'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">


                                <input type="text" name="g_position[]" id="g_position" class="form-control" value="<?php echo isset($value['group_position']) ? $value['group_position'] : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">


                                <input type="number" name="position_order[]" id="position_order" class="form-control" value="<?php echo isset($value['position_order']) ? $value['position_order'] : ''; ?>" required>
                            </div>
                        </div>
                        </div>

                    <?php } ?>

                    <div class="col-md-12">
                        <?php
                        if (!empty($msg_details->msg_id)) {
                            ?>
                            <button type="button" id="update_positions" class="btn btn-success">Update message</button>
                            <?php
                        } else {
                            ?>
                            <button type="button" id="save_positions" class="btn btn-success">Save Positions</button>
                        <?php } ?>

                    </div>
                </form>


            </div>
        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

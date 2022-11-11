<?php $CI = & get_instance(); ?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">User groups</h3>

                    <div class="box-tools">
                   
                    <div class="row" style="margin-top: 20px;">
                        <?php if($this->ion_auth->is_admin() || $this->userpermission->checkUserPermissions2('user_add_group')){?>
                        <div class="col-sm-12">
                            <a href="<?php echo site_url('auth/create_group'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp; Add group</a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table" id="groups_table">
                        <thead style="font-size: 16px;">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>No of sub groups</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($groups as $group)
                            {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($group->description, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>

                                        <?php
                                        if ($CI->get_no_of_sub_groups($group->id) > 0) {
                                           // print_r("okkkka");die();
                                            echo $CI->get_no_of_sub_groups($group->id);
                                        } else {
                                            echo 'No sub groups!';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('auth/edit_group/' . $group->id); ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a> &nbsp; 
                                        <a href="#" data-toggle="tooltip" title="Delete" data-value="<?php echo $group->id ?>" class="btn btn-danger group_delete">
                                            <i class="fa fa-trash-o"></i> 
                                        </a>
                                    </td>
                                </tr>
    <?php $i++;
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



</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
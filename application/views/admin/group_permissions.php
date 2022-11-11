<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-users text-blue"></i>

            <h3 class="box-title">Group Permissions</h3>


        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="font-size: 16px;">Please select a group</label>
                        <select name="group_id" id="group_id" class="form-control">
                            <option value="0">Please select</option>
                            <?php
                            foreach ($groups as $group)
                            {
                                ?>
                                <option value="<?php echo $group['group_id']; ?>">
                                    <?php
                                    if ($group['parent'] != '') {
                                        echo $group['parent'] . '->' . $group['gname'];
                                    } else {
                                        echo $group['gname'];
                                    }
                                    ?>
                                </option>
<?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div style="max-height: 400px; overflow-y: scroll;">
                <div id="tree"></div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-primary" id="save_perms">Save</button>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

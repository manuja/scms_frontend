<?php $CI = & get_instance(); ?>

<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th width="7%">Actions</th>
    </tr>

    <?php
    $result = $CI->db->query("SELECT * FROM system_permissions WHERE level=2")->result_array();

    foreach ($result as $res)
    {
        $id = $res['id'];
        ?>


        <tr>
            <td><?= $res['name'] ?></td>
            <td>
                <!-- Start:Edit child -->
                <span class="update_any" data-toggle="modal" data-target="#child_edit<?= $id ?>">
                    <a data-toggle="tooltip" title="Edit <?php echo $res['name']; ?>?">
                        <span class="fa  fa-pencil" style="color:blue"></span>
                    </a>
                </span>
                <div class="modal fade" id="child_edit<?= $id ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit <?php echo $res['name']; ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="textinput">Child Permission </label> 

                                    <div class="col-md-9">

                                        <input id="child_perm_<?= $id ?>" value="<?php echo $res['name']; ?>" name="child_perm" type="text" placeholder="" class="form-control input-md">
                                        <input id="hidden_child_<?= $id ?>" value="<?php echo $id; ?>" name="hidden_child" type="hidden" placeholder="" class="form-control input-md">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" id="child_perm_edit" name="child_perm_edit" value="<?= $id ?>" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End:Edit child -->
            </td>
        </tr>

    <?php } ?>

</table>
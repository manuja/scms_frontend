<?php $CI = & get_instance(); ?>

<style>
    #pagination-demo{
        display: inline-block;
        margin-bottom: 1.75em;
    }
    #pagination-demo li{
        display: inline-block;
    }

    .page-content{
        background: #eee;
        display: inline-block;
        padding: 10px;
        width: 100%;
        max-width: 660px;
    }
</style>

<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th width="7%">Actions</th>
    </tr>

    <?php
    $result = $CI->db->query("SELECT * FROM system_permissions WHERE level=3")->result_array();

    foreach ($result as $res)
    {
        $id = $res['id'];
        ?>


        <tr>
            <td><?= $res['name'] ?></td>
            <td>
                <!-- Start:Edit grand child -->
                <span class="update_any" data-toggle="modal" data-target="#grandchild_edit<?= $id ?>">
                    <a data-toggle="tooltip" title="Edit <?php echo $res['name']; ?>?">
                        <span class="fa  fa-pencil" style="color:blue"></span>
                    </a>
                </span>
                <div class="modal fade" id="grandchild_edit<?= $id ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit <?php echo $res['name']; ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="textinput">Child Permission </label>  
                                    <div class="col-md-10">
                                        <input id="grand_perm_<?= $id ?>" value="<?php echo $res['name']; ?>" name="grand_perm" type="text" placeholder="" class="form-control input-md">
                                        <input id="hidden_grand_<?= $id ?>" value="<?php echo $id; ?>" name="hidden_grand" type="hidden" placeholder="" class="form-control input-md">

                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" id="grand_perm_edit" name="grand_perm_edit" value="<?php echo $id; ?>" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End:Edit grand child -->
            </td>
        </tr>

    <?php } ?>

</table>

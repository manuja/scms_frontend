    <?php $CI =& get_instance(); ?>
    <table class="table table-striped table-bordered">
      <tr>
        <th>Parent</th>
        <th width="20%">Child</th>
        <th>Grand child</td>
        <th width="7%">Actions</th>
      </tr>

    <?php $result=$CI->db->query("SELECT * FROM system_permissions WHERE parent_id=0")->result_array();

        if(sizeof($result)>0){
          foreach($result as $res){
            $pr_id=$res['id'];

            ?>
            <tr>
              <td valign="top"><?php echo $res['name']; ?></td>
              <td colspan="2">
                <table width="100%">
            <?php

            $result_sub=$CI->db->query("SELECT * FROM system_permissions WHERE parent_id=".$pr_id)->result_array();

            if(sizeof($result_sub) >0){
              foreach($result_sub as $res_sub){
                $sub_pr_id=$res_sub['id'];
                
                ?>
                  <tr>
                    <td width="27%" valign="top">

                      <?php echo $res_sub['name']; ?>
   
                        <span class="update_any" data-toggle="modal" data-target="#delete_child<?=$sub_pr_id?>">
                          <a data-toggle="tooltip" title="Delete <?php echo $res_sub['name']; ?>?">
                            <span class="fa  fa-close" style="color:red"></span>
                          </a>
                        </span>
                        <div class="modal fade" id="delete_child<?=$sub_pr_id?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Delete <?php echo $res_sub['name']; ?></h4>
                              </div>
                              <?php echo form_open('permissions/delete_child_permission');?>
                              <div class="modal-body">
                                <h4>Are you sure you want to delete the permission <?php echo $res_sub['name']; ?>?</h4>
                                <div class="col-sm-1">
                                    <input type="hidden" name="del_child_id" value="<?=$sub_pr_id?>">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-danger">Yes</button>
                              </div>
                              <?php echo form_close();?>
                            </div>
                          </div>
                        </div>
                        <!-- Start:Edit child -->
                        <span class="update_any" data-toggle="modal" data-target="#edit_child<?=$sub_pr_id?>">
                          <a data-toggle="tooltip" title="Edit <?php echo $res_sub['name']; ?>?">
                            <span class="fa  fa-pencil" style="color:blue"></span>
                          </a>
                        </span>
                        <div class="modal fade" id="edit_child<?=$sub_pr_id?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit <?php echo $res_sub['name']; ?></h4>
                              </div>
                              <?php echo form_open('Permissions/update_child'); ?>
                              <div class="modal-body">
                                <div class="row">
                                  

                                  <input type="hidden" name="child_id"  value="<?= $sub_pr_id ?>">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Name</label>
                                        <input type="text" class="form-control" id="childname<?= $sub_pr_id ?>" name="childname<?= $sub_pr_id ?>" value="<?=$res_sub['name']?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Code</label>
                                        <input type="text" class="form-control" id="childcode<?= $sub_pr_id ?>" name="childcode<?= $sub_pr_id ?>" value="<?=$res_sub['permission_code']?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Sequence</label>
                                        <input type="text" class="form-control" id="childsequence<?= $sub_pr_id ?>" name="childsequence<?= $sub_pr_id ?>" value="<?=$res_sub['sequence']?>">
                                    </div>
                                  </div>  
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="submit" class="btn btn-primary">Save</button>
                              </div>
                              <?php echo form_close();?>
                            </div>
                          </div>
                        </div>
                        <!-- End:Edit child -->
                    </td>
                    <td width="73%">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php

                $result_grand_sub=$CI->db->query("SELECT * FROM system_permissions WHERE parent_id=".$sub_pr_id)->result_array();

                if(sizeof($result_grand_sub) >0){
                  foreach($result_grand_sub as $res_grand_sub){
                    $grand_sub_pr_id=$res_grand_sub['id'];

                    //echo $grand_sub_pr_id.'<br>';

                    ?>
                      
                    <tr>
                      <td valign="top">
                        <?php echo $res_grand_sub['name']; ?>

                        <!-- Start:Delete grand child-->
                        <span class="update_any" data-toggle="modal" data-target="#del_grand_child<?=$grand_sub_pr_id?>">
                          <a data-toggle="tooltip" title="Delete <?php echo $res_grand_sub['name']; ?>?">
                            <span class="fa  fa-close" style="color:red"></span>
                          </a>
                        </span>

                        <div class="modal fade" id="del_grand_child<?=$grand_sub_pr_id?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Delete <?php echo $res_grand_sub['name']; ?></h4>
                              </div>
                              <?php echo form_open('permissions/delete_grand_child_permission');?>
                              <div class="modal-body">
                                <h4>Are you sure you want to delete the permission <?php echo $res_grand_sub['name']; ?>?</h4>
                                <div class="col-sm-1">
                                  
                                    
                                    <input type="hidden" name="grand_child_id" value="<?php echo $grand_sub_pr_id; ?>">
                                  
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Yes</button>
                              </div>
                              <?php echo form_close();?>
                            </div>
                          </div>
                        </div>
                        <!-- End:Delete grand child-->

                        <!-- Start:Edit grand child -->
                        <span class="update_any" data-toggle="modal" data-target="#edit_grandchild<?=$grand_sub_pr_id?>">
                          <a data-toggle="tooltip" title="Edit <?php echo $res_sub['name']; ?>?">
                            <span class="fa  fa-pencil" style="color:blue"></span>
                          </a>
                        </span>
                        <div class="modal fade" id="edit_grandchild<?=$grand_sub_pr_id?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit <?php echo $res_grand_sub['name']; ?></h4>
                              </div>
                              <?php echo form_open('permissions/update_grandchild'); ?>
                              <div class="modal-body">
                                <div class="row">
                                  
                                  <input type="hidden" name="grandchild_id"  value="<?= $grand_sub_pr_id ?>">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Name</label>
                                        <input type="text" class="form-control" id="grandchildname<?= $grand_sub_pr_id ?>" name="grandchildname<?= $grand_sub_pr_id ?>" value="<?=$res_grand_sub['name']?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Code</label>
                                        <input type="text" class="form-control" id="grandchildcode<?= $grand_sub_pr_id ?>" name="grandchildcode<?= $grand_sub_pr_id ?>" value="<?=$res_grand_sub['permission_code']?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Sequence</label>
                                        <input type="text" class="form-control" id="grandchildsequence<?= $grand_sub_pr_id ?>" name="grandchildsequence<?= $grand_sub_pr_id ?>" value="<?=$res_grand_sub['sequence']?>">
                                    </div>
                                  </div>  
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <input type="submit" name="submit" value="Save" class="btn btn-primary"></button>
                              </div>
                              <?php echo form_close();?>
                            </div>
                          </div>
                        </div>
                        <!-- End:Edit grand child -->
                      </td>
                    <?php

                    ?>
                    </tr>
                    <?php
                  }
                }else{

                  ?>
                    <tr>
                      <td height="25" colspan="2">&nbsp;</td>
                    </tr>
                  <?php
                }
                ?>
                      </table>
                    </td>
                  </tr>
                <?php
              }
            }else{

              ?>
                <tr>
                  <td width="27%">&nbsp;</td>
                  <td width="73%">&nbsp;</td>
                </tr>
              <?php

            }

            ?>
                </table>
                </td>
                <td>
                  <!-- Start:Delete parent permiision-->
                  <span class="update_any" data-toggle="modal" data-target="#del_parent<?=$pr_id?>">
                    <a data-toggle="tooltip" title="Delete <?php echo $res['name']; ?>?">
                      <span class="label label-danger"><span class="fa  fa-trash-o"></span></span> 
                    </a>
                  </span>

                  <div class="modal fade" id="del_parent<?=$pr_id?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Delete <?php echo $res['name']; ?></h4>
                        </div>
                        <?php echo form_open('permissions/delete_parent_permission');?>
                        <div class="modal-body">
                          <h4>Are you sure you want to delete the permission <?php echo $res['name']; ?>?</h4>
                          <div class="col-sm-1">
                            
                              
                              <input type="hidden" name="parent_id" value="<?php echo $pr_id; ?>">
                            
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-danger">Yes</button>
                        </div>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                  <!-- End:Delete parent permiision-->

                  <!-- Start:Edit parent permiision-->
                  <span class="update_any" data-toggle="modal" data-target="#edit_parent<?=$pr_id?>">
                    <a data-toggle="tooltip" data-placement="top" title="Edit <?php echo $res['name']; ?>?">
                      <span class="label label-primary"><span class="fa  fa-pencil-square-o"></span></span>
                    </a>
                  </span>

                  <div class="modal fade" id="edit_parent<?=$pr_id?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Edit <?php echo $res['name']; ?></h4>
                        </div>
                        <?php echo form_open('Permissions/update_parent'); ?>
                        <div class="modal-body">

                          <div class="row">
                            <input type="hidden" name="parent_id"  value="<?=$pr_id?>">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Name</label>
                                  <input type="text" class="form-control" id="parentname<?=$pr_id?>" name="parentname<?=$pr_id?>" value="<?=$res['name']?>">
                              </div>
                              <div class="form-group">
                                <label>Code</label>
                                  <input type="text" class="form-control" id="parentcode<?=$pr_id?>" name="parentcode<?=$pr_id?>" value="<?=$res['permission_code']?>">
                              </div>
                              <div class="form-group">
                                <label>Sequence</label>
                                  <input type="text" class="form-control" id="parentsequence<?= $pr_id ?>" name="parentsequence<?= $pr_id ?>" value="<?=$res['sequence']?>">
                              </div>
                            </div>  
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                          <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                  <!-- End:Edit parent permiision-->

                </td>
              </tr>
            <?php
          }
        }
    ?>
        <tr>
          <td height="25">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="4">&nbsp;</td>
        </tr>
    </table>
<?php

     //Get Logged User's Info
  
    // $user_id=$this->session->userdata('user_id');
    // $group_id = $this->userpermission->get_user_group($user_id);
    // print_r($user_id);
        // print_r($group_name);
         // User I 
        // User II 
        // User III

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Calling Directory Applications</h3>


                </div>
                <div id="mem_group_view_div"></div>
                <!-- /.box-header -->
                <input type="hidden" name="group_name" id="group_name" value="<?php echo $group_name;?>">
                <div class="row">
                    <?php
                    $user3 = $this->config_variables->getVariable('fin_dev_user_3_group_id');
                    $user2 = $this->config_variables->getVariable('fin_dev_user_2_group_id');
                    $user1 = $this->config_variables->getVariable('fin_dev_user_1_group_id');

                     $user_see_id = $this->session->userdata('user_id');
                     $group_id = $this->userpermission->get_user_group($user_see_id);
                    //  print_r($user_see_id);
                    //  echo "- ";
                    //  print_r($user1);

                    if ($group_id != $user1 && $group_id != $user2 && $group_id != $user3) {
                        ?>
                        <div class="col-md-12">
                            <a class="btn btn-success pull-right" style="margin: 5px;" href="<?php echo site_url('Add_calling_directory') ?>" data-toggle="tooltip" ><i class="fa fa-plus" aria-hidden="true"></i> Add Calling Directory Application</a>
                        </div>
                    <?php } ?>
                    <div class="row" style="margin-left:7px;margin-right:7px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select id="dir_dropdown" name="dir_dropdown" class="form-control" required>
                                    <option selected value="">Select directory type</option>
                                    <option value="1">Adjudicator</option>
                                    <option value="2">Arbitrator</option>
                                    <option value="3">Building Services Engineer</option>
                                    <option value="4">Structural Engineer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select id="status_dropdown" name="status_dropdown" class="form-control" required>
                                    <option selected value="">Select status</option>
                                    <option value="pending">Pending</option>
                                    <option value="ceo">CEO Approved</option>
                                    <option value="finance">Finance Approved</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <input type="hidden" id="approved_values" value="<?php echo $finace; ?>">
                        <div class="message_notification" id="message_notification"></div>
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <!--<div class="panel-heading"></div>-->


                            <div class="panel-body">
                                <table class="table calling_directory_view" id="view_adjudication_application" style="width: 100%"> 
                                    <thead> 
                                        <tr> 
                                            <th>Directory Type</th>
                                            <th>Directory Title</th>
                                            <th style="width: 10%">Registration open date</th>
                                            <th style="width: 10%">Registration close date</th>
                                            <!--<th>Total Invitees/confirmed</th>-->
                                            <th style="width: 15%">Current Status</th>
                                            <th style="width: 10%">Actions</th>
                                            <?php
                                                if ($group_id == $user1 | $group_id == $user2 | $group_id == $user3) {
                                            
                                            ?>
                                            <th></th>
                                                <?php }else{?>

                                            <th>Active/Publish Status</th>

                                            <?php 
                                                }
                                            ?>
                                             <th style="width: 10%"><?php if ($group_id == $user1 | $group_id == $user2 | $group_id == $user3) {echo "";}else{echo "Applications";}?></th>   
                                        </tr> 
                                    </thead> 
                                    <tbody>
                                    </tbody>
                                </table> 
                            </div>

                        </div>

                    </div>
                </div>

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
<div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Please leave a comment</h4>
            </div>
            <div class="modal-body">
            <form method="POST" id="form_active_status">
                <input type="hidden" id="directory_id" name="directory_id">
                <input type="hidden" id="dir_type" name="dir_type">
                <input type="hidden" id="active_status" name="active_status">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-6">
                                <textarea rows="4" cols="61" id="comment" name="comment" placeholder="Text here...." required>

                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="btn_save_modal" name="btn_save_modal" class="btn btn-primary">Save changes</button>
            </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="verifyModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Please leave a comment</h4>
            </div>
            <div class="modal-body">
            <form method="POST" id="form_verify">
                <input type="hidden" id="vdirectory_id" name="vdirectory_id">
                <input type="hidden" id="vdir_type" name="vdir_type">
                <input type="hidden" id="verify_status" name="verify_status">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-6">
                                <textarea rows="4" cols="61" id="vcomment" name="vcomment" placeholder="Text here...." required>

                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="btn_save_modal" name="btn_save_modal" class="btn btn-primary">Save changes</button>
            </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</section>



</div>
<!-- /.content-wrapper -->
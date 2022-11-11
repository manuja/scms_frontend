
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Report Permissions</h3>


            </div>
            <?php
//            echo '<pre>';
//            print_r($this->session->userdata('user_id'));
            ?>
            <div id="mem_group_view_div"></div>
            <!-- /.box-header -->
            <div class="row"><div class="message_notification" id="message_notification"></div>

            </div>
            <input id="user_id" type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                    <div class="panel panel-default">

                        <!-- Default panel contents -->
                        <div class="panel-heading"></div>


                        <div class="panel-body">
                            <table class="table report_permission_view" id="report_permission_view" style="width: 100%"> 
                                <thead> 
                                    <tr> 
                                        <!--<th>Message Title</th>-->
                                        <th>Name</th>
                                        <th>Report Name</th>
                                        <th>Created Date</th>
                                        <th>Total Invitees</th>
                                        <th>Actions</th>
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


<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Total Invites</h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td>Invites</td>

                        </tr>
                        <tr>
                            <td><div id="tot_invites"></div></td>

                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
<!-- /.content-wrapper -->
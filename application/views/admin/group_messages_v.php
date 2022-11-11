
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Membership Group Messages</h3>


            </div>
            <div id="mem_group_view_div"></div>
            <!-- /.box-header -->
            <div class="row"><div class="message_notification" id="message_notification"></div>

            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                    <div class="panel panel-default">
                        <div style="margin-bottom: 20px; margin-left: 20px; margin-top: 20px;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="<?php echo site_url('Membership_Groups/send_message/' . $group_id); ?>" class="btn btn-success">
                                        <i class="fa fa-plus"></i> &nbsp; Create Message
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" id="group_id" value="<?php echo $group_id; ?>">
                        </div>
                        <!-- Default panel contents -->
                        <div class="panel-heading"></div>


                        <div class="panel-body">
                            <table class="table group_messages_view" id="group_messages_view" style="width: 100%"> 
                                <thead> 
                                    <tr> 
                                        <th>Message Title</th>
                                        <th>Message</th>
                                        <th>Created On</th>
                                        <th>Created By</th>
                                        <!--<th>Total Invitees/confirmed</th>-->
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
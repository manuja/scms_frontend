
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Membership Group Meetings</h3>

                <div class="box-tools">
                </div>
            </div>
            <div id="mem_group_view_div"></div>
            <!-- /.box-header -->

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div style="margin-bottom: 20px; margin-left: 20px; margin-top: 20px;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="<?php echo site_url('Membership_Groups/schedule_meeting/'.$group_id); ?>" class="btn btn-success">
                                        <i class="fa fa-calendar"></i> &nbsp; Schedule Meeting
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Default panel contents -->
                        <!--<div class="panel-heading">Membership Group Meetings</div>-->
                        <input type="hidden" id="group_id" value="<?php echo $group_id ?>"
                               <div class="panel-body">
                            <table class="table group_meetings_view" id="group_meetings_view" style="width: 100%"> 
                                <thead> 
                                    <tr> 
                                        <th>Meeting Title</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Venue</th>
                                        <th>Created On</th>
                                        <th>Created By</th>
                                        <th>Total Invitees/confirmed</th>
                                        <!--<th>Participation Confirmed</th>-->
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Total Invitees</h4>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Invites</h2>
                            <h3 id="tot_invites">0</h3>
                        </div>
                        <div class="col-md-4">
                             <h2>Confirmed</h2>
                             <h3 id="tot_confirmed">0</h3>
                        </div>
                        <div class="col-md-4">
                             <h2>Reject</h2>
                             <h3 id="tot_reject">0</h3>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


</div>

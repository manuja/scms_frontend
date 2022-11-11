    <?php 
    $operationalUserLevel = $this->config_variables->getVariable('operationalUserLevel');
    $managerialUserLevel = $this->config_variables->getVariable('managerialUserLevel');
    $topManagementUserLevel = $this->config_variables->getVariable('topManagementUserLevel');

    ?>

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>System Notifications</h1>
<!--        <div class="breadcrumb-holder pull-right">-->
<!--            --><?php //echo $breadcrumbs; ?>
<!--        </div>-->
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <!-- Box Comment -->
                <div class="box box-widget">

                    <!-- /.box-header -->
                    <div class="box-body">

                        <form id="reg_form" action="#asdasd" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form">
                            <div class="col-md-12">

                                <?php if($intiatingUserAccessLevel==$managerialUserLevel || $intiatingUserAccessLevel==$topManagementUserLevel 
                                        || $intiatingUserAccessLevel==85 || $intiatingUserAccessLevel==84 
                                        || $intiatingUserAccessLevel==37 || $intiatingUserAccessLevel==38){ ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                        <a href="<?php echo base_url('SystemNotification/getNotificationForm'); ?>"><button class="btn btn-primary" type="button">Add New</button></a>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="search_filter_noti_category">Category: </label>
                                            <select id="search_filter_noti_category" class="form-control" name="select1" onchange="loadDataTable()">
                                                <option value="" >Select</option>
                                                <?php foreach ($MasterNotificationCategory as $MasterNotificationCategoryItem){ ?>
                                                    <option value="<?php echo $MasterNotificationCategoryItem['master_notification_category_id']; ?>"><?php echo $MasterNotificationCategoryItem['master_notification_category_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="search_filter_noti_priority">Priority: </label>
                                            <select id="search_filter_noti_priority" class="form-control" name="select1" onchange="loadDataTable()">
                                                <option value="" >Select</option>
                                                <?php foreach ($MasterNotificationPriority as $MasterNotificationPriorityItem){ ?>
                                                    <option value="<?php echo $MasterNotificationPriorityItem['master_notification_priority_id']; ?>"><?php echo $MasterNotificationPriorityItem['master_notification_priority_name']; ?></option>
                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="search_filter_search">Search: </label>
                                            <input id="search_filter_search" type="text" class="form-control" placeholder="Search by Excerpt, Message, Hyperlink" onkeyup="loadDataTable()" onchange="loadDataTable()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="form-group col-md-6 col-xs-6">
                                                <label for="search_filter_date_from">From: </label>
                                                <input type="text" id="search_filter_date_from" class="form-control" name="date1">
                                            </div>
                                            <div class="form-group col-md-6 col-xs-6">
                                                <label for="search_filter_date_to">To: </label>
                                                <input type="text" id="search_filter_date_to" class="form-control" name="date1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-6 col-xs-6">
                                                <label for="search_filter_clear">&nbsp;</label>
                                                <button id="search_filter_clear" class="btn btn-default buttons-collection form-control">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </form>

                        <div class="col-md-12" >
                            <table class="table table-striped member_application_list_table" id="member_application_list_table" style="width: 100%">
                                <thead>
                                <tr>
                                    <th style="width: 10%">Notification No</th>
                                    <th style="width: 10%">Category</th>
                                    <th style="width: 10%">Priority</th>
                                    <th style="width: 10%">Excerpt</th>
                                    <th style="width: 10%">Message</th>
                                    <th style="width: 10%">Hyperlink</th>
                                    <th style="width: 10%">Date Submitted</th>
                                    <th style="width: 10%">Expire Date</th>
                                    <th style="width: 10%">Initiator</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>




                        <div class="modal fade" id="modal-edit-status">
                            <div class="modal-dialog  modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h3 class="modal-title">Change Application Status</h3>
                                    </div>
                                    <div class="modal-body">
                                        No Data

                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div id="memberDetails" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h2 class="modal-title text-center" id="memberName"></h2>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center" style="margin-bottom: 20px;">
                                            <img class="img-circle img-bordered-sm" width="128" height="128" alt="User Image" id="userImg">
                                        </div>
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Application No</th>
                                                <td id="appNo"></td>
                                            </tr>
                                            <tr>
                                                <th>Class of Membership</th>
                                                <td id="membershipClass"></td>
                                            </tr>
                                            <tr>
                                                <th>Engineering Discipline</th>
                                                <td id="engineeringDiscipline"></td>
                                            </tr>
                                            <tr>
                                                <th>NIC</th>
                                                <td id="memberNIC"></td>
                                            </tr>
                                            <tr>
                                                <th>Date Submitted</th>
                                                <td id="dateSubmitted"></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td id="memberStatus"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="col-sm-6 text-left">
                                            <a href="<?php echo site_url('membership_applications/show_full_application'); ?>" class="btn btn-primary"><i class="fa fa-eye"></i> &nbsp; View Full Application</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box -->
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


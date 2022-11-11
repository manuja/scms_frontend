<style type="text/css">
    .divideli{
        width: 49%;
        display: inline-block;
    }
    .filter-block{
        display: none;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {display:none;}

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Initiate Notification</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="form2msg"></div>
                        <form data-toggle="validator" role="form" enctype="multipart/form-data" action="#" method="post" id="send_notification_form">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4 class="box-title">Notification Information</h4>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Excerpt(Title)</label>
                                                        <input required type="text" name="notification_text_short" class="form-control length_limit" maxlength="40">
                                                        <small class="character-limit"></small>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Message</label>
                                                        <input required type="text" name="notification_text_long" class="form-control length_limit" maxlength="90">
                                                        <div class="help-block with-errors"></div>
                                                        <small class="character-limit"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Hyperlink</label>
                                                        <input required type="url" name="notification_hyperlink" class="form-control">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Expiration Date (Leave blank for deafult value)</label>
                                                        <input type="text" name="notification_expire" class="form-control notification_expire" id="notification_expire">
                                                        <div class="help-block with-errors"></div>
                                                        <small class="exp-duration"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="notification_thumbnail">Picture Upload: <i class="fa fa-info-circle" style="cursor:help;" aria-hidden="true" title="File Types: jpg | png (Max Size: 1MB)"></i></label><br/>
                                                        <label class="btn btn-primary"> Browse...
                                                            <input type="file" id="notification_thumbnail" name="notification_thumbnail" accept=".jpg, .jpeg, .png" hidden>
                                                        </label>
                                                        <span class="label label-info file_info"></span>
                                                        <span id="thumb_clear_button" class="btn btn-warning" title="Remove Thumbnail" style="display: none;"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                                        <div class="help-block with-errors"></div>
                                                        <div class="row error-block"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Category</label>
                                                        <select name="notification_category" class="form-control">
                                                            <option value="" selected>Please select...</option>
                                                            <?php foreach ($MasterNotificationCategory as $MasterNotificationCategoryItem) { ?>
                                                                <option value="<?php echo $MasterNotificationCategoryItem['master_notification_category_id']; ?>"><?php echo $MasterNotificationCategoryItem['master_notification_category_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Priority</label>
                                                        <select name="notification_priority" class="form-control">
                                                            <option value="" selected>Please select...</option>
                                                            <?php foreach ($MasterNotificationPriority as $MasterNotificationPriorityItem) { ?>
                                                                <option value="<?php echo $MasterNotificationPriorityItem['master_notification_priority_id']; ?>"><?php echo $MasterNotificationPriorityItem['master_notification_priority_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4 class="box-title">Notification Receivers Filters</h4>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div>
<!--                                                        <label class="switch">-->
                                                            <input type="hidden" id="notification_bulk_switch" name="notification_bulk_switch" value="0">
<!--                                                            <input type="checkbox" id="notification_bulk_switch" name="notification_bulk_switch" value="1">-->
<!--                                                            <span class="slider round"></span>-->
<!--                                                        </label>-->

                                                        <ul class="nav nav-tabs">
                                                            <li class="active"><a data-toggle="tab" id="notification_mass_head" class="notification-section-head" href="#notification_mass">Bulk Notification(Members)</a></li>
                                                            <li><a data-toggle="tab" id="notification_single_head" class="notification-section-head" href="#notification_single">Single Notification(Member)</a></li>
                                                            <li><a data-toggle="tab" id="notification_staff_head" class="notification-section-head" href="#notification_staff">Bulk Notification(Staff)</a></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div id="notification_mass" class="tab-pane fade in active form-group">
                                                                <div class="checkbox"><label><input type="checkbox" id="filter_member_class" value="1" name="member_class_only" class="filter-header"> Member Categories</label></div>
                                                                <div class="row filter-block filter_member_class" style="">
                                                                    <div class="col-sm-12" style="padding-left: 50px;">
                                                                        <?php foreach ($MasterMembershipClass as $MasterMembershipClassItem){ ?>
                                                                            <div class="checkbox divideli"><label><input class="checkclass" name="filter_member_class[]" value="<?php echo $MasterMembershipClassItem['class_of_membership_id']; ?>" type="checkbox"><?php echo $MasterMembershipClassItem['class_of_membership_name']; ?></label></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>

                                                                <div class="checkbox"><label><input type="checkbox" id="filter_member_discipline" value="1" name="member_discipline_only" class="filter-header"> Member Disciplines</label></div>
                                                                <div class="row filter-block filter_member_discipline" style="">
                                                                    <div class="col-sm-12" style="padding-left: 50px;">
                                                                        <?php foreach ($MasterEngineeringDiscipline as $MasterEngineeringDisciplineItem){ ?>
                                                                            <div class="checkbox divideli"><label><input class="checkclass" name="filter_member_discipline[]" value="<?php echo $MasterEngineeringDisciplineItem['core_engineering_discipline_id']; ?>" type="checkbox"><?php echo $MasterEngineeringDisciplineItem['core_engineering_discipline_name']; ?></label></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>

                                                                <div class="checkbox"><label><input type="checkbox" id="filter_member_group" value="1" name="member_group_only" class="filter-header"> Member Groups</label></div>
                                                                <div class="row filter-block filter_member_group" style="">
                                                                    <div class="col-sm-12" style="padding-left: 50px;">
                                                                        <?php foreach ($MemberGroups as $MemberGroupsItem){ ?>
                                                                            <div class="checkbox divideli"><label><input class="checkclass" name="filter_member_group[]" value="<?php echo $MemberGroupsItem['mem_group_id']; ?>" type="checkbox"><?php echo $MemberGroupsItem['mem_goup_name']; ?></label></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>

                                                                <div class="checkbox"><label><input type="checkbox" id="filter_province" value="1" name="member_province_only" class="filter-header"> Provinces</label></div>
                                                                <div class="row filter-block filter_province" style="">
                                                                    <div class="col-sm-12" style="padding-left: 50px;">
                                                                        <?php foreach ($MasterProvinces as $MasterProvincesItem){ ?>
                                                                            <div class="checkbox divideli"><label><input class="checkclass" name="filter_member_province[]" value="<?php echo $MasterProvincesItem['sl_provinces_id']; ?>" type="checkbox"><?php echo $MasterProvincesItem['province_name']; ?></label></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div id="notification_single" class="tab-pane fade">
                                                                <div class="row">
                                                                    <div class="col-sm-5">
                                                                        <label for="">Member Name</label>
                                                                        <input type="text" id="single_member_picker_name" class="form-control" placeholder="Search...(3 or more characters)">
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <label for="">Member Membership Number</label>
                                                                        <input type="text" id="single_member_picker_memnum" class="form-control" placeholder="Search...(3 or more characters)">
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <label for="">&nbsp;</label><br>
                                                                        <button id="clear_single_member" class="btn btn-default">Clear</button>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="">Member Id</label>
                                                                            <input type="text" name="single_member_id" id="single_member_id" class="form-control" onfocus="blur();" style="background-color: #eee;opacity: 1;">
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="">Member Name</label>
                                                                            <input type="text" name="single_member_name" id="single_member_name" class="form-control" onfocus="blur();" style="background-color: #eee;opacity: 1;">
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="">Membership Number</label>
                                                                            <input type="text" name="single_member_memnum" id="single_member_memnum" class="form-control" onfocus="blur();" style="background-color: #eee;opacity: 1;">
                                                                            <div class="help-block with-errors"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div id="notification_staff" class="tab-pane fade">
                                                                <div class="col-sm-12" style="padding-left: 50px;">
                                                                <?php
                                                                $parentId = 0;
                                                                foreach ($staffGroups as $staffGroup){
                                                                    if($staffGroup['parent_id'] != $parentId){
                                                                        echo "<br><hr><strong>".$staffGroup['parent']."</strong><br>";
                                                                        $parentId = $staffGroup['parent_id'];
                                                                    }
                                                                    ?>

                                                                    <div class="checkbox col-md-4 col-sm-4 col-xs-6"><label><input class="checkclass" name="filter_staff_group[]" value="<?php echo $staffGroup['group_id']; ?>" type="checkbox"><?php if($staffGroup['parent']){ echo $staffGroup['parent'].' - '; } echo $staffGroup['gname']; ?></label></div>
                                                                <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-success" id="submit_notification"><i class="fa fa-paper-plane-o"></i> &nbsp; Send Notification</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
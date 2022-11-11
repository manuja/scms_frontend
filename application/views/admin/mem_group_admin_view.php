<style>
</style>

<?php
//    print_r($groups);
//    exit;
?>
<style>
    body{margin-top:20px;
         background:#eee;
    }

    .profile-widget {
        position: relative;
    }
    .profile-widget .image-container {
        background-size: cover;
        background-position: center;
        /*padding: 190px 0 10px;*/
    }
    .profile-widget .image-container .profile-background {
        width: 100%;
        height: auto;
    }
    .profile-widget .image-container .avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto -60px;
        display: block;
    }


    /* Component: Mini Profile Widget */
    .mini-profile-widget .image-container .avatar {
        width: 180px;
        height: 180px;
        display: block;
        margin: 0 auto;
        border-radius: 50%;
        background: white;
        padding: 4px;
        border: 1px solid #dddddd;
    }
    .mini-profile-widget .details {
        text-align: center;
    }

    /* Component: Panel */
    .panel {
        border-radius: 0;
        margin-bottom: 30px;
    }
    .panel.solid-color {
        color: white;
    }
    .panel .panel-heading {
        border-radius: 0;
        position: relative;
    }
    .panel .panel-heading > .controls {
        position: absolute;
        right: 10px;
        top: 12px;
    }
    .panel .panel-heading > .controls .nav.nav-pills {
        margin: -8px 0 0 0;
    }
    .panel .panel-heading > .controls .nav.nav-pills li a {
        padding: 5px 8px;
    }
    .panel .panel-heading .clickable {
        margin-top: 0px;
        font-size: 12px;
        cursor: pointer;
    }
    .panel .panel-heading.no-heading-border {
        border-bottom-color: transparent;
    }
    .panel .panel-heading .left {
        float: left;
    }
    .panel .panel-heading .right {
        float: right;
    }
    .panel .panel-title {
        font-size: 16px;
        line-height: 20px;
    }
    .panel .panel-title.panel-title-sm {
        font-size: 18px;
        line-height: 28px;
    }
    .panel .panel-title.panel-title-lg {
        font-size: 24px;
        line-height: 34px;
    }
    .panel .panel-body {
        font-size: 13px;
    }
    .panel .panel-body > .body-section {
        margin: 0px 0px 20px;
    }
    .panel .panel-body > .body-section > .section-heading {
        margin: 0px 0px 5px;
        font-weight: bold;
    }
    .panel .panel-body > .body-section > .section-content {
        margin: 0px 0px 10px;
    }
    .panel-white {
        border: 1px solid #dddddd;
    }
    .panel-white > .panel-heading {
        color: #333;
        background-color: #fff;
        border-color: #ddd;
    }
    .panel-white > .panel-footer {
        background-color: #fff;
        border-color: #ddd;
    }
    .panel-primary {
        border: 1px solid #dddddd;
    }
    .panel-purple {
        border: 1px solid #dddddd;
    }
    .panel-purple > .panel-heading {
        color: #fff;
        background-color: #8e44ad;
        border: none;
    }
    .panel-purple > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-light-purple {
        border: 1px solid #dddddd;
    }
    .panel-light-purple > .panel-heading {
        color: #fff;
        background-color: #9b59b6;
        border: none;
    }
    .panel-light-purple > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-blue,
    .panel-info {
        border: 1px solid #dddddd;
    }
    .panel-blue > .panel-heading,
    .panel-info > .panel-heading {
        color: #fff;
        background-color: #2980b9;
        border: none;
    }
    .panel-blue > .panel-heading .panel-title a:hover,
    .panel-info > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-light-blue {
        border: 1px solid #dddddd;
    }
    .panel-light-blue > .panel-heading {
        color: #fff;
        background-color: #3498db;
        border: none;
    }
    .panel-light-blue > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-green,
    .panel-success {
        border: 1px solid #dddddd;
    }
    .panel-green > .panel-heading,
    .panel-success > .panel-heading {
        color: #fff;
        background-color: #27ae60;
        border: none;
    }
    .panel-green > .panel-heading .panel-title a:hover,
    .panel-success > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-light-green {
        border: 1px solid #dddddd;
    }
    .panel-light-green > .panel-heading {
        color: #fff;
        background-color: #2ecc71;
        border: none;
    }
    .panel-light-green > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-orange,
    .panel-warning {
        border: 1px solid #dddddd;
    }
    .panel-orange > .panel-heading,
    .panel-warning > .panel-heading {
        color: #fff;
        background-color: #e82c0c;
        border: none;
    }
    .panel-orange > .panel-heading .panel-title a:hover,
    .panel-warning > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-light-orange {
        border: 1px solid #dddddd;
    }
    .panel-light-orange > .panel-heading {
        color: #fff;
        background-color: #ff530d;
        border: none;
    }
    .panel-light-orange > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-red,
    .panel-danger {
        border: 1px solid #dddddd;
    }
    .panel-red > .panel-heading,
    .panel-danger > .panel-heading {
        color: #fff;
        background-color: #d40d12;
        border: none;
    }
    .panel-red > .panel-heading .panel-title a:hover,
    .panel-danger > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-light-red {
        border: 1px solid #dddddd;
    }
    .panel-light-red > .panel-heading {
        color: #fff;
        background-color: #ff1d23;
        border: none;
    }
    .panel-light-red > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-pink {
        border: 1px solid #dddddd;
    }
    .panel-pink > .panel-heading {
        color: #fff;
        background-color: #fe31ab;
        border: none;
    }
    .panel-pink > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-light-pink {
        border: 1px solid #dddddd;
    }
    .panel-light-pink > .panel-heading {
        color: #fff;
        background-color: #fd32c0;
        border: none;
    }
    .panel-light-pink > .panel-heading .panel-title a:hover {
        color: #f0f0f0;
    }
    .panel-group .panel {
        border-radius: 0;
    }
    .panel-group .panel + .panel {
        margin-top: 0;
        border-top: 0;
    }

    .bg-blue,
    .bg-info {
        background-color: #2980b9 !important;
    }
    .bg-light-blue {
        background-color: #3498db !important;
    }
    .bg-red,
    .bg-danger {
        background-color: #d40d12 !important;
    }
    .bg-light-red {
        background-color: #ff1d23 !important;
    }
    .bg-purple {
        background-color: #8e44ad !important;
    }
    .bg-light-purple {
        background-color: #9b59b6 !important;
    }
    .bg-green,
    bg-success {
        background-color: #27ae60 !important;
    }
    .bg-light-green {
        background-color: #2ecc71 !important;
    }
    .bg-orange,
    .bg-warning {
        background-color: #e82c0c !important;
    }
    .bg-light-orange {
        background-color: #ff530d !important;
    }
    .bg-pink {
        background-color: #fe31ab !important;
    }
    .bg-light-pink {
        background-color: #fd32c0 !important;
    }
    .color-white {
        color: white !important;
    }
    .color-green,
    .text-success {
        color: #27ae60 !important;
    }
    .color-light-green {
        color: #2ecc71 !important;
    }
    .color-blue,
    .text-info {
        color: #2980b9 !important;
    }
    .color-light-blue {
        color: #3498db !important;
    }
    .color-orange,
    .text-warning {
        color: #e82c0c !important;
    }
    .color-light-orange {
        color: #ff530d !important;
    }
    .color-red,
    .text-danger {
        color: #d40d12 !important;
    }
    .color-light-red {
        color: #ff1d23 !important;
    }
    .color-purple {
        color: #8e44ad !important;
    }
    .color-light-purple {
        color: #9b59b6 !important;
    }
    .color-pink {
        color: #fe31ab !important;
    }
    .color-light-pink {
        color: #fd32c0 !important;
    }
    .border-green {
        border: 4px solid #27ae60 !important;
    }
    .border-light-green {
        border: 4px solid #2ecc71 !important;
    }
    .border-blue {
        border: 4px solid #2980b9 !important;
    }
    .border-light-blue {
        border: 4px solid #3498db !important;
    }
    .border-orange {
        border: 4px solid #e82c0c !important;
    }
    .border-light-orange {
        border: 4px solid #ff530d !important;
    }
    .border-red {
        border: 4px solid #d40d12 !important;
    }
    .border-light-red {
        border: 4px solid #ff1d23 !important;
    }
    .border-purple {
        border: 4px solid #8e44ad !important;
    }
    .border-light-purple {
        border: 4px solid #9b59b6 !important;
    }
    .border-pink {
        border: 4px solid #fe31ab !important;
    }
    .border-light-pink {
        border: 4px solid #fd32c0 !important;
    }
    .border-top-green {
        border-top: 4px solid #27ae60 !important;
    }
    .border-top-light-green {
        border-top: 4px solid #2ecc71 !important;
    }
    .border-top-blue {
        border-top: 4px solid #2980b9 !important;
    }
    .border-top-light-blue {
        border-top: 4px solid #3498db !important;
    }
    .border-top-orange {
        border-top: 4px solid #e82c0c !important;
    }
    .border-top-light-orange {
        border-top: 4px solid #ff530d !important;
    }
    .border-top-red {
        border-top: 4px solid #d40d12 !important;
    }
    .border-top-light-red {
        border-top: 4px solid #ff1d23 !important;
    }
    .border-top-purple {
        border-top: 4px solid #8e44ad !important;
    }
    .border-top-light-purple {
        border-top: 4px solid #9b59b6 !important;
    }
    .border-top-pink {
        border-top: 4px solid #fe31ab !important;
    }
    .border-top-light-pink {
        border-top: 4px solid #fd32c0 !important;
    }
    .border-right-green {
        border-right: 4px solid #27ae60 !important;
    }
    .border-right-light-green {
        border-right: 4px solid #2ecc71 !important;
    }
    .border-right-blue {
        border-right: 4px solid #2980b9 !important;
    }
    .border-right-light-blue {
        border-right: 4px solid #3498db !important;
    }
    .border-right-orange {
        border-right: 4px solid #e82c0c !important;
    }
    .border-right-light-orange {
        border-right: 4px solid #ff530d !important;
    }
    .border-right-red {
        border-right: 4px solid #d40d12 !important;
    }
    .border-right-light-red {
        border-right: 4px solid #ff1d23 !important;
    }
    .border-right-purple {
        border-right: 4px solid #8e44ad !important;
    }
    .border-right-light-purple {
        border-right: 4px solid #9b59b6 !important;
    }
    .border-right-pink {
        border-right: 4px solid #fe31ab !important;
    }
    .border-right-light-pink {
        border-right: 4px solid #fd32c0 !important;
    }
    .border-bottom-green {
        border-bottom: 4px solid #27ae60 !important;
    }
    .border-bottom-light-green {
        border-bottom: 4px solid #2ecc71 !important;
    }
    .border-bottom-blue {
        border-bottom: 4px solid #2980b9 !important;
    }
    .border-bottom-light-blue {
        border-bottom: 4px solid #3498db !important;
    }
    .border-bottom-orange {
        border-bottom: 4px solid #e82c0c !important;
    }
    .border-bottom-light-orange {
        border-bottom: 4px solid #ff530d !important;
    }
    .border-bottom-red {
        border-bottom: 4px solid #d40d12 !important;
    }
    .border-bottom-light-red {
        border-bottom: 4px solid #ff1d23 !important;
    }
    .border-bottom-purple {
        border-bottom: 4px solid #8e44ad !important;
    }
    .border-bottom-light-purple {
        border-bottom: 4px solid #9b59b6 !important;
    }
    .border-bottom-pink {
        border-bottom: 4px solid #fe31ab !important;
    }
    .border-bottom-light-pink {
        border-bottom: 4px solid #fd32c0 !important;
    }
    .border-left-green {
        border-left: 4px solid #27ae60 !important;
    }
    .border-left-light-green {
        border-left: 4px solid #2ecc71 !important;
    }
    .border-left-blue {
        border-left: 4px solid #2980b9 !important;
    }
    .border-left-light-blue {
        border-left: 4px solid #3498db !important;
    }
    .border-left-orange {
        border-left: 4px solid #e82c0c !important;
    }
    .border-left-light-orange {
        border-left: 4px solid #ff530d !important;
    }
    .border-left-red {
        border-left: 4px solid #d40d12 !important;
    }
    .border-left-light-red {
        border-left: 4px solid #ff1d23 !important;
    }
    .border-left-purple {
        border-left: 4px solid #8e44ad !important;
    }
    .border-left-light-purple {
        border-left: 4px solid #9b59b6 !important;
    }
    .border-left-pink {
        border-left: 4px solid #fe31ab !important;
    }
    .border-left-light-pink {
        border-left: 4px solid #fd32c0 !important;
    }

    .btn-blue {
        background-color: #3498db;
        border-color: #3498db;
        color: white;
    }
    .btn-blue:hover,
    .btn-blue:visited {
        background-color: #2980b9;
        color: white;
    }
    .btn-green {
        background-color: #2ecc71;
        border-color: #27ae60;
        color: white;
    }
    .btn-green:hover,
    .btn-green:visited {
        background-color: #27ae60;
        color: white;
    }
    .btn-orange {
        background-color: #ff530d;
        border-color: #e82c0c;
        color: white;
    }
    .btn-orange:hover,
    .btn-orange:visited {
        background-color: #e82c0c;
        color: white;
    }
    .btn-red {
        background-color: #ff1d23;
        border-color: #d40d12;
        color: white;
    }
    .btn-red:hover,
    .btn-red:visited {
        background-color: #d40d12;
        color: white;
    }
    .btn-purple {
        background-color: #9b59b6;
        border-color: #8e44ad;
        color: white;
    }
    .btn-purple:hover,
    .btn-purple:visited {
        background-color: #8e44ad;
        color: white;
    }
    .btn-pink {
        background-color: #fd32c0;
        border-color: #fe31ab;
        color: white;
    }
    .btn-pink:hover,
    .btn-pink:visited {
        background-color: #fe31ab;
        color: white;
    }

    .progress.progress-xs {
        height: 12px;
    }

    /*************************/



    .profile-section:after,
    .profile-section:before {
        content: '';
        display: table;
        clear: both
    }

    .profile-section .title {
        font-size: 20px;
        margin: 0 0 15px
    }

    .profile-section .title small {
        font-weight: 400
    }

    .bg-white {
        background-color: #fff!important;
    }
    .p-10 {
        padding: 10px!important;
    }
    .media.media-xs .media-object {
        width: 32px;
    }
    .m-b-2 {
        margin-bottom: 2px!important;
    }
    .media>.media-left, .media>.pull-left {
        padding-right: 15px;
    }
    .media-body, .media-left, .media-right {
        display: table-cell;
        vertical-align: top;
    }
    .details h4 {
        font-size: 25px;
        color: #2f2f2f;
    }

    .details {
        font-size: 14px;
        line-height: 23px;
        color: #6d6d6d;
        letter-spacing: 0.5px;
        padding: 15px;
        border-bottom: solid 1px;
        margin-right: 21px;
        border-bottom-color: #eaeaea;
    }

    .member-group-members .profile_img img {
        width: 100%;
    }
    .member-group-members p {
        font-size: 9px;
        text-align: center;
    }
    .member-group-members ul li {
        display: inline-block;
        text-align: center;
        width: 152px;
    }
    .member-group-members ul li img {
        width: 100px !important;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Membership Groups</h3>
                    <div id="12345"></div>
                    <div class="box-tools">
                    </div>
                </div>
                <?php
//                print_r($group_info);
//                exit;
//                
                ?>
                <!-- /.box-header -->

                <div class="row">
                    <div class="col-md-10 col-sm-offset-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white profile-widget">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="group_members-img">  
                                                <img src="<?php echo base_url(); ?><?php echo $group_info[0]->mem_group_image_path ?>"class="avatar">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="details">
                                                <h4><?php echo $group_info[0]->mem_goup_name; ?><i class="fa fa-sheild"></i></h4>
                                                <div><?php echo $group_info[0]->mem_group_description; ?></div>
                                                <!--                                            <div>Attended University of Bootdey.com</div>
                                                                                            <div>Bootdey Land</div> -->
                                                <div class="mg-top-10">
                                                    <?php
                                                    foreach ($group_info as $value)
                                                    {
                                                        echo '<i class="fa fa-check-square">&nbsp;' . $value->core_engineering_discipline_name . '</i> &nbsp; &nbsp;';
                                                    }
                                                    ?>
                                                    <!--                                                <a href="#" class="btn btn-blue">Followers</a>
                                                                                                    <a href="#" class="btn btn-green">Following</a>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="">
                                                <div class="panel-heading member-group-profile">
                                                    <div class="controls pull-right">

                                                    </div>
                                                </div>
                                                <div class=""> 
                                                    <div class="group_members">
                                                        <ul class="profile-infor-inline">
                                                            <li><a href="<?php echo site_url() ?>Membership_Groups/group_messages_view/<?php echo $group_info[0]->mem_group_id; ?>" class="section-heading">Messages</a></li>
                                                            <li><a target="_blank" href="<?php echo site_url() ?>Membership_Groups/group_meetings/<?php echo $group_info[0]->mem_group_id; ?>" class="section-heading">Meetings</a></li>
                                                            <li><a href="<?php echo site_url() ?>Event_initiation/?group_mem_id=<?php echo $group_info[0]->mem_group_id; ?>" class="section-heading">Events</a></li>
                                                            <li><a target="_blank" href="<?php echo site_url() ?>Membership_Groups/view_document_archives/<?php echo $group_info[0]->mem_group_id; ?>" class="section-heading">Docs</a></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>                             
                                        </div>        
                                    </div>       
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="panel panel-white border-top-purple">
                                    <div class="panel-heading" style="height:50px">
                                        <h3 class="panel-title">Members <span><a href="<?php echo base_url('Mem_group_admin/export_mem/'.$group_id.'');?>" class="btn btn-default pull-right">Export</a></span></h3>
                                        
                                    </div>
                                    <div class="panel-body">
                                        <div class="">
                                            <div class="">
                                                <div class="member-group-members">
                                                    <ul>
                                                        <?php
                                                        if (!empty($group_members)) {
                                                            foreach ($group_members as $members)
                                                            {
                                                                ?>

                                                                <li>
                                                                    <a class="" href="javascript:;">
                                                                        <?php
//                                                                    if ($members->user_picture) {
                                                                        if (file_exists(base_url() . 'uploads/user_profiles_pictures/' . $members->user_picture)) {
                                                                            ?>
                                                                            <div class="profile_img">
                                                                                <img src="<?php echo base_url(); ?>uploads/user_profiles_pictures/<?php echo $members->user_picture ?>" alt="" class="media-object img-circle"> 
                                                                            </div>

        <?php } else { ?>
                                                                            <div class="profile_img">
                                                                                <img src="<?php echo base_url(); ?>uploads/images/no-user.png" alt="" class="media-object img-circle"> 
                                                                            </div>


        <?php } ?>


                                                                        <p class="">
                                                                        <p class="text-inverse"><?php
                                                                            echo $members->user_name_w_initials;
                                                                            if ($members->is_admin == 1) {
                                                                                echo ' (Admin)';
                                                                            }
                                                                            ?></p>
                                                                        </p>
                                                                    </a>


                                                                </li>

                                                                <?php
                                                            }
                                                        } else {
                                                            echo '<div class="col-sm-6">
                                                            <div class="card text-center">
                                                                No Group Members Found
                                                            </div>
                                                        </div>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>

                                            </div>
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



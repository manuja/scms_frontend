<!-- Author:Chameera-->
<style>

    .Profile {
        background-color: #eeefef;
        /* height: 1000px; */
    }

    .fullProfile-box{
        padding-left: 30px;
        padding-right: 30px;
        padding-top: 20px;
    }
    .first-box{
        background-color: #fafafa;
        border-radius: 4px;
        border: solid 1px;
        border-color: #dedddd;
    }
    .second-box{
        background-color: #f3f3f3;
        margin-top: -2px;
        padding: 44px;
        padding-top: 0;
    }
    .profile-details-area{
        padding-left: 26px;
        padding-right: 26px;
        padding-top: 37px;
    }
    ul.pro-info li p span {
        font-weight: 700;
        color: #444;
    }
    .text-muted {
        color: #605ca8;
    }
    .profile-box1{
        background-color: white;
        /*height: 653px;*/
        padding-bottom: 1px;
        border-radius: 7px;

    }
    .tab-content-area{
        padding: 45px;
        background-color: #ecf0f5;
        margin: 28px;
        border-radius: 5px;
    }
    .profile-user-img{
        margin-top: 45px !important;
        width: 146px !important;
        margin-left: 16px;

    }
    .asiheight, .box-profile{
        min-height: 188px !important;


    }
    .profile-custom{
        padding-left: 80px;
        padding-right: 80px;
        padding-top: 20px;
        background-color: white;
    }
    .profile-username {
        margin-top: 42px !important;
        font-size: 34px!important;
        color: #605ca8;
        font-weight: 800;
    }
    .nav-tabs-boadr {
        border-bottom: 1px solid #d6d6d6 !important;
        margin-right: 36px !important;
        margin-bottom: 0px;
    }
    .box-custom h2{
        font-size: 32px !important;

    }
    .nav-tabs-boadr{
        border-bottom: 2px solid #3c8dbc;

    }
    .box-custom{
        position: relative;
        border-radius: 3px;
        background: #eaeff5;
        border-top: 3px solid #d2d6de;
        margin-bottom: 20px;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }

    .profile-user-img-custom{

    }
    .basic-info ul{
        list-style: none;
        padding-top: 11px;
        line-height: 2;
        margin-left: -47px
    }
    .second-area{
        background: #eaeff5 !important;
        height: 600px;
        padding: 20px;

    }
    .basic-info{
        padding-top: 27px;
    }
    .Academic-Qualifications{
        background-color: white;
        padding: 18px;
        margin: 11px;
    }
    .Academic-Qualifications button i{
        margin-right: 18px;
    }
    .Academic-Qualifications button{
        margin-top: 16px;
    }
    .custom-tabele{
        background-color: white;
        padding: 38px;
    }
    .custom-tabele span{
        text-align: center;
        padding: 21px;

    }
    .edit{
        text-align: right;
        margin-top: -20px;
    }





    /* ================ The Timeline ================ */

    .timeline {
        position: relative;
        width: 660px;
        margin: 0 auto;
        margin-top: 20px;
        padding: 1em 0;
        list-style-type: none;
    }

    .timeline:before {
        position: absolute;
        left: 50%;
        top: 0;
        content: ' ';
        display: block;
        width: 6px;
        height: 100%;
        margin-left: -3px;
        background: rgb(80,80,80);
        background: -moz-linear-gradient(top, rgba(80,80,80,0) 0%, rgb(80,80,80) 8%, rgb(80,80,80) 92%, rgba(80,80,80,0) 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(30,87,153,1)), color-stop(100%,rgba(125,185,232,1)));
        background: -webkit-linear-gradient(top, rgba(80,80,80,0) 0%, rgb(80,80,80) 8%, rgb(80,80,80) 92%, rgba(80,80,80,0) 100%);
        background: -o-linear-gradient(top, rgba(80,80,80,0) 0%, rgb(80,80,80) 8%, rgb(80,80,80) 92%, rgba(80,80,80,0) 100%);
        background: -ms-linear-gradient(top, rgba(80,80,80,0) 0%, rgb(80,80,80) 8%, rgb(80,80,80) 92%, rgba(80,80,80,0) 100%);
        background: linear-gradient(to bottom, rgba(80,80,80,0) 0%, rgb(80,80,80) 8%, rgb(80,80,80) 92%, rgba(80,80,80,0) 100%);

        z-index: 5;
    }

    .timeline li {
        padding: 1em 0;
    }

    .timeline li:after {
        content: "";
        display: block;
        height: 0;
        clear: both;
        visibility: hidden;
    }

    .direction-l {
        position: relative;
        width: 300px;
        float: left;
        text-align: right;
    }

    .direction-r {
        position: relative;
        width: 300px;
        float: right;
    }

    .flag-wrapper {
        position: relative;
        display: inline-block;

        text-align: center;
    }

    .flag {
        position: relative;
        display: inline;
        background: rgb(248,248,248);
        padding: 6px 10px;
        border-radius: 5px;

        font-weight: 600;
        text-align: left;
    }

    .direction-l .flag {
        -webkit-box-shadow: -1px 1px 1px rgba(0,0,0,0.15), 0 0 1px rgba(0,0,0,0.15);
        -moz-box-shadow: -1px 1px 1px rgba(0,0,0,0.15), 0 0 1px rgba(0,0,0,0.15);
        box-shadow: -1px 1px 1px rgba(0,0,0,0.15), 0 0 1px rgba(0,0,0,0.15);
    }

    .direction-r .flag {
        -webkit-box-shadow: 1px 1px 1px rgba(0,0,0,0.15), 0 0 1px rgba(0,0,0,0.15);
        -moz-box-shadow: 1px 1px 1px rgba(0,0,0,0.15), 0 0 1px rgba(0,0,0,0.15);
        box-shadow: 1px 1px 1px rgba(0,0,0,0.15), 0 0 1px rgba(0,0,0,0.15);
        margin-left: 10px;
    }

    .direction-l .flag:before {
        position: absolute;
        top: 50%;
        right: -40px;
        content: ' ';
        display: block;
        width: 20px;
        height: 20px;
        margin-top: -10px;
        background: #fff;
        border-radius: 10px;
        border: 4px solid rgb(255,80,80);
        z-index: 10;
    }

    .direction-r .flag:before {
        position: absolute;
        top: 50%;
        right: -40px;
        content: ' ';
        display: block;
        width: 20px;
        height: 20px;
        margin-top: -10px;
        background: #fff;
        border-radius: 10px;
        border: 4px solid rgb(255,80,80);
        z-index: 10;
    }

    .direction-r .flag:before {
        left: -40px;
    }

    .direction-l .flag:after {
        content: "";
        position: absolute;
        left: 100%;
        top: 50%;
        height: 0;
        width: 0;
        margin-top: -8px;
        border: solid transparent;
        border-left-color: rgb(248,248,248);
        border-width: 8px;
        pointer-events: none;
    }

    .direction-r .flag:after {
        content: "";
        position: absolute;
        right: 100%;
        top: 50%;
        height: 0;
        width: 0;
        margin-top: -8px;
        border: solid transparent;
        border-right-color: rgb(248,248,248);
        border-width: 8px;
        pointer-events: none;
    }

    .time-wrapper {
        display: inline;

        line-height: 1em;
        font-size: 0.66666em;
        color: rgb(250,80,80);
        vertical-align: middle;
    }

    .direction-l .time-wrapper {
        float: left;
    }

    .direction-r .time-wrapper {
        float: right;
    }

    .time {
        display: inline-block;
        padding: 4px 6px;
        background: rgb(248,248,248);
    }

    .desc {
        margin: 1em 0.75em 0 0;

        font-size: 0.77777em;
        font-style: italic;
        line-height: 1.5em;
    }

    .direction-r .desc {
        margin: 1em 0 0 0.75em;
    }

    ul.pro-info li {
        display: inline-block;
        margin-right: 36px;
        list-style: disc !important;
    }

    ul.pro-info {
        padding: 0;
    }

    .personal-info-form-row {
        margin-top: 20px;
    }

    .personal-info-form-row .col-md-6 {
        text-align: right;
    }

    .personal-info-form-row .col-md-6 span {
        font-weight: 700;
        color: #444;
    }


    /* ================ Timeline Media Queries ================ */

    @media screen and (max-width: 660px) {

        .timeline {
            width: 100%;
            padding: 4em 0 1em 0;
        }

        .timeline li {
            padding: 2em 0;
        }

        .direction-l,
        .direction-r {
            float: none;
            width: 100%;

            text-align: center;
        }

        .flag-wrapper {
            text-align: center;
        }

        .flag {
            background: rgb(255,255,255);
            z-index: 15;
        }

        .direction-l .flag:before,
        .direction-r .flag:before {
            position: absolute;
            top: -30px;
            left: 50%;
            content: ' ';
            display: block;
            width: 12px;
            height: 12px;
            margin-left: -9px;
            background: #fff;
            border-radius: 10px;
            border: 4px solid rgb(255,80,80);
            z-index: 10;
        }

        .direction-l .flag:after,
        .direction-r .flag:after {
            content: "";
            position: absolute;
            left: 50%;
            top: -8px;
            height: 0;
            width: 0;
            margin-left: -8px;
            border: solid transparent;
            border-bottom-color: rgb(255,255,255);
            border-width: 8px;
            pointer-events: none;
        }

        .time-wrapper {
            display: block;
            position: relative;
            margin: 4px 0 0 0;
            z-index: 14;
        }

        .direction-l .time-wrapper {
            float: none;
        }

        .direction-r .time-wrapper {
            float: none;
        }

        .desc {
            position: relative;
            margin: 1em 0 0 0;
            padding: 1em;
            background: rgb(245,245,245);
            -webkit-box-shadow: 0 0 1px rgba(0,0,0,0.20);
            -moz-box-shadow: 0 0 1px rgba(0,0,0,0.20);
            box-shadow: 0 0 1px rgba(0,0,0,0.20);

            z-index: 15;
        }

        .direction-l .desc,
        .direction-r .desc {
            position: relative;
            margin: 1em 1em 0 1em;
            padding: 1em;

            z-index: 15;
        }

    }

    @media screen and (min-width: 400px ?? max-width: 660px) {

        .direction-l .desc,
        .direction-r .desc {
            margin: 1em 4em 0 4em;
        }

    }
    h2.pass {
        padding-right: 37px;
        color: red;
    }

    h2.pass span {
        border: solid 1px;
        padding: 5px;
    }

</style>

<?php
$CI = &get_instance();

//print_r($profile_data);
//exit;
?>

<section class="content Profile">
    <!-- fullprofile-box start hear -->
    <div class="fullProfile-box">
        
        <!-- First-box start hear -->
        <div class="first-box tabbable">
            <div class="row">
                <div class="col-md-2 col-sm-12">
                <input type="hidden" value="<?php echo $user_type; ?>" name="user_type" value="" id="user_type" />
                    <div class="pro-img">
                        <?php
                        $profile_pic = '';
                        if ($profile_pic != '') { ?>
                            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>" alt="User profile picture">
                        <?php } else { ?>
                            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/images/user.png" alt="User profile picture">
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-10 col-sm-12">
                    
                    <h2 class="profile-username ">
                       <?php echo $profile_data->name_w_initials; ?>                        
                    </h2>
                    <!-- <ul class="pro-info">
                        <li><p class="text-muted "><span>Employee Number : <?php echo $personal_data->employee_no; ?></span> </p></li>
                        <li><p class="text-muted "><span>Division : <?php echo $personal_data->division_name; ?></span> </p></li>
                        <li><p class="text-muted "><span>Sub Division : <?php echo $personal_data->sub_division_name; ?></span></p></li>
                        
                    </ul> -->

                    <ul class="nav nav-tabs nav-tabs-boadr">
                        <li class="active"><a href="#1" data-toggle="tab">Profile</a></li>
                        <!-- <li><a href="#2" data-toggle="tab">Promotions</a></li>
                        <li><a href="#3" data-toggle="tab">Leave</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <!-- First-box end hear -->
        <!-- second-box start hear -->
        <div class="second-box">
            <div class="row">
                <!-- tab contents start hear-->
                <div class="tab-content">
                    <!-- activites tab start hear -->
                    <div class="active tab-pane" id="1">
                       
                        <div class="profile-box1">
                            <div class="profile-details-area">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs ">
                                        <li class="active"><a href="#tab3" data-toggle="tab">Personal Information</a></li>
                                        <!-- <li><a href="#tab4" data-toggle="tab">Employment Details</a></li>
                                        <li><a href="#tab5" data-toggle="tab">Academic/Professional Qualifications</a></li>
                                        <li><a href="#tab6" data-toggle="tab">Former Employment Details</a></li> -->
                                    </ul>
                                </div>

                            </div>
                            <div class="tabbable">


                                <div class="tab-content-area">
                                    <div class="tab-content">
                                        <!-- Personal info srtat hear -->
                                        <div class="tab-pane active" id="tab3">
                                            <div class="row">
                                                <div>
                                                    <div class="col-md-6 col-sm-12">

                                                        <div class="prosonal-info-from">
                                                            <div class="row personal-info-form-row">
                                                                <div class="col-md-12">
                                                                    <h4><i class="fa fa-user-circle-o fa-lg"></i> &nbsp; Personal Information</h4>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="issri" value="<?php echo $profile_data->is_srilankan; ?>" >
                                                            <div class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Name with Initials: </span>
                                                                </div>
                                                                <div class="col-md-4"><?php echo $profile_data->name_w_initials; ?></div>
                                                            </div>

                                                            <div class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>NIC Number:</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?php echo $profile_data->nic; ?>
                                                                </div>
                                                            </div>
                                                           
                                                            
                                                            <div  id="issri" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Nationality:</span>
                                                                </div>
                                                                <div class="col-md-4"><?php if( $profile_data->is_srilankan == 1){ echo "Sri Lankan"; }else{  echo "Foreign"; } ?> </div>
                                                            </div>
                                                           
                                                         
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="prosonal-info-from">
                                                            <div class="row personal-info-form-row">
                                                                <div class="col-md-12">
                                                                    <h4><i class="fa fa-phone fa-lg"></i> &nbsp; Contact Information</h4>
                                                                </div>
                                                            </div>
                                                            <div  id="confix" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Contact Number(Fix):</span>
                                                                </div>
                                                                <div class="col-md-4"><?php echo $profile_data->contact_home; ?></div>
                                                            </div>
                                                            <div id="conmobile" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Contact Number(Mobile):</span>
                                                                </div>
                                                                <div class="col-md-4"><?php echo $profile_data->contact_mobile; ?></div>
                                                            </div>
                                                            <div class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Email:</span>
                                                                </div>
                                                                <div class="col-md-4"><?php echo $user_data->username; ?></div>
                                                            </div>
                                                            <div  id="f1" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Country:</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                   <?php echo $profile_data->country; ?>
                                                                </div>
                                                            </div>
                                                            <div id="f2" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Passport Country:</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                   <?php echo $profile_data->passport_country; ?>
                                                                </div>
                                                            </div>
                                                            <div id="f3" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Province:</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                   <?php echo $profile_data->Province; ?>
                                                                </div>
                                                            </div>
                                                            <div id="f4" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>City:</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                   <?php echo $profile_data->city; ?>
                                                                </div>
                                                            </div>
                                                            <div id="address1" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Address 1:</span>
                                                                </div>
                                                                <div class="col-md-4"><?php echo $profile_data->address1;?></div>
                                                            </div>
                                                            <div id="address2" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Address 2:</span>
                                                                </div>
                                                                <div class="col-md-4"><?php echo $profile_data->address2; ?></div>
                                                            </div>
                                                            <div id="zipcode" class="row personal-info-form-row">
                                                                <div class="col-md-6">
                                                                    <span>Zip Code:</span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                   <?php echo $profile_data->postal_code; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- Personal info end hear -->



                                    </div>

                                </div>

                            </div>
                        </div>
                        
                    </div>

                   
                </div>
              

            </div>




        </div>

    </div>
  

</section>

</div>
<!-- /.content-wrapper -->
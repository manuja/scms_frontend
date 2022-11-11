<?php
$current_date = date('Y-m-d');

$this->load->helper('master_tables');
?>
<style type="text/css" media="screen">
    .card {
        text-align: center;
        height: 508px;
    }   
    .box {
        position: relative;
        border-radius: 3px;
        background: #ffffff;
        margin-bottom: 20px;
        width: 100%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        -webkit-box-shadow: 0 5px 20px rgba(0, 0, 0, 0);
    }
    ul#my_pending_payments li {
        position: relative;
        margin-bottom: 10px;
        margin-top: 18px;
    }

    ul#my_pending_payments li p {
        position: absolute;
        right: 0;
        top: -6px;
    }
</style>


<div class="content">
    <div class="row">
        <!-- dashboard-info -->
        <div class="col-md-9">
            <div class="row">
                <!-- Member Name and Time -->
                <div class="col-md-12">
                    <!-- Content Header (Page header) -->
                    <section class="content-header dashboard-header">
                        <div class="page-title">
                            <!-- <h1>Member Divisions</h1> -->
                        </div>
                        <div  class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="member-info">
                                    <?php
                                    $display_name = $user_info->name_w_initials;
                                    /* This sets the $time variable to the current hour in the 24 hour clock format */
                                    $time = date("H");
                                    /* Set the $timezone variable to become the current timezone */
                                    $timezone = date("e");
                                    /* If the time is less than 1200 hours, show good morning */
                                    if ($time < "12") {
                                        echo "<h1>Good morning " . $display_name . "</h1>";
                                    } else
                                    /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
                                    if ($time >= "12" && $time < "17") {
                                        echo "<h1>Good afternoon " . $display_name . "</h1>";
                                    } else
                                    /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
                                    if ($time >= "17" && $time < "19") {
                                        echo "<h1>Good evening " . $display_name . "</h1>";
                                    } else
                                    /* Finally, show good night if the time is greater than or equal to 1900 hours */
                                    if ($time >= "19") {
                                        echo "<h1>Good evening " .$display_name . "</h1>";
                                    }
                                    ?>
                                    <p>Welcome to the SLGS</p>	
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div id="clock_wrap">
                                    <div id="clock"></div>
                                </div>

                            </div>
                        </div>
                    </section>
                </div>
                <!-- //Member Name and Time -->
            </div>
            <div class="row">
                <!-- Member-Profile -->
                <div class="col-md-5">
                    <div class="row">
                        <!-- test Event -->
                        <div class="col-md-12"> 
                            <div class="box box-success">
                                <!--  <div class="box-header with-border">
                                     <h3 class="box-title">My Profile</h3>
                                     <div class="box-tools pull-right">
                                         <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                         <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                     </div>
                                 </div> -->
                                 <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="box box-success">
                                <!--  <div class="box-header with-border">
                                     <h3 class="box-title">My Profile</h3>
                                     <div class="box-tools pull-right">
                                         <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                         <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                     </div>
                                 </div> -->
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="box">
                                                    <div class="img" id="member_image">
                                                        <img src="<?php echo base_url('assets/images/user.png'); ?>" alt="Profile pic"/>
                                                    </div>
                                                    <ul class="user-info">
                                                        <li><h2 id="mem_name"><?php echo $display_name; ?><br></h2></li>
                                                        <li><p id="email">Email : <?php echo $user_info_user->username;?> </p></li>
                                                        <li><p id="nic">NIC : <?php echo $user_info->nic;?> </p></li>
                                                    </ul>
                                                    <a href="<?php echo base_url('index.php/my-profile'); ?>" class="btn btn-info btn-flat">View Full Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //Member-Profile -->
                <div class="col-md-7">
                    
                    
                <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">SLGS Website</h3>
                            <div class="box-tools pull-right">

                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="body-inner">
                                        <div class="container">
                                            <!--link with website banner-->
                                            <a href="#" target="_blank"><img src="<?php echo site_url('')?>" style="width:40px;height:40px;" title="SLGS" alt="SLGS">&nbsp;&nbsp;</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-12"> 
                            <!-- <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Feedback & Issues</h3>
                                    <div class="box-tools pull-right">

                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="body-inner">
                                                <div class="container">
                                                    <a href="#" target="_blank" class="btn btn-info btn-flat" role="button">Submit Feedback</a>
                                                    <a href="#" target="_blank" class="btn btn-warning btn-flat" role="button">Report an Issue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                       <!-- <div class="col-md-12"> 
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">My Pending Payments</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="body-inner">
                                                <div class="" style="overflow-y: scroll; height: 117px;">
                                                    <div class="">
                                                        <ul class="" id="my_pending_payments">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <!-- //My Pending Payment -->  

                    </div>
     
                </div>
            </div>
        </div>
        <!-- //dashboard-info -->

        <!-- notification -->
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Notification Panel</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class=""  id="dashboard-notiications"></div>
            </div>
        </div>
        <!--// notification -->
    </div>

</div>
</div>

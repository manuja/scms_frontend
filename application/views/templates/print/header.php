<?php
$user_id = $this->session->userdata('user_id');
if($user_id) {
    $user = $this->User_model->get_user($user_id);

    $username = $user->username;
    
    if(isMemberOrStaff($user_id) == '3'){
        $temp = getMemberProfilePicture($user_id);
        if($temp){
            $profImage = $temp;
        }else{
            $profImage = base_url() . 'uploads/images/no-user.png';
        }
    }else{
        $profImage = base_url() . 'uploads/images/no-user.png';
    }
}else{
    redirect(base_url());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pagetitle ?></title>

    <link rel="icon" type="image/ico" href="<?php echo base_url() . 'uploads/'; ?>favicon.ico" />
    <!-- Tell the browser to be responsive to screen width -->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <!--        <link rel="stylesheet" href="--><?php //echo base_url() . 'assets/'; ?><!--bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">-->
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script href="<?php echo base_url() . 'assets/'; ?>https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script href="<?php echo base_url() . 'assets/'; ?>https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>datatables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>datatables/DataTables-1.10.18/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>datatables/Buttons-1.5.1/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>datatables/dataTables.fontAwesome.css">

    <!-- Main css-->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>css/main.css">
    <!-- Fullcalendar -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/fullcalendar/dist/fullcalendar.min.css">
<!--    <link rel="stylesheet" href="--><?php //echo base_url(); ?><!--application/vendor/serhioromano/bootstrap-calendar/css/calendar.min.css">-->

    <?php
    if (!empty($stylesheetes) && is_array($stylesheetes)) {
        foreach ($stylesheetes as $stylesheet) {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url($stylesheet); ?>" />
            <?php
        }
    }
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"> <img src="<?php echo base_url() . 'assets/'; ?>dist/img/logo.png"/></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">test <b>MIS </b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="<?php echo base_url() . 'assets/'; ?>#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo $profImage; ?>" class="user-image">
                            <span class="hidden-xs"><?php if (isset($username)) {
                                    echo $username;
                                } ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?php echo $profImage; ?>" class="img-circle" alt="User Image">

                                <p>
                                    <?php if (isset($username)) {
                                        echo $username;
                                    } ?>
                                    <small></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#"></a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#"></a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#"></a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?php if(isMemberOrStaff($user_id) == '3'){ ?>
                                    <a href="<?php echo site_url('my_profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                                    <?php } ?>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo site_url('signout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <!--   <li>
                    <a href="<?php echo base_url() . 'assets/'; ?>#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                  </li>-->
                </ul>
            </div>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <div id="notification-dropdown-button" class="notification-dropdown-button">
                                <i class="fa fa-bell-o" aria-hidden="true"></i><span class="notification-count main"></span>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <div id="notification-dropdown-list" class="notification-dropdown-list" style=""></div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <script>
            /**
             * Site URL  http://domain/../index.php
             * append this to relative urls to avoid errors
             * @type String
             */
            var site_url = "<?php echo site_url(); ?>";
            var base_url = "<?php echo base_url(); ?>";
        </script>
    </header>

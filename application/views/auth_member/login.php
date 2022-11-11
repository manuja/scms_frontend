<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SLGS</title>
        <link rel="icon" type="image/ico" href="<?php echo base_url() . 'uploads/'; ?>favicon.ico" />
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/square/blue.css">
        <style>
		


		
		
		
            /* Error messages for login form */
            .error_message {
                color: #f00;
                font-size: 1em;
                font-weight: normal;
                display: block;
            }

            .login-box {
                margin:0 0 0 auto;
            }
           
.login-box-body h5.content-group {
    font-size: 19px;
    font-weight: 700;
    text-align: center;
    color: #000;
    margin-top: 20px;
}
.login-box-body form {
    margin-top: 29px;
}
small.display-block {
    color: #999999;
    font-size: 16px;
    margin-top: 13px!important;
}
.form-group.has-feedback {
    margin-bottom: 36px;
}
.form-group {
    margin-bottom: 32px;
}
span.glyphicon.glyphicon-user.form-control-feedback {
    left: 0;
    top: -1px;
}
input#password {
    border: 0;
    border-bottom: 1px solid #ddd;
}
input#identity {
    border: 0;
    border-bottom: 1px solid #ddd;
    padding-left: 42px;
}
span.glyphicon.glyphicon-lock.form-control-feedback {
    left: 0;
    top: -1px;
}
span.arrow img {
 position: absolute;
    left: 223px;
    bottom: 63px;
    width: 3%;
}
input#password {
    padding-left: 42px;
}
p.for {
       right: 38px;
    position: absolute;
    bottom:115px;
}
input.btn.btn-warning.btn-flat {
    margin-top: 21px;
}
.footer {
    /* width: 360px; */
    color: #464444;
    text-align: center;
    font-size: 114%;
    float: none;
    margin-top: 20px;
    font-weight: 700;
}
.reddlogo {
    text-align: center;
    margin-top: 6px;
}
            .login-logo {
                color: #fff;
            }

            p.footer_member {
                font-size: 110%;
                font-weight: 800;
                text-align: center;
                border: solid 1px;
                color: #3e3c3c;
                border-color: #ffffff;
                padding: 6px;
                transition: 0.5s;
            }
            p.footer_member:hover {
                border-color: #6d6d6d;
                transition: 0.5s;
                color: #F44336;
            }
            .login-box-body input[type=submit] {
                width: 100%;
                background-color: #6495ED;
                border-color: #6495ED;
                transition: 0.8s;
            }
            .login-box-body input[type=submit]:hover {
                background-color: #6495ED;
                transition: 0.5s;
                border-color: #6495ED;
            }
            .login-logo, .register-logo {
                font-size: 35px;
                text-align: center;
                /* margin-bottom: 25px; */
                font-weight: 300;
                margin-top: 74px;
            }
            .company-logo {
                position: absolute;
                margin-top: 34px;
            }
            .system-name-logo {
                margin-top: 38px;
            }
            .footer {
				/* width: 360px; */
				color: #464343!important;
				text-align: center;
				font-size: 114%;
				float: none;
				margin-top:5px;
			}
            label {
                display: inline-block;
                max-width: 100%;
                margin-bottom: 6px;
                font-weight: 700;
                vertical-align: top;
            }

            .login-box-body .form-group:hover span,
            .login-box-body .form-group input:focus + span {
             color: #6495ED;
                transition: 0.5s;
            }
            .login-box-body .form-group span {
                transition: 0.5s;
            }
            p.login-box-msg {
                color: #404040 !important;
                font-weight: 600;
            }
            @media (max-width: 950px) {
                .login-logo, .register-logo {
                    font-size: 35px;
                    text-align: center;
                    margin-bottom: 25px;
                    font-weight: 300;
                    margin-top: 2px;
                    margin-bottom: 0;
                }
                .company-logo {
                    position: relative;
                    margin-top: 34px;
                }
                .system-name-logo {
                    margin-top: 0px;
                }
				
            }
			.loginpanel {
					width: 80%;
					margin: 0 auto;
					padding-top: 40px;
				}
				.login-page, .register-page {
    background:#eeeded!important;
    background-repeat: no-repeat!important;
    background-size: cover!important;
    height: 100vh;
}
				.row.login {
    padding-top: 0;
    padding-bottom: 0;
}
			
			.col-md-8.logosleft {
				
				background-size: cover;
				background-repeat: no-repeat;
				height: 371px;
				width: 50%;
				
			}
			.col-md-4.rightlogo {
				margin-left: 16px!important;
    padding-left: 0px!important;
    width: 48%;
    margin-bottom: 27px;
			}
			.login-box-body, .register-box-body {
				background: #fff;
				padding: 20px;
				border-top: 0;
				color: #666;
				height: 488px;
				box-shadow: 0px 0px 2px #dfd8d8;
			}
			.col-md-8.logosleft .logo img {
				margin: 0 auto;
				text-align: center;
				display: block;
				padding-top:35px;
			}
			.system-name-logo {
    text-align: center;
    font-size: 34px;
    margin-top: 63px;
    color: #000;
    font-weight: 700;
}
			
		  
    .col-md-12.logimain {
    padding: 20px 25px;
    background-size: 55%;
    background-repeat: no-repeat;

			}
			.loingimage img {
				margin: 0 auto;
				text-align: center;
				display: block;
			}
			.textimag:before {
				clear: both;
				display: block;
				content: "";
			}
			.textimag {
    text-align: center;
    color: #151212;
    font-weight: 500!important;
}
			.col-md-8.logosleft p {
				color: #fff;
			}
			
@media(min-width:320)and (max-width:767px){
.loginpanel {
    width: 100%!important;
    margin: 0 auto;
    padding-top: 54px;
}
.col-md-12.logimain {
    padding: 40px 25px!important;
    background-size: 55%;
    background-repeat: no-repeat;
}
.col-md-8.logosleft {
    background-size: cover;
    background-repeat: no-repeat;
    height: 371px;
    width: 100%!important;
}
}


@media(min-width:768)and (max-width:992px){
.textimag {
    clear: both;
}
.loginpanel {
    width: 100%!important;
    margin: 0 auto!important;
}
.col-md-8.logosleft {
    background-size: cover;
    background-repeat: no-repeat;
    height: 371px;
    width: 46%!important;
    float: left!important;
}
.col-md-8.logosleft {
    background-size: cover;
    background-repeat: no-repeat;
    height: 371px;
    width: 46%!important;
    float: left!important;
}
}
        </style>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="container">
            <div class="row login">
                <div class="col-md-8"><div class="company-logo">
                        <img class="img-responsive  " src="" alt="">
                    </div></div>
                
					
					<div class="loginpanel">
					<div class="col-md-12 logimain">
                <div class="col-md-8 logosleft">
				<div class="system-name-logo" >SLGS Staff Portal</div>
				<!-- <div class="logo"><img src="assets/images/RDA-Logo.png"></div>
			
				<div class="reddlogo"><img src="assets/images/ro.png"></div> -->
				
				</div>
                <div class="col-md-4 rightlogo">  <!-- /.login-logo -->
                    <div class="login-box-body">
					<div class="loingimage"><img src="assets/images/readnam.png"></div>
                       <h5 class="content-group">Login to your account<br/>
                                            <small class="display-block">Your credentials</small>
                                        </h5>
                        <div id="infoMessage" style="color: red;"><?php echo $message; ?></div>
                        <?php echo form_open("signin"); ?>
                        <div class="form-group has-feedback">
						
                           <?php //echo lang('login_identity_label', 'identity'); ?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span><?php echo form_input($identity, '', 'placeholder="Username"'); ?>
                            
                        </div>
                        <div class="form-group  has-feedback">
                            <?php //echo lang('login_password_label', 'password'); ?>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span><?php echo form_input($password, '', 'placeholder="Password"'); ?>
                            
                        </div>
                        <p>
                            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                            <?php echo lang('login_remember_label', 'remember'); ?>
							<p class="for"><a target="_blank" href="#">Forgot password?</a></p>
                        </p>
                        <p><?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-warning  btn-flat'), lang('login_submit_btn')); ?><span class="arrow"><img  src="assets/images/flechas-vector-png-1.png"></span></p>
                        <?php echo form_close(); ?>
                        
                       </div></div>
					  <div class="textimag">If you have any troubles in login, please <br> Contact us on <strong>+00</strong></div>
					   </div>
					   </div>
               
                <div class="col-md-12"><!-- /.login-box -->
                    <div class="footer">
                     © 2021. All rights reserved. SLGS   
                    </div></div>

            </div>

        </div>
        <div class="login-box">
		

            <!-- /.login-box-body -->
        </div>
        <!-- jQuery 3 -->
        <script src="<?php echo base_url(); ?>bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' /* optional */
                });
            });
        </script>
    </body>
</html>
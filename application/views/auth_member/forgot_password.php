<link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/font-awesome/css/font-awesome.min.css">
<style>
    .forgot-from {
   width: 500px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 10%;
    padding: 44px;
    text-align: center;
    -webkit-box-shadow: 0 19px 86px rgba(0, 0, 0, 0.22);
    box-shadow: 0 19px 86px rgba(0, 0, 0, 0.22);
}
.icon span {
        width: 150px;
    /* height: 150px; */
    /* background-color: #2196F3; */
    border-radius: 50%;
    /* padding: 34px; */
    display: inline-block;
    color: #F44336;
}

.icon span i {
    font-size: 69px;
}
body:before {
    content: "";
    position: absolute;
    width: 100%;
    height: 58%;
    background-color: #ffffff;
    top: 0;
    left: 0;
}
body {
    background-color: #071561;
}
.forgot-from input[type="submit"] {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}

.forgot-from input[type="submit"] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    font-weight: 600;
    font-size: 17px;
    padding: 13px;
        margin-top: 7px;
}
</style>


<body>
    <div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="forgot-from panel panel-default small__width">
             <div class="icon">
                 <span><i class="fa fa-key" aria-hidden="true"></i></span>
             </div>
            <h1><?php echo lang('forgot_password_heading');?></h1>
            <p><?php echo sprintf(lang('forgot_password_subheading'), 'User Name (Email)');?></p>
            <div id="infoMessage"><?php echo $message;?></div>
<?php echo form_open("auth/forgot_password");?>
<p>
   <label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
   <?php echo form_input($identity);?>
</p>
<?php echo form_submit('submit', lang('forgot_password_submit_btn'));?>
<?php echo form_close();?>

         </div>
      </div>
   </div>
</div>
</body>


<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
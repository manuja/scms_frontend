







<link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url() . 'assets/'; ?>bower_components/font-awesome/css/font-awesome.min.css">
<style>
    .forgot-from {
   width: 500px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 7%;
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

input#new {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}

input#new_confirm {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}

</style>


<body>
    <div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="forgot-from panel panel-default small__width">
             <div class="icon">
                 <span><i class="fa fa-undo" aria-hidden="true"></i></span>
             </div>
            <h1><?php echo lang('reset_password_heading');?></h1>
            <div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('auth/reset_password/' . $code);?>

	<p>
		<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
		<?php echo form_input($new_password);?>
	</p>

	<p>
		<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
		<?php echo form_input($new_password_confirm);?>
	</p>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	<p><?php echo form_submit('submit', lang('reset_password_submit_btn'));?></p>

<?php echo form_close();?>

         </div>
      </div>
   </div>
</div>
</body>


<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
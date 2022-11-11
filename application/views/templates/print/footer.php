<footer class="main-footer">
    <p><span class="pull-left"><strong>Copyright &copy; 2020 <a href="http://www.test.lk/">test</a>.</strong> All rights reserved.</span><span class="pull-right hidden-xs">Designed and Developed by <a href="http://testinfotech.com/"><b>test Infotech</b></a><strong> | Version</strong> <?php echo getSystemVariable('mis_version')[0]->system_variable_value; ?></span></p>
</footer>

<!-- jQuery 3 -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url() . 'assets/'; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() . 'assets/'; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() . 'assets/'; ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url() . 'assets/'; ?>dist/js/pages/dashboard.js"></script>

<!-- AdminLTE for demo purposes -->
<!--<script src="--><?php //echo base_url() . 'assets/'; ?><!--dist/js/demo.js"></script>-->
<script src="<?php echo base_url() . 'assets/'; ?>bootstrap-treeview/bootstrap-treeview.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/datatables.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/DataTables-1.10.18/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/Buttons-1.5.1/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/Buttons-1.5.1/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/Buttons-1.5.1/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/Buttons-1.5.1/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() . 'assets/'; ?>datatables/Buttons-1.5.1/js/buttons.print.min.js "></script>

<script src="<?php echo base_url() . 'assets/'; ?>dist/js/scroll/jquery.doubleScroll.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/sweetalert2-master/src/sweetalert2.all.min.js"); ?>"></script>

<script src="<?php echo base_url() . 'assets/'; ?>bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<!--<script src="--><?php //echo base_url(); ?><!--application/vendor/serhioromano/bootstrap-calendar/js/calendar.min.js"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--application/vendor/serhioromano/bootstrap-calendar/components/underscore/underscore-min.js"></script>-->

<?php

if (!empty($scriptview) && is_array($scriptview)) {
    foreach ($scriptview as $script_name) {
        $this->load->view($script_name);
    }
}

?>

<script src="<?php echo base_url().'assets/'; ?>js/pagination/jquery.twbsPagination.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/jquery.smartWizard.min.js"></script>
  <?php
  if (!empty($scripts) && is_array($scripts)) {
      foreach ($scripts as $script) {
          ?>
          <script type="text/javascript" src="<?php echo base_url($script); ?>"></script>
          <?php
      }
  }
  ?>

<?php
$user_id_noti = $this->session->userdata('user_id');
if(isMember($user_id_noti)) {
    $refreshInterval = getSystemVariable('notification_fetch_interval_member')[0]->system_variable_value;
}elseif(isStaff($user_id_noti)) {
    $refreshInterval = getSystemVariable('notification_fetch_interval_admin')[0]->system_variable_value;
}else{
    $refreshInterval = getSystemVariable('notification_fetch_interval_member')[0]->system_variable_value;
}
?>

<script>
    // fetch notifications
    // notification view handle
    // notification read handle

    $(document).ready(function () {

        // periodic function to update notifications
        // function updateNotifications() {
        //     $.ajax({
        //         type: 'POST',
        //         url: '<?php echo site_url("SystemNotification/getNotificationsHeader"); ?>',
        //         data: {},
        //         success: function (data) {
        //             $("#notification-dropdown-list").html(data);
        //             var notification_indicator = $(".notification-count.main");

        //             if($(".notification-count.hidden").html() == '0'){
        //                 notification_indicator.removeClass('has-value').html('');
        //                 notification_indicator.siblings('i.fa').removeClass('fa-bell').addClass('fa-bell-o');
        //             }else{
        //                 notification_indicator.html($(".notification-count.hidden").html()).addClass('has-value');
        //                 notification_indicator.siblings('i.fa').removeClass('fa-bell-o').addClass('fa-bell');
        //             }
        //         },
        //         error: function (data) {
        //             // console.log('An error occurred.');
        //         },
        //         cache: false,
        //         contentType: false,
        //         processData: false
        //     });
        // }

        // notification drop down open action
        // mark all notifications as viewed
        // open dropdown
    //     $("#notification-dropdown-button").on('click', function (event) {
    //         event.preventDefault();

    //         $(".notification-count.main").removeClass('has-value').html('');
    //         $(".notification-count.main").siblings('i.fa').removeClass('fa-bell').addClass('fa-bell-o');
    //         $.ajax({
    //             type: 'POST',
    //             url: '<?php echo site_url("SystemNotification/notificationsView"); ?>',
    //             data: {},
    //             success: function (data) {
    //                 console.log('Success.');
    //             },
    //             error: function (data) {
    //                 console.log('An error occurred.');
    //             },
    //             cache: false,
    //             dataType: "json"
    //         });
    //     });

    //     updateNotifications(); // initially load notifications
    //     setInterval(function(){ updateNotifications(); }, <?php echo intval($refreshInterval); ?>); // update notifications
    // });

    // // notification read action
    // // mark notification as read
    // // redirect to hyperlink
    // function readNotification(hyperlink, noti_id){
    //     // event.preventDefault();
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?php echo site_url("SystemNotification/notificationRead"); ?>',
    //         data: {
    //             noti_id: noti_id
    //         },
    //         success: function (data) {
    //             // console.log('Success.');
    //             window.open(hyperlink, '_blank');
    //         },
    //         error: function (data) {
    //             console.log('An error occurred.');
    //         },
    //         cache: false,
    //         dataType: "json"
    //     });

    // }

</script>
<script src="<?php echo base_url(); ?>assets/plugins/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<?php
$user_id_noti = $this->session->userdata('user_id');
if (isMember($user_id_noti)) {
    $refreshInterval = getSystemVariable('notification_fetch_interval_member')[0]->system_variable_value;
} elseif (isStaff($user_id_noti)) {
    $refreshInterval = getSystemVariable('notification_fetch_interval_admin')[0]->system_variable_value;
} else {
    $refreshInterval = getSystemVariable('notification_fetch_interval_member')[0]->system_variable_value;
}
?>


<!-- Chart code -->
<script>

    $(document).ready(function () {
     

        function updateNotificationsDash() {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("SystemNotification/getNotificationDashboard"); ?>',
                data: {},
                success: function (data) {
                    $("#dashboard-notiications").html(data);
                },
                error: function (data) {
                    // console.log('An error occurred.');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

        updateNotificationsDash(); // initially load notifications
        setInterval(function () {
            updateNotificationsDash();
        }, <?php echo intval($refreshInterval); ?>); // update notifications





    });



    function updateClock() {
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        var currentMinutes = currentTime.getMinutes();
        var currentSeconds = currentTime.getSeconds();

        var currentDate = currentTime.toDateString();
        var currentWeekday = currentDate.substring(0, 3);
        var currentMonth = currentDate.substring(4, 8);
        var currentYear = currentTime.getFullYear();
        var currentDay = currentTime.getDate();

        // Pad the minutes and seconds with leading zeros, if required
        currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
        currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

        // Choose either "AM" or "PM" as appropriate
        var timeOfDay = (currentHours < 12) ? "AM" : "PM";

        // Convert the hours component to 12-hour format if needed
        currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;

        // Convert an hours component of "0" to "12"
        currentHours = (currentHours == 0) ? 12 : currentHours;
        // Compose the string for display
        var currentTimeString = currentWeekday + ", " + currentDay + "      " + currentMonth + "        " + currentYear + "<br>" + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;


        $("#clock").html(currentTimeString);

    }




    $(document).ready(function ($) {
        setInterval('updateClock()', 1000);
    });
</script>
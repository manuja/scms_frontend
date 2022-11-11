<script>
// fetch notifications
// notification view handle
// notification read handle

$(document).ready(function () {

    // periodic function to update notifications
    function updateNotifications() {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("SystemNotification/getNotificationsHeader"); ?>',
            data: {},
            success: function (data) {
                $("#notification-dropdown-list").html(data);
                var notification_indicator = $(".notification-count.main");

                if($(".notification-count.hidden").html() == '0'){
                    notification_indicator.removeClass('has-value').html('');
                    notification_indicator.siblings('i.fa').removeClass('fa-bell').addClass('fa-bell-o');
                }else{
                    notification_indicator.html($(".notification-count.hidden").html()).addClass('has-value');
                    notification_indicator.siblings('i.fa').removeClass('fa-bell-o').addClass('fa-bell');
                }
            },
            error: function (data) {
                // console.log('An error occurred.');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    // notification drop down open action
    // mark all notifications as viewed
    // open dropdown
    $("#notification-dropdown-button").on('click', function (event) {
        event.preventDefault();

        $(".notification-count.main").removeClass('has-value').html('');
        $(".notification-count.main").siblings('i.fa').removeClass('fa-bell').addClass('fa-bell-o');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("SystemNotification/notificationsView"); ?>',
            data: {},
            success: function (data) {
//                console.log('Success.');
            },
            error: function (data) {
                console.log('An error occurred.');
            },
            cache: false,
            dataType: "json"
        });
    });

    updateNotifications(); // initially load notifications
    setInterval(function(){ updateNotifications(); }, <?php echo intval($refreshInterval); ?>); // update notifications
});

// notification read action
// mark notification as read
// redirect to hyperlink
function readNotification(hyperlink, noti_id){
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("SystemNotification/notificationRead"); ?>',
        data: {
            noti_id: noti_id
        },
        success: function (data) {
            // console.log('Success.');
            window.open(hyperlink, '_blank');
        },
        error: function (data) {
            console.log('An error occurred.');
        },
        cache: false,
        dataType: "json"
    });

}

</script>
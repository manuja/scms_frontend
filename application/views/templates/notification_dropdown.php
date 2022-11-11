<div class="notification-list-title"><h4>Notifications</h4><span class="notification-count hidden"><?php echo $notifications['count']; ?></span></div>
<ul class="notifications-list" style="max-height: 311px; overflow-y: scroll;">
    <?php if(intval($notifications['count_all']) > 0){ ?>
        <?php foreach ($notifications['notifications'] as $notification){ ?>
            <li class="notifications-list-item priority-<?php echo $notification['notification_priority']; ?> read-<?php echo $notification['notification_read']; ?>  view-<?php echo $notification['notification_view']; ?>" onclick="readNotification('<?php echo $notification['notification_hyperlink']."', ".$notification['notification_id']; ?>)">
                <div class="notification-wrapper">
                    <div class="notification-image">
                        <img class="notification-item-thumb" src="<?php
                        if($notification['notification_thumbnail'] && $notification['notification_thumbnail_external'] == '0'){
                            echo site_url($notification['notification_thumbnail']);
                        }elseif($notification['notification_thumbnail'] && $notification['notification_thumbnail_external'] == '1'){
                            echo $notification['notification_thumbnail'];
                        }else{
                            echo site_url('assets/images/slgs_logo.jpg');
                        } ?>" alt="">
                    </div>
                    <div class="notification-data">
                        <strong class="notification-item-title"><?php echo substr($notification['notification_text_short'], 0, 40); ?></strong><br>
                        <span class="notification-item-message"><?php echo substr($notification['notification_text_long'], 0, 90); ?></span><br>
                        <em class="notification-item-timestamp"><?php echo date('M d, Y H:i', strtotime($notification['created_datetime'])); ?></em>
                    </div>
                </div>
            </li>
        <?php } ?>
    <?php }else{ ?>
        <div class="notifications-list-none priority-none" style="text-align: center;">
            <strong class="notification-item-title" style="text-align: center">No Notifications</strong>
        </div>
    <?php } ?>
</ul>
<div style="text-align: center;"><a href="<?php echo site_url("SystemNotification/getNotificationGridMembers"); ?>" target="_blank"><small style="">View All Notifications</small></a></div>
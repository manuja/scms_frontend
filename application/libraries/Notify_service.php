<?php
/**
 * Created by PhpStorm.
 * User: ba
 * Date: 7/6/18
 * Time: 1:49 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Notify_service
{
    private $CI;
    private $defaultExpiry;
    private $notificationPriorityTopLimit;
    private $notificationTotalTopLimit;

    public function __construct(){

        $this->CI =& get_instance();
        $this->CI->load->helper('security', 'master_tables');
        $this->CI->load->database();

    }


    /**
     * @param $recipient
     * @param $messageLong
     * @param $messageShort
     * @param $hyperlink
     * @param $notificationCategory
     * @param $notificationPriority
     * @param null $expirationDuration
     * @param null $notificationThumbnail
     * @param int $notificationThumbnailExternal
     * @return bool
     * Purpose: Send a system notification to a single user
     */
    public function fireNotification($recipient, $messageLong, $messageShort, $hyperlink, $notificationCategory, $notificationPriority, $expirationDuration = NULL, $notificationThumbnail = NULL, $notificationThumbnailExternal = 1){
        $status = false;
        $this->defaultExpiry = getSystemVariable('notification_expire_duration')[0]->system_variable_value;
        $intiatingUserId = 0;
        $this->CI->load->library('session');
        if($this->CI->session->userdata('user_id')){
            $intiatingUserId = $this->CI->session->userdata('user_id');
        }
        
        if(!$recipient || empty($recipient)){
            // return error
            log_message('error', 'Notification Fail: No Recipient');
        }
        if(!$messageLong || empty($messageLong)){
            // return error
            log_message('error', 'Notification Fail: No Message');
        }
        if(!$messageShort || empty($messageShort)){
            // return error
            log_message('error', 'Notification Fail: No Title');
        }
        if(!$hyperlink || empty($hyperlink)){
            // return error
            log_message('error', 'Notification Fail: No Hyperlink');
        }
        if(!$expirationDuration || empty($expirationDuration)){
            $date=date_create(date('Y-m-d'));
            date_add($date,date_interval_create_from_date_string($this->defaultExpiry." days"));
            $expirationDuration = date_format($date,"Y-m-d");
        }

        // "notification_main" entry
        $data = array(
            'notification_category' => $notificationCategory,
            'notification_priority' => $notificationPriority,
            'notification_text_short' => $messageShort,
            'notification_text_long' => $messageLong,
            'notification_hyperlink' => $hyperlink,
            'notification_thumbnail' => $notificationThumbnail,
            'notification_thumbnail_external' => $notificationThumbnailExternal,
            'initiated_by' => $intiatingUserId,
            'expire_datetime' => $expirationDuration,
            'state' => 1
        );

        $this->CI->db->insert('notification_main', $data);
        $notification_id = $this->CI->db->insert_id();
        $this->CI->db->reset_query();

        // "notification_single_map" entry
        if($notification_id) {
            $data = array(
                'notification_id' => $notification_id,
                'user_id' => $recipient
            );

            $this->CI->db->insert('notification_single_map', $data);
            $mapping_id = $this->CI->db->insert_id();

            $status = true;
        }

        return $status;
    }

    /**
     * @param $recipients
     * @param $messageLong
     * @param $messageShort
     * @param $hyperlink
     * @param $notificationCategory
     * @param $notificationPriority
     * @param null $expirationDuration
     * @param null $notificationThumbnail
     * @param int $notificationThumbnailExternal
     * @return bool
     * Purpose: Send a system notification to multiple user
     */
    public function fireNotifications($recipients, $messageLong, $messageShort, $hyperlink, $notificationCategory, $notificationPriority, $expirationDuration = NULL, $notificationThumbnail = NULL, $notificationThumbnailExternal = 1){
     
        $status = false;
        $this->defaultExpiry = getSystemVariable('notification_expire_duration')[0]->system_variable_value;
        $intiatingUserId = 0;
        $this->CI->load->library('session');
        if($this->CI->session->userdata('user_id')){
            $intiatingUserId = $this->CI->session->userdata('user_id');
        }
        
        if(!$recipients || empty($recipients)){
            // return error
            log_message('error', 'Notification Fail: No Recipients');
        }
        if(!$messageLong || empty($messageLong)){
            // return error
            log_message('error', 'Notification Fail: No Message');
        }
        if(!$messageShort || empty($messageShort)){
            // return error
            log_message('error', 'Notification Fail: No Title');
        }
        if(!$hyperlink || empty($hyperlink)){
            // return error
            log_message('error', 'Notification Fail: No Hyperlink');
        }
        if(!$expirationDuration || empty($expirationDuration)){
            $date=date_create(date('Y-m-d'));
            date_add($date,date_interval_create_from_date_string($this->defaultExpiry." days"));
            $expirationDuration = date_format($date,"Y-m-d");
        }

        // "notification_main" entry
        $data = array(
            'notification_category' => $notificationCategory,
            'notification_priority' => $notificationPriority,
            'notification_text_short' => $messageShort,
            'notification_text_long' => $messageLong,
            'notification_hyperlink' => $hyperlink,
            'notification_thumbnail' => $notificationThumbnail,
            'notification_thumbnail_external' => $notificationThumbnailExternal,
            'initiated_by' => $intiatingUserId,
            'expire_datetime' => $expirationDuration,
            'state' => 1
        );

        $this->CI->db->insert('notification_main', $data);
        
        $notification_id = $this->CI->db->insert_id();
        $this->CI->db->reset_query();

        $res_data =  array();

        // "notification_group_map" entry
        if($notification_id) {
            $data = array();

            foreach ($recipients as $recipient) {
                $temp = array(
                    'notification_id' => $notification_id,
                    'user_id' => $recipient
                );
                array_push($data, $temp);
            }

            try{
                $this->CI->db->insert_batch('notification_group_map', $data);
                $status = true;
                $res_data = array('status' => true, 'id' => $notification_id  );
            }catch(Exception $exception){
                log_message('error', $exception->getMessage());
                $status = false;
                $res_data = array('status' => false);
            }

        }

        return $res_data;
    }

    /**
     * @param $user_id
     * @param null $limit
     * @return array
     * Purpose: Fetch list of unread notifications for a given user
     */
    public function getUsersNotifications($user_id, $limit = NULL){
        $this->notificationPriorityTopLimit = getSystemVariable('notification_priority_top_limit')[0]->system_variable_value;
        $this->notificationTotalTopLimit = getSystemVariable('notification_total_top_limit')[0]->system_variable_value;

        $notifications = array(
            'notifications' => array(),
            'count' => 0,
            'count_all' => 0
        );

        // ***** get top priority notifications
        // select from "notification_group_map"
        $this->CI->db->select('main.notification_id AS notification_id,
                            main.notification_category AS notification_category,
                            main.notification_priority AS notification_priority,
                            main.notification_text_short AS notification_text_short,
                            main.notification_text_long AS notification_text_long,
                            main.notification_hyperlink AS notification_hyperlink,
                            main.notification_thumbnail AS notification_thumbnail,
                            main.notification_thumbnail_external AS notification_thumbnail_external,
                            main.created_datetime AS created_datetime,
                            map.notification_view AS notification_view,
                            map.notification_read AS notification_read');
        $this->CI->db->from('notification_group_map AS map');
        $this->CI->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_read', 0);
        $this->CI->db->where('notification_priority', 1);
        $this->CI->db->distinct();
        $top_noti_list1 = $this->CI->db->get()->result_array();
        $this->CI->db->reset_query();

        // select from "notification_single_map"
        $this->CI->db->select('main.notification_id AS notification_id,
                            main.notification_category AS notification_category,
                            main.notification_priority AS notification_priority,
                            main.notification_text_short AS notification_text_short,
                            main.notification_text_long AS notification_text_long,
                            main.notification_hyperlink AS notification_hyperlink,
                            main.notification_thumbnail AS notification_thumbnail,
                            main.notification_thumbnail_external AS notification_thumbnail_external,
                            main.created_datetime AS created_datetime,
                            map.notification_view AS notification_view,
                            map.notification_read AS notification_read');
        $this->CI->db->from('notification_single_map AS map');
        $this->CI->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_read', 0);
        $this->CI->db->where('notification_priority', 1);
        $this->CI->db->distinct();
        $top_noti_list2 = $this->CI->db->get()->result_array();
        $this->CI->db->reset_query();

        // fetch notification data from "notification_main"
        $top_noti_all = array_merge($top_noti_list1, $top_noti_list2);

        // php7 feature
        // sort multi-dimension array by key
        usort($top_noti_all, function($a, $b) {
            return $b['notification_id'] <=> $a['notification_id']; // order by id or date (id should be faster)
        });

        $top_noti_all_count = count($top_noti_all);
        // top notification limit
        if($top_noti_all_count > $this->notificationPriorityTopLimit){
            $top_noti_all = array_slice($top_noti_all, 0,$this->notificationPriorityTopLimit);
            // $top_noti_all_count = count($top_noti_all);
        }

        // ***** get less priority notifications
        // select from "notification_group_map"
        $this->CI->db->select('main.notification_id AS notification_id,
                            main.notification_category AS notification_category,
                            main.notification_priority AS notification_priority,
                            main.notification_text_short AS notification_text_short,
                            main.notification_text_long AS notification_text_long,
                            main.notification_hyperlink AS notification_hyperlink,
                            main.notification_thumbnail AS notification_thumbnail,
                            main.notification_thumbnail_external AS notification_thumbnail_external,
                            main.created_datetime AS created_datetime,
                            map.notification_view AS notification_view,
                            map.notification_read AS notification_read');
        $this->CI->db->from('notification_group_map AS map');
        $this->CI->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_read', 0);
        $this->CI->db->where('(notification_priority != 1 OR notification_priority IS NULL)');
        $this->CI->db->distinct();
        $less_noti_list1 = $this->CI->db->get()->result_array();
        $this->CI->db->reset_query();

        // select from "notification_single_map"
        $this->CI->db->select('main.notification_id AS notification_id,
                            main.notification_category AS notification_category,
                            main.notification_priority AS notification_priority,
                            main.notification_text_short AS notification_text_short,
                            main.notification_text_long AS notification_text_long,
                            main.notification_hyperlink AS notification_hyperlink,
                            main.notification_thumbnail AS notification_thumbnail,
                            main.notification_thumbnail_external AS notification_thumbnail_external,
                            main.created_datetime AS created_datetime,
                            map.notification_view AS notification_view,
                            map.notification_read AS notification_read');
        $this->CI->db->from('notification_single_map AS map');
        $this->CI->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_read', 0);
        $this->CI->db->where('(notification_priority != 1 OR notification_priority IS NULL)');
        $this->CI->db->distinct();
        $less_noti_list2 = $this->CI->db->get()->result_array();
        $this->CI->db->reset_query();

        // fetch notification data from "notification_main"
        $less_noti_all = array_merge($less_noti_list1, $less_noti_list2);


        // php7 feature
        // sort multi-dimension array by key
        usort($less_noti_all, function($a, $b) {
            return $b['notification_id'] <=> $a['notification_id']; // order by id or date (id should be faster)
        });
        $less_noti_all_count = count($less_noti_all);

        // if limit has been passed
        if($limit){
            $this->notificationTotalTopLimit = $limit;
        }
        if($less_noti_all_count > $this->notificationTotalTopLimit - $top_noti_all_count){ // limit less important notifications
            $less_noti_all = array_slice($less_noti_all, 0,  abs($this->notificationTotalTopLimit - $top_noti_all_count));
            // $less_noti_all_count = count($less_noti_all);

        }

        $notifications['notifications'] = array_merge($top_noti_all, $less_noti_all);

        // unread notification count
        foreach ($notifications['notifications'] as $notiItem){
            if($notiItem['notification_view'] == "0"){
                $notifications['count']++;
            }
            $notifications['count_all']++;
        }
        $notifications['count_all'] = $less_noti_all_count + $top_noti_all_count;
        return $notifications;
    }
    
    public function getUsersNotificationsUnlimit($user_id, $limit = NULL){
        $this->notificationPriorityTopLimit = getSystemVariable('notification_priority_top_limit')[0]->system_variable_value;
        $this->notificationTotalTopLimit = getSystemVariable('notification_total_top_limit')[0]->system_variable_value;

        $notifications = array(
            'notifications' => array(),
            'count' => 0,
            'count_all' => 0
        );

        // ***** get top priority notifications
        // select from "notification_group_map"
        $this->CI->db->select('main.notification_id AS notification_id,
                            main.notification_category AS notification_category,
                            main.notification_priority AS notification_priority,
                            main.notification_text_short AS notification_text_short,
                            main.notification_text_long AS notification_text_long,
                            main.notification_hyperlink AS notification_hyperlink,
                            main.notification_thumbnail AS notification_thumbnail,
                            main.notification_thumbnail_external AS notification_thumbnail_external,
                            main.created_datetime AS created_datetime,
                            map.notification_view AS notification_view,
                            map.notification_read AS notification_read');
        $this->CI->db->from('notification_group_map AS map');
        $this->CI->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_read', 0);
//        $this->CI->db->where('notification_priority', 1);
        $this->CI->db->distinct();
        $this->CI->db->order_by('notification_id','DESC');
        $this->CI->db->limit(20);
        $top_noti_list1 = $this->CI->db->get()->result_array();
        $this->CI->db->reset_query();

        // select from "notification_single_map"
        $this->CI->db->select('main.notification_id AS notification_id,
                            main.notification_category AS notification_category,
                            main.notification_priority AS notification_priority,
                            main.notification_text_short AS notification_text_short,
                            main.notification_text_long AS notification_text_long,
                            main.notification_hyperlink AS notification_hyperlink,
                            main.notification_thumbnail AS notification_thumbnail,
                            main.notification_thumbnail_external AS notification_thumbnail_external,
                            main.created_datetime AS created_datetime,
                            map.notification_view AS notification_view,
                            map.notification_read AS notification_read');
        $this->CI->db->from('notification_single_map AS map');
        $this->CI->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_read', 0);
//        $this->CI->db->where('notification_priority', 1);
        $this->CI->db->distinct();
        $this->CI->db->order_by('notification_id','DESC');
        $this->CI->db->limit(10);
        $top_noti_list2 = $this->CI->db->get()->result_array();
        $this->CI->db->reset_query();

        // fetch notification data from "notification_main"
        $top_noti_all = array_merge($top_noti_list1, $top_noti_list2);

        // php7 feature
        // sort multi-dimension array by key
        usort($top_noti_all, function($a, $b) {
            return $b['notification_id'] <=> $a['notification_id']; // order by id or date (id should be faster)
        });

        $top_noti_all_count = count($top_noti_all);
        // top notification limit
//        if($top_noti_all_count > $this->notificationPriorityTopLimit){
//            $top_noti_all = array_slice($top_noti_all, 0,$this->notificationPriorityTopLimit);
//            // $top_noti_all_count = count($top_noti_all);
//        }

   

        $notifications['notifications'] = $top_noti_all;

        // unread notification count
        foreach ($notifications['notifications'] as $notiItem){
            if($notiItem['notification_view'] == "0"){
                $notifications['count']++;
            }
            $notifications['count_all']++;
        }
        $notifications['count_all'] = $top_noti_all_count;
        return $notifications;
    }

    /**
     * @param $user_id
     * @param $notificationId
     * Purpose: Mark given notification for given user as read
     */
    public function notificationRead($user_id, $notificationId){
        // update in "notification_single_map"
        $this->CI->db->set('notification_read', 1);
        $this->CI->db->set('read_datetime', date('Y-m-d H:i:s'));
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_id', $notificationId);
        $this->CI->db->where('notification_read !=', 1);
        $this->CI->db->update('notification_single_map');
        // update in "notification_group_map"
        $this->CI->db->set('notification_read', 1);
        $this->CI->db->set('read_datetime', date('Y-m-d H:i:s'));
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_id', $notificationId);
        $this->CI->db->where('notification_read !=', 1);
        $this->CI->db->update('notification_group_map');
    }

    /**
     * @param $user_id
     * Purpose: Mark all notification for given user as viewed
     */
    public function notificationsView($user_id){
        // update in "notification_single_map"
        $this->CI->db->set('notification_view', 1);
        $this->CI->db->set('view_datetime', date('Y-m-d H:i:s'));
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_view !=', 1);
        $this->CI->db->update('notification_single_map');
        // update in "notification_group_map"
        $this->CI->db->set('notification_view', 1);
        $this->CI->db->set('view_datetime', date('Y-m-d H:i:s'));
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('notification_view !=', 1);
        $this->CI->db->update('notification_group_map');
    }
}
?>
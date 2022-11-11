<?php
/**
 * Created by PhpStorm.
 * User: ba
 * Date: 7/6/18
 * Time: 2:26 PM
 */

class Systemnotification_model extends CI_Model {
    public function __construct(){
        $this->load->database();
        $this->load->helper('misc');
    }




    function getMemberGroups(){
        $this->db->select('mem_group_id, mem_goup_name');
        $this->db->from('membership_group');
        $this->db->where('status', 1);

        $query = $this->db->get();
        return $query->result_array();
    }

    function fetchMembersByName(){

        $query = $this->db->select('member_profile_data.user_id AS mem_id, CONCAT(member_profile_data.user_names_by_initials, " | ", member_profile_data.user_name_w_initials) AS mem_name, member_profile_data.membership_number AS membership_number');
        $query = $this->db->from('member_profile_data');
        $query = $this->db->where('member_profile_data.state', 1);
        $query = $this->db->get();

//    $query = $CI->db->get('member_profile_data');
        return $query->result();
    }

    function getRecipients($member_class_only,
                           $filter_member_class,
                           $member_discipline_only,
                           $filter_member_discipline,
                           $member_group_only,
                           $filter_member_group,
                           $member_province_only,
                           $filter_member_province){

        $users_1 = $users_2 = array();
        // TODO: fetch users according to filters
        // fetching from "member_profile_data"
        $this->db->select('user_id');
        $this->db->from('member_profile_data');
        $this->db->where('state', 1);
        if($filter_member_class != NULL){
            $this->db->where_in('user_member_class', $filter_member_class);
        }
        if($filter_member_discipline != NULL){
            $this->db->where_in('user_member_discipline', $filter_member_discipline);
        }
        if($filter_member_discipline != NULL){
            $this->db->where_in('user_province', $filter_member_province);
        }
        $this->db->distinct();
        $query = $this->db->get();
        $users_1 = $query->result_array();

        $this->db->reset_query();


        if($filter_member_group != NULL && !empty($filter_member_group)) {
            // fetching from "assign_members_to_group"
            $this->db->select('assigned_mem_id AS user_id');
            $this->db->from('assign_members_to_group');
            $this->db->where('status', 1);
            $this->db->where_in('mem_group_id', $filter_member_group);
            $this->db->distinct();
            $query = $this->db->get();
            $users_2 = $query->result_array();
        }

        $users_all = array_unique(array_column(array_merge($users_1, $users_2), 'user_id'));
        return $users_all;
    }

    function getStaffMembers($filter_staff_group){
        // fetching staff members
        $this->db->select('user_id');
        $this->db->from('users_groups');
        $this->db->where('status', 1);
        $this->db->where_in('group_id', $filter_staff_group);
        $this->db->distinct();
        $query = $this->db->get();

        return array_column($query->result_array(),'user_id');
    }

    function getStaffGroups(){
        $this->db->select('g.name AS gname, g.id AS group_id, p.name AS parent, g.parent_id AS parent_id');
        $this->db->from('groups AS g');
        $this->db->join('groups as p', 'g.parent_id = p.id', 'left');
        $this->db->where('g.is_admin', 2);
        $this->db->order_by('g.parent_id');
        $this->db->order_by('g.name');
        $query = $this->db->get();

        return $query->result_array();
    }

    function showListOfNotifications(){
        $search_txt = '';

        $filter_notification_category_id = $this->input->post_get('notification_category');
        $filter_notification_priority_id = $this->input->post_get('notification_priority');
        $filter_date_to = $this->input->post_get('search_filter_date_to');
        $filter_date_from = $this->input->post_get('search_filter_date_from');
        $filter_search_text = $this->input->post_get('search_text');


        $this->db->select('notification_main.notification_id', false);
        $this->db->from('notification_main');
        $this->db->join('master_notification_priority', 'notification_main.notification_priority = master_notification_priority.master_notification_priority_id', 'left');
        $this->db->join('master_notification_category', 'notification_main.notification_category = master_notification_category.master_notification_category_id', 'left');
        $this->db->join('users', 'notification_main.initiated_by = users.id', 'left');
        if((int) $filter_notification_category_id > 0){
            $this->db->where('notification_main.notification_category', $filter_notification_category_id);
        }
        if((int) $filter_notification_priority_id > 0){
            $this->db->where('notification_main.notification_priority', $filter_notification_priority_id);
        }
        if($filter_date_to > 0){
            $this->db->where('DATE(notification_main.created_datetime) <=', date($filter_date_to));
        }
        if($filter_date_from > 0){
            $this->db->where('DATE(notification_main.created_datetime) >=', date($filter_date_from));
        }

//        if (!empty($search['value'])) {
        if (!empty($filter_search_text)) {

//            $filter_search_text = $search['value'];

            $this->db->group_start();
            $this->db->like('notification_text_short', $filter_search_text, 'both');
            $this->db->or_like('notification_text_long', $filter_search_text, 'both');
            $this->db->or_like('notification_hyperlink', $filter_search_text, 'both');
            $this->db->group_end();
            $search_txt = $filter_search_text;
        }

        $result = FALSE;
        $totalData = $this->db->count_all_results();

        $totalFiltered = $totalData;
        $data_result = array();
        $q = '';
        if (!empty($totalData)) {

            $columns = array(
                'notification_id',
                'notification_category',
                'notification_priority',
                'notification_text_short',
                'notification_text_long',
                'notification_hyperlink',
                'created_datetime',
                'expire_datetime',
                'initiated_by',
                'notification_category_name',
                'notification_priority_name'
            );

            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');

            $this->db->select(implode(",", array(
                'notification_main.notification_id AS notification_id',
                'notification_main.notification_category AS notification_category',
                'master_notification_category.master_notification_category_name AS notification_category_name',
                'notification_main.notification_priority AS notification_priority',
                'master_notification_priority.master_notification_priority_name AS notification_priority_name',
                'notification_main.notification_text_short AS notification_text_short',
                'notification_main.notification_text_long AS notification_text_long',
                'notification_main.notification_hyperlink AS notification_hyperlink',
                'DATE(notification_main.created_datetime) AS created_datetime',
                'DATE(notification_main.expire_datetime) AS expire_datetime',
                'users.last_name AS initiated_by'
            )), false);
            $this->db->from('notification_main');
            $this->db->join('master_notification_priority', 'notification_main.notification_priority = master_notification_priority.master_notification_priority_id', 'left');
            $this->db->join('master_notification_category', 'notification_main.notification_category = master_notification_category.master_notification_category_id', 'left');
            $this->db->join('users', 'notification_main.initiated_by = users.id', 'left');

            if((int) $filter_notification_category_id > 0){
                $this->db->where('notification_main.notification_category', $filter_notification_category_id);
            }
            if((int) $filter_notification_priority_id > 0){
                $this->db->where('notification_main.notification_priority', $filter_notification_priority_id);
            }
            if($filter_date_to > 0){
                $this->db->where('DATE(notification_main.created_datetime) <=', date($filter_date_to));
            }
            if($filter_date_from > 0){
                $this->db->where('DATE(notification_main.created_datetime) >=', date($filter_date_from));
            }

//            if (!empty($search['value'])) {
            if (!empty($filter_search_text)) {

//                $filter_search_text = $search['value'];
                $this->db->group_start();
                $this->db->like('notification_text_short', $filter_search_text, 'both');
                $this->db->or_like('notification_text_long', $filter_search_text, 'both');
                $this->db->or_like('notification_hyperlink', $filter_search_text, 'both');
                $this->db->group_end();
            }

            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
            if (!empty($limit) && $limit != "-1") {
                $this->db->limit($limit, $start);
            }
            $query = $this->db->get();

            if (empty($query)) {
                return false;
            } else {
                $data_result = $query->result();
            }
            if (!empty($filter_search_text)) {
                $totalFiltered = $query->num_rows();
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post_get('draw')), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data_result // total data array
        );
        return $json_data;
    }
    
    public function getMembersNotificationsGrid($user_id){
    
        $search_txt = '';

        $filter_notification_category_id = $this->input->post_get('notification_category');
        $filter_notification_priority_id = $this->input->post_get('notification_priority');
        $filter_date_to = $this->input->post_get('search_filter_date_to');
        $filter_date_from = $this->input->post_get('search_filter_date_from');
        $filter_search_text = $this->input->post_get('search_text');


        // notification from group map
        $this->db->reset_query();
        $this->db->select('main.notification_id AS notification_id', false);
        $this->db->from('notification_group_map AS map');
        $this->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
        $this->db->join('master_notification_priority', 'main.notification_priority = master_notification_priority.master_notification_priority_id', 'left');
        $this->db->join('master_notification_category', 'main.notification_category = master_notification_category.master_notification_category_id', 'left');
        
        $this->db->where('user_id', $user_id);
        if((int) $filter_notification_category_id > 0){
            $this->db->where('main.notification_category', $filter_notification_category_id);
        }
        if((int) $filter_notification_priority_id > 0){
            $this->db->where('main.notification_priority', $filter_notification_priority_id);
        }
        if($filter_date_to > 0){
            $this->db->where('DATE(main.created_datetime) <=', date($filter_date_to));
        }
        if($filter_date_from > 0){
            $this->db->where('DATE(main.created_datetime) >=', date($filter_date_from));
        }

        if (!empty($filter_search_text)) {
            $this->db->group_start();
            $this->db->like('notification_text_short', $filter_search_text, 'both');
            $this->db->or_like('notification_text_long', $filter_search_text, 'both');
            $this->db->or_like('notification_hyperlink', $filter_search_text, 'both');
            $this->db->group_end();
            $search_txt = $filter_search_text;
        }

        $result = FALSE;
        $totalData_1 = $this->db->count_all_results();

        $totalFiltered_1 = $totalData_1;
        $data_result_1 = array();
        $q = '';
        if (!empty($totalData_1)) {

            $columns = array(
                'notification_category',
                'notification_priority',
                'notification_text_short',
                'notification_text_long',
                'notification_hyperlink',
                'created_datetime',
                'expire_datetime',
                'notification_category_name',
                'notification_priority_name'
            );

            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');

            
            $this->db->reset_query();
            $this->db->select('main.notification_id AS notification_id,
                            main.notification_category AS notification_category,
                            master_notification_category.master_notification_category_name AS notification_category_name,
                            main.notification_priority AS notification_priority,
                            master_notification_priority.master_notification_priority_name AS notification_priority_name,
                            main.notification_text_short AS notification_text_short,
                            main.notification_text_long AS notification_text_long,
                            main.notification_hyperlink AS notification_hyperlink,
                            main.created_datetime AS created_datetime');
            $this->db->from('notification_group_map AS map');
            $this->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
            $this->db->join('master_notification_priority', 'main.notification_priority = master_notification_priority.master_notification_priority_id', 'left');
            $this->db->join('master_notification_category', 'main.notification_category = master_notification_category.master_notification_category_id', 'left');

            $this->db->where('user_id', $user_id);
            if((int) $filter_notification_category_id > 0){
                $this->db->where('main.notification_category', $filter_notification_category_id);
            }
            if((int) $filter_notification_priority_id > 0){
                $this->db->where('main.notification_priority', $filter_notification_priority_id);
            }
            if($filter_date_to > 0){
                $this->db->where('DATE(main.created_datetime) <=', date($filter_date_to));
            }
            if($filter_date_from > 0){
                $this->db->where('DATE(main.created_datetime) >=', date($filter_date_from));
            }

            if (!empty($filter_search_text)) {
                $this->db->group_start();
                $this->db->like('notification_text_short', $filter_search_text, 'both');
                $this->db->or_like('notification_text_long', $filter_search_text, 'both');
                $this->db->or_like('notification_hyperlink', $filter_search_text, 'both');
                $this->db->group_end();
            }

            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
            if (!empty($limit) && $limit != "-1") {
                $this->db->limit($limit, $start);
            }
            $query1 = $this->db->get();

            if (empty($query1)) {
                return false;
            } else {
                $data_result_1 = $query1->result();
            }
            if (!empty($filter_search_text)) {
                $totalFiltered_1 = $query1->num_rows();
            }
        }
        
        // notifications form single map
        $this->db->reset_query();
        $this->db->select('main.notification_id AS notification_id', false);
        $this->db->from('notification_single_map AS map');
        $this->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
        $this->db->join('master_notification_priority', 'main.notification_priority = master_notification_priority.master_notification_priority_id', 'left');
        $this->db->join('master_notification_category', 'main.notification_category = master_notification_category.master_notification_category_id', 'left');
        
        $this->db->where('user_id', $user_id);
        if((int) $filter_notification_category_id > 0){
            $this->db->where('main.notification_category', $filter_notification_category_id);
        }
        if((int) $filter_notification_priority_id > 0){
            $this->db->where('main.notification_priority', $filter_notification_priority_id);
        }
        if($filter_date_to > 0){
            $this->db->where('DATE(main.created_datetime) <=', date($filter_date_to));
        }
        if($filter_date_from > 0){
            $this->db->where('DATE(main.created_datetime) >=', date($filter_date_from));
        }

        if (!empty($filter_search_text)) {
            $this->db->group_start();
            $this->db->like('notification_text_short', $filter_search_text, 'both');
            $this->db->or_like('notification_text_long', $filter_search_text, 'both');
            $this->db->or_like('notification_hyperlink', $filter_search_text, 'both');
            $this->db->group_end();
            $search_txt = $filter_search_text;
        }

        $result = FALSE;
        $totalData_2 = $this->db->count_all_results();

        $totalFiltered_2 = $totalData_2;
        $data_result_2 = array();
        $q = '';
        if (!empty($totalData_1)) {

            $columns = array(
                'notification_category',
                'notification_priority',
                'notification_text_short',
                'notification_text_long',
                'notification_hyperlink',
                'created_datetime',
                'expire_datetime',
                'notification_category_name',
                'notification_priority_name'
            );

            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');

            
            $this->db->reset_query();
            $this->db->select('main.notification_id AS notification_id,
                            main.notification_category AS notification_category,
                            master_notification_category.master_notification_category_name AS notification_category_name,
                            main.notification_priority AS notification_priority,
                            master_notification_priority.master_notification_priority_name AS notification_priority_name,
                            main.notification_text_short AS notification_text_short,
                            main.notification_text_long AS notification_text_long,
                            main.notification_hyperlink AS notification_hyperlink,
                            main.created_datetime AS created_datetime');
            $this->db->from('notification_single_map AS map');
            $this->db->join('notification_main AS main', 'main.notification_id = map.notification_id', 'left');
            $this->db->join('master_notification_priority', 'main.notification_priority = master_notification_priority.master_notification_priority_id', 'left');
            $this->db->join('master_notification_category', 'main.notification_category = master_notification_category.master_notification_category_id', 'left');

            $this->db->where('user_id', $user_id);
            if((int) $filter_notification_category_id > 0){
                $this->db->where('main.notification_category', $filter_notification_category_id);
            }
            if((int) $filter_notification_priority_id > 0){
                $this->db->where('main.notification_priority', $filter_notification_priority_id);
            }
            if($filter_date_to > 0){
                $this->db->where('DATE(main.created_datetime) <=', date($filter_date_to));
            }
            if($filter_date_from > 0){
                $this->db->where('DATE(main.created_datetime) >=', date($filter_date_from));
            }

            if (!empty($filter_search_text)) {
                $this->db->group_start();
                $this->db->like('notification_text_short', $filter_search_text, 'both');
                $this->db->or_like('notification_text_long', $filter_search_text, 'both');
                $this->db->or_like('notification_hyperlink', $filter_search_text, 'both');
                $this->db->group_end();
            }

            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
            if (!empty($limit) && $limit != "-1") {
                $this->db->limit($limit, $start);
            }
            $query2 = $this->db->get();

            if (empty($query2)) {
                return false;
            } else {
                $data_result_2 = $query2->result();
            }
            if (!empty($filter_search_text)) {
                $totalFiltered_2 = $query2->num_rows();
            }
        }
        
        // Total Result
        $json_data = array(
            "draw" => intval($this->input->post_get('draw')), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData_1+$totalData_2), // total number of records
            "recordsFiltered" => intval($totalFiltered_1+$totalFiltered_2), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => array_merge($data_result_1, $data_result_2) // total data array
        );
        return $json_data;
    }
    
}
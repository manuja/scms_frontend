<?php

/**
 * Created by test
 * date 2021-03-26
 * get division list
 */
function getDivisions(){
    $CI = & get_instance();
    $CI->load->database();


    $CI->db->select('division_id,division_name');
    $CI->db->where('status', 1);
    $query = $CI->db->get('master_divisions');
    return $query->result_array();
}


/**
 * Created by PhpStorm.
 * User: test
 * Date: 2021/03/26
 * Time: 3:54 PM
 */
function getmembergroups() {
    $CI = & get_instance();
    $CI->load->database();


    $CI->db->select('mem_group_id,mem_goup_name');
    $CI->db->where('status', 1);
    $query = $CI->db->get('membership_group');
    return $query->result_array();
}

/**
 * @return array
 * Purpose: get person titles
 */
function getMasterPersonTitle() {
    $CI = & get_instance();
    $CI->load->database();


    $CI->db->select('person_title_id, person_title');
    $CI->db->where('state', 1);
    $query = $CI->db->get('master_person_title');
    return $query->result_array();
}

/**
 * @return array
 * Purpose: get Notifications categories
 */
function getMasterNotificationCategory() {
    $CI = & get_instance();
    $CI->load->database();


    $CI->db->select('master_notification_category_id, master_notification_category_name');
    $CI->db->where('state', 1);
    $query = $CI->db->get('master_notification_category');
    return $query->result_array();
}

/**
 * @return array
 * Purpose: get provinces
 */
function getMasterNotificationPriority() {
    $CI = & get_instance();
    $CI->load->database();


    $CI->db->select('master_notification_priority_id, master_notification_priority_name');
    $CI->db->where('state', 1);
    $query = $CI->db->get('master_notification_priority');
    return $query->result_array();
}

function get_sub_menu_items($menu_id) {
//    echo 'fssdfsfsfd';
//    exit;
    $CI = & get_instance();
    $CI->load->database();
    $CI->db->select('system_menu.menu_id,
system_menu.menu_level,
system_menu.menu_title,
system_menu.menu_icon,
system_menu.menu_path,
system_menu.permission_id,
system_menu.menu_parent,
system_menu.row_order,
system_menu.`status`,
system_menu.permission_parent_id,
system_menu.permission_child_id,
system_menu.permission_grand_child_id,
system_menu.created_date');
    $CI->db->from('system_menu');
    $CI->db->where('system_menu.status', '1');
    $CI->db->where('system_menu.menu_level', '2');
//    $CI->db->where('system_menu.permission_parent_id', $parent_id);
    $CI->db->where('system_menu.menu_parent', $menu_id);
    $query = $CI->db->get();
//    print_r($CI->db->last_query());
    $submenu = $query->result_array();
    return $submenu;
//   print_r($submenu);
//   exit;
}

function get_grand_child_menu_items($sub_id) {

    $CI = & get_instance();
    $CI->load->database();
    $CI->db->select('system_menu.menu_id,
system_menu.menu_level,
system_menu.menu_title,
system_menu.menu_icon,
system_menu.menu_path,
system_menu.permission_id,
system_menu.menu_parent,
system_menu.row_order,
system_menu.`status`,
system_menu.permission_parent_id,
system_menu.permission_child_id,
system_menu.permission_grand_child_id,
system_menu.created_date');
    $CI->db->from('system_menu');
    $CI->db->where('system_menu.status', '1');
    $CI->db->where('system_menu.menu_level', '3');
    $CI->db->where('system_menu.permission_parent_id', $sub_id);
    $query = $CI->db->get();
//    print_r($CI->db->last_query());
    $grand_child_menu = $query->result_array();
    return $grand_child_menu;
//   print_r($submenu);
//   exit;
}

/**
 * @param $variableName
 * @return mixed
 * Purpose: gat value of a given system variable
 */
function getSystemVariable($variableName) {
    $CI = & get_instance();
    $CI->load->database();


    $CI->db->select('system_variable_value');
    $CI->db->where('system_variable_name', $variableName);
    $CI->db->where('state', 1);
    $query = $CI->db->get('system_variables');
//    print_r($CI->db->last_query());
//    exit;
    return $query->result();
}

/**
 * Author test wijesinghe
 * Purpose: check_user_restrictions_for_membership_groups.
 */
function check_user_restrictions_for_membership_groups($group_id) {
    $CI = & get_instance();
    $CI->load->database();

    $user_id = $CI->session->userdata('user_id');
    $CI->db->select('assign_members_to_group.is_admin,
assign_members_to_group.assigned_mem_id,
assign_members_to_group.mem_group_id');
    $CI->db->where('assign_members_to_group.mem_group_id', $group_id);
    $CI->db->where('assign_members_to_group.`status`', '1');
    $CI->db->where('assign_members_to_group.assigned_mem_id', $user_id);
    $group_mem = $CI->db->get('assign_members_to_group');
    return $group_mem->row();
//    return $group_mem->result();
}

/**
 * Author test wijesinghe
 * Purpose: Membership groups
 */
function Get_membership_groups($group_id = null) {
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select(array('A.mem_group_id as id', 'A.mem_goup_name as name'));
    $CI->db->from('membership_group AS A');
    $CI->db->where('A.status' . '=' . '1');
//    $CI->db->where('A.verify_stat' . '=' . '1');
    if ($group_id) {
        $CI->db->where('A.mem_group_id', $group_id);
    }
    $CI->db->order_by("A.mem_group_id", "asc");
    $d = $CI->db->get();
//    print_r($CI->db->last_query());
//    exit;

    if ($d) {
        $data = array();
//        $data[''] = "Select Groups";
        foreach ($d->result() as $row) {
// Add array keys to the array while looping...
            $data[$row->id] = $row->name;
        }

        return $data;
    } else {
        return FALSE;
    }
}

function check_admin($group_id) {
    $CI = & get_instance();
    $CI->load->database();

    $user_id = $CI->session->userdata('user_id');
    $CI->db->select('assign_members_to_group.is_admin');
    $CI->db->where('assign_members_to_group.mem_group_id', $group_id);
    $CI->db->where('assign_members_to_group.`status`', '1');
    $CI->db->where('assign_members_to_group.assigned_mem_id', $user_id);
    $group_mem = $CI->db->get('assign_members_to_group');
    return $group_mem->row();
//    return $group_mem->result();
}

//check user is system admin or not
//test wijesinghe

function check_msg_create_is_system_admin($msg_created_by) {

    $CI = & get_instance();
    $CI->load->database();
    $user_id = $CI->session->userdata('user_id');
    $CI->db->select(array('groups.is_admin'));
    $CI->db->from('users_groups');
    $CI->db->join('groups', 'users_groups.group_id = groups.id', 'INNER');
    $CI->db->where('users_groups.user_id', $msg_created_by);
    $CI->db->where('groups.is_admin', '2');

    $d = $CI->db->get();
//     print_r($CI->db->last_query());
//    exit;
    $admin_or_not = $d->num_rows();


    if ($admin_or_not > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function isMemberOrStaff($user_id) {
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('group_id');
    $CI->db->from('users_groups');
    $CI->db->where('user_id', $user_id);
    $query = $CI->db->get();

    $CI->db->reset_query();

    $CI->db->select('is_admin');
    $CI->db->from('groups');
    $CI->db->where('id', $query->result()[0]->group_id);
    $query = $CI->db->get();

    return $query->result()[0]->is_admin;
}

/**
 * created by : test
 * date : 28/02/2019
 * @param int $user_id
 * @return string user name
 * get userb=name from users table
 */
function get_user_name($user_id) {
    if ($user_id != 0 && $user_id != "") {

        $CI = & get_instance();
        $CI->load->database();
        $CI->db->reset_query();
        $CI->db->select('first_name,last_name,name_initials');
        $CI->db->from('users');
        $CI->db->where('users.id', $user_id);
        $query = $CI->db->get();
        $ret = $query->row();
        if ($ret->name_initials != "" && $ret->name_initials != NULL) {
            return $ret->name_initials;
        } else {
            return $ret->first_name . ' ' . $ret->last_name;
        }
    }
}

function get_user_email($user_id) {
    if ($user_id != 0 && $user_id != "") {

        $CI = & get_instance();
        $CI->load->database();
        $CI->db->reset_query();
        $CI->db->select('email');
        $CI->db->from('users');
        $CI->db->where('users.id', $user_id);
        $query = $CI->db->get();
        $ret = $query->row();

        return $ret->email;
    }
}

/**
 * created by : test
 * date : 28/02/2019
 * @return array
 */
function sub_items($parent_id) {
    $CI = & get_instance();
    $CI->load->database();
    $query = $CI->db->query("SELECT
        g.`name` AS sname,
        g.id AS group_id
        FROM
        `groups` AS g
        WHERE
        g.is_admin != 1 AND
        g.parent_id = $parent_id");
    return $query->result_array();
}

function get_system_groups()
    {
    $CI = & get_instance();
    $CI->load->database();
        $query = $CI->db->query('SELECT
            g.`name` AS gname,
            g.id AS group_id,
            g.parent_id
            FROM
            groups AS g
            WHERE
            g.is_admin != 1 AND
            g.parent_id = 0');

//        print_r($this->db->last_query());
//        exit;
        $queries = $query->result();

//
        return $queries;
    }

function get_user_email_from_name($user_name) {
    if ($user_name != 0 && $user_name != "") {

        $CI = & get_instance();
        $CI->load->database();
        $CI->db->reset_query();

        $CI->db->select('users.email');
        $CI->db->from('users');
        $CI->db->where('users.username', $user_name);
        $query = $CI->db->get();
        $ret = $query->row();
        if ($ret->email != "" && $ret->email != NULL) {
            return $ret->email;
        }
    }
}

function get_active_employee_list(){
    $CI = & get_instance();
    $CI->load->database();
    $CI->db->select('user_id,name_w_initials,employee_no');
    $CI->db->from('user_profile');
    $CI->db->where('status', 1);
    $query = $CI->db->get();
    return $query->result();
}

function getSubDivisions($division_id=null){
    $CI = & get_instance();
    $CI->load->database();


    $CI->db->select('sub_division_id,sub_division_name');
    if($division_id != null){
    $CI->db->where('division_id', $division_id);
    }
    $CI->db->where('status', 1);
    $query = $CI->db->get('master_sub_division');
    return $query->result_array();
}

function getInstitution()
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('institute_id,institute_name');
    $CI->db->where('status', 1);
    $query = $CI->db->get('master_institute');
    return $query->result_array();
    
}
/**
 * Created by test
 * created on 2021-05-19
 * @return array
 */

function getCostTypes()
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('cost_id,cost_type');
    $CI->db->where('status', 1);
    $query = $CI->db->get('master_cost_type');
    return $query->result_array();
    
}
function getBloodGroups()
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('blood_group_id,blood_group');
    $CI->db->where('status', 1);
    $query = $CI->db->get('emp_blood_group');
    return $query->result();
    
}

function getSlProvice()
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('sl_provinces_id,province_name');
    $CI->db->where('state', 1);
    $query = $CI->db->get('master_sl_provinces_tbl');
    return $query->result();
    
}

function getNationalities()
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('nationality_id,nationality');
    $CI->db->where('status', 1);
    $query = $CI->db->get('master_nationality');
    return $query->result();
    
}
function getDesignations()
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('*');
    $CI->db->where('status', 1);
    $query = $CI->db->get('emp_designation');
    return $query->result();
    
}

function getEmployeeCountOfdesignation($designation_id){
    $CI = & get_instance();
    $CI->load->database();
    $CI->db->select('COUNT(user_profile_id) AS no_of_employee');
    $CI->db->from('emp_employment_details');
    $CI->db->where('job_title',$designation_id);
    $CI->db->where('status',1);
    $result = $CI->db->get()->row();
    return $result->no_of_employee;
}

function getAllUsersbyPermissionCodes($permissionArr){
    $CI = & get_instance();
    $CI->load->database();
    
    $CI->db->select('users_groups.user_id');
    $CI->db->from('users_groups');
    $CI->db->join('group_permissions','group_permissions.group_id=users_groups.group_id','inner');
    $CI->db->join('system_permissions','system_permissions.id=group_permissions.perm_id','inner');    
    $CI->db->where_in('system_permissions.permission_code',$permissionArr);

    $result = $CI->db->get()->result_array();

    if( count($result) != 0 ){

        return array_unique(array_column($result, 'user_id'));


    }else{

        
        $CI->db->select('user_permissions.user_id');
        $CI->db->from('user_permissions');
        $CI->db->join('system_permissions','system_permissions.id=user_permissions.perm_id','inner');    
        $CI->db->where_in('system_permissions.permission_code',$permissionArr);

        $result2 = $CI->db->get()->result_array();
        return array_unique(array_column($result2, 'user_id'));


    }

    
    
}

function getUserDetailsByid($user_id){
    $CI = & get_instance();
    $CI->load->database();
    
    $CI->db->select('employee_no');
    $CI->db->from('users');  
    $CI->db->where_in('id',$user_id);
    
    $result = $CI->db->get()->row();
    return $result;
}

?>

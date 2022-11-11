<?php

/**
 * Updated by PhpStorm.
 * User: testMJ
 * Date: 7/24/2018
 * Time: 8:40 AM
 */
/**
 * Created by PhpStorm.
 * User: test
 * Date: 4/17/2018
 * Time: 1:40 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

Class Userpermission {

    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->helper('security');
        $this->CI->load->database();
    }

    /**
     * @param $methodConstant // member_div_registration_form
     * @return bool (true: has permission | false: no permission)
     * Purpose: Determine logged-in user's permission to execute a given task
     */
    public function checkUserPermissions($methodConstant)
    {

        // get list of permissions for logged in user
        // match with $methodConstant (hash)
        // if match, load view. Else show 403
        // if public user, show 404

        if ($this->CI->session->userdata('user_id')) {
            $loggedIn = true;
        } else {
            $loggedIn = false;
            show_404();
        }
        $this->CI->load->library('ion_auth');
        $is_admin = $this->CI->ion_auth->is_admin($this->CI->session->userdata('user_id'));
        
        if($is_admin){
            return true;
        }else{
            $permissionHash = $this->getHash($methodConstant);
            $userPermissions = $this->getUserPermissionsFromSession();

            if (in_array($permissionHash, $userPermissions)) {
                return true;
            } else {

                if ($loggedIn) {
                    $page = $this->CI->session->userdata('page');
                    $data['breadcrumbs'] = $this->CI->breadcrumb->render();
                    $data['dashboard_url'] = site_url('dashboard/' . $page);
                    $user_id = $this->CI->session->userdata('user_id');
                    $user = $this->CI->User_model->get_user($user_id);

                    $data['username'] = $user->username;
                    $data['user_id'] = $user_id;
                    $data['pagetitle'] = '403: Permission Denied';
                    $data['errorMessage'] = NULL;
                    $data['stylesheetes'] = array();
                    $data['scripts'] = array();

                    $this->CI->load->view('templates/header', $data);
                    $this->CI->load->view('templates/main_sidebar');
                    $this->CI->load->view('errors/html/error_permission', $data);
                    $this->CI->load->view('templates/footer');
                    $this->CI->load->view('templates/close');
                } else {
                    show_404();
                }
                return false;
            }
        }
    }
    
    /**
     * created by test
     * date 2019/09/26
     * @param type $methodConstant
     * @return boolean
     * check permission set or not for the user
     */
    public function checkUserPermissions2($methodConstant)
    {
        $this->CI->load->library('ion_auth');
        $is_admin = $this->CI->ion_auth->is_admin($this->CI->session->userdata('user_id'));
        if($is_admin){
            return true;
        }else{
            $permissionHash = $this->getHash($methodConstant);
            $userPermissions = $this->getUserPermissionsFromSession();

            if (in_array($permissionHash, $userPermissions)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * @return array
     * Purpose: Get permission(MD5) array from session
     */
    public function getUserPermissionsFromSession()
    {
        // TODO: get MD5 array for this usr from session
        $userPermissions = array();
        if ($this->CI->session->userdata('userperms')) {
            $userPermissions = $this->CI->session->userdata('userperms');
        }
        return $userPermissions;
    }

    /**
     * @param $userId
     * @return array
     * Purpose: Get permission(MD5) array from user permissions table(DB)
     * This function is fired once when the user logs in successfully
     */
    public function getUserPermissionsFromDb($userId)
    {
        // TODO: get MD5 array for this usr from user_permission table

        $userPermissions = array();
        $this->CI->db->select('sp.hash_code AS hashes');
        $this->CI->db->from('user_permissions AS up');
        $this->CI->db->join('system_permissions AS sp', 'up.perm_id = sp.id', 'left');
        $this->CI->db->where('up.user_id', $userId);
        $query = $this->CI->db->get()->result_array();
        if ($query) {
            $userPermissions = array_column($query, 'hashes');
        }
        
        // get grouyp id of logged in user
        if($userId){
            $sql="SELECT group_id FROM users_groups WHERE user_id= '.$userId.' AND status=1";

            $query=$this->CI->db->query($sql);
            if($query->num_rows() > 0){
                $userGroupId = $query->row()->group_id;
            }else{
                $userGroupId = false;
            }
        }else{
            $userGroupId = false;
        }
        
        if($userGroupId){
        
        
            $userPermissionsGroup = array();
            $this->CI->db->select('sp.hash_code AS hashes');
            $this->CI->db->from('group_permissions AS gp');
            $this->CI->db->join('system_permissions AS sp', 'gp.perm_id = sp.id', 'left');
            $this->CI->db->where('gp.group_id', $userGroupId);
            $query = $this->CI->db->get()->result_array();
            if($query) {
                $userPermissionsGroup = array_column($query, 'hashes');
            }
            $userPermissions = array_unique( array_merge($userPermissions, $userPermissionsGroup), SORT_REGULAR);
        }
        
        return $userPermissions;
    }
    
    

    /**
     * @return int
     * Purpose: Get the user id of logged-in user
     */
    private function getUserId()
    {
        // TODO: get user id from session
        $this->CI->load->library('session');
        $userId = $this->CI->session->userdata('user_id');
        return $userId;
    }

    /**
     * @return string
     * Purpose: Get constant(string) assigned to the logged in user ($userId)
     */
    private function getUserConstant($userId)
    {
        // TODO: get user constant
        // read user constant from DB table

        $userConstant = "";
        $row = $this->CI->db->query("SELECT uc.name AS constatnt  FROM user_permission_constants uc INNER JOIN users u ON uc.id=u.user_constatnt_id WHERE u.id= " . $userId)->row();
        $userConstant = $row->constatnt;
        return $userConstant;
    }

    /**
     * @param $permissionConstant
     * @return string
     * Purpose: Get MD5 hash of input string
     */
    private function getHash($permissionConstant)
    {
        $str = do_hash($permissionConstant, 'md5'); // MD5
        return $str;
    }

    //Get sub group of given user
    public function get_user_group($user_id)
    {

        $query = $this->CI->db->query("SELECT ug.group_id,g.name FROM users_groups ug INNER JOIN groups g ON ug.group_id=g.id WHERE ug.status=1 AND ug.user_id= " . $user_id);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->group_id;
        } else {
            return 0;
        }
    }

    //Get sub group of given user
    public function get_user_group_parent_id($user_id)
    {

        $query = $this->CI->db->query("SELECT ug.group_id,g.name,g.parent_id FROM users_groups ug INNER JOIN groups g ON ug.group_id=g.id WHERE ug.status=1 and ug.user_id= " . $user_id);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->parent_id;
        } else {
            return 0;
        }
    }

    /**
     * Note: this function uses internal template(Which is used for logged-in users). Hence prevent from using to public views
     */
    public function show_403($errorMessage)
    {
        $page = $this->CI->session->userdata('page');
        $data['breadcrumbs'] = $this->CI->breadcrumb->render();
        $data['dashboard_url'] = site_url('dashboard/' . $page);
        $user_id = $this->CI->session->userdata('user_id');
        $user = $this->CI->User_model->get_user($user_id);

        $data['username'] = $user->username;
        $data['user_id'] = $user_id;
        $data['pagetitle'] = '403: Permission Denied';
        $data['errorMessage'] = $errorMessage;
        $data['stylesheetes'] = array();
        $data['scripts'] = array();

        $this->CI->load->view('templates/header', $data);
        $this->CI->load->view('templates/main_sidebar');
        $this->CI->load->view('errors/html/error_permission', $data);
        $this->CI->load->view('templates/footer');
        $this->CI->load->view('templates/close');
    }

    /**
     * Note: this function uses internal template(Which is used for logged-in users). Hence prevent from using to public views
     */
    public function show_underConstruction()
    {
        $page = $this->CI->session->userdata('page');
        $data['breadcrumbs'] = $this->CI->breadcrumb->render();
        $data['dashboard_url'] = site_url('dashboard/' . $page);
        $user_id = $this->CI->session->userdata('user_id');
        $user = $this->CI->User_model->get_user($user_id);

        $data['username'] = $user->username;
        $data['user_id'] = $user_id;
        $data['pagetitle'] = '404: Coming Soon';
        $data['stylesheetes'] = array();
        $data['scripts'] = array();

        $this->CI->load->view('templates/header', $data);
        $this->CI->load->view('templates/main_sidebar');
        $this->CI->load->view('errors/html/error_under_construction', $data);
        $this->CI->load->view('templates/footer');
        $this->CI->load->view('templates/close');
    }

    /**
     * Note: this function uses internal template(Which is used for logged-in users). Hence prevent from using to public views
     */
    public function show_warning($warningTitle, $warningContent)
    {
        $exit_status = 1; // EXIT_ERROR

        $_error = & load_class('Exceptions', 'core');
        echo $this->show_error($warningTitle, $warningContent, 'error_warning', 500);
        exit($exit_status);
    }

    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        $templates_path = config_item('error_views_path');
        if (empty($templates_path)) {
            $templates_path = VIEWPATH . 'errors' . DIRECTORY_SEPARATOR;
        }

        if (is_cli()) {
            $message = "\t" . (is_array($message) ? implode("\n\t", $message) : $message);
            $template = 'cli' . DIRECTORY_SEPARATOR . $template;
        } else {
            set_status_header($status_code);
            $message = '<p>' . (is_array($message) ? implode('</p><p>', $message) : $message) . '</p>';
            $template = 'html' . DIRECTORY_SEPARATOR . $template;
        }

        $page = $this->CI->session->userdata('page');
        $data['breadcrumbs'] = $this->CI->breadcrumb->render();
        $data['dashboard_url'] = site_url('dashboard/' . $page);
        $user_id = $this->CI->session->userdata('user_id');
        $user = $this->CI->User_model->get_user($user_id);

        $data['username'] = $user->username;
        $data['user_id'] = $user_id;
        $data['pagetitle'] = 'Oops!';
        $data['stylesheetes'] = array();
        $data['scripts'] = array();
        $data['warningTitle'] = $heading;
        $data['warningContent'] = $message;

        $view = $this->CI->load->view('templates/header', $data, TRUE);
        $view .= $this->CI->load->view('templates/main_sidebar', $data, TRUE);
        $view .= $this->CI->load->view('errors/html/error_warning', $data, TRUE);
        $view .= $this->CI->load->view('templates/footer', $data, TRUE);
        $view .= $this->CI->load->view('templates/close', $data, TRUE);

        ob_end_flush();
        ob_start();
        include($templates_path . $template . '.php');
        ob_end_clean();
        return $view;
    }

    public function getUserPermissionsIDsFromDb($userId)
    {
        // TODO: get MD5 array for this usr from user_permission table

        $userPermissions = array();
        $this->CI->db->select('sp.id AS ids');
        $this->CI->db->from('user_permissions AS up');
        $this->CI->db->join('system_permissions AS sp', 'up.perm_id = sp.id', 'left');
        $this->CI->db->where('up.user_id', $userId);
        $query = $this->CI->db->get()->result_array();
       
        if ($query) {
            $userPermissions = array_column($query, 'ids');
        }

        // get grouyp id of logged in user
        if ($userId) {
            $sql = "SELECT group_id FROM users_groups WHERE user_id= '.$userId.' AND status=1";

            $query = $this->CI->db->query($sql);
            if ($query->num_rows() > 0) {
                $userGroupId = $query->row()->group_id;
            } else {
                $userGroupId = false;
            }
        } else {
            $userGroupId = false;
        }

        if ($userGroupId) {

//echo $userGroupId;
//exit;
            $userPermissionsGroup = array();
            $this->CI->db->select('sp.id AS ids');
            $this->CI->db->from('group_permissions AS gp');
            $this->CI->db->join('system_permissions AS sp', 'gp.perm_id = sp.id', 'left');
            $this->CI->db->where('gp.group_id', $userGroupId);
            $query = $this->CI->db->get()->result_array();
//             print_r($this->CI->db->last_query());
//             exit;
            if ($query) {
                $userPermissionsGroup = array_column($query, 'ids');
            }
            $userPermissions = array_unique(array_merge($userPermissions, $userPermissionsGroup), SORT_REGULAR);
        }

        return $userPermissions;
    }

}

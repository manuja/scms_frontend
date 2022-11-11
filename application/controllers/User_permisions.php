<?php

 /*
    @Ujitha Sudasingha
    2022-11-04
    User permission for the system users
    */
class User_permisions extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        $this->load->model(array('User_group_model', 'User_model'));
        $this->load->model('User_model');

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('signin', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }
    }

    //Load view
    public function index()
    {

        //echo 'User permissions'; die();

        $data['groups'] = $this->User_group_model->get_groups_without_member();
        $data['users'] = $this->User_model->get_users();
        //$data['currentGroups'] = $this->ion_auth->get_users_groups($id)->result();
        //print_r($data['currentGroups']);

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else if (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        } else {

            $this->breadcrumb->add('Home', site_url('admin_dashboard'));
            $this->breadcrumb->add('User permissions', site_url('user_permissions'));
            $data['breadcrumbs'] = $this->breadcrumb->render();

            $user_id = $this->session->userdata('user_id');

            $user = $this->User_model->get_user($user_id);

            $data['username'] = $user->username;

            $data['pagetitle'] = 'User permissions';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('admin/user_permissions', $data);
            $this->load->view('templates/footer');
            $this->load->view('admin/user_permissions_script');
            $this->load->view('templates/close');
        }
    }

    //Load users in given group
    public function load_user_combo_to_group()
    {

        $group_id = $this->input->post('goup_id');
        $result = $this->User_model->getUsersByGroupId($group_id);
        if (!empty($result)) {
            echo json_encode(array("status" => "1", "data" => $result));
        } else {
            echo json_encode(array("status" => "2", "data" => "Error"));
        }
    }

    //Get permissions for specific user
    public function get_permissions_to_user()
    {

        $userid = $this->input->post('user_id');
        $result = $this->User_model->get_user_related_permissions($userid);
        $perm_arr = array();
        if ($result) {
            foreach ($result as $perm_row)
            {
                $perm_arr[] = $perm_row->perm_id;
            }
        }

        if ($perm_arr) {
            echo json_encode(array("status" => 1, "data" => $perm_arr));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Could not get the user group permissions"));
        }
        return;
    }

    //Save user specific permissions
    public function saveUserPermissions()
    {

        $datestring = '%Y-%m-%d %H:%i:%s';
        $this->load->database();
        $user_id = $this->input->post('user_id');
        $group_id = $this->input->post('group_id');
        $perms = $this->input->post('perms');
        if (!empty($user_id)) {
	            $this->db->trans_start();
            $this->clearUserPerms($user_id, $group_id);
            $insert_row = array("user_id" => 0, "perm_id" => 0, "group_id" => 0);
            $batch_data = array();
            foreach ($perms as $perm)
            {
                $insert_row["user_id"] = $user_id;
                $insert_row["group_id"] = $group_id;
                $insert_row["perm_id"] = $perm;
                $batch_data[] = $insert_row;
            }

            $flag = $this->db->insert_batch('user_permissions', $batch_data);
//            print_r($this->db->last_query());
//            exit;
	            $trans = $this->db->trans_complete();
        }
        if (!empty($trans)) {
            echo json_encode(array("status" => 1, "msg" => "Permissions updated for the user"));
        } else {
            echo json_encode(array("status" => 2, "msg" => "Cannot update user permissions"));
        }
    }

    //Delete current permissions
    public function clearUserPerms($user_id, $group_id)
    {
        $this->load->database();
        $this->db->where('user_id', $user_id);
        $this->db->where('group_id', $group_id);
        $flag = $this->db->delete('user_permissions');
//        print_r($this->db->last_query());
//        exit;
    }

    public function get_user_groups()
    {

        $user_id = $this->input->post('user_id');
        $result = $this->ion_auth->get_users_groups($user_id)->result();
        ;
        if (!empty($result)) {
            echo json_encode(array("status" => "1", "data" => $result));
        } else {
            echo json_encode(array("status" => "2", "data" => "Error"));
        }
    }

    //Load permissions in groups for a given user
    public function load_group_permissions($id)
    {

        $data['group_id'] = $id;

        $this->load->view('templates/header');
        $this->load->view('templates/main_sidebar');
        $this->load->view('admin/group_permissions_for_user');
        $this->load->view('templates/footer');
        $this->load->view('admin/group_permissions_for_user_script', $data);
        $this->load->view('templates/close');
    }

    //Load all permissions  for a given user
    public function load_all_user_permissions($id)
    {

        $data['user_id'] = $id;

        $this->load->view('templates/header');
        $this->load->view('templates/main_sidebar');
        $this->load->view('admin/user_all_permissions');
        $this->load->view('templates/footer');
        $this->load->view('admin/user_all_permissions_script', $data);
        $this->load->view('templates/close');
    }

    //Load all groups not in current groups for user
    public function load_groups_not_in_user_groups()
    {

        $user_id = $this->input->post('user_id');
        $result = $this->User_model->getGroupsNotInCurrentGroups($user_id);
        if (!empty($result)) {
            echo json_encode(array("status" => "1", "data" => $result));
        } else {
            echo json_encode(array("status" => "2", "data" => "Error"));
        }
    }

}

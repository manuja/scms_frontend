<?php

 /*
    @Ujitha Sudasingha
    2022-11-04
     User permission mgt function for the system users
    */
defined('BASEPATH') OR exit('No direct script access allowed');

class User_permissions_new extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('User_permissions_new_modal'));
        $this->load->helper(array('master_tables'));
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');  
        }else if($this->userpermission->checkUserPermissions('permission_user')){
         
        $this->load->library('session');

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/' . $page));
        $this->breadcrumb->add('User Permissions', site_url(''));
        $data['breadcrumbs'] = $this->breadcrumb->render();

        $data['dashboard_url'] = site_url('dashboard/' . $page);
        $user_id = $this->session->userdata('user_id');
//            echo $user_id;exit;
        $user = $this->User_model->get_user($user_id);
        $data['username'] = $user->username;
        $data['user_id'] = $user_id;

        $this->load->helper('master_tables');
        $data['system_users'] = $this->User_permissions_new_modal->get_system_users();

        $data['editMode'] = false;
        $data['pagetitle'] = "SLGS - User Permissions";
        $data['stylesheetes'] = array(
            'assets/jstree/dist/themes/default/style.min.css',
            'assets/css/select2.css'
        );
        $data['scripts'] = array(
            'assets/jstree/dist/jstree.min.js',
            'assets/js/select2.js'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/main_sidebar', $data);
        $this->load->view('user/User_permissions_new_v', $data);
        $this->load->view('templates/footer', $data);
        $this->load->view('user/user_permissions_new_script');
        $this->load->view('templates/close');
        }
    }

    public function get_js_tree()
    {

        $trans = $this->User_permissions_new_modal->get_js_tree();

        if ($trans) {
            return $trans;
        } else {
            return $trans;
        }
    }

    public function save_user_permissions()
    {
        $this->load->model('User_permissions_new_modal');
        $trans = $this->User_permissions_new_modal->save_user_permissions();

        if ($trans) {
            echo $trans;
        } else {
            echo $trans;
        }
    }

}

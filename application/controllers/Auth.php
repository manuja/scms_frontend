<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation', 'session', 'audit_trail'));
        $this->load->model(array('User_model', 'User_permissions_model', 'User_group_model', 'Side_bar_m', 'Ion_auth_model'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('signin', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('users')) {
            //$this->userpermission->test();die();

            $user_id = $this->session->userdata('user_id');
            $group_id = $this->userpermission->get_user_group($user_id);
             //print_r("okknn");die();

            $this->breadcrumb->add('Home', site_url('admin_dashboard'));
            $this->breadcrumb->add('Users', site_url('auth/index'));
            $this->data['breadcrumbs'] = $this->breadcrumb->render();

            $user_id = $this->session->userdata('user_id');

            $user = $this->User_model->get_user($user_id);

            $this->data['pagetitle'] = 'Users';

            $this->data['username'] = $user->username;

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $this->data['users'] = $this->ion_auth->users()->result();
            foreach ($this->data['users'] as $k => $user) {
                //$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
                $this->data['users'][$k]->groups = $this->User_group_model->get_user_group($user->id);
            }

            $this->data['groups'] = $this->db->get('groups')->result();

            $this->data['system_groups'] = get_system_groups();
            // $this->data['division_list'] = getDivisions();
            //$this->_render_page('auth/index', $this->data);
            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('auth/index', $this->data);
            $this->load->view('templates/footer');
            $this->load->view('auth/users_script');
            $this->load->view('templates/close');
        }
    }

    //Load administrator dashboard  

    public function dashboard()
    {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else if (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        } else {

            //$this->load_dashboard(57);die();
            $this->breadcrumb->add('Home', site_url('admin_dashboard'));
            $data['breadcrumbs'] = $this->breadcrumb->render();

            $user_id = $this->session->userdata('user_id');

            $user = $this->User_model->get_user($user_id);

            //get_dashboard_user_count

            $data['user_counts'] =  $this->ion_auth->get_dashboard_user_count();

            $data['username'] = $user->username;

            $data['pagetitle'] = 'Admin dashboard';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('admin/dashboard', $data);
            $this->load->view('templates/footer');
            $this->load->view('admin/dashboard_script');
        }
    }

    public function get_sub_groups()
    {

        $this->db->select('*');
        $this->db->from(`groups`);
        $this->db->where('is_admin', 0);
        $this->db->where('parent_id!=', 0);
        return $this->db->get()->result_array();
    }



    public function delete_parent_group()
    {
        $group_id = $this->input->post('group_id');
        $this->db->where('id', $group_id);
        $this->db->delete('groups');
        $this->db->where('parent_id', $group_id);
        $flag = $this->db->delete('groups');
        echo json_encode($flag);
    }

    public function delete_sub_group_page($id)
    {
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/' . $page));
        $this->breadcrumb->add('Sub groups', site_url(''));

        $data['breadcrumbs'] = $this->breadcrumb->render();
        $data['sub_group_id'] = $id;
        $this->db->select('name');
        $this->db->from('groups');
        $this->db->where('id', $id);
        $data['sub_group'] = $this->db->get()->row();
        $data['pagetitle'] = "test MIS - Delete sub groups";
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('user_group_delete')) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar', $data);
            $this->load->view('auth/delete_sub_group', $data);
            //            $this->load->view('templates/footer');
            $this->load->view('templates/close');
        }
    }

    public function delete_sub_group()
    {
        if ($this->userpermission->checkUserPermissions2('user_group_delete')) {
            $data = $this->input->post('data');
            //            var_dump($data['sub_group_id']);die();
            $this->db->where('id', $data['sub_group_id']);
            if ($this->db->delete('groups')) {
                echo json_encode(array('status' => 1, 'msg' => 'Group Deleted.'));
            } else {
                echo json_encode(array('status' => 0, 'msg' => 'Not Success,Try Again.'));
            }
        } else {
            echo json_encode(array('status' => 0, 'msg' => 'You have not access permission'));
        }
    }

    /**
     * Redirect if needed, otherwise display the group list
     */
    public function groups()
    {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('user_group')) { //remove this elseif if you want to enable this for non-admins



            $this->breadcrumb->add('Home', site_url('/'));
            $this->breadcrumb->add('Groups', site_url('auth/groups'));
            $this->data['breadcrumbs'] = $this->breadcrumb->render();

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



            //list the groups
            $this->data['groups'] = $this->ion_auth->groups()->result();

      //print_r($data);die();

            $user_id = $this->session->userdata('user_id');

            $user = $this->User_model->get_user($user_id);

            //print_r($user);die();


            $this->data['username'] = $user->username;

            $this->data['pagetitle'] = 'Groups';



            //$this->_render_page('auth/groups', $this->data);
            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('admin/groups', $this->data);
            $this->load->view('templates/footer');
            $this->load->view('admin/groups_script');
        }
    }

    //Retrive the number of sub groups
    public function get_no_of_sub_groups($group_id)
    {

        if (isset($group_id)) {
            $subgroups = $this->ion_auth->get_sub_groups($group_id);
            $subgroup_count = sizeof($subgroups);
            return $subgroup_count;
        } else {
            return 0;
        }
    }

    /**
     * Log the user in
     */
    public function login()
    {

        $this->data['title'] = "CRM";

        //


        // validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');



        if ($this->form_validation->run() === TRUE) {


            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');
            //Model Ion_auth_model
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {


                //if the login is successful
                //redirect them back to the home page
                $user_id = $_SESSION['user_id'];
                 //  print_r($user_id);die();
                $group_ids = $this->User_model->get_user_group_ids($user_id);

                //print_r($group_ids);

                //  print_r("QAaaaaskkk");die();

                // check for user agreement
                // if agreed -> proceed
                // if not agree, logout
                //                if ($this->User_model->checkUserAgreement($user_id)) {
                if (!$this->User_model->isFirstLogin($user_id)) {

                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {
                        $this->loginLog();
                        // die();
                        redirect('admin_dashboard', 'refresh');
                    } else {
                        $this->loginLog();
                        // TODO: call permission lib here and write permission array to session
                        $thisUsersPermissions = $this->userpermission->getUserPermissionsFromDb($user_id);

                        $this->session->set_userdata('userperms', $thisUsersPermissions);

                        //Redirect user to his/her relevant page
                        $this->load_dashboard($group_ids);
                    }
                } else { // offer password reset
                    $data['identity'] = $this->User_model->getIdentity($user_id);
                    $this->load->view('member/user_password_reset', $data);
                }
                //                } else { // offer terms and agreements
                //                    $this->load->view('member/user_terms_and_conditions');
                //                }
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('signin', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array(
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                'class' => 'form-control'
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'autocomplete' => "off"
            );

            $this->_render_page('auth/login', $this->data);
        }
    }

    /**
     * Load dashboard for specific user group
     */
    public function load_dashboard($group_ids)
    {
        //        var_dump($this->session->userdata('request_url'));die();
        $requested_url = '';
        if ($this->session->userdata('request_url') != null) {
            $requested_url = $this->session->userdata('request_url');

            $this->session->unset_userdata('request_url');
        }

        $dataService = $this->Side_bar_m->createUserMenu();

        foreach ($group_ids as $group_id) {
            $gid = $group_id['group_id'];
        }

        $this->session->user_menu = $dataService;

        if (sizeof($group_ids) == 1) {
            foreach ($group_ids as $group_id) {
                $id = $group_id['group_id'];
            }
            $page = '';
            $name = '';
            if (!empty($id)) {
                //                $row = $this->db->get_where('system_views', array('group_id' => $id))->row();

                //                if($row){
                //                    $page = $row->page;
                //                    $name = $row->name;
                //                }else{
                $page1 = 'dashboard_member';
                $page2 = 'dashboard_staff';
                $name = 'dashboard';
                //                }
            }
            //dashboard _staff
            if ($requested_url != null && $requested_url != '') {
                $this->session->set_userdata('page', $page);;
                redirect($requested_url);
            } else {
                // print_r($gid);
                // die();
                if ($gid == 4) {
                    redirect('dashboard/' . $page2, 'refresh');
                } else if ($gid == 5) {
                    redirect('dashboard/' . $page1, 'refresh');
                } else {
                    redirect('dashboard/' . $page1, 'refresh');
                }
            }
        } else {
            echo 'Multiple groups';
        }
    }



    //Redirect to each group dashboard

    public function group_dashboard($page)
    {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('signin', 'refresh');
        } else {

            $this->session->set_userdata('page', $page);
            redirect('member_dashboard');
        }
    }

    /**
     * Log the user out
     */
    public function logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        //$this->load->helper('cookie');
        //delete_cookie('ci_session');
        // redirect them to the login page
        $this->session->unset_userdata('userperms');
        $this->session->unset_userdata('request_url');
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('signin', 'refresh');
    }

    /**
     * Change password
     */
    public function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === FALSE) {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            // render
            $this->_render_page('auth/change_password', $this->data);
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    /**
     * Forgot password
     */
    public function forgot_password()
    {


        //setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }




        if ($this->form_validation->run() === FALSE) {

            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->data['identity'] = array(
                'name' => 'identity',
                'id' => 'identity',
                'class' => 'form-control'
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth/forgot_password', $this->data);
        } else {

            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }

            //            $this->load->helper('master_tables');
            //            $email = get_user_email_from_name($user_name);
            //            $this->email_service->sendSingleEmail('testw.pipl@gmail.com', 'Reset Password', $body);
            // run the forgotten password method to email an activation code to the user

            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {

                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }

    /**
     * Reset password - final step for forgotten password
     *
     * @param string|null $code The reset code
     */
    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $this->data['title'] = $this->lang->line('reset_password_heading');

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() === FALSE) {
                // display the form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = [
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                ];
                $this->data['new_password_confirm'] = [
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                ];
                $this->data['user_id'] = [
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                ];
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
            } else {
                $identity = $user->{$this->config->item('identity', 'ion_auth')};

                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($identity);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    // finally change the password
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    /**
     * Activate the user
     *
     * @param int         $id   The user ID
     * @param string|bool $code The activation code
     */
    public function activate($id, $code = FALSE)
    {
        if ($code !== FALSE) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("Users_new", 'refresh');
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    /**
     * Deactivate the user
     *
     * @param int|string|null $id The user ID
     */
    /* public function deactivate($id = NULL)
    {

        error_reporting(0);
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/' . $page));
        $this->breadcrumb->add('Sub groups', site_url(''));

        $data['breadcrumbs'] = $this->breadcrumb->render();

        $data['pagetitle'] = "test MIS - Delete sub groups";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $id = (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() === FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            //$this->_render_page('auth/deactivate_user', $this->data);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('auth/deactivate_user', $this->data);
//            $this->load->view('templates/footer');
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    return show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            // redirect them back to the auth page
            redirect('Users_new', 'refresh');
        }
    }
    * 
    */

    /**
     * Create a new user
     */
    public function create_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('user_add')) {

            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;

            // validate form input
            $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
            $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
            $this->form_validation->set_rules('name_initials', $this->lang->line('create_user_validation_name_initials_label'), 'trim|required');
            $this->form_validation->set_rules('nic', 'NIC', 'trim|required|is_unique[' . $tables['users'] . '.nic]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');

            if ($this->form_validation->run() === TRUE) {
                $email = strtolower($this->input->post('email'));
                $password = $this->input->post('nic');

                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'name_initials' => $this->input->post('name_initials'),
                    'nic' => $this->input->post('nic'),
                    'created_by' => $this->session->userdata('user_id'),

                );
                // var_dump($this->input->post());die();
            }
            if ($this->form_validation->run() === TRUE && $this->ion_auth->register($password, $email, $additional_data)) {
                // check to see if we are creating the user
                // redirect them back to the admin page
                $this->audit_trail->saveAuditData('audit_trial_user_management', 'user_add', $this->session->userdata('user_id'));
                //sending a notification for relevant users
                // $Permission_arr = array('emp','all_users'); 
                // $recipients = getAllUsersbyPermissionCodes($Permission_arr);
                // print_r($recipients);
                // die();
                $messageShort = 'New user accout was created';
                $messageLong = 'Staff member account was created';
                $hyperlink = base_url('employees');
                $notificationCategory = 1;
                $notificationPriority = 2;
                //  $result = $this->notify_service->fireNotifications($recipients, $messageLong, $messageShort, $hyperlink, $notificationCategory, $notificationPriority, $expirationDuration = NULL, $notificationThumbnail = NULL);
                //                           

                // $this->session->set_flashdata('response_success', $this->ion_auth->messages());
                // redirect("auth", 'refresh');

                $this->session->set_flashdata('success', 'Record Added successfully!');
                redirect(base_url() . 'auth');
            } else {
                // display the create user form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                $this->data['first_name'] = array(
                    'name' => 'first_name',
                    'id' => 'first_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('first_name'),
                    'placeholder' => 'First name',
                    'class' => 'form-control',
                    'pattern' => "[A-Za-z ]{1,255}",
                    'required' => true
                );
                $this->data['last_name'] = array(
                    'name' => 'last_name',
                    'id' => 'last_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('last_name'),
                    'placeholder' => 'Last name',
                    'class' => 'form-control',
                    'pattern' => "[A-Za-z ]{1,255}",
                    'required' => true
                );
                $this->data['name_initials'] = array(
                    'name' => 'name_initials',
                    'id' => 'name_initials',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('name_initials'),
                    'placeholder' => 'Name with initials',
                    'class' => 'form-control',
                    'pattern' => "[A-Za-z ]{1,255}",
                    'required' => true
                );
                $this->data['nic'] = array(
                    'name' => 'nic',
                    'id' => 'nic',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('nic'),
                    'placeholder' => 'NIC',
                    'class' => 'form-control',
                    'required' => true
                );
                $this->data['email'] = array(
                    'name' => 'email',
                    'id' => 'email',
                    'type' => 'email',
                    'value' => $this->form_validation->set_value('email'),
                    'placeholder' => '',
                    'class' => 'form-control',
                    'required' => true,

                );


                $this->breadcrumb->add('Home', site_url('admin_dashboard'));
                $this->breadcrumb->add('Users', site_url('auth/index'));
                $this->breadcrumb->add('Add user', site_url('auth/create_user'));
                $this->data['breadcrumbs'] = $this->breadcrumb->render();

                $user_id = $this->session->userdata('user_id');

                $user = $this->User_model->get_user($user_id);

                $this->data['username'] = $user->username;
                $this->data['pagetitle'] = 'Add User';
                // $this->data['division_list'] = getDivisions();

                $this->load->view('templates/header', $this->data);
                $this->load->view('templates/main_sidebar');
                $this->load->view('auth/create_user', $this->data);
                $this->load->view('templates/footer');
                $this->load->view('auth/create_user_script');
                $this->load->view('templates/close');
            }
        }
    }

    /**
     * Edit a user
     *
     * @param int|string $id
     */
    public function edit_user($id)
    {
        error_reporting(0);
        $this->data['title'] = $this->lang->line('edit_user_heading');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('user_edit')) {

            $user = $this->ion_auth->user($id)->row();
            $groups = $this->User_group_model->get_groups_without_member();
            $currentGroups = $this->ion_auth->get_users_groups($id)->result();

            // validate form input
            $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
            $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
            //        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');



            if (isset($_POST) && !empty($_POST)) {

                if ($id != $this->input->post('id')) {

                    show_error($this->lang->line('error_csrf'));
                }

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                    $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
                }

                if ($this->form_validation->run() === TRUE) {
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'username' => $this->input->post('email'),
                        'name_initials' => $this->input->post('name_initials'),
                        'employee_no' => "PF" . $this->input->post('emp_number'),
                        'nic' => $this->input->post('nic')
                    );


                    // check to see if we are updating the user
                    if ($this->ion_auth->update($user->id, $data)) {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('response_success', $this->ion_auth->messages());
                        $this->audit_trail->saveAuditData('audit_trial_user_management', 'user_edit', $this->session->userdata('user_id'));
                        if ($this->ion_auth->is_admin()) {
                            redirect('auth/edit_user/' . $id);
                        } else {
                            redirect('auth/edit_user/' . $id);
                        }
                    } else {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('response_error', $this->ion_auth->errors());
                        if ($this->ion_auth->is_admin()) {
                            redirect('auth/edit_user/' . $id);
                        } else {
                            redirect('auth/edit_user/' . $id);
                        }
                    }
                }
            }

            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            // pass the user to the view
            $this->data['user'] = $user;



            $user_name = $this->db->query("SELECT username FROM users WHERE id= " . $id)->row()->username;

            $this->breadcrumb->add('Home', site_url('admin_dashboard'));
            $this->breadcrumb->add('Users', site_url('auth'));
            $this->breadcrumb->add($user_name, site_url('auth/edit_user/' . $id));
            $this->data['breadcrumbs'] = $this->breadcrumb->render();


            $user_id = $this->session->userdata('user_id');

            $user = $this->User_model->get_user($user_id);

            $this->data['username'] = $user->username;

            $this->data['pagetitle'] = 'Edit Staff Member';
            // $this->data['division_list'] = getDivisions();

            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('auth/edit_user', $this->data);
            $this->load->view('templates/footer');
            $this->load->view('auth/create_user_script');
            $this->load->view('templates/close');
        }
    }


    public function edit_slgs_member($id)
    {



        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('edit_slgs_member)')) {

            $user = $this->ion_auth->user($id)->row();

            // firstname
            // lastname
            // nic
            // address1
            // address2
            // pcode
            // F_country
            // F_province
            // F_city
            // F_pasport_country
            // conmobile
            // confix
            // Email
            //issri


            if (isset($_POST) && !empty($_POST)) {

                $tables = $this->config->item('tables', 'ion_auth');

                if ($this->input->post('issri')  != 1) {

                    // print("in->if1");

                    $this->form_validation->set_rules('F_country', 'f_country', 'trim|required');
                    $this->form_validation->set_rules('F_province', 'f_province', 'trim|required');
                    $this->form_validation->set_rules('F_city', 'f_city', 'trim|required');
                    $this->form_validation->set_rules('F_pasport_country', 'f_pasport_country', 'trim|required');
                }


                $this->form_validation->set_rules('title', 'Title', 'trim|required');
                $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
                $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
                // $this->form_validation->set_rules('nic', 'NIC', 'trim|required|is_unique[' . $tables['users'] . '.nic]');
                $this->form_validation->set_rules('iname', 'Iname', 'trim|required');
                $this->form_validation->set_rules('address1', 'Address1', 'trim|required');
                $this->form_validation->set_rules('address2', 'Address2', 'trim|required');
                $this->form_validation->set_rules('pcode', 'Pcode', 'trim|required');
                $this->form_validation->set_rules('conmobile', 'Conmobile', 'trim|required');
                $this->form_validation->set_rules('confix', 'Confix', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');



                if ($this->form_validation->run() === TRUE) {


                    if ($this->input->post('issri')  == 1) {

                        // print("in->if2");

                        $data1 = array(
                            'first_name' => $this->input->post('firstname'),
                            'last_name' => $this->input->post('lastname'),
                            'username' => $this->input->post('email'),
                            'name_initials' => $this->input->post('iname'),
                            'nic' => $this->input->post('nic')
                        );


                        $data2 = array(
                            'nic' => $this->input->post('nic'),
                            'title' => $this->input->post('title'),
                            'first_name' => $this->input->post('firstname'),
                            'last_name' => $this->input->post('lastname'),
                            'name_initials' => $this->input->post('iname'),
                            'address1' => $this->input->post('address1'),
                            'address2' => $this->input->post('address2'),
                            'Province' => '',
                            'city' => '',
                            'country' => '',
                            'passport_country' => '',
                            'contact_mobile' => $this->input->post('conmobile'),
                            'contact_home' => $this->input->post('confix'),
                            'postal_code' => $this->input->post('pcode'),
                        );
                    } else {
                        print("in->else");


                        $data1 = array(
                            'first_name' => $this->input->post('firstname'),
                            'last_name' => $this->input->post('lastname'),
                            'username' => $this->input->post('email'),
                            'name_initials' => $this->input->post('iname'),
                            'nic' => $this->input->post('nic')
                        );


                        $data2 = array(
                            'nic' => $this->input->post('nic'),
                            'title' => $this->input->post('title'),
                            'first_name' => $this->input->post('firstname'),
                            'last_name' => $this->input->post('lastname'),
                            'name_w_initials' => $this->input->post('iname'),
                            'address1' => $this->input->post('address1'),
                            'address2' => $this->input->post('address2'),
                            'Province' => $this->input->post('F_province'),
                            'city' => $this->input->post('F_city'),
                            'country' => $this->input->post('F_country'),
                            'passport_country' => $this->input->post('F_pasport_country'),
                            'contact_mobile' => $this->input->post('conmobile'),
                            'contact_home' => $this->input->post('confix'),
                            'postal_code' => $this->input->post('pcode')
                        );
                    }

                    // die();

                    // check to see if we are updating the user
                    if ($this->ion_auth->updatemember($user->id, $data1, $data2)) {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('response_success', $this->ion_auth->messages());
                        $this->audit_trail->saveAuditData('audit_trial_user_management', 'user_edit', $this->session->userdata('user_id'));
                        if ($this->ion_auth->is_admin()) {
                            redirect('edit_member/' . $id);
                        } else {
                            redirect('edit_member/' . $id);
                        }
                    } else {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('response_error', $this->ion_auth->errors());
                        if ($this->ion_auth->is_admin()) {
                            redirect('edit_member/' . $id);
                        } else {
                            redirect('edit_member/' . $id);
                        }
                    }
                }
            }

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->breadcrumb->add('Home', site_url('admin_dashboard'));
            $this->breadcrumb->add('Users', site_url('auth'));
            $this->breadcrumb->add('Edit SLGS Member', site_url('auth/edit_member/' . $id));
            $this->data['breadcrumbs'] = $this->breadcrumb->render();


            $user_id = $this->session->userdata('user_id');

            $user = $this->User_model->get_user($user_id);

            $this->data['user'] = $this->User_model->get_user($id);
            $this->data['user_pro'] = $this->User_model->get_user_profile($id);

            $this->data['username'] = $user->username;

            $this->data['pagetitle'] = 'Edit SLGS Member';

            $this->data['edit_status'] = true;


            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('auth/edit_slgs_member', $this->data);
            $this->load->view('templates/footer');
            $this->load->view('auth/edit_slgs_member_script');
            $this->load->view('templates/close');
        }
    }

    public function view_slgs_member($id)
    {



        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('view_slgs_member)')) {


            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->breadcrumb->add('Home', site_url('admin_dashboard'));
            $this->breadcrumb->add('Users', site_url('auth'));
            $this->breadcrumb->add('View SLGS Member', site_url('auth/view_member/' . $id));
            $this->data['breadcrumbs'] = $this->breadcrumb->render();


            $user_id = $this->session->userdata('user_id');

            $user = $this->User_model->get_user($user_id);

            $this->data['user'] = $this->User_model->get_user($id);
            $this->data['user_pro'] = $this->User_model->get_user_profile($id);

            $this->data['username'] = $user->username;

            $this->data['pagetitle'] = 'View SLGS Member';

            $this->data['edit_status'] = false;


            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('auth/edit_slgs_member', $this->data);
            $this->load->view('templates/footer');
            $this->load->view('auth/edit_slgs_member_script');
            $this->load->view('templates/close');
        }
    }

    /**
     * Create a new group
     */
    public function create_group()
    {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('user_add_group')) {

            // validate form input
            $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required');

            if ($this->form_validation->run() === TRUE) {
                $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
                if ($new_group_id) {
                    $this->audit_trail->saveAuditData('audit_trial_user_management', 'user_add_group', $this->session->userdata('user_id'));
                    // check to see if we are creating the group
                    // redirect them back to the admin page
                    $this->session->set_flashdata('response_success', $this->ion_auth->messages());
                    redirect("auth/groups");
                }
            } else {
                // display the create group form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                $this->data['group_name'] = array(
                    'name' => 'group_name',
                    'id' => 'group_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('group_name'),
                    'class' => 'form-control'
                );
                $this->data['description'] = array(
                    'name' => 'description',
                    'id' => 'description',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('description'),
                    'class' => 'form-control'
                );

                $this->breadcrumb->add('Home', site_url('admin_dashboard'));
                $this->breadcrumb->add('Groups', site_url('auth/groups'));
                $this->breadcrumb->add('Add group', site_url('auth/create_group'));
                $this->data['breadcrumbs'] = $this->breadcrumb->render();


                $user_id = $this->session->userdata('user_id');

                $user = $this->User_model->get_user($user_id);

                $this->data['username'] = $user->username;
                $this->data['pagetitle'] = "Create groups";

                $this->load->view('templates/header', $this->data);
                $this->load->view('templates/main_sidebar');
                $this->_render_page('auth/create_group', $this->data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function create_sub_group($id)
    {
        if ($this->userpermission->checkUserPermissions('user_sub_group_add')) {
            $this->data['group_id'] = $id;

            $group_name = $this->db->query("SELECT name FROM groups WHERE id= " . $id)->row()->name;

            $this->breadcrumb->add('Home', site_url('admin_dashboard'));
            $this->breadcrumb->add($group_name, site_url('auth/edit_group/' . $id));
            $this->breadcrumb->add('Create sub group', site_url('auth/create_sub_group/' . $id));
            $this->data['breadcrumbs'] = $this->breadcrumb->render();
            $this->data['pagetitle'] = "Create sub groups";

            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/main_sidebar');
            $this->_render_page('auth/create_sub_group', $this->data);
            $this->load->view('templates/footer');
            $this->_render_page('auth/create_sub_group_script');
            $this->load->view('templates/close');
        }
    }

    public function save_sub_group()
    {
        if ($this->userpermission->checkUserPermissions('user_sub_group_add')) {

            $name = $this->input->post('name');
            $desc = $this->input->post('desc');
            $parent_id = $this->input->post('group_id');

            if ($name != '' && $desc != '' && $parent_id != 0) {
                $data = array(
                    'name' => $name,
                    'description' => $desc,
                    'parent_id' => $parent_id
                );

                if ($this->ion_auth->create_sub_group($data) == TRUE) {
                    $this->audit_trail->saveAuditData('audit_trial_user_management', 'user_sub_group_add', $this->session->userdata('user_id'));
                    $this->session->set_flashdata('response_success', "Sub-Group Saved Successfully");
                    redirect("auth/edit_group/" . $parent_id, 'refresh');
                } else {
                    $this->session->set_flashdata('response_error', "Try Again!");
                    redirect("auth/groups", 'refresh');
                }
            } else {
                $this->session->set_flashdata('response_error', "Try Again!");
                redirect("auth/groups", 'refresh');
            }
        }
    }

    /**
     * Edit a group
     *
     * @param int|string $id
     */
    public function edit_group($id)
    {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('user_edit_group')) {

            $group = $this->ion_auth->group($id)->row();

            //print_r($group); die();
            // validate form input
            $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required');

            if (isset($_POST) && !empty($_POST)) {
                if ($this->form_validation->run() === TRUE)
                    //Array with values to update
                    $update_data = array(
                        'desc' => $_POST['group_description']
                    ); {
                    $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $update_data);

                    if ($group_update) {
                        $this->audit_trail->saveAuditData('audit_trial_user_management', 'user_edit_group', $this->session->userdata('user_id'));
                        $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                    }
                    redirect("auth/groups", 'refresh');
                }
            }

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            // pass the user to the view
            $this->data['group'] = $group;

            $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name', $group->name),
                $readonly => $readonly,
                'class' => 'form-control'
            );
            $this->data['group_description'] = array(
                'name' => 'group_description',
                'id' => 'group_description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_description', $group->description),
                'class' => 'form-control'
            );

            $this->data['group_sequence'] = array(
                'name' => 'group_sequence',
                'id' => 'group_sequence',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_sequence', $group->sequence),
                'class' => 'form-control'
            );

            $this->data['sub_groups'] = $this->ion_auth->get_sub_groups($id);
            $this->data['group_id'] = $id;

            $group_name = $this->db->query("SELECT name FROM groups WHERE id= " . $id)->row()->name;

            $this->breadcrumb->add('Home', site_url('admin_dashboard'));
            $this->breadcrumb->add('Groups', site_url('auth/groups'));
            $this->breadcrumb->add($group_name, site_url('auth/edit_group/' . $id));
            $this->data['breadcrumbs'] = $this->breadcrumb->render();


            $user_id = $this->session->userdata('user_id');

            $user = $this->User_model->get_user($user_id);

            $this->data['username'] = $user->username;

            $this->data['pagetitle'] = 'Sub Groups';

            //$this->_render_page('auth/edit_group', $this->data);
            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/main_sidebar');

            $this->load->view('auth/edit_group', $this->data);
            $this->load->view('templates/footer');
        }
    }

    /**
     * @return array A CSRF key-value pair
     */
    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    /**
     * @return bool Whether the posted CSRF token matches
     */
    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @param string     $view
     * @param array|null $data
     * @param bool       $returnhtml
     *
     * @return mixed
     */
    public function _render_page($view, $data = NULL, $returnhtml = FALSE)
    { //I think this makes more sense
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        // This will return html on 3rd argument being true
        if ($returnhtml) {
            return $view_html;
        }
    }

    public function termsConditionsFormSubmit()
    {
        $form_data = $this->input->post();

        if (isset($form_data['agree_terms'])) {
            if ($form_data['agree_terms'] == '1') {
                $user_id = $this->session->userdata('user_id');
                $this->User_model->agreeTerms($user_id);

                if ($this->User_model->checkUserAgreement($user_id)) {
                    if ($this->User_model->isFirstLogin($user_id)) {
                        $data['identity'] = $this->User_model->getIdentity($user_id);
                        $this->load->view('member/user_password_reset', $data);
                    } else {
                        // TODO: call permission lib here and write permission array to session
                        $group_ids = $this->User_model->get_user_group_ids($user_id);
                        $thisUsersPermissions = $this->userpermission->getUserPermissionsFromDb($user_id);
                        $this->session->set_userdata('userperms', $thisUsersPermissions);

                        //Redirect user to his/her relevant page
                        $this->load_dashboard($group_ids);
                    }
                } else {
                    $this->logout();
                }
            }
        }
    }

    public function setNewPssword()
    {
        $form_data = $this->input->post();
        $user_id = $this->session->userdata('user_id');
        $new = $form_data['password'];
        $identity = $form_data['identity'];

        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password2]');
            $this->form_validation->set_rules('password2', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

            if ($this->form_validation->run() == FALSE) {
                $data['identity'] = $this->User_model->getIdentity($user_id);
                $this->load->view('member/user_password_reset', $data);
            } else {
                $this->loginLog();
                $this->load->model('Ion_auth_model');
                $this->Ion_auth_model->change_password_firstime_login($identity, $new);
            }
        }
    }

    public function sub_group_edit()
    {

        $this->load->model('User_model');
        $trans = $this->User_model->update_sub_groups();
        //        }
        //        print_r($trans);
        //        exit;
        if ($trans) {
            echo json_encode(array("status" => 1, "msg" => "Successfully Saved", "data" => $trans));
        } else {
            echo json_encode(array("status" => 2, "msg" => 'Cannot add duplicate entries, Please select another data'));
        }
    }

    /**
     * created by : test
     * Date : 2019/08/27
     * create user login log
     */
    public function loginLog()
    {

        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            //check for ip from share internet
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            // Check for the Proxy User
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }


        $data['user_id'] = $this->session->userdata('user_id');
        $data['username'] = $this->session->userdata('username');
        $data['ip'] = $ip;
        $result = $this->User_model->userLog($data);

        return $result;
    }

    public function getUserDtails()
    {
        if ($this->userpermission->checkUserPermissions2('user_active')) {
            $user_id = $this->input->post('user_id');
            $user_details = $this->User_model->get_user($user_id);
            $user_group = $this->User_model->get_user_group_ids($user_id);
            $user_comment = $this->User_model->getstatuscomment($user_id);


            // print_r($user_comment);
            // die();

            if (count($user_comment) > 0) {

                $user_details->comment = $user_comment[0]['comment'];
                $user_details->comment_date = $user_comment[0]['created_at'];
            } else {

                $user_details->comment = "";
                $user_details->comment_date = "";
            }

            if ($user_group) {
                $user_details->group_id = $user_group[0]['group_id'];
            } else {
                $user_details->group_id = 0;
            }

            echo json_encode($user_details);
        } else {
            echo 0;
        }
    }

    public function userActivation()
    {
        if ($this->userpermission->checkUserPermissions2('user_active')) {
            $post_data = $this->input->post();



            if ($post_data['user_group'] != "" && $post_data['user_id'] != '') {
                if ($this->User_model->userActivation($post_data)) {
                    $this->audit_trail->saveAuditData('audit_trial_user_management', 'user_active', $this->session->userdata('user_id'));
                    if ($post_data['user_status'] == 0) {
                        //sending a notification for relevant users
                        // $user_details = getUserDetailsByid($post_data['user_id']);
                        // $Permission_arr = array('emp','all_users'); 
                        // $recipients = getAllUsersbyPermissionCodes($Permission_arr);
                        // $messageShort = 'User account is deactivated';
                        // $messageLong = $user_details->employee_no.' has been deactivated';
                        // $hyperlink = base_url('employees');
                        // echo json_encode(array('status'=>1,'msg'=>'Successfully Updated.'));
                        //$notificsationCategory = 1;
                        //$notificationPriority = 2;
                        // $result = $this->notify_service->fireNotifications($recipients, $messageLong, $messageShort, $hyperlink, $notificationCategory, $notificationPriority, $expirationDuration = NULL, $notificationThumbnail = NULL);
                    }

                    // echo json_encode(array('status'=>1,'msg'=>'Successfully Updated.'));
                } else {
                    //echo json_encode(array('status'=>0,'msg'=>'Database error occured'));
                }
            } else {
                //echo json_encode(array('status'=>0,'msg'=>'Reqiured data was empty'));
            }
        } else {
            //echo json_encode(array('status'=>0,'msg'=>'You have no access permission'));
        }
    }

    function oldNicToNewNic($oldNic)
    {
        $arr1 = str_split($oldNic, 5);

        $newNic = substr(strtoupper("19" . $arr1[0] . '0' . $arr1[1]), 0, -1);
        $oldNic = strtoupper($oldNic);

        return array($oldNic, $newNic);
    }
    function unique_nic()
    {
        $nic = $_REQUEST['nic'];

        if (isset($_REQUEST['user_id'])) {
            $user_id = $_REQUEST['user_id'];
        } else {
            $user_id = false;
        }

        $newNic = $this->oldNicToNewNic($nic)[1];
        if (strlen($_REQUEST['nic']) == 12) {
            $newNic = $nic;
        }
        $validNic = $this->fieldauthentication->uniqueNic($newNic, $user_id);
        echo json_encode($validNic);
    }


    public function viewMyProfile()
    {
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/' . $page));
        $this->breadcrumb->add('My Profile', site_url('my-profile'));

        $data['breadcrumbs'] = $this->breadcrumb->render();
        $data['pagetitle'] = 'My Profile';
        $user_id = $this->session->userdata('user_id');


        $data['profile_data'] = $this->User_model->get_user_profile($user_id);
        $data['user_data'] = $this->User_model->get_user($user_id);

        $data['user_type']  = $data['user_data']->in_source;

        $data['is_admin'] = false;
        $data['stylesheetes'] = array();

        $data['scripts'] = array();

        $view_arr = array(
            'data' => $data,
            'view_file' => 'user/viewProfile',
            'script_file' => 'user/viewProfile_script'
        );

        $this->load->view('templates/template', $view_arr);
    }
}

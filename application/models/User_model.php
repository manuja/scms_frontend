
<?php

/**
 * Class : User_model
 * Access user data from database 
 * @author : test / test
 * @version : 1.0
 * @since : 31.03.2018
 */
class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    public function getUserIdByUserTableId($usr_tbl_id)
    {

        if ($usr_tbl_id) {

            $sql = "SELECT user_id FROM member_profile_data WHERE user_tbl_id = " . $usr_tbl_id;

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {

                return $query->row()->user_id;
            } else {
                return 0;
            }
        } else {

            return 0;
        }
    }

    //Retrive user information using his email 
    public function get_user_by_email($email)
    {

        $row = $this->db->query("SELECT * FROM users WHERE email ='" . $email . "'")->row();
        return $row;
    }

    //Retrive the groups of given user
    public function get_user_groups($user_id)
    {

        $query = $this->db->query("SELECT g.name,g.id FROM users_groups ug INNER JOIN groups g ON ug.group_id=g.id WHERE ug.user_id= " . $user_id);
        return $query->result_array();
    }

    //Retrive all users
    public function get_users()
    {

        $query = $this->db->query('SELECT id,first_name,last_name FROM users WHERE active=1');
        return $query->result_array();
    }

    //Get the user group ids
    public function get_user_group_ids($user_id)
    {

        //   $query = $this->db->query("SELECT ug.group_id,g.name FROM users_groups ug INNER JOIN groups g ON ug.group_id=g.id WHERE ug.user_id= " . $user_id . "");
        $query = $this->db->query("SELECT ug.group_id,g.name FROM users_groups ug INNER JOIN `groups` g ON ug.group_id=g.id WHERE ug.user_id= " . $user_id . " AND ug.status != 6");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function get_perms_of_group($ids)
    {
        $ids = join(', ', $ids);

        $query = $this->db->query(" SELECT name
                                FROM   permissions 
                                WHERE  parent_id IN (SELECT ag.perm_id 
                                FROM   permissions_groups ag 
                                       INNER JOIN permissions ap 
                                               ON ag.perm_id = ap.id 
                                WHERE  ag.group_id IN ($ids) 
                                       AND ap.parent_id = 0)");

        //return $query->result_array();
        return $query;
    }

    public function getUsersByGroupId($group_id)
    {

        $this->db->select('B.id,
	        B.username');
        $this->db->from('users_groups AS A');
        $this->db->join('users AS B', 'B.id = A.user_id');
        $this->db->where('group_id', $group_id);
        $this->db->where('B.active=1');
        $query = $this->db->get();
        $result = false;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

    public function getGroupsNotInCurrentGroups($user_id)
    {

        $query = $this->db->query("SELECT id,name FROM groups WHERE id NOT IN(SELECT group_id FROM users_groups WHERE user_id=" . $user_id . ")");
        return $query->result_array();
    }

    public function get_user_related_permissions($userid)
    {

        $this->db->from('user_permissions');
        $this->db->where('user_id', $userid);
        $query = $this->db->get();

        $result = FALSE;
        if (!empty($query)) {
            $result = $query->result();
        }
        return $result;
    }

    //Get login details of user
    public function get_user($id)
    {

        if ($id) {
            $row = $this->db->get_where('users', array('id' => $id))->row();
            return $row;
        } else {
            return FALSE;
        }
    }

    //Get profile details of user
    public function get_user_profile($id)
    {

        if ($id) {
            $row = $this->db->get_where('user_profile', array('user_id' => $id))->row();
            return $row;
        } else {
            return FALSE;
        }
    }


    /**
     * 
     * @param type $user_id
     * Purpose: check if user has agreed the terms and conditions
     * if agree -> proceed
     * if not agree, logout
     */
    public function checkUserAgreement($user_id)
    {
        $this->db->reset_query();
        $this->db->select('user_agreement_read');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();

        if ($query->result()[0]->user_agreement_read != '1') {
            // offer terms and conditions
            return false;
        } else {
            return true;
        }
    }

    public function agreeTerms($user_id)
    {
        $this->db->reset_query();
        $this->db->set('user_agreement_read', 1);
        $this->db->where('id', $user_id);
        $this->db->update('users');

        return true;
    }

    public function newPasswordSet($user_id)
    {
        $this->db->reset_query();
        $this->db->set('first_login', 1);
        $this->db->where('id', $user_id);
        $this->db->update('users');

        return true;
    }

    public function isFirstLogin($user_id)
    {
        $this->db->reset_query();
        $this->db->select('first_login');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();

        if ($query->result()[0]->first_login == '0') {
            // offer password reset
            return true;
        } else {
            return false;
        }
    }

    public function getIdentity($user_id)
    {
        $this->db->reset_query();
        $this->db->select('username');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();

        if ($query->result()[0]->username) {
            // offer password reset
            return $query->result()[0]->username;
        } else {
            return false;
        }
    }

    public function update_sub_groups()
    {

        $g_id = $this->input->post('hidden_id');
        $description = $this->input->post('description');
        $subs_group = $this->input->post('subs_group');
        $data = array(
            'name' => $subs_group,
            'description' => $description
        );
        $this->db->where('id', $g_id);
        $req = $this->db->update('groups', $data);
        return $req;
    }



    public function userLog($data)
    {
        $saveData = array(
            'user_id' => $data['user_id'],
            'username' => $data['username'],
            'login_ip' => $data['ip']
        );

        $this->db->insert('user_log', $saveData);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function userAccountDeactivated($user_id)
    {
        $sql = "UPDATE `users` SET `username` = concat(`username`,'_REJECTED') , `email`=concat(`email`,'_REJECTED'),`active`=2 WHERE `id` =$user_id";
        $result = $this->db->query($sql);

        return  $result;
    }

    //Get basic information of user
    public function get_user_basic_info($userId)
    {
        $this->db->select('*');
        $this->db->from('user_profile');
        // $this->db->join('master_divisions','master_divisions.division_id = user_profile.division','left');
        $this->db->where('user_id', $userId);
        $this->db->where('user_profile.status', 1);
        $query = $this->db->get();

        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
    public function get_user_basic_info_user($userId)
    {
        $this->db->select('*');
        $this->db->from('users');
        // $this->db->join('master_divisions','master_divisions.division_id = user_profile.division','left');
        $this->db->where('id', $userId);
        $this->db->where('users.active', 1);
        $query = $this->db->get();

        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function userActivation($data)
    {

        $this->db->trans_begin();

        // $group_count = $data['gr_sts'];

        // print_r($data);
        // die();

        if ($data['user_status'] == 2 || $data['user_status'] == 3 ||  $data['user_status'] == 6 || $data['user_status'] == 7) {


            $this->db->set('active', $data['user_status']);
            $this->db->where('id', $data['user_id']);
            $this->db->update('users');

            if ($data['status_comment'] != "") {


                $sql = "insert into status_comment  (user_id,comment,created_at) values (?,?,NOW())";
                $this->db->query($sql, array($data['user_id'], $data['status_comment']));
            }

            if( $data['user_status'] == 7){

                $user_id = $this->session->userdata('user_id');

                $payment_type = 1;

                $sql2 = "insert into payment  (user_id,year,amount,payment_slip,payment_type,payment_comment,payment_createdby) values (?,?,?,?,?,?,?)";
              $res = $this->db->query($sql2, array($data['user_id'], $data['payment_year'],$data['payment_amount'],$data['payment_slip'],$payment_type,$data['payment_comment'],$user_id));

            }


        }  else {

    

            $this->db->set('active', $data['user_status']);
            $this->db->where('id', $data['user_id']);
            $this->db->update('users');
            $this->db->reset_query();


            if ($data['status_comment'] != "") {


                $sql = "insert into status_comment  (user_id,comment,created_at) values (?,?,NOW())";
                $this->db->query($sql, array($data['user_id'], $data['status_comment']));
            }

            if( $data['payment_status'] == 1){

                $user_id = $this->session->userdata('user_id');

                $payment_type = 2;

                $sql2 = "insert into payment  (user_id,year,amount,payment_slip,payment_type,payment_comment,payment_createdby) values (?,?,?,?,?,?,?)";
              $res = $this->db->query($sql2, array($data['user_id'], $data['payment_year'],$data['payment_amount'],$data['payment_slip'],$payment_type,$data['payment_comment'],$user_id));

            }


            $user = $data['user_id'];
          

            $query = $this->db->query("select * from users_groups  where user_id = $user ");
            $data_arr =  $query->result_array();
    

          if( $data['update_type'] != 0 &&  count($data_arr) == 0 ){

            $this->db->set('group_id', $data['user_group']);
            $this->db->set('status', $data['user_status']);
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('users_groups');
            if (!$this->db->affected_rows()) {
                $group_data = array(
                    'user_id' => $data['user_id'],
                    'group_id' => $data['user_group'],
                    'status' => $data['user_status'],
                );
                $this->db->insert('users_groups', $group_data);
            }

        }


        }

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
          return FALSE;
        } else {
            $this->db->trans_commit();
           return true;
        }
    }

    public function getstatuscomment($userid)
    {


        $query = $this->db->query("select * from status_comment  where user_id = $userid order by id desc limit 1");

        return $query->result_array();
    }

    public function getpayment_details($userid)
    {


        $query = $this->db->query("select * from payment  where user_id = $userid order by id DESC");

        return $query->result_array();
    }

    public function getuserststua($id){

        $result = array();

        $sq1 = "select active from users  where id = ?";
        $data =  $this->db->query($sq1, $id)->result_array();

        return $data;

    }

    public function getuseremails($data)
    {

        $this->db->trans_start();


        $count = count($data);

        $result = array();

        $sq2 = "select username,id from users  where id = ?";



        for ($x = 0; $x < $count; $x++) {


            $data[$x] =  $this->db->query($sq2, array($data[$x]))->result_array();

            $result = array_merge($result, $data[$x]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return $result;
        }

    }

    public function saveemaillog($data){


       
        $this->db->trans_start();


        $count = count($data);

        $result = array();

 
        $sql1 = "insert into email_notification  (user_id,notification_id,email,status,created_at) values (?,?,?,?,NOW())";



        for ($x = 0; $x < $count; $x++) {


          $this->db->query($sql1, array($data[$x]['user_id'],$data[$x]['noti_id'],$data[$x]['email_add'],$data[$x]['status']));

          
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
          return false;
        } else {
            $this->db->trans_commit();
          return true;
        }



        
    }


}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Side bar -  Generate the side navigation
 *
 * @author sam
 */
class Side_bar_m extends CI_Model {

    public function createUserMenuss()
    {

//        $user_id = '7';
        $user_id = $this->session->user_id;
//        print_r($this->session);
//        exit;
        $permissions = $this->get_parent_menu($user_id);


//        echo '<pre>';
//        print_r($permissions);
//        exit;

        $parent_items = array();
        $sub_items = array();
        foreach ($permissions as $m1)
        {
            if ($m1['menu_level'] == 1) {
                $parent_items[$m1['permission_id']] = $m1;
            }
        }


//        GROUP SUB MENU ITEMS BY PARENT MENU ITEM
        foreach ($permissions as $m2)
        {
            if ($m2['menu_level'] == '2') {
                $sub_items[$m2['permission_parent_id']][$m2['menu_id']] = $m2;
            }
        }
// echo '<pre>';
//print_r($sub_items);
//exit;
        foreach ($parent_items as $kp1 => $p1)
        {
            if (!empty($sub_items[$p1['permission_parent_id']])) {
                $parent_items[$kp1]['sub_items'] = $sub_items[$p1['permission_parent_id']];
            }
        }

//    echo '<pre>';
//print_r($parent_items);
//exit;
        return $parent_items;
    }

    public function get_user_enabled_menu($user_id)
    {

        $this->db->select('user_permissions.perm_id');
        $this->db->from('user_permissions');
        $this->db->where('user_permissions.user_id', $user_id);

        $query = $this->db->get();
//         log_message('errorasdasdasd', $this->db->last_query());

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row;
        }
    }

    public function get_parent_menu($user_id)
    {

        $this->db->select('system_menu.menu_title,
        system_menu.menu_icon,
        system_menu.menu_path,
        system_menu.menu_parent,
        system_menu.row_order,
        system_menu.status,
        system_menu.permission_parent_id,
        system_menu.permission_id,
        system_menu.permission_child_id,
        system_menu.permission_grand_child_id,
        system_menu.menu_level,
        system_menu.menu_id,
        system_menu.created_date');
        $this->db->from('system_menu');
        $this->db->join('user_permissions', 'system_menu.permission_parent_id = user_permissions.perm_id', 'inner');
        $this->db->where('user_permissions.user_id', $user_id);
        $this->db->order_by('system_menu.row_order desc');
        $this->db->where('system_menu.status', '1');

        $query = $this->db->get();
//        print_r($this->db->last_query());
//        exit;
        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row;
        }
    }

    public function createUserMenu()
    {


        $user_id = $this->session->user_id;

        $permissions = $this->userpermission->getUserPermissionsIDsFromDb($user_id);
        $perm_ids = implode(', ', $permissions);
//      print_r($permissions);
    //  print_r($perm_ids);
    //  exit;
        //parent ID's
        if($permissions){
        $query1 = $this->db->query("SELECT system_menu.menu_title,
        system_menu.menu_id,
        system_menu.menu_level,
        system_menu.menu_icon,
        system_menu.menu_path,
        system_menu.permission_id,
        system_menu.menu_parent,
        system_menu.row_order FROM system_menu WHERE system_menu.menu_id IN (SELECT
        system_menu.menu_parent
        FROM
        system_menu
        WHERE
        system_menu.permission_id IN ($perm_ids)) AND
        system_menu.status = 1");
        $main_menu = $query1->result_array();
        
        $query2 = $this->db->query("SELECT
            system_menu.menu_title,
            system_menu.menu_id,
            system_menu.menu_parent,
            system_menu.menu_level,
            system_menu.menu_icon,
            system_menu.menu_path,
            system_menu.permission_id,
            system_menu.row_order
            FROM
            system_menu
            WHERE
            system_menu.permission_id IN ($perm_ids) AND
            system_menu.status = 1");
        $sub_menu = $query2->result_array();

   

        $all_menu_items = array_merge($main_menu, $sub_menu);
      
        usort($all_menu_items, function($a, $b) {
            return $a['row_order'] <=> $b['row_order'];
        });


        $parent_items = array();
        $sub_items = array();
        foreach ($all_menu_items as $m1)
        {
            if ($m1['menu_parent'] == 0) {
                $parent_items[$m1['menu_id']] = $m1;
            }
        }
        
        foreach ($all_menu_items as $m2)
        {
            if ($m2['menu_parent'] != 0) {
                $sub_items[$m2['menu_parent']][$m2['menu_id']] = $m2;
            }
        }
// echo '<pre>';
//        print_r($sub_items);
//        exit;
        foreach ($parent_items as $kp1 => $p1)
        {
            if (!empty($sub_items[$p1['menu_id']])) {
                $parent_items[$kp1]['sub_items'] = $sub_items[$p1['menu_id']];
            }
        }

    //    echo '<pre>';
    //    print_r($parent_items);
    //    exit;
        return $parent_items;
        }else{
            return null;
        }
    }

    public function get_group_id_menu($user_id)
    {

        $this->db->select('users_groups.group_id');
        $this->db->from('users_groups');
        $this->db->where('users_groups.user_id', $user_id);
//        $this->db->where('users_groups.user_id', $user_id);
        $this->db->where('users_groups.status', '1');

        $query = $this->db->get();
//        print_r($this->db->last_query());
//        exit;
        if ($query->num_rows() > 0) {
            $row = $query->row_array();

            return $array = array_shift($row);
        } else {
            redirect('login');
        }
    }

    /////////////////////////////////////
}

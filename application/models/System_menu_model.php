<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class System_menu_model extends CI_Model {

    public function get_parent_menu($seleted_val = '') {

        $this->db->select(array('A.id', 'A.name'));
        $this->db->from('system_permissions AS A');
//        $this->db->join('groups', 'groups ON groups.id = gsub.parent_id', 'inner');
        $this->db->where('A.parent_id', '0');
        $this->db->order_by("A.id", "asc");
        $d = $this->db->get();

        if ($d) {
            $data = array();
            $data['0'] = "Select Group";
            foreach ($d->result() as $row) {
// Add array keys to the array while looping...
                $data[$row->id] = $row->name;
            }

            return $data;
        } else {
            return FALSE;
        }
    }

    public function get_child_menu($parent_id, $seleted_val = '') {

        $this->db->select(array('A.id', 'A.name'));
        $this->db->from('system_permissions AS A');
        $this->db->where('A.level', '2');
        $this->db->where('A.parent_id', $parent_id);
        $this->db->order_by("A.name", "asc");
        $d = $this->db->get();
//        print_r($this->db->last_query());
//        exit;
        if ($d) {
            $data = $d->result();
            return $data;
        } else {
            return FALSE;
        }
    }

//    public function get_grand_child_menu($child_id, $seleted_val = '') {
//
//        $this->db->select(array('A.id', 'A.name'));
//        $this->db->from('system_permissions AS A');
//        $this->db->where('A.level' . '=' . '3');
//        $this->db->where('A.parent_id', $child_id);
//        $this->db->order_by("A.name", "asc");
//        $d = $this->db->get();
////        print_r($this->db->last_query());
////        exit;
//        if ($d) {
//            $data = $d->result();
//
//            return $data;
//        } else {
//            return FALSE;
//        }
////        print_r($this->db->last_query());
////        exit;
//    }

    public function sub_category_drop_down($main_category = '') {

        $this->db->select(array('actionp_sub_category.sub_category_id', 'actionp_sub_category.sub_category', 'actionp_sub_category.actionp_main_category_id'));
        $this->db->from('actionp_sub_category');
        $this->db->where('actionp_sub_category.actionp_main_category_id', $main_category);

        $this->db->order_by("actionp_sub_category.sub_category_id", "asc");
        $d = $this->db->get();
//        print_r($this->db->last_query());
//        exit;
        if ($d) {
            $data = $d->result();

            return $data;
        } else {
            return FALSE;
        }
    }

    public function system_menu_save() {
//        print_r($_POST);
//        exit;
//        $group_id = $this->input->post('group_id');
        $menu_title = $this->input->post('menu_title');
        $menu_icon = $this->input->post('menu_icon');
//        $menu_level = $this->input->post('menu_level');
        $menu_url = $this->input->post('menu_url');
        $parent_menu = $this->input->post('parent_menu');
        $menu_order = $this->input->post('menu_order');
        $child_menu = $this->input->post('child_menu');
//        $grand_child = $this->input->post('grand_child');
        $parent = $this->input->post('menu_id');
//        $group_id = $this->input->post('group_id');
//        $this->db->trans_start();
        $date_stamp = mdate('%Y-%m-%d');
        $time_stamp = mdate('%H:%i:%s');
        if ($parent) {
            $menu_level = 2;
        } else {
            $menu_level = 1;
        }

        if ($menu_level == '1') {
            $child_menu = 0;
            $meu_parent = 0;
            $perm_id = 0;
            $parent_menu = 0;
        } else if ($menu_level == '2') {
            $parent_menu = $parent_menu;
            $perm_id = $child_menu;
            $meu_parent = $parent;
        }
//        echo $perm_id;
//        exit;
        $data = array(
            'menu_level' => $menu_level,
            'menu_title' => $menu_title,
            'menu_icon' => $menu_icon,
            'menu_path' => $menu_url,
            'permission_id' => $perm_id,
            'row_order' => $menu_order,
            'permission_parent_id' => $parent_menu,
            'permission_child_id' => $child_menu,
//            'permission_grand_child_id' => $grand_child,
            'menu_parent' => $meu_parent,
            'created_date' => $date_stamp,
            'status' => '1'
        );

        $flag = $this->db->insert('system_menu', $data);
//       echo $this->db->_error_message();
//       exit;
//        print_r($this->db->last_query());
////        print_r($flag);
//        exit;
//        $system_menu_id = $this->db->insert_id();

        if ($flag) {
            return $flag;
        } else {
//            $ret['ErrorMessage'] = $this->db->_error_message();
//            print_r($flag);
//            exit;
            return FALSE;
        }
// END INSERT FUNC
    }

    public function grid_view_for_system_menu() {

        $this->db->select('system_menu.menu_level,
system_menu.menu_title,
system_menu.menu_icon,
system_menu.menu_id,
system_menu.permission_id,
system_menu.menu_parent,
system_menu.row_order,
system_menu.`status`,
system_menu.permission_parent_id,
system_menu.permission_child_id,
system_menu.permission_grand_child_id,
system_menu.created_date,
system_menu.menu_path');
        $this->db->from('system_menu');
        $this->db->where('system_menu.status', '1');
        $this->db->where('system_menu.menu_level', '1');
        $query = $this->db->get();
//                        print_r($this->db->last_query());
//        exit;
        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row;
        } else {
//            redirect('signin');
            return FALSE;
        }
    }

    public function edit_grand_child_m() {
//        print_r($_POST);
        $gchild = $this->input->post('grand_child_val');
        $this->db->select('system_menu.menu_id,
system_menu.menu_level,
system_menu.menu_title,
system_menu.menu_icon,
system_menu.menu_path,
system_menu.permission_id,
system_menu.menu_parent,
system_menu.row_order,
system_menu.menu_id,
system_menu.`status`,
system_menu.permission_parent_id,
system_menu.permission_child_id,
system_menu.permission_grand_child_id,
system_menu.created_date');
        $this->db->where('system_menu.menu_id', $gchild);
        $grand = $this->db->get('system_menu');
//                print_r($this->db->last_query());
//        exit;
        $grand_childs = $grand->row();
        return $grand_childs;
    }

    public function system_menu_update() {
//        print_r($_POST);
//        exit;
//        $menu_title = $this->input->post('menu_title');
//        $menu_icon = $this->input->post('menu_icon');
        $menu_level_original = $this->input->post('menu_level');
//        $menu_url = $this->input->post('menu_url');
//        $parent_menu = $this->input->post('parent_menu');
//        $menu_order = $this->input->post('menu_order');
//        $child_menu = $this->input->post('child_menu');
//        $grand_child = $this->input->post('grand_child');
//        $menu_id = $this->input->post('menu_id');
//        $this->db->trans_start();
        $menu_title = $this->input->post('menu_title');
        $menu_icon = $this->input->post('menu_icon');
        $menu_parent_hdn = $this->input->post('menu_parent_hdn');
        $menu_url = $this->input->post('menu_url');
        $parent_menu = $this->input->post('parent_menu');
        $menu_order = $this->input->post('menu_order');
        $child_menu = $this->input->post('child_menu');
//        $grand_child = $this->input->post('grand_child');
        $parent = $this->input->post('menu_id');
//        $group_id = $this->input->post('group_id');
//        $this->db->trans_start();
        $date_stamp = mdate('%Y-%m-%d');
        $time_stamp = mdate('%H:%i:%s');
        if ($parent) {
            $menu_level = 2;
        } else {
            $menu_level = 1;
        }

        if ($menu_level == '1') {
            $child_menu = 0;
            $meu_parent = 0;
            $perm_id = 0;
            $parent_menu = 0;
        } else if ($menu_level == '2') {
            $parent_menu = $parent_menu;
            $perm_id = $child_menu;
            $meu_parent = $menu_parent_hdn;
        }
//        echo $perm_id;
//        exit;
        $data = array(
            'menu_level' => $menu_level_original,
            'menu_title' => $menu_title,
            'menu_icon' => $menu_icon,
            'menu_path' => $menu_url,
            'permission_id' => $perm_id,
            'row_order' => $menu_order,
            'permission_parent_id' => $parent_menu,
            'permission_child_id' => $child_menu,
//            'permission_grand_child_id' => $grand_child,
            'menu_parent' => $meu_parent,
            'created_date' => $date_stamp,
            'status' => '1'
        );


//        $flag = $this->db->insert('project_job_order', $data);
        $this->db->where('menu_id', $parent);
        $flag = $this->db->update('system_menu', $data);
        print_r($this->db->last_query());
        exit;
        if ($flag) {
            return $flag;
        } else {
            return false;
        }
    }

    public function delete_system_menu() {

        $menu_id = $this->input->post('dchild_delete');
        $this->db->where('menu_id', (int) $menu_id);
        $flag = $this->db->delete('system_menu');
        if ($flag) {

            $this->db->where('menu_parent', (int) $menu_id);
            $flags = $this->db->delete('system_menu');
        }
//        $this->db->set('status', -1);
//        $this->db->where('menu_id', (int) $menu_id);
//        $flag = $this->db->update('system_menu');
//        print_r($this->db->last_query());
//        exit;
        if ($flag) {
            return $flag;
        } else {
            return FALSE;
        }
    }

}

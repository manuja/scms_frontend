<?php


class User_permissions_new_modal extends CI_Model {

    public function get_system_users()
    {

        $this->db->select(array('users.id',
            'users.first_name',
            'users.last_name'));
        $this->db->from('users');
        $this->db->order_by("users.id", "desc");
        $this->db->where('users.active', 1);
        $d = $this->db->get();
//        print_r($this->db->last_query());
//        exit;
        if ($d) {
            $data = array();
            $data[''] = "Select User";
            foreach ($d->result() as $row)
            {

// Add array keys to the array while looping...
                $data[$row->id] = $row->first_name . '&nbsp;' . $row->last_name;
            }


            return $data;
        } else {
            return FALSE;
        }
    }

    //Draw the full tree of permissions
    public function get_js_tree()
    {
        $user_id = $this->input->post('user_id');
//        $group_permissions = $this->get_group_permissions($user_id);
//        $user_permissions = $this->get_user_permissions($user_id);

        $result = $this->getPermisstions();




        $parent_id = array();
//        print_r($result);
//        exit;
//if ($group_permissions[$keys]->perm_id == $result[$keys]->id) {
        foreach ($result as $row)
        {
//            echo $result[$keys]->id;
            $sub_data["id"] = $row->id;
            $sub_data["text"] = $row->name;
            $group_available = $this->check_value_is_in_group_permissions($user_id, $row->id);
            $user_available = $this->get_user_permissions($user_id, $row->id);
//           echo $abc;
//           exit;
//            echo '<br';
//			 $sub_data["name"] = $row->name;

            if ($user_available == 1 && $group_available == 1) {
                $disabled = true;
                $selected = true;
            } elseif ($user_available == 1 && $group_available == 0) {
                $disabled = false;
                $selected = true;
            } elseif ($user_available == 0 && $group_available == 1) {
                $disabled = true;
                $selected = true;
            } elseif ($user_available == 0 && $group_available == 0) {
                $disabled = false;
                $selected = false;
            }

            $sub_data["state"] = ['selected' => $selected, 'disabled' => $disabled];

            array_push($parent_id, $row->parent_id);

//            $sub_data["parent_id"] = $row->parent_id;
            $data[] = $sub_data;
        }

//        $new_data = $this->sanitize($data);
        foreach ($data as $key => &$value)
        {
            $output[$value["id"]] = &$value;
        }

        $i = 0;

        foreach ($data as $key => &$value)
        {
            if ($parent_id[$i] && isset($output[$parent_id[$i]])) {
                $output[$parent_id[$i]]["children"][] = &$value;
            }
            $i++;
        }

        $k = 0;
        foreach ($data as $key => &$value)
        {
            if ($parent_id[$k] && isset($output[$parent_id[$k]])) {
                unset($data[$key]);
            }
            $k++;
        }
//        echo '<pre>';
//        print_r($new_data);
//                        exit;
        echo json_encode($data);
    }

    //Get all permissions
    public function getPermisstions()
    {

        $query = $this->db->query("SELECT * FROM system_permissions ORDER BY level");

        return $query->result();
    }

    public function get_group_permissions($user_id)
    {

        $this->db->select('group_permissions.perm_id');
        $this->db->join('users_groups', 'users_groups.group_id = group_permissions.group_id', 'inner');
        $this->db->where('users_groups.user_id', $user_id);
        $group_data = $this->db->get('group_permissions');
        $group_permissions = $group_data->result();

        return $group_permissions;
//        print_r($letter_row);
    }

    public function get_user_permissions($user_id, $perm_id)
    {
        $this->db->select('user_permissions.perm_id');
        $this->db->where('user_permissions.user_id', $user_id);
        $this->db->where('user_permissions.perm_id', $perm_id);
        $user_data = $this->db->get('user_permissions');
        $user_permissions = $user_data->num_rows();
//        print_r($this->db->last_query());
//       exit;
        return $user_permissions;
//        print_r($letter_row);
    }

    public function check_value_is_in_group_permissions($user_id, $perm_id)
    {

        $this->db->select('group_permissions.perm_id');
        $this->db->join('users_groups', 'users_groups.group_id = group_permissions.group_id', 'inner');
        $this->db->where('group_permissions.perm_id', $perm_id);
        $this->db->where('users_groups.user_id', $user_id);

        $user_data = $this->db->get('group_permissions');
        $group_permissions = $user_data->num_rows();
        return $group_permissions;
//        print_r($letter_row);
    }

    //checks is there a specific value in full array
    public function sanitize($arr)
    {
        if (is_array($arr)) {
            $out = array();
            foreach ($arr as $key => $val)
            {
                if ($key != 'parent_id') {
                    $out[$key] = $this->sanitize($val);
                }
            }
        } else {
            return $arr;
        }
        return $out;
//        print_r($out);
//        exit;
    }

    public function save_user_permissions()
    {
//echo '<pre>';
//        print_r($_POST);
//        exit;
        $date_stamp = mdate('%Y-%m-%d');
        $year = mdate('%Y');
        $time_stamp = mdate('%H:%i:%s');


        $checked_ids = $this->input->post('checkedNodes');
        $user_id = $this->input->post('user_id');

        $this->db->where('user_id', $user_id);
        $this->db->delete('user_permissions');

//            print_r($this->db->last_query());
//            exit;
        $permissions_batch = array();
//        foreach ($group_admins as $key => $admins)

        foreach ($checked_ids as $value)
        {
//            echo $admins;assigned_mem_id
            $mtng["user_id"] = $user_id;
            $mtng["perm_id"] = $value;
            $permissions_batch[] = $mtng;
        }


        if (!empty($permissions_batch)) {




            $flag = $this->db->insert_batch('user_permissions', $permissions_batch);


            $date_stamp = mdate('%Y-%m-%d');
            $time_stamp = mdate('%H:%i:%s');
            $updated_by = $this->session->userdata('user_id');
//        $this->db->trans_start();
            $data = array(
                'updated_user' => $updated_by,
                'userId_or_groupId' => $user_id,
                'perm_type' => 1,
                'updated_date' => $date_stamp,
                'updated_time' => $time_stamp,
                'status' => '1'
            );

            $this->db->insert('permission_history', $data);

//                        print_r($this->db->last_query());
//            exit;
            return $flag;
        }
    }

}

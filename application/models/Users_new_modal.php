<?php


class Users_new_modal extends CI_Model {

    public function system_users_view()
    {
        $group_id = $this->input->post_get('group_id');
        $search_txt = '';
        $this->db->select('users.id');
        $this->db->from('users');
        $this->db->join('users_groups', 'users_groups.user_id = users.id', 'left');
        $this->db->join('groups', 'users_groups.group_id = groups.id', 'left');
        $this->db->join('groups AS parents', 'parents.id = groups.parent_id', 'left');
        $this->db->where('users.active !=', '-1');
        $this->db->where('users_groups.`status`', 1);
        if ($group_id) {

            $this->db->where('users_groups.group_id', $group_id);
        }

        if (!empty($search['value'])) {
            $this->db->group_start();
            $this->db->like('first_name', $search['value'], 'both');
            $this->db->or_like('last_name', $search['value'], 'both');
            $this->db->or_like('email', $search['value'], 'both');
            $this->db->group_end();
        }

//        $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
//        if (!empty($limit)) {
//            $this->db->limit($limit, $start);
//        }

        $result = FALSE;

        $totalData = $this->db->count_all_results();
//                    print_r($this->db->last_query());
//                    exit;
        $totalFiltered = $totalData;
        $data_result = array();
        $q = '';
        if (!empty($totalData)) {

            $columns = array(
// datatable column index  => database column name
                'id',
                'first_name',
                'last_name',
                'email',
                'active',
                'group_name'
            );
// filter
            $search = $this->input->post_get('search');
            $order = $this->input->post_get('order');
            $start = $this->input->post_get('start');
            $limit = $this->input->post_get('length');

//            print_r($limit) ;
//exit;
            $this->db->select(implode(",", array('users.first_name,
            users.last_name,
            users.email,
            users.active,
            CONCAT(groups.`name`, " -> ", parents.`name`) AS group_name,
            users.id')), false);
            $this->db->from('users');
            $this->db->join('users_groups', 'users_groups.user_id = users.id', 'left');
            $this->db->join('groups', 'users_groups.group_id = groups.id', 'left');
            $this->db->join('groups AS parents', 'parents.id = groups.parent_id', 'left');
            $this->db->where('users.active !=', '-1');
            $this->db->where('users_groups.`status`', 1);
            if ($group_id) {

                $this->db->where('users_groups.group_id', $group_id);
            }


// if there is a search parameter, ['search']['value'] contains search parameter
            if (!empty($search['value'])) {
                $this->db->group_start();
                $this->db->like('first_name', $search['value'], 'both');
                $this->db->or_like('last_name', $search['value'], 'both');
                $this->db->or_like('email', $search['value'], 'both');
                $this->db->group_end();
            }

            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
            if (!empty($limit)) {
                $this->db->limit($limit, $start);
            }
            $query = $this->db->get();
//                        print_r($this->db->last_query());
//                        exit;
            if (empty($query)) {
                return false;
            } else {
                $data_result = $query->result();
            }
            if (!empty($search['value'])) {
                $totalFiltered = $query->num_rows();
            }
        }


//        print_r(intval($totalFiltered));
//        exit;
//        echo '<br>';


        $json_data = array(
            "draw" => intval($this->input->post_get('draw')), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data_result, // total data array
//            "excel_filters" => base64_encode($excel_param)
        );
        return $json_data;
    }

}

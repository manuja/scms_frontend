<?php

class Permissions_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    // Retrieve all records from the permissions table
    public function get_permissions()
    {
        $query = $this->db->query('SELECT * from system_permissions');

        return $query->result();
    }

    // Retrieve all records only from the parent permissions table
    public function get_parent_permissions()
    {
        $query = $this->db->query('SELECT * from system_permissions WHERE parent_id=0');

        return $query->result();
    }

    // Retrieve all records only from the child permissions table
    public function get_child_permissions()
    {
        $query = $this->db->query('SELECT * from system_permissions WHERE parent_id > 0 AND level=2');

        return $query->result();
    }

    //Check weather sequence is already taken
    public function isSequenceTaken($sequence)
    {

        $query = $this->db->query("SELECT id FROM system_permissions WHERE sequence<10000 AND sequence= " . $sequence);

        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Update all after updating specific sequence
    public function updateAllAfterGivenSequence($sequence)
    {
        $sql = "UPDATE system_permissions SET sequence=sequence+1 WHERE sequence> " . $sequence;
        if ($this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Delete all grand childs
    public function deleteAllGrandChilds($id)
    {

        if ($id) {

            $this->db->where('parent_id', $id);
            if ($this->db->delete('system_permissions')) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    //Delete child
    public function deleteChilds($id)
    {

        if ($id) {

            $this->db->where('id', $id);
            if ($this->db->delete('system_permissions')) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    //Delete parent
    public function deleteParent($id)
    {

        if ($id) {

            $this->db->where('id', $id);
            if ($this->db->delete('system_permissions')) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getChildsOfGivenParent($id)
    {

        if ($id) {

            $this->db->where('parent_id', $id);
            $query = $this->db->get('system_permissions');

            if ($query->num_rows() > 0) {

                return $query->result_array();
            } else {
                return array();
            }
        } else {

            return array();
        }
    }

    public function edit_child_perm()
    {

        $child_perm = $this->input->post('child_perm');
        $hidden_child = $this->input->post('hidden_child');
        $data = array(
            'name' => $child_perm
        );
        $this->db->where('id', $hidden_child);
        $req = $this->db->update('system_permissions', $data);
        return $req;
    }

    public function edit_grand_perm()
    {

        $grand_perm = $this->input->post('grand_perm');
        $hidden_grand = $this->input->post('hidden_grand');
        $data = array(
            'name' => $grand_perm
        );
        $this->db->where('id', $hidden_grand);
        $req = $this->db->update('system_permissions', $data);
//        print_r($this->db->last_query());
//        exit;
        return $req;
    }

}

<?php

	/**
	 * Class : User_group_model
	 * Access user group data from database 
	 * @author : Chameera Nuwan / chameera.se@gmail.com
	 * @version : 1.0
	 * @since : 31.03.2018
	 */
	

	class User_group_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		//Get all permissions
		public function getPermisstions(){

			$query=$this->db->query("SELECT * FROM system_permissions ORDER BY level");

			return $query->result();
		}

		//Retrive all parent groups
		public function get_parent_groups(){

			$query = $this->db->query('SELECT * FROM groups WHERE is_admin != 1 AND parent_id=0');
			return $query->result_array();
		}

		// Retrieve all groups
		public function get_groups()
		{
			$query = $this->db->query('SELECT g.name AS gname,g.id AS group_id,p.name AS parent FROM groups g LEFT JOIN groups p ON g.parent_id=p.id WHERE g.is_admin !=1');
			return $query->result_array();
		}

		// Retrieve groups without member
		public function get_groups_without_member()
		{
			$query = $this->db->query("SELECT g.name AS gname,g.id AS group_id,p.name AS parent FROM groups g INNER JOIN groups p ON g.parent_id=p.id WHERE p.name !='Member'");
			return $query->result_array();
		}

		//Get user group with parent group
		public function get_user_group($user_id){
			$query = $this->db->query("SELECT g.name AS gname,g.id AS group_id,p.name AS parent FROM groups g LEFT JOIN groups p ON g.parent_id=p.id LEFT JOIN users_groups ug on g.id=ug.group_id WHERE ug.user_id= ".$user_id);
			return $query->result_array();
		}

		public function getUserGroupId($id){

			if($id){

				$sql="SELECT group_id FROM users_groups WHERE user_id= ".$id;

				$query=$this->db->query($sql);
				if($query->num_rows() > 0){

					return $query->row()->group_id;
				}else{

					return 0;
				}
			}else{

				return 0;
			}
		}

		//Get all group permissions 
		public function getUserGroupPermissions($group_id) {
	        $this->db->select('perm_id');
	        $this->db->from('group_permissions AS A');
	        $this->db->where('group_id', $group_id);
	        $query = $this->db->get();
//                print_r($this->db->last_query());
//                exit;
	        $result = FALSE;
	        if (!empty($query)) {
	            $result = $query->result();
	        }
	        return $result;
    	}

    	public function getAllUsersGroups()
    	{
    		$query = $this->db->get('users_groups');
    		return $query->result();
    	}

	}
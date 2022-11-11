<?php
	
	class User_permissions_model extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		//Get user specific permission
		public function get_user_permissions($userID){
			echo "User ID";
			print_r($userID);
			exit;

			if(!empty($userID)){
				$result=$this->db->query("SELECT sp.id AS perm_id,sp.name,sp.permission_code AS perm_code FROM user_permissions up INNER JOIN system_permissions sp ON up.perm_id=sp.id WHERE up.user_id= '.$userID.'")->result_array();
																																													
				return $result;
			}else{
				return FALSE;
			}
		}

		public function get_group_permissions($groupID){

			if($groupID){

				$sql="SELECT * FROM group_permissions WHERE group_id= '.$groupID[0].'";

				$query=$this->db->query($sql);

				if($query->num_rows() >0){

					return $query->result_array();
				}else{

					return array();
				}

			}else{

				return array();
			}

		}
	}
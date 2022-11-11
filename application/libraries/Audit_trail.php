<?php

/*
 * Creted by test
 * Date : 2021-04-21
 * RDA Audit trail
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_trail
{
    private $CI;

    public function __construct(){

        $this->CI =& get_instance();
        $this->CI->load->database();

    }
    
    public function saveAuditData($table_name,$perm_code,$user_id){
        $perm_id = $this->getPermissionIDbyCode($perm_code);
        $ip = $_SERVER['REMOTE_ADDR'];
        $port = $_SERVER['SERVER_PORT'];
        $data_arr = array(
            'user_id'=>$user_id,
            'permission_id'=>$perm_id,
            'ip_address'=>$ip,
            'traffic_port'=>$port
        );
        $this->CI->db->insert($table_name,$data_arr);
        if($this->CI->db->insert_id()){
            return true;
        }else{
            return false;
        }
    }
    
    public function getPermissionIDbyCode($perm_code){
        $this->CI->db->select('id');
        $this->CI->db->from('system_permissions');
        $this->CI->db->where('permission_code',$perm_code);
        $result = $this->CI->db->get()->row();
        if($result){
            return $result->id;
        }else{
            return 0;
        }
    }
}
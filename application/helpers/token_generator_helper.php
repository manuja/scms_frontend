<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Net beans.
 * User: test
 * Date: 4/23/2018
 * Time: 12:43 PM
 */

/**
 * @return 
 * Purpose: get api key
 */

function get_api_key($purpose_id) {
    $CI = & get_instance();
    $CI->load->database();
    $CI->db->select('api_key.ip_address,
api_key.purpose,
api_key.date');
    $CI->db->from('api_key');
//    $CI->db->join('sub_payment_related_tax', 'sub_payment_related_tax.sub_payment_category_id = master_sub_payment_categories.sub_payment_category_id', 'left');
    $CI->db->where('api_key.purpose_id', $purpose_id);
    $result = $CI->db->get()->row();
    $ip_address = $result->ip_address;
    $purpose = $result->purpose;
    $date = $result->date;
    $api_key = $ip_address . '_' . $purpose . '_' . $date;
    $encripted_api_key = md5($api_key);
    return $encripted_api_key;
}

function generate_token() {
    
    $CI = & get_instance();
    $CI->load->database();
  $api_key =  get_api_key('1');
    $ipaddress = get_real_IP_address();
    $current_date = mdate('%Y-%m-%d');
    $current_time = mdate('%H-%i-%s');
    $exp_time = '900';
    //$input= INSERT INTO access_token('id', 'api_key', 'token', 'exp_time', 'status') VALUES ([value-1],[value-2],[value-3],[value-4],[value-5]);
    $token = $ipaddress . '_' . $current_date . '_' . $current_time . '_' . $exp_time;
    $encripted_token = md5($token);


    $data1 = array(
        'api_key' => $api_key,
        'token' => $encripted_token,
        'exp_time' => $exp_time,
        'status' => 1
    );

    $flag = $CI->db->insert('access_token', $data1);
    if($flag){
       $keys = array($encripted_token, $api_key); 
       return $keys;
    }
}

function getVerificationCode() {
    //get ipaddress for user
    //$ipaddress = $this->get_real_IP_address();
    //set your ipaddress if try to use in localhost
    $ipaddress = "123.231.12.160"; // set local server IP
    //$ipaddress = "123.231.12.160"; // localy
    //get time stamp need to add 5.30 hours to globel time
    $diiferance = 5 * 3600 + 30 * 60;
    $time = time() + $diiferance;

    // if email addres null need to set email address as example@ex.exp
    //if(strlen($emailaddress)==0)
    //{
    $emailaddress = "2018_";
    //}
    //create basic stucture and encode value for verification code
    $variables = $ipaddress . ':' . $emailaddress . ':' . $time;
    $encodval = base64_encode($variables);

    //need to set secret value in here
    //This secrect value need to set from some globele value such as parms
    //intially secet valu use as 0;
    $secretval = '0';
    //$verificode = JWebservice::encription($encodval, $secretval) . ":" . $encodval;
    $verificode = encription($encodval, $secretval) . ":" . $encodval;
    //echo $verificode;
    //exit;

    return $verificode;
}

function get_real_IP_address() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {//check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){//to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function encription($inputval, $secretval) {

    $base64val = base64_encode($inputval);
    $decodeval = base64_decode($inputval);
    $sha1encval = $base64val . $decodeval;

    $wordcount = strlen($sha1encval);
    // suffel the each pair of string
    $t = strlen($sha1encval) % 2;
    for ($i = 0; $i < strlen($sha1encval); $i++) {
        if ($i % 2 == 0) {
            if ($t == 0) {
                $shuf[$i + 1] = substr($sha1encval, $i, 1);
            } else if ($t == 1) {

                if ($i + 1 < strlen($sha1encval)) {

                    $shuf[$i + 1] = substr($sha1encval, $i, 1);
                }
                if ($i + 1 == strlen($sha1encval)) {

                    $shuf[$i] = substr($sha1encval, $i, 1);
                }
            }
        } else if ($i % 2 == 1) {

            $shuf[$i - 1] = substr($sha1encval, $i, 1);
        }
    }

    $returnval = '';
    for ($j = 0; $j < count($shuf); $j++) {
        $returnval = $returnval . $shuf[$j];
    }
    //        $returnval;
    return md5($returnval . $secretval);
}



//ADDED ON 15.09.2018 -  COMMON API VERIFICATION FUNCTION 
function apiVerification($api, $token, $date) {
    $CI = & get_instance();
    $CI->load->database();
       
        $request_time = date('Y-m-d H:i:s', $date);
        $today = date("Y-m-d H:i:s");

        $time1 = new DateTime($request_time);
        $time2 = new DateTime($today);


        $CI->db->select('access_token.api_key,
        access_token.token,
        access_token.exp_time,
        access_token.id');
        $CI->db->from('access_token');
        $CI->db->where('access_token.status', '1');
        $CI->db->where('access_token.api_key', $token);
        $CI->db->where('access_token.token', $api);

        $data_result = $CI->db->get();

        $aa = $data_result->row();
        $time_in_sec = $aa->exp_time;

        $interval = $time2->getTimestamp() - $time1->getTimestamp();

        if ($interval <= $time_in_sec) {

            return true;
        } else {
            return false;
        }
    }






//   public function insert_access_token() {
//
//        //$created_datetime = date('Y-m-d h:i:s');
//        $data1 = array(
//        'token_id' =>,
//        'access_token' => '',
//        );
//        $flag = $this->db->insert('access_token', $data1);
//        return $insert_id = $this->db->insert_id();
//    }


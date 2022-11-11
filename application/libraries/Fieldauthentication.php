<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 4/20/2018
 * Time: 10:08 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

Class Fieldauthentication{
    public function __construct(){

    }

    /**
     * @param $swissNumberStr
     * @return bool (validity of input)
     */
    public function authenticateTelephone($phoneNumber){
        // https://github.com/giggsey/libphonenumber-for-php

        // Phone number validation - start
//        $phoneNumberStr = "+94 074 28 96 548";
        $phoneNumberStr = $phoneNumber;

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $phoneNumberStr = $phoneUtil->parse($phoneNumberStr, "CH");
//            echo "<pre>";
//            var_dump($phoneNumberStr);
//            echo "</pre>";
        } catch (\libphonenumber\NumberParseException $e) {
//            var_dump($e);
        }

        $isValid = $phoneUtil->isValidNumber($phoneNumberStr);
//        var_dump($isValid); // true

        // Produces "+41446681800"
//        echo $phoneUtil->format($phoneNumberStr, \libphonenumber\PhoneNumberFormat::E164).'<br>';

        // Produces "044 668 18 00"
//        echo $phoneUtil->format($phoneNumberStr, \libphonenumber\PhoneNumberFormat::NATIONAL).'<br>';

        // Produces "+41 44 668 18 00"
//        echo $phoneUtil->format($phoneNumberStr, \libphonenumber\PhoneNumberFormat::INTERNATIONAL).'<br>';

        return $isValid;
    }

    public function authenticateEmail($emailAddress){
        $pattern = '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
        return (preg_match($pattern, $emailAddress) === 1) ? true : false;
    }

    public function authenticateNic($nic){
        $pattern1 = '/([0-9]{12})/';
        $pattern2 = '/([0-9]{9})(V|v|X|x)/';
        if((preg_match($pattern1, $nic) === 1 && strlen($nic) == 12) || (preg_match($pattern2, $nic) === 1 && strlen($nic) == 10)){
            return true;
        }else{
            return false;
        }
    }

    public function uniqueEmail($emailAddress, $user_id){
        $CI =& get_instance();

        $CI->load->database();

        $CI->db->select('id, email');
        $CI->db->from('users');
        $CI->db->where('active', 1);
        $CI->db->where('email', $emailAddress);

        $query = $CI->db->get();
        $result = $query->result();

        if(sizeof($result)>0){
            if($user_id != false) {
                if ($result[0]->id == $user_id) { // to allow owner of this email to use same email address

                    $ret = array('status' => true, 'email' => '');
                    return $ret;
                } else {
                    $ret = array('status' => false, 'email' => $result[0]->email);
                    return $ret;
                }
            }else{ // for first time registrations
                $ret = array('status' => false, 'email' => $result[0]->email);
                return $ret;
            }
        }else{
            $ret = array( 'status' => true, 'email' => '' );
            return $ret;
        }

    }

    public function uniqueNic($nic, $user_id){
        $CI =& get_instance();

        $CI->load->database();

        $CI->db->select('user_tbl_id, user_nic, user_id');
        $CI->db->from('user_registrations');
        $CI->db->where('user_nic', $nic);

        $query = $CI->db->get();
        $result = $query->result();

        if(sizeof($result)>0){
            if($user_id != false) {
                if ($result[0]->user_id == $user_id) { // to allow owner of this nic to use same nic
                    $ret = array('status' => true, 'nic' => '');
                    return $ret;
                } else {

                    $ret = array('status' => false, 'nic' => $result[0]->user_nic);
                    return $ret;
                }
            } else{
                $ret = array('status' => false, 'nic' => $result[0]->user_nic);
                return $ret;
            }
        }else{
            $ret = array( 'status' => true, 'nic' => '');
            return $ret;
        }
    }
}
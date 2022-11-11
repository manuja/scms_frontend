<?php
/**
 * Created by PhpStorm.
 * User: ba
 * Date: 5/25/18
 * Time: 1:07 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Email_lib {
    public function __construct(){

    }


    function sendEmail($sendingAddress, $receiverAddress, $mailSubject, $mailBody){

        
        $CI =& get_instance();
        $sendingAddressnew = 'dev@test.lk';
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.test.lk',
            'smtp_port' => 587,
            'smtp_user' => 'dev@test.lk', // change it to yours
            'smtp_pass' => '~J-jztux@,Bm', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $CI->load->library('email', $config);
        $CI->email->set_header('MIME-Version', '1.0; charset=utf-8'); //must add this line
        $CI->email->set_header('Content-type', 'text/html');
        $CI->email->set_newline("\r\n");
        $CI->email->from($sendingAddressnew); // change it to yours
        $CI->email->to($receiverAddress);// change it to yours
        $CI->email->subject($mailSubject);
        $CI->email->message($mailBody);
        

        //$CI->email->send();
        if( $CI->email->send() )
        {
           $CI->email->clear();

           return true; //echo 'Email sent.';
        }
        else
        {
           show_error($CI->email->print_debugger());
           $CI->email->clear();
           return false;
            
        }

       
    }

    // function sendbulkEmail($sendingAddress, $receiverAddress, $mailSubject, $mailBody){
    //     // error_reporting(0);
    //     $CI =& get_instance();

       

    //     $config = Array(
    //         'protocol' => 'smtp',
    //         'smtp_host' => 'ssl://smtp.googlemail.com',
    //         'smtp_port' => 465,
    //         'smtp_user' => 'testl.pipl@gmail.com', // change it to yours
    //         'smtp_pass' => 'test@1991', // change it to yours
    //         'mailtype' => 'html',
    //         'charset' => 'iso-8859-1',
    //         'wordwrap' => TRUE
    //     );

    //     $count = 0;

    //     $email_count = count($receiverAddress);
    //     $CI->load->library('email', $config);

    //     for ($x = 0; $x < $email_count; $x++) {
    //         print($receiverAddress[$x]['username']);
                     
    //         $CI->email->set_newline("\r\n");
    //         $CI->email->from($sendingAddress); // change it to yours
    //         $CI->email->to($receiverAddress[$x]['username']);// change it to yours
    //         $CI->email->subject($mailSubject);
    //         $CI->email->message($mailBody);
            
    //         if( $CI->email->send() )
    //         {
    //            //return true; //echo 'Email sent.';
    //            $count = $count + 1;
    //         }else{
    //             $count = $count ;
    //         }
            
    //     }

    //     // if( $count ==  $email_count ){
    //     //     return true;
    //     //     }else{
    //     //     return false;
    //     //     }
    // }


}
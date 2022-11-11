<?php

 /*
    @Ujitha Sudasingha
    2022-11-04
     Verify the token and token mgt
    */

class Verify_token extends CI_Controller {

    public function __construct() {


        parent::__construct();
//        $this->load->database();
        $this->load->helper('token_generator');
//        echo 'dfsfsdf';
//        exit;
    }

    public function index() {


//        $dataService = $this->qb_support->quick_book_receipt_create('1', 'test', '1000', '1', 'books', '100', '10', '20', '92');
        $dataService = generate_token();
        echo'<pre>';
        print_r($dataService);
        exit;
    }

    public function get_api_key($api_key) {

        $dataService = generate_token($api_key);
        echo json_encode($dataService);
    }

    public function verify_generated_token_get() {
        $dataService = getVerificationCode();
        
        echo'<pre>';
        print_r($dataService);
        exit;
    }

}

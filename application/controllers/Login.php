<?php
	
	 /*
    @Ujitha Sudasingha
    2022-11-04
    Login controller for the system users
    */

	class Login extends CI_Controller{


		public function __construct(){
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->library('form_validation');
		}

		public function index(){
			$this->isLoggedIn();
		}

		 /**
	     * This function used to check the user is logged in or not
	     */
	    public function isLoggedIn(){
	        $isLoggedIn = $this->session->userdata('isLoggedIn');
	        
	        if(!isset($isLoggedIn) || $isLoggedIn != TRUE){
	            $this->load->view('authentication/login');
	        }
	        else{
	            //redirect('/dashboard');
	            echo 'Logged';
	        }
	    }

		/**
	     * This function used to logged in user
	    */
		public function loginMe(){
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        	$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        
	        if($this->form_validation->run() == FALSE)
	        {
	            $this->index();
	        }else{
	        	$email = $this->security->xss_clean($this->input->post('email'));
            	$password = $this->input->post('password');

            	echo $email;
	        }
		}

	}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->library(array('session', 'Userpermission'));
        }
        
        public function show_application_instructions(){
            $data['pagetitle'] = 'Application Instructions';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );

            $this->load->view('member/templates/header', $data);
            $this->load->view('member/templates/topmenu');
            $this->load->view('member/templates/sidebar');
            $this->load->view('public/application_instructions', $data);
            $this->load->view('member/templates/footer', $data);
            $this->load->view('member/templates/close');
        }
        public function show_supportive_documents(){
            $data['pagetitle'] = 'Application Instructions';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );

            $this->load->view('member/templates/header', $data);
            $this->load->view('member/templates/topmenu');
            $this->load->view('member/templates/sidebar');
            $this->load->view('public/supportive_documents', $data);
            $this->load->view('member/templates/footer', $data);
            $this->load->view('member/templates/close');
        }
        public function show_contact_member_division(){
            $data['pagetitle'] = 'Application Instructions';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );

            $this->load->view('member/templates/header', $data);
            $this->load->view('member/templates/topmenu');
            $this->load->view('member/templates/sidebar');
            $this->load->view('public/contact_member_division', $data);
            $this->load->view('member/templates/footer', $data);
            $this->load->view('member/templates/close');
        }
        public function show_contact_member_division_tempusers(){
            $data['pagetitle'] = 'Application Instructions';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );
            $page = $this->session->userdata('page');
            $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
            $this->breadcrumb->add('Contact test', site_url());
            $data['breadcrumbs']=$this->breadcrumb->render();
            $data['dashboard_url'] = site_url('dashboard/'.$page);


            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar');
            $this->load->view('public/contact_member_division2');
            $this->load->view('templates/footer', $data);
            $this->load->view('templates/close');
        }
        
        public function show_member_payments(){
            $membershipClasses = array(1,2,3,6,7);
            $payableInfo = getSubPaymentDetails(1, 1);
            if($payableInfo){
                if($payableInfo->is_tax_enable == "1"){
                    $totalPayable = $payableInfo->amount_with_tax;
                }else{
                    $totalPayable = $payableInfo->amount;
                }
                $data['studentFee'] = $totalPayable;
            }else{
                $data['studentFee'] = 'N/A';
            }
            
            
            $payableInfo = getSubPaymentDetails(2, 1);
            if($payableInfo){
                if($payableInfo->is_tax_enable == "1"){
                    $totalPayable = $payableInfo->amount_with_tax;
                }else{
                    $totalPayable = $payableInfo->amount;
                }
                $data['conpanionFee'] = $totalPayable;
            }else{
                $data['conpanionFee'] = 'N/A';
            }
            
            
            $payableInfo = getSubPaymentDetails(3, 1);
            if($payableInfo){
                if($payableInfo->is_tax_enable == "1"){
                    $totalPayable = $payableInfo->amount_with_tax;
                }else{
                    $totalPayable = $payableInfo->amount;
                }
                $data['associateFee'] = $totalPayable;
            }else{
                $data['associateFee'] = 'N/A';
            }
            
            
            $payableInfo = getSubPaymentDetails(6, 1);
            if($payableInfo){
                if($payableInfo->is_tax_enable == "1"){
                    $totalPayable = $payableInfo->amount_with_tax;
                }else{
                    $totalPayable = $payableInfo->amount;
                }
                $data['amieFee'] = $totalPayable;
            }else{
                $data['amieFee'] = 'N/A';
            }
            
            
            $payableInfo = getSubPaymentDetails(7, 1);
            if($payableInfo){
                if($payableInfo->is_tax_enable == "1"){
                    $totalPayable = $payableInfo->amount_with_tax;
                }else{
                    $totalPayable = $payableInfo->amount;
                }
                $data['afimieFee'] = $totalPayable;
            }else{
                $data['afimieFee'] = 'N/A';
            }
            
            
            $data['pagetitle'] = 'Application Instructions';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );

            $this->load->view('member/templates/header', $data);
            $this->load->view('member/templates/topmenu');
            $this->load->view('member/templates/sidebar');
            $this->load->view('public/member_payments', $data);
            $this->load->view('member/templates/footer', $data);
            $this->load->view('member/templates/close');
        }
        
        
        public function show_help_nr(){
            $data['pagetitle'] = 'User Guide';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );

            $this->load->view('member/templates/header', $data);
            $this->load->view('member/templates/topmenu');
            $this->load->view('member/templates/sidebar');
            $this->load->view('public/help_nr', $data);
            $this->load->view('member/templates/footer', $data);
            $this->load->view('member/templates/close');
        }
        public function show_help_dr(){
            $data['pagetitle'] = 'User Guide';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );

            $this->load->view('member/templates/header', $data);
            $this->load->view('member/templates/topmenu');
            $this->load->view('member/templates/sidebar-dr');
            $this->load->view('public/help_dr', $data);
            $this->load->view('member/templates/footer', $data);
            $this->load->view('member/templates/close');
        }
        public function show_help_to(){
            $data['pagetitle'] = 'User Guide';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );

            $this->load->view('member/templates/header', $data);
            $this->load->view('member/templates/topmenu');
            $this->load->view('member/templates/sidebar-to');
            $this->load->view('public/help_to', $data);
            $this->load->view('member/templates/footer', $data);
            $this->load->view('member/templates/close');
        }
        

        /**
         * Purpose: Reroute users to "page under construction" view
         */
        public function show_underConstruction()
	{
            $this->userpermission->show_underConstruction();
	}
        
        
        
        // beta testing urls redirect - temp
        public function member_feedback(){
//            redirect("https://goo.gl/forms/3zFhIAlMlih9lEhp1");
            echo '<script>window.open("https://goo.gl/forms/3zFhIAlMlih9lEhp1","_blank");</script>';
            echo '<script>window.history.back();</script>';
        }
        public function staff_feedback(){
//            redirect("https://goo.gl/forms/Dz7h6yjrscw9pnBi1");
            echo '<script>window.open("https://goo.gl/forms/Dz7h6yjrscw9pnBi1","_blank");</script>';
            echo '<script>window.history.back();</script>';
        }
        public function report_bug(){
//            redirect("https://goo.gl/forms/LoDOb9q2UiDr7d8S2");
            
            echo '<script>window.open("https://goo.gl/forms/LoDOb9q2UiDr7d8S2","_blank");</script>';
            echo '<script>window.history.back();</script>';
            
        }
        
         public function show_eligibility_criteria(){
            $data['pagetitle'] = 'Application Instructions';
            $data['stylesheetes'] = array(
            );
            $data['scripts'] = array(
            );

            $this->load->view('member/templates/header', $data);
            $this->load->view('member/templates/topmenu');
            $this->load->view('member/templates/sidebar');
            $this->load->view('public/non_recognized_instructions', $data);
            $this->load->view('member/templates/footer', $data);
            $this->load->view('member/templates/close');
        }
        
        
}

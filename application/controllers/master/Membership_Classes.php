<?php

    date_default_timezone_set('Asia/Colombo');

    class Membership_Classes extends CI_Controller{

        // Contructor
        public function __construct()
        {
            parent::__construct();
            $this->load->helper(array('url','form'));
            $this->load->library(array('form_validation', 'session'));
            $this->load->model('master/Membership_Classes_model', 'this_model');
        }

        // get table data form the model and returns as json format
        public function getTableData()
        {
            echo json_encode($this->this_model->getTableData());
        }

        // Load the class of membership view
        public function index()
        {
            $data['pagetitle'] = "test MIS - Classes of Membership";

            // $data['membership_class'] = $this->this_model->getTableRawData();

            $page = $this->session->userdata('page');
            $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
            $this->breadcrumb->add('Class of Membership', site_url());
            $data['breadcrumbs']=$this->breadcrumb->render();
            // $data['dashboard_url'] = site_url('dashboard/'.$page);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar', $data);
            $this->load->view('employee/membership_classes', $data);
            $this->load->view('templates/footer');
            $this->load->view('employee/membership_classes_script');
            $this->load->view('templates/close');
        }

        // Validate the input data and feed the post data to model for create a new class of membership
        public function create()
        {
            $this->form_validation->set_rules('code', 'Code', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('short', 'Short Name', 'required');
            $this->form_validation->set_rules('title', 'Class Title', 'required');
            $this->form_validation->set_rules('is_membership_class', 'Is Class of Membership', 'required');
            $this->form_validation->set_rules('description', 'Description', '');

            if($this->form_validation->run() == FALSE){
                $this->index();
            } else{
                $postData = $this->input->post();

                $data = array(
                    'class_of_membership_code' => $postData['code'],
                    'class_of_membership_name' => $postData['name'],
                    'class_of_membership_name_short' => $postData['short'],
                    'member_class_title' => $postData['title'],
                    'is_class_of_membership' => $postData['is_membership_class'],
                    'description' => $postData['description'],
                    'state' => 1
                );

                $jobState = $this->this_model->setNewMembershipClass($data);

                if($jobState == NULL){
                    $msg = 'New class of membership have not been created successfully.';
                } else{
                    $msg = 'A new Membership class have been created successfully.';
                }

                $this->session->set_flashdata('msg', $msg);
                redirect('master/Membership_Classes/index', 'refresh');
            }
        }

        // update the existing data of class of membership
        public function update()
        {
            $postData = $this->input->post();

            $data = array(
                'class_of_membership_id' => $postData['class_of_membership_id'],
                'class_of_membership_code' => $postData['new_code'],
                'class_of_membership_name' => $postData['new_name'],
                'class_of_membership_name_short' => $postData['new_short'],
                'member_class_title' => $postData['new_title'],
                'is_class_of_membership' => $postData['new_is_class_of_membership'],
                'description' => $postData['new_description']
            );

            $this->this_model->updateMemberClass($data);
            $this->session->set_flashdata('msg', 'A Membership class has been updated successfully');
            redirect('master/Membership_Classes/index', 'refresh');
        }

        // set a membership class as deleted
        public function delete()
        {
            $membershipClassId = $this->input->post('class_of_membership_id');

            $this->this_model->setMembershipClassAsDeleted($membershipClassId);
            $this->session->set_flashdata('msg', 'A Membership class has been deleted successfully');
            redirect('master/Membership_Classes/index', 'refresh');
        }
    }

?>
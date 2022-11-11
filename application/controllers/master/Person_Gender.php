<?php
    date_default_timezone_get('Asia/Colombo');

    /**
     * Date : 20/11/2018
     * Time : 9:30 AM
     */
    class Person_Gender extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->helper(array('url','form'));
            $this->load->library(array('form_validation', 'session'));
            $this->load->model('master/Person_Gender_model','this_model');
        }

        // get table data form the model and returns as json format
        public function getTableData()
        {
            echo json_encode($this->this_model->getTableData());
        }

        // Load the person gender view
        public function index()
        {
            $data['pagetitle'] = "test MIS - Person Gender";
            $page = $this->session->userdata('page');
            $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
            $this->breadcrumb->add('Person Gender', site_url());
            $data['breadcrumbs']=$this->breadcrumb->render();

            // $data['personGenders'] = $this->this_model->getTableData();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar', $data);
            $this->load->view('employee/person_gender', $data);
            $this->load->view('templates/footer');
            $this->load->view('employee/person_gender_script', $data);
            $this->load->view('templates/close');
        }

        // create a new person gender
        public function create(){
            $this->form_validation->set_rules('person_gender', 'Person Gender', 'required');

            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            } else{
                $gender = $this->input->post('person_gender');

                $data = array(
                    'person_gender' => $gender
                );
                
                $this->this_model->setNewPersonGender($data);
                $this->session->set_flashdata('msg', 'A new gender has been added successfully');

                redirect('master/Person_Gender/index', 'refresh');
            }
        }

        // update a person gender
        public function update(){
            $genderId = $this->input->post('person_gender_id');
            $gender = $this->input->post('new_gender');

            $this->this_model->updatePersonGender($genderId, $gender);

            $this->session->set_flashdata('msg', 'A person gender has been successfully updated');

            redirect('master/Person_Gender/index', 'refresh');
        }

        // delete a gender
        public function delete(){
            $genderId = $this->input->post('person_gender_id');

            $jobState = $this->this_model->deletePersonGender($genderId);

            if($jobState == TRUE){
                $msg = 'A gender has been deleted successfully.';
            } else{
                $msg = 'Delete process not successfully completed.';
            }
            
            $this->session->set_flashdata('msg', $msg);
            redirect('master/Person_Gender/index', 'refresh');
        }
    }
?>
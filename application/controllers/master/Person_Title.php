<?php
    date_default_timezone_get('Asia/Colombo');

    /**
     * Date : 20/11/2018
     * Time : 10:22 AM
     */
    class Person_Title extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            // $this->load->helper(array('url','form'));
            $this->load->library(array('form_validation', 'session'));
            $this->load->model('master/Person_Title_model','this_model');
        }

        // get table data form the model and returns as json format
        public function getTableData()
        {
            echo json_encode($this->this_model->getTableData());
        }

        // Load the person title view
        public function index()
        {
            $data['pagetitle'] = "test MIS - Person Title";
            $page = $this->session->userdata('page');
            $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
            $this->breadcrumb->add('Person Title', site_url());
            $data['breadcrumbs']=$this->breadcrumb->render();

            // $data['personTitles'] = $this->this_model->getTableData();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar', $data);
            $this->load->view('employee/person_title', $data);
            $this->load->view('templates/footer');
            $this->load->view('employee/person_title_script');
            $this->load->view('templates/close');
        }

        // create a new person title
        public function create(){
            $this->form_validation->set_rules('person_title', 'Person Title', 'required');

            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            } else{
                $title = $this->input->post('person_title');

                $data = array(
                    'person_title' => $title,
                    'state' => 1
                );
                
                $jobState = $this->this_model->setNewPersonTitle($data);

                if($jobState == FALSE){
                    $msg = 'Title you entered already exists';
                }
                else {
                    $msg = 'A new title has been added successfully';
                }

                $this->session->set_flashdata('msg', $msg);
                redirect('master/Person_Title/index', 'refresh');
            }
        }

        // update a person title
        public function update(){
            $postTemp =$this->input->post();

            $data = array(
                'person_title_id' => $postTemp['person_title_id'],
                'person_title' => $postTemp['new_title'],
                'updated_datetime' => date('Y-m-d H:i:s')
            );

            $this->this_model->updatePersonTitle($data);

            $this->session->set_flashdata('msg', 'A person title has been successfully updated');

            redirect('master/Person_Title/index', 'refresh');
        }

        // delete a title
        public function delete(){
            $titleId = $this->input->post('person_title_id');

            $jobState = $this->this_model->setPersonTitleAsDeleted($titleId);

            if($jobState == TRUE){
                $msg = 'A title has been deleted successfully.';
            } else{
                $msg = 'Delete process not successfully completed.';
            }
            
            $this->session->set_flashdata('msg', $msg);
            redirect('master/Person_Title/index', 'refresh');
        }
    }
?>
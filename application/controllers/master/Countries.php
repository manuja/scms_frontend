<?php
    date_default_timezone_get('Asia/Colombo');

    class Countries extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->helper(array('url','form'));
            $this->load->library(array('form_validation', 'session'));
            $this->load->model('master/Countries_model','this_model');
        }

        public function getTableData()
        {
            echo json_encode($this->this_model->getTableData());
        }

        // Load the countries views
        public function index()
        {
            $data['pagetitle'] = "test MIS - Countries";
            $page = $this->session->userdata('page');
            $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
            $this->breadcrumb->add('Countries', site_url());
            $data['breadcrumbs']=$this->breadcrumb->render();

            // $data['countries'] = $this->this_model->getTableData();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar', $data);
            $this->load->view('employee/countries', $data);
            $this->load->view('templates/footer');
            $this->load->view('employee/countries_script');
            $this->load->view('templates/close');
        }

        // create a new country
        public function create(){
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('short_code', 'Short Code', 'required');

            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            } else{
                $tempData = $this->input->post();

                $data = array(
                    'country_name' => $tempData['country'],
                    'country_short_code' => $tempData['short_code'],
                    'status' => 1
                );
                $this->this_model->setNewCountry($data);

                $this->session->set_flashdata('msg', 'A new country has been added successfully');
                redirect('master/countries/index', 'refresh');
            }
        }

        // update a country
        public function update(){
            $tempData = $this->input->post();

            $data = array(
                'country_id' => $tempData['country_id'],
                'country_name' => $tempData['new_country'],
                'country_short_code' => $tempData['new_short_code']
            );

            $this->this_model->updateCountry($data);

            $this->session->set_flashdata('msg', 'A country has been updated successfully');
            redirect('master/countries/index', 'refresh');
        }

        // delete a country
        public function delete(){
            $countryId = $this->input->post('country_id');

            $this->this_model->setCountryAsDeleted($countryId);

            $this->session->set_flashdata('msg', 'A country has been deleted successfully');
            redirect('master/countries/index', 'refresh');
        }
    }
?>
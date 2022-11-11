<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_survey_inputs extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/survey_inputs_model');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Online Survey Inputs";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Survey Inputs', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
        
		//$data['inputs'] = $this->survey_inputs_model->showDetails();
		
        $this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/survey_inputs', $data);
		$this->load->view('templates/footer');
		$this->load->view('employee/survey_inputs_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->survey_inputs_model->showDetails()));
}

	public function create(){
		$this->form_validation->set_rules('input_type', 'Survey Input Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$postInput = $this->input->post();

			$data = array(
				'form_input_type' => $postInput['input_type'],
				'state' => 1
			);
			
			$this->survey_inputs_model->create($data);
			
			$this->session->set_flashdata('msg', 'A new survey input has been added successfully');
			redirect('master/Class_of_survey_inputs/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'online_survey_form_input_id' => $postInput['online_survey_form_input_id'],
			'form_input_type' => $postInput['new_input_type'],
			'state' => 1
		);
		$this->survey_inputs_model->update($data);
		$this->session->set_flashdata('msg', 'Survey input has been updated successfully');
		redirect('master/Class_of_survey_inputs/index', 'refresh');
	}

	public function delete(){
		$online_survey_form_input_id = $this->input->post('online_survey_form_input_id');
		$this->survey_inputs_model->delete($online_survey_form_input_id);
		$this->session->set_flashdata('msg', 'Survey input has been deleted successfully');
		redirect('master/Class_of_survey_inputs/index', 'refresh');
	}
}

?>
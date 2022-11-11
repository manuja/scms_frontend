<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_Resource_Person_Preferences extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/Resource_Person_Preferences_model');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Resource Person Preferences";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Resource Person Preferences', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/Resource_Person_Preferences');
		$this->load->view('templates/footer');
		$this->load->view('employee/Resource_Person_Preferences_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->Resource_Person_Preferences_model->showDetails()));
	}

	public function create(){
		$this->form_validation->set_rules('name','Resource Person Preferences Name', 'required');
		$this->form_validation->set_rules('code','Color Code', 'required');
		$this->form_validation->set_rules('hourrate','Per hour rate', 'required');
		$this->form_validation->set_rules('sessionrate','Per session rate', 'required');
		$this->form_validation->set_rules('dayrate','Per day rate', 'required');
		$this->form_validation->set_rules('maxrate','Max amount per month', 'required');

		if($this->form_validation->run() == FALSE){

			$this->session->set_flashdata('msg', 'New Resource Person Preferences has not been added successfully');
			$this->index();
		} else{

			$postInput = $this->input->post();

			$data = array(
				'resource_person_preference_name' => $postInput['name'],
				'color_code' => $postInput['code'],
				'default_per_hour_rate' => $postInput['hourrate'],
				'default_per_session_rate' => $postInput['sessionrate'],
				'default_per_day_rate' => $postInput['dayrate'],
				'max_amount_per_month' => $postInput['maxrate'],
				'state' => 1
			);
			$this->Resource_Person_Preferences_model->create($data);

			$this->session->set_flashdata('msg', 'A Resource Person Preferences have been added successfully');
			redirect('master/Class_of_Resource_Person_Preferences/index', 'refresh');
		}

	}

	public function update(){

		$postInput = $this->input->post();
		$data = array(
			'resource_person_preference_id' => $postInput['resource_person_preference_id'],
			'resource_person_preference_name' => $postInput['new_name'],
			'color_code' => $postInput['new_code'],
			'default_per_hour_rate' => $postInput['new_hourrate'],
			'default_per_session_rate' => $postInput['new_sessionrate'],
			'default_per_day_rate' => $postInput['new_dayrate'],
			'max_amount_per_month' => $postInput['new_maxrate'],
			'state' => 1
		);

		$this->Resource_Person_Preferences_model->update($data);
		$this->session->set_flashdata('msg', 'Resource Person Preferences have been updated successfully');
		redirect('master/Class_of_Resource_Person_Preferences/index', 'refresh');
	}

	public function delete(){
		$resource_person_preference_id = $this->input->post('resource_person_preference_id');
		$this->Resource_Person_Preferences_model->delete($resource_person_preference_id);
		$this->session->set_flashdata('msg', 'Resource Person Preferences have been deleted successfully');
		redirect('master/Class_of_Resource_Person_Preferences/index', 'refresh');
	}
}

?>
<?php 
date_default_timezone_set('Asia/Colombo');

class Class_SurveyTypes extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/SurveyTypesModel');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Survey Types";
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Survey Types',  site_url());
    	$data['breadcrumbs']=$this->breadcrumb->render();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/SurveyTypes');
		$this->load->view('templates/footer');
		$this->load->view('employee/SurveyTypes_script');
		$this->load->view('templates/close');
	}

	public function showListOfRegistrations(){
		print_r(json_encode($this->SurveyTypesModel->showListOfRegistrations()));
	}

	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		} else {
			$postInput = $this->input->post();

			$data = array(
				'online_survey_type' => $postInput['name'],
				'state' => 1
			);
			
			$this->SurveyTypesModel->create($data);
			$this->session->set_flashdata('msg', 'A new online survey type has been added successfully');
			redirect('master/Class_SurveyTypes/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'online_survey_type_id' => $postInput['online_survey_type_id'],
			'online_survey_type' => $postInput['new_name'],
			'state' => 1
		);
		$this->SurveyTypesModel->update($data);
		$this->session->set_flashdata('msg', 'An online survey type has been updated successfully');
		redirect('master/Class_SurveyTypes/index', 'refresh');
	}

	public function delete(){
		$online_survey_type_id = $this->input->post('online_survey_type_id');
		$this->SurveyTypesModel->delete($online_survey_type_id);
		$this->session->set_flashdata('msg', 'An online survey type has been deleted successfully');
		redirect('master/Class_SurveyTypes/index', 'refresh');
	}
}

?>
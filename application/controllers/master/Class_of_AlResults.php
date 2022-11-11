<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_AlResults extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/AlResults_model');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - AL Results";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('AL Results',  site_url());
		$data['breadcrumbs']=$this->breadcrumb->render();
		
		// $data['al_result'] = $this->AlResults_model->showListOfRegistrations();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/Al_Results');
		$this->load->view('templates/footer');
		$this->load->view('employee/Al_Results_script');
		$this->load->view('templates/close');
	}

	public function showListOfRegistrations(){
			print_r(json_encode($this->AlResults_model->showListOfRegistrations()));
	}

	public function create(){
		$this->form_validation->set_rules('short', 'Short', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('Category', 'Category', 'required');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		} else{
			$postInput = $this->input->post();

			$data = array(
				'master_al_results_code' => $postInput['short'],
				'master_al_results_name' => $postInput['name'],
				'category' => $postInput['Category'],
				'state' => 1
			);
			
			$this->AlResults_model->create($data);
			
			$this->session->set_flashdata('msg', 'A new AL result code has been added successfully');
			redirect('master/Class_of_AlResults/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'master_al_results_id' => $postInput['master_al_results_id'],
			'master_al_results_code' => $postInput['new_code'],
			'master_al_results_name' => $postInput['new_name'],
			'category' => $postInput['new_category'],
			'state' => 1
		);
		$this->AlResults_model->update($data);
		$this->session->set_flashdata('msg', 'AL results code has been updated successfully');
		redirect('master/Class_of_AlResults/index', 'refresh');
	}

	public function delete(){
		$master_al_results_id = $this->input->post('master_al_results_id');
		$this->AlResults_model->delete($master_al_results_id);
		$this->session->set_flashdata('msg', 'AL results code has been deleted successfully');
		redirect('master/Class_of_AlResults/index', 'refresh');
	}
}

?>
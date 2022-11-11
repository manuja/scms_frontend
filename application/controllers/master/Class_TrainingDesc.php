<?php 
date_default_timezone_set('Asia/Colombo');

class Class_TrainingDesc extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/TrainingDescModel');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Training Org. Descipline";
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Training Org. Descipline',  site_url());
    	$data['breadcrumbs']=$this->breadcrumb->render();
		// $inpdata = $this->TrainingDescModel->showListOfRegistrations();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/TrainingDesc');
		$this->load->view('templates/footer');
		$this->load->view('employee/TrainingDesc_script');
		$this->load->view('templates/close');
	}

	public function showListOfRegistrations(){
		print_r(json_encode($this->TrainingDescModel->showListOfRegistrations()));
	}

	public function create(){
		$this->form_validation->set_rules('short','Core ID', 'required');
		$this->form_validation->set_rules('name','Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		} else{
			$postInput = $this->input->post();

			$data = array(
				'core_engineering_discipline_id' => $postInput['short'],
				'master_training_org_descipline_name' => $postInput['name'],
				'state' => 1
			);
			$this->TrainingDescModel->create($data);
			$this->session->set_flashdata('msg', 'A new training descipline has been added successfully');
			redirect('master/Class_TrainingDesc/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'master_training_org_descipline_id' => $postInput['master_training_org_descipline_id'],
			'core_engineering_discipline_id' => $postInput['new_code'],
			'master_training_org_descipline_name' => $postInput['new_name'],
			'state' => 1
		);
		$this->TrainingDescModel->update($data);
		$this->session->set_flashdata('msg', 'A training descipline has been updated successfully');
		redirect('master/Class_TrainingDesc/index', 'refresh');
	}

	public function delete(){
		$master_training_org_descipline_id = $this->input->post('master_training_org_descipline_id');
		$this->TrainingDescModel->delete($master_training_org_descipline_id);
		$this->session->set_flashdata('msg', 'A training descipline has been deleted successfully');
		redirect('master/Class_TrainingDesc/index', 'refresh');
	}
}

?>
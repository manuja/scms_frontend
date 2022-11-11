<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_AlSubjects extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/Al_Subjects_model');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - AL Subjects";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('AL Subjects', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
        
        $this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/Al_Subjects');
		$this->load->view('templates/footer');
		$this->load->view('employee/Al_Subjects_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->Al_Subjects_model->showDetails()));
	}

	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('Category', 'Category', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('msg', 'A new A/L subject has not been added successfully');

			$this->index();
		} else{

			$postInput = $this->input->post();

			$data = array(
				'master_al_subjects_name' => $postInput['name'],
				'state' => 1
			);

			$this->Al_Subjects_model->create($data);
			
			$this->session->set_flashdata('msg', 'A new A/L subject has been added successfully');
			redirect('master/Class_of_AlSubjects/index', 'refresh');
		}
	}

	public function update(){

		$postInput = $this->input->post();
		$data = array(
			'master_al_subjects_id' => $postInput['master_al_subjects_id'],
			'master_al_subjects_name' => $postInput['new_name'],
			'category' => $postInput['new_category'],
			'state' => 1
		);

		$this->Al_Subjects_model->update($data);
		$this->session->set_flashdata('msg', 'A/L subject has been updated successfully');
		redirect('master/Class_of_AlSubjects/index', 'refresh');
	}

	public function delete(){
		$master_al_subjects_id = $this->input->post('master_al_subjects_id');
		$this->Al_Subjects_model->delete($master_al_subjects_id);
		$this->session->set_flashdata('msg', 'A/L subject has been deleted successfully');
		redirect('master/Class_of_AlSubjects/index', 'refresh');
	}
}

?>
<?php 
date_default_timezone_set('Asia/Colombo');

class Class_DegreeQualification extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/DegreeQualificationModel');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Degree Qualification";
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Degree Qualification',  site_url());
		$data['breadcrumbs']=$this->breadcrumb->render();
		
		// $inpdata = $this->DegreeQualificationModel->showListOfRegistrations();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/DegreeQualification');
		$this->load->view('templates/footer');
		$this->load->view('employee/DegreeQualification_script');
		$this->load->view('templates/close');
	}

	public function showListOfRegistrations(){
		print_r(json_encode($this->DegreeQualificationModel->showListOfRegistrations()));
	}

	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('short', 'Code', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		} else {
			$postInput = $this->input->post();

			$data = array(
				'degree_qualification_nvq_level' => $postInput['short'],
				'degree_qualification_name' => $postInput['name'],
				'state' => 1
			);
			$this->DegreeQualificationModel->create($data);
			$this->session->set_flashdata('msg', 'A new degree qualification has been added successfully');
			redirect('master/Class_DegreeQualification/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'degree_qualification_id' => $postInput['degree_qualification_id'],
			'degree_qualification_nvq_level' => $postInput['new_code'],
			'degree_qualification_name' => $postInput['new_name'],
			'state' => 1
		);
		$this->DegreeQualificationModel->update($data);
		$this->session->set_flashdata('msg', 'A degree qualification has been updated successfully');
		redirect('master/Class_DegreeQualification/index', 'refresh');
	}

	public function delete(){
		$degree_qualification_id = $this->input->post('degree_qualification_id');
		$this->DegreeQualificationModel->delete($degree_qualification_id);
		$this->session->set_flashdata('msg', 'A degree qualification has been deleted successfully');
		redirect('master/Class_DegreeQualification/index', 'refresh');
	}
}

?>
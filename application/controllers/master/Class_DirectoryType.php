<?php 
date_default_timezone_set('Asia/Colombo');

class Class_DirectoryType extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/DirectoryTypeModel');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Directory Type";
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Directory Type',  site_url());
    	$data['breadcrumbs']=$this->breadcrumb->render();
		// $inpdata = $this->DirectoryTypeModel->showListOfRegistrations();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/DirectoryType');
		$this->load->view('templates/footer');
		$this->load->view('employee/DirectoryType_script');
		$this->load->view('templates/close');
	}

	public function showListOfRegistrations(){
		print_r(json_encode($this->DirectoryTypeModel->showListOfRegistrations()));
	}

	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		} else {
			$postInput = $this->input->post();

			$data = array(
				'directory_type_id' => $postInput['short'],
				'directory_type' => $postInput['name'],
				'status' => 1
			);
			$this->DirectoryTypeModel->create($data);

			$this->session->set_flashdata('msg', 'A directory type has been added successfully');
			redirect('master/Class_DirectoryType/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'directory_type_id' => $postInput['directory_type_id'],
			'directory_type' => $postInput['new_name'],
			'status' => 1
		);
		$this->DirectoryTypeModel->update($data);
		$this->session->set_flashdata('msg', 'A directory type has been updated successfully');
		redirect('master/Class_DirectoryType/index', 'refresh');
	}

	public function delete(){
		$directory_type_id = $this->input->post('directory_type_id');
		$this->DirectoryTypeModel->delete($directory_type_id);
		$this->session->set_flashdata('msg', 'A directory type has been deleted successfully');
		redirect('master/Class_DirectoryType/index', 'refresh');
	}
}

?>
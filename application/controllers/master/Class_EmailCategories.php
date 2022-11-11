<?php 
date_default_timezone_set('Asia/Colombo');

class Class_EmailCategories extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/EmailCategoriesModel');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Email Categories";
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Email Categories',  site_url());
    	$data['breadcrumbs']=$this->breadcrumb->render();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/EmailCategories');
		$this->load->view('templates/footer');
		$this->load->view('employee/EmailCategories_script');
		$this->load->view('templates/close');
	}

	public function showListOfRegistrations(){
		print_r(json_encode($this->EmailCategoriesModel->showListOfRegistrations()));
	}


	public function create(){
		$this->form_validation->set_rules('name', 'Category Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		} else {
			$postInput = $this->input->post();

			$data = array(
				'email_category_name' => $postInput['name'],
				'state' => 1
			);
			$this->EmailCategoriesModel->create($data);
			$this->session->set_flashdata('msg', 'A new Email category has been added successfully');
			redirect('master/Class_EmailCategories/index', 'refresh');	
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'email_category_id' => $postInput['email_category_id'],
			'email_category_name' => $postInput['new_name'],
			'state' => 1
		);
		$this->EmailCategoriesModel->update($data);
		$this->session->set_flashdata('msg', 'Email category has been updated successfully');
		redirect('master/Class_EmailCategories/index', 'refresh');
	}

	public function delete(){
		$email_category_id = $this->input->post('email_category_id');
		$this->EmailCategoriesModel->delete($email_category_id);
		$this->db->update('master_email_categories');
		redirect('master/Class_EmailCategories/index', 'refresh');
	}
}

?>
<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_stall_categories extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/Techno_Stall_Category_model', 'this_model');
    }
    
	public function index() {
		$userId = $this->session->userdata('user_id');
		if($userId) {
			$groupId = isMemberOrStaff($userId);
			if($groupId >= 3) show_404();
		} else redirect(base_url());

		$data['pagetitle'] = "Main Stall Categories";

		$page = $this->session->userdata('page');
		$this->breadcrumb->add('Home', site_url('dashboard/'.$page));
		$this->breadcrumb->add($data['pagetitle'], site_url());
		$data['breadcrumbs']=$this->breadcrumb->render();
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/stall_categories');
		$this->load->view('templates/footer');
		$this->load->view('employee/stall_categories_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->this_model->showDetails()));
	}

	public function create() {
		$this->form_validation->set_rules('categories', 'Stall Categories', 'required');

		if($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'The Category name is required');	
		} else {
			$postInput = $this->input->post();
			
			$data = array(
				'stall_category' => $postInput['categories'],
				'state' => 1
			);
			
			$state = $this->this_model->createNewCategory($data);
			
			if($state) $this->session->set_flashdata('success', 'New stall category has been added successfully');
			else  $this->session->set_flashdata('error', 'Error occured while saving the category');	
		}

		redirect('master/Class_of_stall_categories/index', 'refresh');
	}

	public function update() {
		$postInput = $this->input->post();

		$data = array(
			'category_id' => $postInput['category_id'],
			'stall_category' => $postInput['new_stall'],
			'state' => 1
		);
		$status = $this->this_model->updateStallCategory($data);

		if($status) $this->session->set_flashdata('success', 'Main stall category has been updated successfully');
		else $this->session->set_flashdata('error', 'Error occured while updating stall category');

		redirect('master/Class_of_stall_categories/index', 'refresh');
	}

	public function delete() {
		$category_id = $this->input->post('category_id');
		
		$status = $this->this_model->setStallCategoryAsDeleted($category_id);

		if($status) $this->session->set_flashdata('success', 'Stall category has been deleted successfully');
		else $this->session->set_flashdata('error', 'Error occured while deleting stall category');

		redirect('master/Class_of_stall_categories/index', 'refresh');
	}
}

?>
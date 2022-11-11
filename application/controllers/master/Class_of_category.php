<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_category extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/category_model');
    }
    
    public function index() {
		$userId = $this->session->userdata('user_id');
		if($userId) {
			$groupId = isMemberOrStaff($userId);
			if($groupId >= 3) show_404();
		} else redirect(base_url());

		$data['pagetitle'] = "Oraganizational Categories";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Oraganizational Categories', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
        
		
        $this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/category', $data);
		$this->load->view('templates/footer');
		$this->load->view('employee/category_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->category_model->showDetails()));
}

	public function create(){
		$this->form_validation->set_rules('name', 'Category Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$postInput = $this->input->post();

			$data = array(
				'category_name' => $postInput['name'],
				'state' => 1
			);
			
			$this->category_model->create($data);
			
			$this->session->set_flashdata('msg', 'A new category name has been added successfully');
			redirect('master/Class_of_category/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'category_id' => $postInput['category_id'],
			'category_name' => $postInput['new_name'],
			'state' => 1
		);
		$this->category_model->update($data);
		$this->session->set_flashdata('msg', 'Category has been updated successfully');
		redirect('master/Class_of_category/index', 'refresh');
	}

	public function delete(){
		$category_id = $this->input->post('category_id');
		$this->category_model->delete($category_id);
		$this->session->set_flashdata('msg', 'Category has been deleted successfully');
		redirect('master/Class_of_category/index', 'refresh');
	}
}

?>
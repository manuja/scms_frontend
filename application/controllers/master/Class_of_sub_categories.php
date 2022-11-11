<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_sub_categories extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/Techno_Stall_Sub_Category_model', 'this_model');
		}
		
		public function index() {
			$userId = $this->session->userdata('user_id');
			if($userId) {
				$groupId = isMemberOrStaff($userId);
				if($groupId >= 3) show_404();
			} else redirect(base_url());
			
			$data['pagetitle'] = "Sub Stall Categories";
			$data['stylesheetes'] = array(
			 'assets/select2/dist/css/select2.min.css',
			);
			$data['scripts'] = array(
			 'assets/select2/dist/js/select2.min.js',
			);

			$page = $this->session->userdata('page');
			$this->breadcrumb->add('Home', site_url('dashboard/'.$page));
			$this->breadcrumb->add($data['pagetitle'], site_url());
			$data['breadcrumbs']=$this->breadcrumb->render();

			$data['mainStallCategories'] = $this->this_model->getMainStallCategories();
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/main_sidebar', $data);
			$this->load->view('employee/sub_categories', $data);
			$this->load->view('templates/footer');
			$this->load->view('employee/sub_categories_script');
			$this->load->view('templates/close');
		}

		public function showDetails(){
			print_r(json_encode($this->this_model->showDetails()));
		}

	public function create(){
		$this->form_validation->set_rules('sub_category', 'Category Name', 'required');
		$this->form_validation->set_rules('main_category[]', 'Main Category Name', 'required');

		if($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Error in your submission, all parameters are required');
		} else {
			$postInput = $this->input->post();

			$data = array(
				'sub_category' => $postInput['sub_category'],
			);
			$subCategoryId = $this->this_model->createSubStallCategory($data);
			$relationData = array(
				'sub_category_id' => $subCategoryId,
				'main_category_id' => '',
			);

			$status = false;
			foreach ($postInput['main_category'] as $key => $category) {
				$relationData['main_category_id'] = $category;

				$status = $this->this_model->setSubCategoryRelation($relationData);
			}
			
			if($status) {
				$this->session->set_flashdata('success', 'A new sub category has been added successfully.');
			}{
				$this->session->set_flashdata('error', 'Sub category not created successfully.');
			}
		}

		redirect('master/Class_of_sub_categories/index', 'refresh');
	}

	public function update(){
		$postInput = $this->input->post();

		$data = array(
			'category_id' => $postInput['category_id'],
			'sub_category' => $postInput['new_sub_category'],
		);
		$this->this_model->updateSubStallCategory($data);
		$this->this_model->deleteRelations($postInput['category_id']);
		
		$relationData = array(
			'sub_category_id' => $postInput['category_id'],
			'main_category_id' => '',
		);
		foreach ($postInput['new_main_categories'] as $key => $category) {
			$relationData['main_category_id'] = $category;
			
			$this->this_model->setSubCategoryRelation($relationData);
		}
		
		$this->session->set_flashdata('success', 'Sub category has been updated successfully');
		redirect('master/Class_of_sub_categories/index', 'refresh');
	}
	
	public function delete(){
		$category_id = $this->input->post('category_id');
		$status = $this->this_model->deleteSubStallCategory($category_id);
		
		if($status) {
			$this->this_model->deleteRelations($category_id);
			$this->session->set_flashdata('success', 'Sub category has been deleted successfully');
		} else $this->session->set_flashdata('error', 'Error occured while deleting sub stall category');

		redirect('master/Class_of_sub_categories/index', 'refresh');
	}
}

?>
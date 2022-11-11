<?php 
date_default_timezone_set('Asia/Colombo');

class Class_EventCategories extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/EventCategoriesModel');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Event Categories";
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Event Categories',  site_url());
    	$data['breadcrumbs']=$this->breadcrumb->render();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/EventCategories');
		$this->load->view('templates/footer');
		$this->load->view('employee/EventCategories_script');
		$this->load->view('templates/close');
	}

	public function showListOfRegistrations(){
		print_r(json_encode($this->EventCategoriesModel->showListOfRegistrations()));

	}

	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		} else {
			$postInput = $this->input->post();

			$data = array(
				'event_category_name' => $postInput['name'],
				'state' => 1
			);
			$this->EventCategoriesModel->create($data);
			$this->session->set_flashdata('msg', 'A new event category has been added successfully');
			redirect('master/Class_EventCategories/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'event_category_id' => $postInput['event_category_id'],
			'event_category_name' => $postInput['new_name'],
			'state' => 1
		);
		$this->EventCategoriesModel->update($data);
		$this->session->set_flashdata('msg', 'An event category has been updated successfully');
		redirect('master/Class_EventCategories/index', 'refresh');
	}

	public function delete(){
		$event_category_id = $this->input->post('event_category_id');
		$this->EventCategoriesModel->delete($event_category_id);
		$this->session->set_flashdata('msg', 'An event category has been deleted successfully');
		redirect('master/Class_EventCategories/index', 'refresh');
	}
}

?>
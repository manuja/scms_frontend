<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_Notification_Category extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/Notification_Category_model');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Notification Category";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Notification Category', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
        
        //$this->Notification_Category_model->showDetails();

        //$data['notification_Category'] = $this->db->get()->result();
        $this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/Notification_Category', $data);
		$this->load->view('templates/footer');
		$this->load->view('employee/Notification_Category_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->Notification_Category_model->showDetails()));
	}

	public function create(){
		$this->form_validation->set_rules('name', 'Category Name', 'required');

		if($this->form_validation->run() == FALSE){
			$this->index();
		} else{
			$postInput = $this->input->post();

			$data = array(
				'master_notification_category_name' => $postInput['name'],
				'state' => 1
			);
			
			$this->Notification_Category_model->create($data);
			
			$this->session->set_flashdata('msg', 'A new notification category has been added successfully');
			redirect('master/Class_of_Notification_Category/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'master_notification_category_id' => $postInput['master_notification_category_id'],
			'master_notification_category_name' => $postInput['new_input_type'],
			'state' => 1
		);
		$this->Notification_Category_model->update($data);
		$this->session->set_flashdata('msg', 'Notification category has been updated successfully');
		redirect('master/Class_of_Notification_Category/index', 'refresh');
	}
	
	public function delete(){
		$master_notification_category_id = $this->input->post('master_notification_category_id');
		$this->Notification_Category_model->delete($master_notification_category_id);
		$this->session->set_flashdata('msg', 'Notification category has been deleted successfully');
		redirect('master/Class_of_Notification_Category/index', 'refresh');
	}
}

?>
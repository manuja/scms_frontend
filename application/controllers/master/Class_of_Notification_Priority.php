<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_Notification_Priority extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/Notification_Priority_model');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Notification Priority";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Notification Priority', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/Notification_Priority');
		$this->load->view('templates/footer');
		$this->load->view('employee/Notification_Priority_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->Notification_Priority_model->showDetails()));
	}

	public function create(){
		$this->form_validation->set_rules('name','Priority Type', 'required');

		if($this->form_validation->run() == FALSE){

			$this->session->set_flashdata('msg', 'New Priority type has not been added successfully');
			$this->index();
		} else{

			$postInput = $this->input->post();

			$data = array(
				'master_notification_priority_name' => $postInput['name'],
				'state' => 1
			);
			$this->Notification_Priority_model->create($data);

			$this->session->set_flashdata('msg', 'A Priority type has been added successfully');
			redirect('master/Class_of_Notification_Priority/index', 'refresh');
		}

	}

	public function update(){

		$postInput = $this->input->post();
		$data = array(
			'master_notification_priority_id' => $postInput['master_notification_priority_id'],
			'master_notification_priority_name' => $postInput['new_name'],
			'state' => 1
		);

		$this->Notification_Priority_model->update($data);
		$this->session->set_flashdata('msg', 'Priority type has been updated successfully');
		redirect('master/Class_of_Notification_Priority/index', 'refresh');
	}

	public function delete(){
		$master_notification_priority_id = $this->input->post('master_notification_priority_id');
		$this->Notification_Priority_model->delete($master_notification_priority_id);
		$this->session->set_flashdata('msg', 'Priority type has been deleted successfully');
		redirect('master/Class_of_Notification_Priority/index', 'refresh');
	}
}

?>
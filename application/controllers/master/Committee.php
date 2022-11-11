<?php

date_default_timezone_set('Asia/Colombo');

class Committee extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/Committee_model','this_model');
	}
	
	// get table data form the model and returns as json format
	public function getTableData()
	{
		echo json_encode($this->this_model->getTableData());
	}
    
    public function index() {
		$data['pagetitle'] = "test MIS - Committee";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Committee', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
        
		// $data['committee'] = $this->this_model->showDetails();
		
        $this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/committee', $data);
		$this->load->view('templates/footer');
		$this->load->view('employee/committee_script');
		$this->load->view('templates/close');
	}

	public function create(){
		$this->form_validation->set_rules('name', 'Comittee Name', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		} else{
			$name = $this->input->post('name');

			$data = array(
				'committee_name' => $name,
				'status' => 1
			);

			$this->this_model->setNewCommittee($data);

			$this->session->set_flashdata('msg', 'A new committee name has been added successfully');
			redirect('master/Committee/index', 'refresh');
		}	
	}

	public function update(){
		$postData = $this->input->post();

		$data = array(
			'committee_id' => $postData['committee_id'],
			'committee_name' => $postData['new_name']
		);

		$this->this_model->updateCommitteeName($data);

		$this->session->set_flashdata('msg', 'Committee name has been updated successfully');
		redirect('master/Committee/index', 'refresh');
	}

	public function delete(){
		$committee_id = $this->input->post('committee_id');

		$this->this_model->setCommitteeAsDeleted($committee_id);

		$this->session->set_flashdata('msg', 'A Committee has been deleted successfully');
		redirect('master/Committee/index', 'refresh');
	}
}

?>
<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_All_Countries extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/All_Countries_Model');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - All Countries";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('All Countries', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/All_Countries');
		$this->load->view('templates/footer');
		$this->load->view('employee/All_Countries_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->All_Countries_Model->showDetails()));
	}

	public function create(){
		$this->form_validation->set_rules('code','Country Code', 'required');
		$this->form_validation->set_rules('name','Country Name', 'required');

		if($this->form_validation->run() == FALSE){

			$this->session->set_flashdata('msg', 'New country details have not been added successfully');
			$this->index();
		} else{

			$postInput = $this->input->post();

			$data = array(
				'country_code' => $postInput['code'],
				'country_name' => $postInput['name'],
				'state' => 1
			);
			$this->All_Countries_Model->create($data);

			$this->session->set_flashdata('msg', 'A new Country has been added successfully');
			redirect('master/Class_of_All_Countries/index', 'refresh');
		}

	}

	public function update(){

		$postInput = $this->input->post();
		$data = array(
			'id' => $postInput['id'],
			'country_code' => $postInput['new_code'],
			'country_name' => $postInput['new_name'],
			'state' => 1
		);

		$this->All_Countries_Model->update($data);
		$this->session->set_flashdata('msg', 'Country details have been updated successfully');
		redirect('master/Class_of_All_Countries/index', 'refresh');
	}

	public function delete(){
		$id = $this->input->post('id');
		$this->All_Countries_Model->delete($id);
		$this->session->set_flashdata('msg', 'Country details have been deleted successfully');
		redirect('master/Class_of_All_Countries/index', 'refresh');
	}
}

?>
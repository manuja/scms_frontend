<?php

date_default_timezone_set('Asia/Colombo');

class SL_Provinces extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/SL_Provinces_model', 'this_model');
	}
	
	// get table data form the model and returns as json format
	public function getTableData()
	{
		echo json_encode($this->this_model->getTableData());
	}
    
    public function index() {
		$data['pagetitle'] = "test MIS - SL Provinces";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('SL Provinces', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
        
		// $data['sl_provinces'] = $this->this_model->getTableRawData();
		
        $this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/sl_provinces', $data);
		$this->load->view('templates/footer');
		$this->load->view('employee/sl_provinces_script');
		$this->load->view('templates/close');
	}

	public function create(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('msg', 'A new province has not been added successfully');
			$this->index();
		} else {
			$name = $this->input->post('name');
			$code = $this->input->post('code');

			$data = array(
				'province_name' => $name,
				'province_name_short' => $code,
				'state' => 1,
			);
			$this->this_model->setNewProvince($data);

			
			$this->session->set_flashdata('msg', 'A new province has been added successfully');
			redirect('master/SL_Provinces/index', 'refresh');
		}
	}

	public function update(){
		$this->this_model->update();
	}

	public function delete(){
		$sl_provinces_id = $this->input->post('sl_provinces_id');

		$this->this_model->delete($sl_provinces_id);
		
		$this->session->set_flashdata('msg', 'Province details has been deleted successfully');
		redirect('master/SL_Provinces/index', 'refresh');
	}
}

?>
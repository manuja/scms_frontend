<?php

date_default_timezone_set('Asia/Colombo');

class Class_of_payment_status extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/Payment_status_model');
    }
    
    public function index() {
		$data['pagetitle'] = "test MIS - Payment Status";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Payment Status', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();

        //$data['paymentstatus'] = $this->payment_status_model->showDetails();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/payment_status', $data);
		$this->load->view('templates/footer');
		$this->load->view('employee/payment_status_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->payment_status_model->showDetails()));
	}

	public function create(){
		$this->form_validation->set_rules('payment_status', 'Payment Status', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->index();
		} else{
			$postInput = $this->input->post();

			$data = array(
				'payment_status' => $postInput['payment_status'],
				'state' => 1
			);
			
			$this->payment_status_model->create($data);
			
			$this->session->set_flashdata('msg', 'A new payment status has been added successfully');
			redirect('master/Class_of_payment_status/index', 'refresh');
		}
	}

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'payment_status_id' => $postInput['payment_status_id'],
			'payment_status' => $postInput['new_payment_status'],
			'state' => 1
		);
		$this->payment_status_model->update($data);
		$this->session->set_flashdata('msg', 'Payment status has been updated successfully');
		redirect('master/Class_of_payment_status/index', 'refresh');
	}

	public function delete(){
		$payment_status_id = $this->input->post('payment_status_id');
		$this->payment_status_model->delete($payment_status_id);
		$this->session->set_flashdata('msg', 'Payment status has been deleted successfully');
		redirect('master/Class_of_payment_status/index', 'refresh');
	}
}

?>
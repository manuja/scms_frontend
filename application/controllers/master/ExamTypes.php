<?php
/**
 * created by test
 * date 20/03/2019
 */

date_default_timezone_set('Asia/Colombo');

class ExamTypes extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/ExamTypeModel');
    }
    
    /**
     * created by : test
     * date 20/03/2019
     * show index page of exam types,show to insert and list of added exam types
     */
    public function index() {
	$data['pagetitle'] = "test MIS - Exam Types";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Exam Types', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
        
        $this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('exams/exam_types');
		$this->load->view('templates/footer');
		$this->load->view('exams/exam_types_script');
		$this->load->view('templates/close');
	}

	public function showDetails(){
		print_r(json_encode($this->ExamTypeModel->showDetails()));
	}

	public function create(){
		$this->form_validation->set_rules('exam_type', 'Exam Type', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('msg', 'Plese Enter Valid Information');

			$this->index();
		} else{

			$postInput = $this->input->post();
			$this->ExamTypeModel->create($postInput);
			
			$this->session->set_flashdata('msg', 'Exam type has been added successfully');
			redirect('master/ExamTypes/index', 'refresh');
		}
	}

	public function update(){

		$postInput = $this->input->post();
		
		$this->ExamTypeModel->update($postInput);
		$this->session->set_flashdata('msg', 'Exam type has been updated successfully');
		redirect('master/ExamTypes/index', 'refresh');
	}

	public function delete(){
		$exam_type_id = $this->input->post('exam_type_id');
		$this->ExamTypeModel->delete($exam_type_id);
		$this->session->set_flashdata('msg', 'Exam type has been deleted successfully');
		redirect('master/ExamTypes/index', 'refresh');
	}
}

?>
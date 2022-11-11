<?php
/**
 * created by test
 * date 20/03/2019
 */

date_default_timezone_set('Asia/Colombo');

class MainSubjects extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session'));
		$this->load->model('master/MainSubjectsModel');
    }
    
    /**
     * created by : test
     * date 20/03/2019
     * show index page of Main Sbjects,show to insert and list of added exam types
     */
    public function index(){
	$data['pagetitle'] = "test MIS - Main Subjects";
        $this->load->helper('master_tables');
        $data['MasterEngineeringDiscipline'] = getMasterEngineeringDiscipline();
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Subjects', site_url());
        $data['breadcrumbs'] = $this->breadcrumb->render();
        
            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar', $data);
            $this->load->view('exams/main_subjects',$data);
            $this->load->view('templates/footer');
            $this->load->view('exams/main_subjects_script');
            $this->load->view('templates/close');
	}

	public function showDetails(){
		echo (json_encode($this->MainSubjectsModel->showDetails()));
	}

	public function create(){
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
//		$this->form_validation->set_rules('engineering_discipline_id', 'Engineering Discipline', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('msg', 'Plese Enter Valid Information');

			$this->index();
		} else{

			$postInput = $this->input->post();
			$this->MainSubjectsModel->create($postInput);
			
			$this->session->set_flashdata('msg', 'Main Subject has been added successfully');
			redirect('master/MainSubjects/index', 'refresh');
		}
	}

	public function update(){

		$postInput = $this->input->post();
		
		$this->MainSubjectsModel->update($postInput);
		$this->session->set_flashdata('msg', 'Exam subject has been updated successfully');
		redirect('master/MainSubjects/index', 'refresh');
	}

	public function delete(){
		$main_subject_id = $this->input->post('master_main_subject_id');
		$this->MainSubjectsModel->delete($main_subject_id);
		$this->session->set_flashdata('msg', 'Exam subject has been deleted successfully');
		redirect('master/MainSubjects/index', 'refresh');
	}
}

?>
<?php
date_default_timezone_set('Asia/Colombo');

class Techno_Event_Info extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session','Userpermission'));
        $this->load->model('master/Techno_Event_Info_model', 'this_model');
	}
	 
// #region for main view
	public function index() {
             if($this->userpermission->checkUserPermissions('tech_event_view_tech_event')) {
		$data['pagetitle'] = "Techno Events";
		
		$page = $this->session->userdata('page');
		$this->breadcrumb->add('Home', site_url('dashboard/'.$page));
		$this->breadcrumb->add($data['pagetitle'], site_url());
		$data['breadcrumbs']=$this->breadcrumb->render();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/main_sidebar', $data);
		$this->load->view('employee/techno_event_info');
		$this->load->view('templates/footer');
		$this->load->view('employee/techno_event_info_script');
		$this->load->view('templates/close');
            }
        }
	
	public function showDetails(){
		print_r(json_encode($this->this_model->showListOfRegistrations()));
	}
// #endregion

	public function update(){
		$postInput = $this->input->post();
		$data = array(
			'event_id' => $postInput['event_id'],
            'exhibition_title' => $postInput['new_exhibition_title'],
            'year' => $postInput['new_year'],
			'state' => 1
		);
		$this->this_model->update($data);
		$this->session->set_flashdata('msg', 'Event has been updated successfully');
		redirect('master/Techno_Event_Info/index', 'refresh');
	}

	public function delete(){
		$event_id = $this->input->post('event_id');
		$this->this_model->delete($event_id);
		$this->session->set_flashdata('msg', 'Event has been deleted successfully');
		redirect('master/Techno_Event_Info/index', 'refresh');
	}

	public function closereg(){
		$event_id = $this->input->post('event_id');
		$this->this_model->closereg($event_id);
		$this->session->set_flashdata('msg', 'Event has been activated successfully');
		redirect('master/Techno_Event_Info/index', 'refresh');
	}

	public function openreg(){
		$event_id = $this->input->post('event_id');
		$this->this_model->openreg($event_id);
		$this->session->set_flashdata('msg', 'Event has been activated successfully');
		redirect('master/Techno_Event_Info/index', 'refresh');
	}

	public function deactivate(){
		$event_id = $this->input->post('event_id');
		$this->this_model->deactivate($event_id);
		$this->session->set_flashdata('msg', 'Event has been deactivated successfully');
		redirect('master/Techno_Event_Info/index', 'refresh');
	}
}

?>
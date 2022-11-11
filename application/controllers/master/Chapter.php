<?php
    date_default_timezone_get('Asia/Colombo');

    class Chapter extends CI_Controller{
        
        public function __construct()
        {
            parent::__construct();
            $this->load->helper(array('url','form'));
            $this->load->library(array('form_validation', 'session'));
            $this->load->model('master/Chapter_model', 'this_model');
        }

        // get table data form the model and returns as json format
        public function getTableData()
        {
            echo json_encode($this->this_model->getTableData());
        }

        // Load the chapter viewS
        public function index()
        {
            $data['pagetitle'] = "test MIS - Chapter";
            
            $page = $this->session->userdata('page');
            $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
            $this->breadcrumb->add('Chapter', site_url());
            $data['breadcrumbs']=$this->breadcrumb->render();

            // $data['chapters'] = $this->this_model->getTableData();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/main_sidebar', $data);
            $this->load->view('employee/chapter', $data);
            $this->load->view('templates/footer');
            $this->load->view('employee/chapter_script');
            $this->load->view('templates/close');
        }

        // create a new chapter
        public function create(){
            $this->form_validation->set_rules('chapter', 'Chapter', 'required');

            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            } else{
                $chapter = $this->input->post('chapter');

                $data = array(
                    'chapter_name' => $chapter,
                    'status' => 1
                );
                
                $this->this_model->setNewChapter($data);
                $this->session->set_flashdata('msg', 'A new chapter has been added successfully');

                redirect('master/chapter/index', 'refresh');
            }
        }

        // update a chapter
        public function update(){
            $chapterId = $this->input->post('chapter_id');
            $chapterName = $this->input->post('new_chapter');

            $this->this_model->updateChapterName($chapterId, $chapterName);

            $this->session->set_flashdata('msg', 'A chapter has been successfully updated');

            redirect('master/chapter/index', 'refresh');
        }

        // delete a chapter
        public function delete(){
            $chapterId = $this->input->post('chapter_id');

            $this->this_model->setChapterAsDeleted($chapterId);

            $this->session->set_flashdata('msg', 'A chapter has been deleted successfully');
            redirect('master/chapter/index', 'refresh');
        }
    }
?>
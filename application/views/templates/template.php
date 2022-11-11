<?php

    $this->load->view('templates/header', $data);
    $this->load->view('templates/main_sidebar', $data);
    $this->load->view($view_file,$data);
    $this->load->view('templates/footer');
    if($script_file != ''){
    $this->load->view($script_file);
    }
    $this->load->view('templates/close');


<?php

use Aws\Api\Parser\JsonParser;
use Aws\Api\Serializer\JsonBody;

defined('BASEPATH') or exit('No direct script access allowed');


 /*
    @Ujitha Sudasingha
    2022-11-04
    Order mgt controller
    */

class OrderController extends CI_Controller
{
   

    public function __construct()
    {
        parent::__construct();

    }


      /*
    @Ujitha Sudasingha
    2022-11-04
    Function to load all the orders
    */
    public function  index()
    {
       
        $url="http://localhost/";

        if (!$this->ion_auth->logged_in()) {
            redirect('signin', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('event_management')) {

            $page = $this->session->userdata('page');

            $this->breadcrumb->add('Home', site_url('dashboard/' . $page));
            $this->breadcrumb->add('Manage Orders', site_url('event_management'));

            $data['breadcrumbs'] = $this->breadcrumb->render();
            $data['pagetitle'] = 'Manage Orders';

            $data['stylesheetes'] = array(
                'assets/css/bootstrap-datetimepicker.css'
            );

            $data['scripts'] = array(
                'assets/js/validator.js',
                'assets/js/bootstrap-datetimepicker.js'
            );
          
            $service_url = $url."scms_backend/API/orders/";
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('token: Ab&5$rgyh123oakyhgfdA',));
            //curl_setopt($curl, CURLOPT_HTTPHEADER,'token: Ab&5$rgyh123oakyhgfdA',true);
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
              $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);
            $decoded = json_decode($curl_response);
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
            }
          $array = json_decode(json_encode($decoded), true);
     
          $data['events'] = $array;
      
         

            $view_arr = array(

                'data' => $data,
                'view_file' => 'order/order_grid',
                'script_file' => 'order/order_grid_script'
            );

            $this->load->view('templates/template', $view_arr);
        }
    }



        /*
    @Ujitha Sudasingha
    2022-11-04
    Function to create orders and load order form
    */
    public function add_orders()
    {

        $url="http://localhost/";

        if (!$this->ion_auth->logged_in()) {
            redirect('signin', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('add_event')) { //add permission


            if (isset($_POST) && !empty($_POST)) {

                $this->form_validation->set_rules('title', 'Title', 'trim|required');
                $this->form_validation->set_rules('order_need_date', 'Order Expected Date', 'trim|required');
    

                if ( $this->form_validation->run() === TRUE ) {

                      // print_r("hiiii");
                      // print_r($this->input->post());die();

                    $title = $this->input->post('title');
                    $orderid= $this->input->post('orderid');
                    $order_completion_date=$this->input->post('order_need_date');
                    $description=$this->input->post('description');
                    $created_by=$this->session->userdata('first_name');
                    $client=$this->input->post('client');
                    $contactno=$this->input->post('contactno');
                    $form_identify=$this->input->post('form_identify');


                     $postRequest = array(
                     'ordername' => $title,
                     'orderid' => $orderid,
                     'order_need_date' => $order_completion_date,
                     'description'=> $description,
                     'created_by'=>$created_by,
                     'client'=>$client,
                     'contactno'=>$contactno,
                     'form_identify'=>$form_identify,

                    );

                   

                    $service_url = $url."scms_backend/API/addTotalOrder/";
                    $cURLConnection = curl_init($service_url);
                    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
                    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('token: Ab&5$rgyh123oakyhgfdA',));

                    $apiResponse = curl_exec($cURLConnection);
                    curl_close($cURLConnection);

                    $jsonArrayResponse = json_decode($apiResponse);

                    if($jsonArrayResponse){

                       
                        $this->session->set_flashdata('success', 'Record Updated successfully!');
                        redirect(base_url() . 'orders');


                    }else{

                        $this->session->set_flashdata('failure', 'Record Added failure!');
                        redirect(base_url() . 'event_management');

                    }



            }else{
                
                $this->session->set_flashdata('failure', 'Record Added failure!');
                redirect(base_url() . 'event_management');
            }

        }


            $page = $this->session->userdata('page');

            $this->breadcrumb->add('Home', site_url('dashboard/' . $page));
            $this->breadcrumb->add('Manage Events', site_url('event_management'));
            $this->breadcrumb->add('Add Events', site_url('event_management/add_events'));

            $data['breadcrumbs'] = $this->breadcrumb->render();
            $data['pagetitle'] = 'Add Order';
            $data['edit_status'] = true;
            $data['formUrl'] = 'order_management/add_orders';
            $data['one_event']   = "";

                $postRequest = array(
            //'status' => 0,
            );
            $service_url = $url."scms_backend/API/addOrder/";
            $cURLConnection = curl_init($service_url);
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('token: Ab&5$rgyh123oakyhgfdA',));
            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);

            // $apiResponse - available data from the API request
            $jsonArrayResponse = json_decode($apiResponse);


            $data['stylesheetes'] = array(
                'assets/css/bootstrap-datetimepicker.css'
            );



            $data['scripts'] = array(
                'assets/js/validator.js',
                'assets/js/bootstrap-datetimepicker.js'
            );

            $data['order_id']= $jsonArrayResponse ;



            $view_arr = array(

                'data' => $data,
                'view_file' => 'order/add_order',
                'script_file' => 'order/add_order_script'
            );

            $this->load->view('templates/template', $view_arr);
        }
    }


    // public function edit_items() {

    //     print_r("hiii".$this->input->post('droporderitem'));die();
    //     // $json = array();
    //     // $staffID = $this->input->post('staff_id');
    //     // $this->staff->setStaffID($staffID);
    //     // $json['staffInfo'] = $this->staff->getStaff();

    //     $this->output->set_header('Content-Type: application/json');
    //     $this->load->view('staff/popup/renderEdit', $json);
    // }


      /*
    @Ujitha Sudasingha
    2022-11-04
    Function to view single order
    */
    public function view_orders($id)
    {

         $url="http://localhost/";

        if (!$this->ion_auth->logged_in()) {
            redirect('signin', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('view_event')) { //add permission

            $page = $this->session->userdata('page');

            $this->breadcrumb->add('Home', site_url('dashboard/' . $page));
            $this->breadcrumb->add('Manage Orders', site_url('orders/'));
            $this->breadcrumb->add('View Orders', site_url('OrderController/view_orders/' . $id));

            $data['breadcrumbs'] = $this->breadcrumb->render();
            $data['pagetitle'] = 'View Orders';
            $data['edit_status'] = false;
            $data['formUrl'] = '';

            $data['stylesheetes'] = array(
                'assets/css/bootstrap-datetimepicker.css'
            );

            $data['scripts'] = array(
                'assets/js/validator.js',
                'assets/js/bootstrap-datetimepicker.js'
            );



            $service_url = $url."scms_backend/API/getSingleOrder?id=".$id;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('token: Ab&5$rgyh123oakyhgfdA',));
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
              $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);
            $decoded = json_decode($curl_response);
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
            }


            $data['one_order_id']   = $id;
            $data['name']=$decoded[0]->name;
            $data['contactno']=$decoded[0]->contactno;
            $data['order_need_date']=$decoded[0]->order_need_date;
            $data['description']=$decoded[0]->description;


            $view_arr = array(

                'data' => $data,
                'view_file' => 'order/view_order',
                'script_file' => 'order/add_order_script'
            );

            $this->load->view('templates/template', $view_arr);
        }
    }


     /*
    @Ujitha Sudasingha
    2022-11-04
    Function to edit orders and load order edit form
    */
    public function edit_orders($id=''){



       
        $url="http://localhost/";

        if (!$this->ion_auth->logged_in()) {
            redirect('signin', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('edit_event')) { //add permission

            if (isset($_POST) && !empty($_POST)) {

                $this->form_validation->set_rules('title', 'Title', 'trim|required');
                $this->form_validation->set_rules('order_need_date', 'Order Expected Date', 'trim|required');
       
           

                if ( $this->form_validation->run() === TRUE ) {

                    $title = $this->input->post('title');
                    $orderid= $this->input->post('orderid');
                    $order_completion_date=$this->input->post('order_need_date');
                    $description=$this->input->post('description');
                    $created_by=$this->session->userdata('first_name');
                    $client=$this->input->post('client');
                    $contactno=$this->input->post('contactno');
                   // $form_identify=$this->input->post('form_identify');

                     $postRequest = array(
                     'ordername' => $title,
                     'orderid' => $orderid,
                     'order_need_date' => $order_completion_date,
                     'description'=> $description,
                     'created_by'=>$created_by,
                     'client'=>$client,
                     'contactno'=>$contactno,
                    // 'form_identify'=>$form_identify,
                    );

                    $service_url = $url."scms_backend/API/addTotalOrder/";
                    $cURLConnection = curl_init($service_url);
                    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
                    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('token: Ab&5$rgyh123oakyhgfdA',));

                    $apiResponse = curl_exec($cURLConnection);
                    curl_close($cURLConnection);



                    // $apiResponse - available data from the API request
                    $jsonArrayResponse = json_decode($apiResponse);

                    // $res = $this->Event_management_model->saveevent($formarray, $this->session->userdata('user_id'));

                    if($jsonArrayResponse){

                       
                        $this->session->set_flashdata('success', 'Record Updated successfully!');
                        redirect(base_url() . 'orders');


                    }else{

                        $this->session->set_flashdata('failure', 'Record Added failure!');
                        redirect(base_url() . 'event_management');

                    }



            }else{
                print_r("not okkkkkk");die();
                $this->session->set_flashdata('failure', 'Record Added failure!');
                redirect(base_url() . 'event_management');
            }

        }


            $page = $this->session->userdata('page');

            $this->breadcrumb->add('Home', site_url('dashboard/' . $page));
            $this->breadcrumb->add('Manage Events', site_url('order_management'));
            $this->breadcrumb->add('Add Events', site_url('order_management/edit_orders'));

            $data['breadcrumbs'] = $this->breadcrumb->render();
            $data['pagetitle'] = 'Edit Order';
            $data['edit_status'] = true;
            $data['formUrl'] = 'order_management/edit_orders';

            $data['one_event']   = "";

                $postRequest = array(
            //'status' => 0,
            );
            
            $service_url = $url."scms_backend/API/getSingleOrder?id=".$id;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('token: Ab&5$rgyh123oakyhgfdA',));
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
              $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);
            $decoded = json_decode($curl_response);
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
            }

            
           // print_r($decoded);die();


            $data['stylesheetes'] = array(
                'assets/css/bootstrap-datetimepicker.css'
            );



            $data['scripts'] = array(
                'assets/js/validator.js',
                'assets/js/bootstrap-datetimepicker.js'
            );

            $data['order_id']= $id ;
            $data['orderinfo']=$decoded;

           // print_r($data['orderinfo']);die();



            $view_arr = array(

                'data' => $data,
                'view_file' => 'order/edit_order',
                'script_file' => 'order/edit_order_script'
            );

            $this->load->view('templates/template', $view_arr);
        }
    }



    public function delete_orders()
    {

      
        $url="http://localhost/";

        if (!$this->ion_auth->logged_in()) {
            redirect('signin', 'refresh');
        } else if ($this->userpermission->checkUserPermissions('delete_event')) {

        $id = $this->input->post('d_id');

          //print_r("sssssssssss".$id);die();

        $service_url = $url."scms_backend/API/deleteSingleOrder?id=".$id;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('token: Ab&5$rgyh123oakyhgfdA',));
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
              $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);
            $decoded = json_decode($curl_response);
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
            }

            


        if ($decoded == 1) {


            $this->session->set_flashdata('success', 'Record Deleted successfully!');
            redirect(base_url() . 'orders');
        } else {

            $this->session->set_flashdata('failure', 'Record Delete failure!');
            redirect(base_url() . 'orders');
        }

    }
    }

 
}
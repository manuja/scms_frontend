<?php
  date_default_timezone_set('Asia/Colombo');

  /**
   * @author: Hasitha Samarasinghe / hasitha.h45h@gmail.com
   */
  class Techno_Event_Initiation extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array('form', 'url', 'upload_custom_helper', 'file'));
      $this->load->library('form_validation');
      $this->load->model('master/Techno_Event_Initiation_model', 'this_model');
      $this->load->model('master/Techno_Stall_Category_model', 'category_model');
      $this->load->model('master/Techno_Stall_Sub_Category_model', 'sub_category_model');
      $this->load->model('master/Techno_Stalls_model', 'stall_model');
    }

    public function isStaff()
    {
      $userId = $this->session->userdata('user_id');
      if($userId) {
        $groupId = isMemberOrStaff($userId);
        if($groupId >= 3) show_404();
        return true;
      } else redirect(base_url());
    }

    public function index($eventId = NULL, $tempData = NULL)
    {
      $this->isStaff();

      $data['pagetitle'] = "test Techno - Event Initialization";

      $page = $this->session->userdata('page');
      $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
      $this->breadcrumb->add('Techno Events', site_url('master/Techno_Event_Info'));
      $this->breadcrumb->add('View', site_url());
      $data['breadcrumbs']=$this->breadcrumb->render();
      
      if($tempData) {
        $data = $tempData;
      }

      $data['stylesheetes'] = array(
        'assets/select2/dist/css/select2.min.css',
        'assets/css/bootstrap-datetimepicker.css',
        'application/vendor/jackocnr/intl-tel-input/build/css/intlTelInput.css'
      );
      $data['scripts'] = array(
          'assets/js/validator.min.js',
          'assets/select2/dist/js/select2.min.js',
          'assets/js/bootstrap-datetimepicker.js',
          'application/vendor/jackocnr/intl-tel-input/build/js/intlTelInput.min.js'
      );

      if($eventId) {
        $data['event_data'] = $this->this_model->getEventData($eventId);          
        $data['stall_data'] = $this->stall_model->getStallData($eventId);
        $data['adz_data'] = $this->this_model->getAdvertisements($eventId);
        $data['extra_data'] = $this->this_model->getExtraItemData($eventId);
        $data['bare_data'] = $this->this_model->getBareItemData($eventId);
        if(!$tempData) $data['isReadOnly'] = TRUE;
      }

      $data['main_stall_categories'] = $this->this_model->getStallMainCategories();
      $data['sub_stall_categories'] = $this->this_model->getStallSubCategories();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/main_sidebar', $data);
      $this->load->view('employee/techno_event_initiation', $data);
      $this->load->view('templates/footer');
      $this->load->view('employee/techno_event_initiation_script');
      $this->load->view('templates/close');
    }

    public function create() 
    {
      $data['pagetitle'] = "test Techno Create Event";
      
      $task = $this->input->post('task');
      if(!isset($task)) {
        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Techno Events', site_url('master/Techno_Event_Info'));
        $this->breadcrumb->add('Create', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();
        
        $this->index(NULL,$data);
      } else {
        if($task != 'save') {
          echo json_encode(array('status' => false, 'msg' => 'Problem occured with method of acquiring data. Please contact your system administrator'));
          return false;
        }
        $postData = $this->input->post();
//        var_dump($postData['tax_enabled']);die();
// #region handling basic event detials
        // Collecting and Storing Data for Event Initiation table
        $eventData = array(
          'exhibition_title' => $postData['event_title'],
          'year' => $postData['event_year'],
          'start_date' => $postData['event_date_from'],
          'end_date' => $postData['event_date_to'],
          'start_time' => $postData['event_time_from'],
          'end_time' => $postData['event_time_to'],
          'organized_by' => $postData['organized_by'],
          'venue' => $postData['venue'],
          'contact_person_name' => $postData['contact_person_name'],
          'contact_designation' => $postData['contact_person_designation'],
          'contact_tel' => $postData['event_contact_person_tp'],
          'contact_email' => $postData['contact_person_email'],
          'description' => $postData['event_description'],
          'reg_open' => 0,
          'state' => 1,
        );  
        $eventInfo = $this->this_model->createEvent($eventData);

        $uploadData = upload_file('uploads/techno', '_stall_plan_'.$eventInfo['event_id'].'_'.date('Y_m_d__H_i_s'), 'stall_plan', 2048);
        if($uploadData['status'] == 0 || $eventInfo['status'] == false) {
          echo json_encode(array("status" => FALSE, "msg" => (!$eventInfo['status'])?'Error occured while saving company details and ':''.$uploadData['message']));
          return false;
        }
        $postData['event_id'] = $eventInfo['event_id'];
// #endregion

// #region handlilng stalls details
        // Collecting and storing Data for Event Initiation table
        $stallData = array();
        $stallNosCount = 0;
        foreach($postData['stall'] as $key=>$stall){
          $tempData = array(
            'event_id' => $postData['event_id'],
            'stall_category_id' => $postData['stall_category'][$key],
            'sub_category_id' => $postData['sub_category'][$key],
            'No_of_stalls' => $postData['noOfStallNos'][$key],
            'is_ac' => $postData["is_ac"][$key],
            'local_rate' => $postData['stall_local_rate'][$key],
            'foreign_rate' => $postData['stall_foreign_rate'][$key],
            'tax_enabled' => $postData['tax_enabled'][$key],
          );
          
          $stallData[$key] = $tempData;
          $stallId = $this->stall_model->createStall($stallData[$key]);
          $tempData["stall_id"] = $stallId;

          $tempStallNo = array();
          for ($i=$stallNosCount; $i < $stallNosCount+$postData['noOfStallNos'][$key]; $i++) { 
            $tempNo = array(
              'techno_stalls_id' => $stallId,
              'stall_number' => $postData['stall_number'][$i],
            );
            array_push($tempStallNo, $tempNo);
          }
          $stallNosCount += $postData['noOfStallNos'][$key];
          // var_dump($tempStallNo);
          $this->stall_model->createStallNumbers($tempStallNo);
        }
// #endregion

// #region handling extra items
        // Collecting and Storing Data for Extra Accessories
        $extraItemData = array();
        foreach($postData['extra_item'] as $key=>$item){
          $tempData = array(
            'event_id' => $postData['event_id'],
            "item_description" => $postData['extra_description'][$key],
            "local_rate" => $postData['extra_local_rate'][$key],
            "foreign_rate" => $postData['extra_foreign_rate'][$key],
          );
          
          $extraItemData[$key] = $tempData;
          $this->this_model->createExtraItem($extraItemData[$key]);
        }
// #endregion

// #region handling bare items
        // Collecting and Storing Data for Bare Space Items
        $bareItemData = array();
        foreach($postData['bare_item'] as $key=>$item){
          $tempData = array(
            'event_id' => $postData['event_id'],
            "item" => $postData['bare_space_item'][$key],
          );

          $bareItemData[$key] = $tempData;
          $this->this_model->createBareItem($bareItemData[$key]);
        }
// #endregion
        
// #region handling advertisements
        // Collecting and storing data for advertisements
        $adzData = array();
        foreach ($postData['ad'] as $key => $ad) {
          $tempData = array(
            'event_id' => $postData['event_id'],
            'ad_name' => $postData['ad_description'][$key],
            'maximum_ads' => $postData['ad_max_no'][$key],
            'local_rate' => $postData['ad_local_rate'][$key],
            'foreign_rate' => $postData['ad_foreign_rate'][$key],
          );
          $adzData[$key] = $tempData;
          $this->this_model->createAdvertisement($tempData);
        }
// #endregion

        $stallPlan = array(
          'event_id' => $postData['event_id'],
          'reg_open' => 1,
          'stall_plan' => '',
          'state' => 1,
        );

        if($eventInfo['status'])
        {
          $stallPlan['stall_plan'] = $uploadData['fileName'].'.'.pathinfo($_FILES['stall_plan']['name'], PATHINFO_EXTENSION);
          $this->this_model->updateEvent($stallPlan);
          
          echo json_encode(array("status" => TRUE, "msg" => "Event Information was Added Successfully. Please Wait..."));
        } else {
          $stallPlan['reg_open'] = 0;
          $this->this_model->updateEvent($stallPlan);
          
          $msg = "Cannot Update.";
          echo json_encode(array("status" => FALSE, "msg" => $msg));
        }
      }
    }

    public function update($eventId = NULL)
    {
      $task = $this->input->post('task');
      if(!isset($task)) {
        $data['pagetitle'] = "test Techno Update Event";

        $page = $this->session->userdata('page');
        $this->breadcrumb->add('Home', site_url('dashboard/'.$page));
        $this->breadcrumb->add('Techno Events', site_url('master/Techno_Event_Info'));
        $this->breadcrumb->add('Update', site_url());
        $data['breadcrumbs']=$this->breadcrumb->render();

        $this->index($eventId, $data);
      } else {
        $postData = $this->input->post();
        $eventState = true;
        // goto stalls;

        $eventData = array();
        if(($_FILES['stall_plan']) != ''){
          $uploadData = upload_file('uploads/techno', '_stall_plan_'.$postData['event_id'].'_'.date('Y_m_d__H_i_s'), 'stall_plan', 2048);
          if($uploadData['status'] == 0) {
            echo json_encode(array("status" => FALSE, "msg" => $uploadData['message']));
    
            return false;
          }
          $eventData += ['stall_plan' => $uploadData['fileName'].'.'.pathinfo($_FILES['stall_plan']['name'], PATHINFO_EXTENSION)];
        }

        // Collecting and Updating Data for Event Initiation table
        $eventData +=
        [ 'event_id' => $postData['event_id'],
          'exhibition_title' => $postData['event_title'],
          'year' => $postData['event_year'],
          'start_date' => $postData['event_date_from'],
          'end_date' => $postData['event_date_to'],
          'start_time' => $postData['event_time_from'],
          'end_time' => $postData['event_time_to'],
          'organized_by' => $postData['organized_by'],
          'venue' => $postData['venue'],
          'contact_person_name' => $postData['contact_person_name'],
          'contact_designation' => $postData['contact_person_designation'],
          'contact_tel' => $postData['event_contact_person_tp'],
          'contact_email' => $postData['contact_person_email'],
          'description' => $postData['event_description'],
        ];
        $eventState &= $this->this_model->updateEvent($eventData);

        stalls:
        // Collecting and storing Data for Event Initiation table
        $stallData = array();
        $stallNosCount = 0;
        foreach($postData['stall'] as $key=>$place){
          $tempData = array(
            'event_id' => $postData['event_id'],
            'stall_category_id' => $postData['stall_category'][$key],
            'sub_category_id' => $postData['sub_category'][$key],
            'No_of_stalls' => $postData['noOfStallNos'][$key],
            'is_ac' => $postData["is_ac"][$key],
            'local_rate' => $postData['stall_local_rate'][$key],
            'foreign_rate' => $postData['stall_foreign_rate'][$key],
          );
          if ($place == '') {
            $stallData[$key] = $tempData;
            $stallId = $this->stall_model->createStall($stallData[$key]);
          } else if ($place == '0' || $place == '1'){
            $tempData['state'] = $place;
            $tempData['techno_stall_id'] = $postData['stall_id'][$key];
            $stallData[$key] = $tempData;
            $eventState &= $this->stall_model->updateStall($stallData[$key]);
          } else {
            echo json_encode(array("status" => FALSE, "msg" => 'Error occured while updating stalls.'));
            return false;                
          }

          $newStallNos = array();
          // echo count($postData['stall_number']);
          for ($i=$stallNosCount; $i < $stallNosCount+$postData['noOfStallNos'][$key]; $i++) { 
            $tempNo = array(
              'techno_stalls_id' => isset($stallId)?$stallId:$postData['stall_id'][$key],
              'stall_number' => $postData['stall_number'][$i],
            );
            $state = $postData['stallNo'][$i];
            if($state == '') {
              array_push($newStallNos, $tempNo);
            } else if($state == '0' || $state == '1') {
              $tempNo['state'] = $state;
              $tempNo['techno_stall_no_id'] = $postData['stallNo_id'][$i];
              
              $this->stall_model->updateStallNumber($tempNo);
            } else {
              echo json_encode(array("status" => FALSE, "msg" => 'Error occured while updating stalls.'));
              return false;
            }
          }
          $stallNosCount += $postData['noOfStallNos'][$key];

          if(count($newStallNos)) {
            $this->stall_model->createStallNumbers($newStallNos);
          }
        }

        // Collecting and Storing Data for Extra Accessories
        $extraItemData = array();
        foreach($postData['extra_item'] as $key=>$item){
          $tempData = array(
            'event_id' => $postData['event_id'],
            "item_description" => $postData['extra_description'][$key],
            "local_rate" => $postData['extra_local_rate'][$key],
            "foreign_rate" => $postData['extra_foreign_rate'][$key],
          );
          switch ($item) {
            case '':
              $extraItemData[$key] = $tempData;
              $eventState &= $this->this_model->createExtraItem($extraItemData[$key]);
              break;
            case 0:
              $tempData['state'] = 0;
              $tempData['extra_acc_id'] = $postData['extra_id'][$key];
              $extraItemData[$key] = $tempData;
              $eventState &= $this->this_model->updateExtraItem($extraItemData[$key]);
              break;
            case 1:
              $tempData['extra_acc_id'] = $postData['extra_id'][$key];
              $extraItemData[$key] = $tempData;
              $eventState &= $this->this_model->updateExtraItem($extraItemData[$key]);
              break;
            default:
              break;
          }
        }
        
        // Collecting and Storing Data for Bare Space Items
        $bareItemData = array();
        foreach($postData['bare_item'] as $key=>$item){
          $tempData = array(
            'event_id' => $postData['event_id'],
            'item' => $postData['bare_space_item'][$key],
          );
          switch ($item) {
            case '':
              if(!isset($tempData['item']) || $tempData['item'] == ''){break;}
              $bareItemData[$key] = $tempData;
              $eventState &= $this->this_model->createBareItem($bareItemData[$key]);
              break;
            case '0':
              $tempData['state'] = 0;
              $tempData['bare_id'] = $postData['bare_id'][$key];
              $bareItemData[$key] = $tempData;
              $eventState &= $this->this_model->updateBareItem($bareItemData[$key]);
              break;
            case '1':
              // $tempData['state'] = 1;
              $tempData['bare_id'] = $postData['bare_id'][$key];
              $bareItemData[$key] = $tempData;
              $eventState &= $this->this_model->updateBareItem($bareItemData[$key]);
              break;
            default:
              break;
          }
        }

        // Collecting and storing data for advertisements
        $adzData = array();
        foreach ($postData['ad'] as $key => $ad) {
          $tempData = array(
            'event_id' => $postData['event_id'],
            'ad_name' => $postData['ad_description'][$key],
            'maximum_ads' => $postData['ad_max_no'][$key],
            'local_rate' => $postData['ad_local_rate'][$key],
            'foreign_rate' => $postData['ad_foreign_rate'][$key],
          );

          if($ad == '') {
            $adzData[$key] = $tempData;
            $this->this_model->createAdvertisement($tempData);
          } else if($ad == '0' || $ad == '1') {
            $tempData['state'] = $ad;
            $tempData['ad_id'] = $postData['ad_id'][$key];
            $adzData[$key] = $tempData;
            $state = $this->this_model->updateAdvertisement($tempData);
          }
        }

        if($eventState) {
          echo json_encode(array("status" => TRUE, "msg" => "Event Information was Updated Successfully. Please Wait..."));
        } else{
          $msg = "Cannot Update.";
          if(isset($error)){ $msg = $tempData['error']; }

          echo json_encode(array("status" => FALSE, "msg" => $msg));        
        }
      }
    }

// #region helper functions
    public function file_check($str) {
      $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
      $mime = get_mime_by_extension($_FILES['stall_plan']['name']);

      if(isset($_FILES['stall_plan']['name']) && $_FILES['stall_plan']['name']!="") {
        if(in_array($mime, $allowed_mime_type_arr)) {
          return true;
        } else {
          $this->form_validation->set_message('file_check', 'Please select only gif/jpg/png file.');
          return false;
        }
      } else {
        $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
        return false;
      }
    }
// #endregion
  }
?>
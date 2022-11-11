<?php

/**
 * Created by PhpStorm.
 * User: test
 * Date: 4/23/2018
 * Time: 12:43 PM
 */
//require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

/**
 * @return false|string
 * Purpose: get DATETIME value for database queries
 */
function getDateTime()
{
    return date('Y-m-d H:i:s');
}

/**
 * @return false|string
 * Purpose: get DATETIME value for namings as strings
 */
function getDateTimeOneString()
{
    echo date('Y-m-d-H-i-s');
    return true;
}

function incrementSequence($sqName)
{
    $CI = & get_instance();
    $CI->load->database();

    $incrementStatus = $CI->db->query("UPDATE system_sequences SET sequence_value = sequence_value + 1 WHERE sequence_name = '" . $sqName . "'");
    return $incrementStatus;
}

function getSequence($sqName)
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('sequence_value');
    $CI->db->where('sequence_name', $sqName);
    $CI->db->where('state', 1);
    $query = $CI->db->get('system_sequences');
    return $query->result_array();
}

function isStaff($user_id)
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('group_id');
    $CI->db->where('user_id', $user_id);
    $CI->db->where('status', 1);
    $query = $CI->db->get('users_groups');
    $user_groups = array_column($query->result_array(), 'group_id');
    $CI->db->reset_query();

    if ($user_groups) {
        $CI->db->select('is_admin');
        $CI->db->where_in('id', $user_groups);
        $query = $CI->db->get('groups');
        $user_permissions = array_column($query->result_array(), 'is_admin');

        if (in_array('2', $user_permissions)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function isMember($user_id)
{
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->select('group_id');
    $CI->db->where('user_id', $user_id);
    $CI->db->where('status', 1);
    $query = $CI->db->get('users_groups');
    $user_groups = array_column($query->result_array(), 'group_id');
    $CI->db->reset_query();

    if ($user_groups) {
        $CI->db->select('is_admin');
        $CI->db->where_in('id', $user_groups);
        $query = $CI->db->get('groups');
        $user_permissions = array_column($query->result_array(), 'is_admin');

        if (in_array('3', $user_permissions) || in_array('4', $user_permissions)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function fireEmailNotification($values)
{
    /* $values = array(
      'recipient' => '',
      'messageLong' => '',
      'messageShort' => '',
      'hyperlink' => '',
      'notificationCategory' => '',
      'notificationPriority' => '',
      'expirationDuration' => '',
      'notificationThumbnail' => '',

      'sendingAddress' => '',
      'receiverAddress' => '',
      'mailSubject' => '',
      'mailBody' => ''
      ); */

    $CI = & get_instance();
    $CI->load->library(array('Notify_service', 'Email_lib'));

    $CI->notify_service->fireNotification($values['recipient'], $values['messageLong'], $values['messageShort'], $values['hyperlink'], $values['notificationCategory'], $values['notificationPriority'], $values['expirationDuration'] = NULL, $values['notificationThumbnail'] = NULL);
    $CI->email_lib->sendEmail('test.pipl@gmail.com', $values['receiverAddress'], $values['mailSubject'], $values['mailBody']);
}

/**
 * @param $filter_staff_group
 * @param $intiatingUserId
 * @return mixed
 * Purpose: Fetch ids of staff users of given groups except for initiating user
 */
function getStaffMembersHelper($filter_staff_group, $intiatingUserId)
{
    $CI = & get_instance();
    $CI->load->model('Systemnotification_model');
    $users_of_group = $CI->Systemnotification_model->getStaffMembers($filter_staff_group);
    // remove this user form notification receivers
    if (($key = array_search($intiatingUserId, $users_of_group)) !== false) {
        unset($users_of_group[$key]);
    }
    return $users_of_group;
}

/**
 * @param $filter_staff_group
 * @param $intiatingUserId
 * @return mixed
 * Purpose: Fetch ids of staff users of given groups (all users)
 */
function getStaffMembersAllHelper($filter_staff_group)
{
    $CI = & get_instance();
    $CI->load->model('Systemnotification_model');
    $users_of_group = $CI->Systemnotification_model->getStaffMembers($filter_staff_group);

    return $users_of_group;
}

/**
 * 
 * @param type $fileName
 * @param type $membershipLetterContent
 * Purpose: Put PDF file to temp folder in server
 * Used for downloading applications
 */
function putPDFFileInDownloadFolder($folderName, $fileName, $membershipLetterContent)
{

    $dompdf = new Dompdf();
//    $dompdf->set_base_path(realpath(__DIR__ . '/../..'));
//    $dompdf->setPaper('a4', 'landscape');
    $dompdf->loadHtml($membershipLetterContent);
    $dompdf->render();
    $output = $dompdf->output();


    $returnValue = file_put_contents(realpath(__DIR__ . '/../..') . '/downloads/temp/' . $folderName . '/' . $fileName . '.pdf', $output);

    if ($returnValue === false) {
        return false;
    }
    return true;
}

/**
 * 
 * @param type $folderName
 * @param type $fileName
 * @param type $membershipLetterContent
 * @return boolean
 * Purpose: Put file in folder
 */
function putFileInDownloadFolder($orginalFilePath, $destinationFilePath)
{
    if (file_exists($orginalFilePath)) {
        if (copy($orginalFilePath, $destinationFilePath)) {
            return true;
        }
    }
    return false;
}

function zipDirectory($originalPath, $destinationPath)
{
    $zip = new ZipArchive();
//    $zip->open($destinationPath.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
    $zip->open($destinationPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($originalPath), RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file)
    {
        // Skip directories (they would be added automatically)
        if (!$file->isDir()) {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($originalPath) + 1);

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Zip archive will be created only after closing object
    $zip->close();
}

function deleteTempFolder()
{
    // before creating this zip, empty and downloads/zip/ directories
    $files2 = glob('downloads/zip/*'); // get all file names
    foreach ($files2 as $file)
    { // iterate files
        if (is_file($file)) {
            unlink($file); // delete file
        }
    }
    // before creating this zip, empty downloads/temp/ and directories
    $dir = 'downloads' . DIRECTORY_SEPARATOR . 'temp';
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file)
    {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
}

/**
 * 
 * @param type $input
 * @return type
 * Purpose: check if the input is an integer
 * 
 * var_dump(isInteger(23)); //bool(true)
 * var_dump(isInteger("23")); //bool(true)
 * var_dump(isInteger(23.5)); //bool(false)
 * var_dump(isInteger(NULL)); //bool(false)
 * var_dump(isInteger("")); //bool(false)
 */
function isInteger($input)
{
    return(ctype_digit(strval($input)));
}

function getUserEmails($user_ids)
{
    // fetching user emails
    $CI = & get_instance();
    $CI->db->select('email');
    $CI->db->from('users');
    $CI->db->where_in('id', $user_ids);
    $CI->db->where('email <> ', "");
    $CI->db->distinct();
    $query = $CI->db->get();
//print_r($CI->db->last_query());
//exit;
    return array_column($query->result_array(), 'email');
}

function getStaffEmails(){
    // fetching user emails
    $CI = & get_instance();
    $CI->db->select('email');
    $CI->db->from('users');
    $CI->db->where('users.is_admin = 2');
    $CI->db->where('email <> ', "");
    $CI->db->distinct();
    $query = $CI->db->get();
//print_r($CI->db->last_query());
//exit;
    return array_column($query->result_array(), 'email');
}

function getGroupIdFromUserId($user_ids)
{
    // fetching user emails
    $CI = & get_instance();
    $CI->db->select('users_groups.group_id');
    $CI->db->from('users');
    $CI->db->join('users_groups', 'users_groups.user_id = users.id', 'inner');
    $CI->db->where('users.id', $user_ids);

    $query = $CI->db->get();

    $ret = $query->row();
    return $ret->group_id;
//print_r($CI->db->last_query());
//exit;
}

function getBulkUserEmails($ids, $type,$member_status = null)
{
    $CI = & get_instance();

    $query = '';

    if($type == 1) {
        $CI->db->select('user_email');
        $CI->db->from('member_profile_data');
        $CI->db->where_in('user_member_class', $ids);
        $CI->db->where('user_email <> ', "");
        $query = $CI->db->get();
    } else if($type == 2) {
        $CI->db->select('user_email');
        $CI->db->from('member_profile_data');
        $CI->db->where_in('user_member_discipline', $ids);
        $CI->db->where('user_email <> ', "");
        $query = $CI->db->get();
    } else if($type == 3) {
        $CI->db->select('mpd.user_email');
        $CI->db->from('member_profile_data mpd');
        $CI->db->join('assign_members_to_group amtg', 'mpd.user_id = amtg.assigned_mem_id', 'inner');
        $CI->db->where_in('amtg.mem_group_id', $ids);
        $CI->db->where('mpd.user_email <> ', "");
        if($member_status != NULL){
          $CI->db->where('mpd.state', $member_status);  
        }
        
        $query = $CI->db->get();
    } else {
        $CI->db->select('user_email');
        $CI->db->from('member_profile_data');
        $CI->db->where_in('user_province', $ids);
        $CI->db->where('user_email <> ', "");
        $query = $CI->db->get(); 
    }

    return array_column($query->result_array(), 'user_email');
}


function getAllBulkUserEmails($member_category=null,$member_special_area=null,$memer_group_committee_chapter=null,$member_province=null,$member_status = null)
{
    $CI = & get_instance();

    $query = '';

        $CI->db->select('user_email');
        $CI->db->from('member_profile_data mpd');
        if($member_category !=null){
            $CI->db->where_in('mpd.user_member_class', $member_category);
        }
        if($member_special_area != null){
            $CI->db->where_in('mpd.user_member_discipline', $member_special_area);
        }
        if($member_province != null){
             $CI->db->where_in('mpd.user_province', $member_province);
        }
        if($memer_group_committee_chapter != null){
            $CI->db->join('assign_members_to_group amtg', 'mpd.user_id = amtg.assigned_mem_id', 'left');
            $CI->db->where_in('amtg.mem_group_id', $memer_group_committee_chapter);
            
        }
        if($member_status != null){
           $CI->db->where('mpd.state', $member_status);  
        }
        
        $CI->db->where('is_passed_away !=', "1");
        $CI->db->where('user_email !=', "");
       
        $query = $CI->db->get();

    return array_column($query->result_array(), 'user_email');
}



function getAllMemberEmails()
{
    $CI = & get_instance();

    $CI->db->select('DISTINCT(user_email)');
    $CI->db->from('member_profile_data');
    $CI->db->where('user_email <> ', "");
    $CI->db->where('is_passed_away !=', "1");
    $query = $CI->db->get();

    return array_column($query->result_array(), 'user_email');
}

function getAllMemberEmailsByStatus($status)
{
    $CI = & get_instance();

    $CI->db->select('DISTINCT(user_email)');
    $CI->db->from('member_profile_data');
    $CI->db->where('user_email <> ', "");
    $CI->db->where('is_passed_away !=', "1");
    $CI->db->where('state', $status);
    $query = $CI->db->get();

    return array_column($query->result_array(), 'user_email');
}

/**
 * created by test
 * date : 07/08/2019
 * 
 */
function getWildApricotNumber(){
    $CI = & get_instance();

    $CI->db->select('sequence_value');
    $CI->db->from('system_sequences');
    $CI->db->where('sequence_name', 'member_wild_apricot_number');
    $query = $CI->db->get();

    return $query->result()[0]->sequence_value;
}

function getGroupNameByID($group_id = 0){
    $CI = & get_instance();

    $CI->db->select("groups.name");
    $CI->db->from("groups");
    //// $CI->db->where("groups.is_admin", 2);
    $CI->db->where("groups.id",$group_id);
    $query =  $CI->db->get();
    $row = $query->row();
    return $row->name;
    
}

function getGroupIDByGroupName($group_name = ''){
    $CI = & get_instance();

    $CI->db->select("groups.id");
    $CI->db->from("groups");
    //// $CI->db->where("groups.is_admin", 2);
    $CI->db->where("groups.name",$group_name);
    $query =  $CI->db->get();
    $row = $query->row();
    return $row->id;
    
}


function OnlineIPGModal(){
    ?>
<style type="text/css">
    .modal-body.alignrecord img {
    width:  200px;
    height:  93px;
    object-fit:  contain;
}
.pay_btn {
    margin-right: 17px;
}
span.any_bank {
   
    font-weight: 700!important;
    color: #0072ff;
    font-size: 27px;
    text-shadow: 2px 1px #424145;
    
}

</style>
<div  class="modal" id="onlineipg" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div  class="modal-content">
      <div class="modal-header">

        <h4 align="center" class="modal-title">Please select one of the below options to pay online via <br /> Internet Payment Gateway. 
            <br /><span class="any_bank">Any bank (credit/debit) card is acceptable.</span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            <div class="form2msg" id='form2msg'></div>
      </div>
      <div  class="modal-body alignrecord">

        <p align="center">  <!-- <input class="btn btn-success " id="saveEventBtn" value="Pay Online" type="button" name="payonline"> -->
             <button type="button" onclick="goIPGBOC()" class="btn btn-default pay_btn"><img src="<?php echo site_url(); ?>assets/images/boc1.png"></button><button type="button" onclick="goIPGtest()"  class="btn btn-default pay_btn"><img src="<?php echo site_url(); ?>assets/images/sam1.png"></button></p>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    <?php
    
}
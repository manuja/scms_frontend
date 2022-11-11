<?php
/*
Developer - sandun
This library use for manage online payment.
*/

class CI_Payment_log_offline_outstanding
{

	public $user_id		= 0;
	public $group_id	= 17; //default public user
	public $master_table_name = "";
	public $master_table_record_id = 0;
	public $name = 0;
	public $member_ship_number='';
	public $address='';
	public $membership_class_id=0;
	public $nic='';
	public $email='';
	public $main_payment_category_id=0;
	public $description='';
	public $due_amount=0;

    public function __construct() {
    	

  				error_reporting(0);
    }


	public function OutstandingPaymentsPublic($master_table_name,$master_table_record_id,$payamount,$pay_recepy_req=0,$beneval_fund_req=0,$subscrip_amount_for_registration=0,$surcharge=0,$arrias=0)
	{	

		error_reporting(0);	

		//Load Time Zone
		date_default_timezone_set('Asia/Colombo');
		//Load CodeIgniter’s resources from externally
		$this->CI =& get_instance();
		//Returns your site URL, as specified in your config file.
		$this->CI->load->helper('url');
		//Sessions will typically run globally with each page load
		$this->CI->load->library('session');

		$this->CI->load->helper('finance');

		$this->CI->load->helper('master_tables');

	    




		//Get values from master table
	    $master_table_results=$this->getMasterTableResultsPublic($master_table_name,$master_table_record_id);

	    //Get User Id from session
	    $user_id=0;

		//Get Group Id using user id
		$group_id=17;




			//Member Name
			$name=$master_table_results->non_mem_name;

	    	//Member Address
	    	$address=$master_table_results->non_mem_address;

			//Member Member NIC
	    	$nic=$master_table_results->non_mem_nic;

			//Aplication Number
		    $member_ship_number='';






	    
	    //Member Member Class ID
	    $membership_class_id=0;

       if ($master_table_name=='event_member_registration') {
	    	$main_payment_category_id=4;
	    	$sub_payment_category_id=$master_table_results->non_member_sub_payment_category_id;
	    	$description=$master_table_results->event_title;
	    }


	    if ($master_table_name=='cpd_member_registration') {
	    	$main_payment_category_id=3;
	    	$sub_payment_category_id=$master_table_results->non_member_sub_payment_category_id;
	    	$description=$master_table_results->event_title;
	    }


	    if ($master_table_name=='elearning_registrations') {
	    	$main_payment_category_id=76;
	    	$sub_payment_category_id=$master_table_results->Nonmember_subpayment_id;
	    	$description=$master_table_results->Course_title;
	    }





	    //Payment Status still pending
	    $payment_status_id=0;


		//Total Amount
	    $due_amount=$payamount;

   		//Assign Date
	    $assign_date=date("Y-m-d");	

   		//Assign Time
		$assign_time=date("Y-m-d")." ".date("h:i:s");

		//State pending
		$state=0;



		//Check table exist row
		$countRecord=$this->CountRecords($master_table_name,$master_table_record_id);
		if($countRecord==0){
		//Insert registration details
		return $ResInsetDataPaymentLog = $this->InsertTransactionDetailsofPayment($name,$address, $nic, $member_ship_number, $main_payment_category_id, $membership_class_id, $due_amount,  $user_id, $group_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$sub_payment_category_id,$pay_recepy_req,$beneval_fund_req,$subscrip_amount_for_registration,$surcharge,$arrias);	
		}else{


			$ResUpdateDataPaymentLog = $this->UpdateTransactionDetailsofPayment($name,$address, $nic, $member_ship_number, $main_payment_category_id, $membership_class_id, $due_amount,  $user_id, $group_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$sub_payment_category_id,$pay_recepy_req,$beneval_fund_req,$subscrip_amount_for_registration,$surcharge,$arrias);	

			return $countRecord=$this->DashboardLogId($master_table_name,$master_table_record_id);
		}


		

	}



		public function getMasterTableResultsPublic($master_table_name='',$master_table_record_id=0){

		//Get Master Table Results
		$this->CI =& get_instance();
		$this->CI->load->database();

		if($master_table_name=='event_member_registration'){

			$this->CI->db->select('A.*,C.*');
			$this->CI->db->from('event_member_registration A');
			$this->CI->db->join('event_initiation C', 'C.event_initiation_id = A.event_initiation_id', 'INNER');
		    $this->CI->db->where('A.event_registration_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='cpd_member_registration'){

			$this->CI->db->select('A.*,C.*');
			$this->CI->db->from('cpd_member_registration A');
			$this->CI->db->join('cpd_initiation C', 'C.event_initiation_id = A.event_initiation_id', 'INNER');
		    $this->CI->db->where('A.event_registration_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}


		if($master_table_name=='elearning_registrations'){

			$this->CI->db->select('A.*,C.*');
			$this->CI->db->from('elearning_registrations A');
			$this->CI->db->join('elearning_courses C', 'C.Elearning_course_id = A.Elearning_course_id', 'INNER');
		    $this->CI->db->where('A.elearning_registration_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}


	      $this->CI->db->last_query();
		$row = $query->row();
		$query->free_result(); // The $query result object will no longer be available
		if(!empty($row)){
			return  $row;
		}else{
			return 0;
		}

	}



	public function CompletedPaymentUpdate($master_table_name,$master_table_record_id,$payamount)
	{
			$this->CI =& get_instance();
			$this->CI->load->database();

			  date_default_timezone_set('Asia/Colombo');
		      $assign_time=date("Y-m-d")." ".date("h:i:s");

		      $this->CI->load->library('session');
              $first_name=$this->CI->session->userdata('first_name');
              $last_name=$this->CI->session->userdata('last_name');

       

			$data1 = array(
			'cancel_remarks' => "Invoice updated and enabled for rest of the payment. Updated by".$first_name." ".$last_name." Updated Date is ".$assign_time,	
			'payment_status_id' =>  0,
			'payment_date' =>  '0000-00-00 00:00:00',
			);


			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->order_by('invoice_id', 'DESC');
 			$this->CI->db->limit(1);
		    $flag = $this->CI->db->update('invoices', $data1);

			$data2 = array(
			'state' =>  0,
			);


			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->order_by('payment_dashboard_id', 'DESC');
 			$this->CI->db->limit(1);
		    $flag = $this->CI->db->update('outstanding_payments', $data2);


			$this->OutstandingPayments($master_table_name,$master_table_record_id,$payamount);

	}	






	public function OutstandingPayments($master_table_name,$master_table_record_id,$payamount,$pay_recepy_req=0,$beneval_fund_req=0,$subscrip_amount_for_registration=0,$surcharge=0,$arrias=0)
	{	


		error_reporting(0);	

		//Load Time Zone
		date_default_timezone_set('Asia/Colombo');
		//Load CodeIgniter’s resources from externally
		$this->CI =& get_instance();
		//Returns your site URL, as specified in your config file.
		$this->CI->load->helper('url');
		//Sessions will typically run globally with each page load
		$this->CI->load->library('session');

		$this->CI->load->helper('finance');

	    



		//Get values from master table
	    $master_table_results=$this->getMasterTableResults($master_table_name,$master_table_record_id);


	    //Get User Id from session
	    $user_id=$master_table_results->user_id;

		//Get Group Id using user id
		$group_id=$this->getGroupID($user_id);


		if ($master_table_name=='training_org_recommendation') {

			//Member Name
			$name=$master_table_results->org_name;

			//Member Address
			$address=$master_table_results->org_address;

			//Member Member NIC
			$nic=' - ';

			//Aplication Number
			$member_ship_number=$master_table_results->reg_application_id;


		}else{

			if ($master_table_name=='user_registrations' || $master_table_name=='techeng_registrations' || $master_table_name=='directroute_registrations' || $master_table_name=='edu_de_application' || $master_table_name=='de_member_registrations'){

				//Aplication Number
				$member_ship_number=$master_table_results->reg_application_id;

			}else{

				//Member Member Ship Number
				$member_ship_number=$master_table_results->membership_number;

			}


			if($master_table_name=='edu_de_application'){

									//Member Name
					$name=$master_table_results->name_initials.' '.$master_table_results->name_lastname;

					//Member Address
					$address=$master_table_results->addr_line1. ' ,'.$master_table_results->addr_line2.' ,'.$master_table_results->addr_city;

								//Member Member NIC
					if($master_table_results->nic_old=='' || $master_table_results->nic_old==NULL){
						$nic=$master_table_results->nic;
					}else{
						$nic=$master_table_results->nic_old;
					}



			}else{

					//Member Name
					$name=$master_table_results->user_name_initials.' '.$master_table_results->user_name_lastname;


					//Member Address
					$address=$master_table_results->user_permanent_addr;

								//Member Member NIC
					if($master_table_results->user_nic_old=='' || $master_table_results->user_nic_old==NULL){
						$nic=$master_table_results->user_nic;
					}else{
						$nic=$master_table_results->user_nic_old;
					}

			}


		}

			if($master_table_name=='edu_de_application'){

	    //Member Member Class ID
	    $membership_class_id=$master_table_results->membership_class;
			}else{
					    //Member Member Class ID
	    $membership_class_id=$master_table_results->user_member_class;
			}


			if($master_table_name=='edu_exam_application'){
			//Member Name
			$name=$master_table_results->name_initials.' '.$master_table_results->name_lastname;
			$address=$master_table_results->address_line1. ' ,'.$master_table_results->address_line2.' ,'.$master_table_results->city;

			  $nic=$master_table_results->nic;
			  if($master_table_results->user_id>0){
			   $member_ship_number=$master_table_results->membership_number;
			   if($member_ship_number=='' || $member_ship_number==NULL){
			   		$member_ship_number=$master_table_results->index_no;
			   }
	           $membership_class_id=$master_table_results->user_member_class;
			   if($membership_class_id=='' || $membership_class_id==NULL){
			   		$membership_class_id=4;
			   }

	           	}else{
	           		$user_id=0;
	           		$member_ship_number=$master_table_results->index_no;
	           		$membership_class_id=4;
	           	}
			}



	    //Nomal registration category id is 1
	    if($master_table_name=='user_registrations'){
	    	$main_payment_category_id=1;
	    }else if($master_table_name=='b_paper_application'){
	    	$main_payment_category_id=5;
	    }else if ($master_table_name=='event_member_registration') {
	    	$main_payment_category_id=4;
	    }else if ($master_table_name=='cpd_member_registration') {
	    	$main_payment_category_id=3;
	    }else if ($master_table_name=='elearning_registrations') {
	    	$main_payment_category_id=76;
	    }else if ($master_table_name=='techeng_registrations') {
	    	$main_payment_category_id=30;
	    }else if ($master_table_name=='member_reinstatement') {
	    	$main_payment_category_id=29;
	    }else if ($master_table_name=='mem_transfer_registrations') {

			if($membership_class_id == '1' && $master_table_results->applied_member_class == '6' && $master_table_results->payment_iteration==0){ // Student applying for AMIE
			$main_payment_category_id = 31;
			}else if($membership_class_id == '1' && $master_table_results->applied_member_class == '7' && $master_table_results->payment_iteration==0){ // Student applying for AfiMIE
			$main_payment_category_id = 32;
			}else if($membership_class_id == '7' && $master_table_results->applied_member_class == '6' && $master_table_results->payment_iteration==0){ // Student applying for AfiMIE
			$main_payment_category_id = 36;
			}else if($membership_class_id == '6' && $master_table_results->applied_member_class == '8' && $master_table_results->payment_iteration==0){ // Student applying for AfiMIE
			$main_payment_category_id = 37;
			}else if($membership_class_id == '8' && $master_table_results->applied_member_class == '9' && $master_table_results->payment_iteration==0){ // Student applying for AfiMIE
			$main_payment_category_id = 38;
			}else if($membership_class_id == '8' && $master_table_results->applied_member_class == '11' && $master_table_results->payment_iteration==0){ // Student applying for AfiMIE
			$main_payment_category_id = 39;
			}else if($membership_class_id == '9' && $master_table_results->applied_member_class == '12' && $master_table_results->payment_iteration==0){ // Student applying for AfiMIE
			$main_payment_category_id = 40;
			}else if($membership_class_id == '8' && $master_table_results->applied_member_class == '9' && $master_table_results->payment_iteration==1){ // Student applying for AfiMIE
			$main_payment_category_id = 43;
			}else{
			$main_payment_category_id = 31;	
			}	   

	    }else if ($master_table_name=='pr_viva_application') {
	    	$main_payment_category_id=34;

	    }else if ($master_table_name=='training_org_recommendation') {

	    	$main_payment_category_id=33;

	    }else if ($master_table_name=='member_subscription') {

	    	$main_payment_category_id=2;
	    	
	    }else if ($master_table_name=='cdp_applications') {

	    	$main_payment_category_id=28;
	    	
	    }else if ($master_table_name=='directroute_registrations') {

	    	$main_payment_category_id=42;
	    	
	    }else if ($master_table_name=='adjudicator_application' || $master_table_name=='ceo_building_services_application' || $master_table_name=='structural_engineers_application' || $master_table_name=='adjudicator_application_publication' || $master_table_name=='ceo_building_services_application_publication' || $master_table_name=='structural_engineers_application_publication' || $master_table_name=='adjudicator_and_arbitrator_application' || $master_table_name=='adjudicator_and_arbitrator_application_publication') {

	    	if($master_table_results->application_fee==0){
	    		$main_payment_category_id=44;
	    	}else{
	    		$main_payment_category_id=45;
	    	}	    	
	    	
	    }else if ($master_table_name=='edu_de_application') {

	    	$main_payment_category_id=60;
	    	
	    }else if ($master_table_name=='member_fund_payment') {

	    	$main_payment_category_id=61;
	    	
	    }else if ($master_table_name=='member_recover') {

	    	$main_payment_category_id=62;
	    	
	    }else if ($master_table_name=='edu_exam_application') {

	    	$main_payment_category_id=71;
	    	
	    }else if ($master_table_name=='member_wallet_logs') {

	    	$main_payment_category_id=72;
	    	
	    }else if ($master_table_name=='ecsl_member') {

	    	$main_payment_category_id=73;
	    	
	    }else if ($master_table_name=='pe_data') {

	    	$main_payment_category_id=74;
	    	
	    }else if ($master_table_name=='de_member_registrations') {

	    	$main_payment_category_id=75;
	    	
	    }






	    if ($master_table_name=='event_member_registration') {

	    	if($master_table_results->is_member_category==1){

	    		$CategoryDetails= getEventCategoryDetails($master_table_results->event_initiation_id,$master_table_results->user_member_class);

	    		$sub_payment_category_id=$CategoryDetails[0]->sub_payment_category_id;


	    	}else{

	    		$sub_payment_category_id=$master_table_results->member_sub_payment_category_id;
	    	}
	    	


	    	$description=$master_table_results->event_title;


	    }else if($master_table_name=='cpd_member_registration'){
	    	$sub_payment_category_id=$master_table_results->member_sub_payment_category_id;
	    	$description=$master_table_results->event_title;

        }else if($master_table_name=='elearning_registrations'){
	    	$sub_payment_category_id=$master_table_results->Member_subpayment_id;
	    	$description=$master_table_results->Course_title;

        }else if($master_table_name=='b_paper_application'){

			$sub_payment_category_id=$master_table_results->sub_payment_cat_id;
			$description=$master_table_results->b_paper_batch_title;

        }else if($master_table_name=='pr_viva_application'){

			$sub_payment_category_id=$master_table_results->sub_payment_cat_id;
			$description=$master_table_results->pr_viva_batch_title;

        }else if($master_table_name=='adjudicator_application' || $master_table_name=='ceo_building_services_application' || $master_table_name=='structural_engineers_application' || $master_table_name=='adjudicator_application_publication' || $master_table_name=='ceo_building_services_application_publication' || $master_table_name=='structural_engineers_application_publication' || $master_table_name=='adjudicator_and_arbitrator_application' || $master_table_name=='adjudicator_and_arbitrator_application_publication'){

        	if($master_table_results->application_fee==0 && $master_table_results->new_or_count==0){

        		$sub_payment_category_id=$master_table_results->sub_cat_new_reg;
        		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$description=$desres[0]->user_defined_sub_payment_category;


        	}else if($master_table_results->application_fee==0 && $master_table_results->new_or_count==1){
				$sub_payment_category_id=$master_table_results->sub_cat_cont_reg;
        		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$description=$desres[0]->user_defined_sub_payment_category;

        	}else if($master_table_results->application_fee==2 && $master_table_results->new_or_count==0){

        		$sub_payment_category_id=$master_table_results->sub_cat_new_pub;
        		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$description=$desres[0]->user_defined_sub_payment_category;

        	}else if($master_table_results->application_fee==2 && $master_table_results->new_or_count==1){

        		$sub_payment_category_id=$master_table_results->sub_cat_cont_pub;
        		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$description=$desres[0]->user_defined_sub_payment_category;

        	}
        	

        }else if($master_table_name=='member_fund_payment'){

			$sub_payment_category_id=$master_table_results->sub_payment_category_id;
			$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$description=$desres[0]->user_defined_sub_payment_category;

        }else{

	    //get payment details
	    $master_sub_payment_results=$this->getSubPaymentDetails($membership_class_id,$main_payment_category_id);
	     // Sub Payment Category
	    $sub_payment_category_id=$master_sub_payment_results->sub_payment_category_id;
	    //Payment description
	    $description=$master_sub_payment_results->main_payment_category;

	    	   if($master_table_results->special_status_subscription==10){


			    		$sub_payment_category_id=$master_table_results->sub_payment_category_id;
			    		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        				$description=$desres[0]->user_defined_sub_payment_category;	

        					    		
			    }

	    
	    }



	    //Payment Status still pending
	    $payment_status_id=0;


		//Total Amount
	    $due_amount=$payamount;

   		//Assign Date
	    $assign_date=date("Y-m-d");	

   		//Assign Time
		$assign_time=date("Y-m-d")." ".date("h:i:s");

		//State pending
		$state=0;


		if($master_table_name=='adjudicator_application_publication'){
			$master_table_name='adjudicator_application';
		}else if($master_table_name=='ceo_building_services_application_publication'){
			$master_table_name='ceo_building_services_application';
		}else if($master_table_name=='structural_engineers_application_publication'){
			$master_table_name='structural_engineers_application';
		}else if($master_table_name=='adjudicator_and_arbitrator_application_publication'){
			$master_table_name='adjudicator_and_arbitrator_application';
		}


		//Check table exist row
		$countRecord=$this->CountRecords($master_table_name,$master_table_record_id);
		if($countRecord==0){


		//Insert registration details
		return $ResInsetDataPaymentLog = $this->InsertTransactionDetailsofPayment($name,$address, $nic, $member_ship_number, $main_payment_category_id, $membership_class_id, $due_amount,  $user_id, $group_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$sub_payment_category_id,$pay_recepy_req,$beneval_fund_req,$subscrip_amount_for_registration,$surcharge,$arrias);	
		}else{


			$ResUpdateDataPaymentLog = $this->UpdateTransactionDetailsofPayment($name,$address, $nic, $member_ship_number, $main_payment_category_id, $membership_class_id, $due_amount,  $user_id, $group_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$sub_payment_category_id,$pay_recepy_req,$beneval_fund_req,$subscrip_amount_for_registration,$surcharge,$arrias);	

			return $countRecord=$this->DashboardLogId($master_table_name,$master_table_record_id);
		}




	}

	public function DashboardLogId($master_table_name,$master_table_record_id){
		//Check already register member
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('*');
		$this->CI->db->from('outstanding_payments');
		$this->CI->db->where('master_table_name', $master_table_name);
		$this->CI->db->where('master_table_record_id', $master_table_record_id);
		$this->CI->db->order_by('payment_dashboard_id', 'DESC');
 		$this->CI->db->limit(1);
		//$this->CI->db->where('state', 0);
		  $num_results = $this->CI->db->get()->row();
		return $num_results->payment_dashboard_id;


	}


	public function CountRecords($master_table_name,$master_table_record_id){
		//Check already register member
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('*');
		$this->CI->db->from('outstanding_payments');
		$this->CI->db->where('master_table_name', $master_table_name);
		$this->CI->db->where('master_table_record_id', $master_table_record_id);
		$this->CI->db->where('state', 0);
		return  $num_results = $this->CI->db->count_all_results();


	}


	   function getInvoiceID($master_table_name,$master_table_record_id){

        $this->CI->db->select('invoice_id');
        $this->CI->db->from('invoices');
        $this->CI->db->where('master_table_name', $master_table_name);
        $this->CI->db->where('master_table_record_id', $master_table_record_id);
        $this->CI->db->order_by('invoice_id', 'DESC');
 		$this->CI->db->limit(1);
        return $this->CI->db->get()->row()->invoice_id;
    }

	public function UpdateTransactionDetailsofPayment($name,$address, $nic, $member_ship_number, $main_payment_category_id, $membership_class_id, $due_amount,  $user_id, $group_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$sub_payment_category_id,$pay_recepy_req,$beneval_fund_req,$subscrip_amount_for_registration,$surcharge,$arrias){



		if($beneval_fund_req==1){
			$beneval_fund_amount=getFundAmount($master_table_record_id);
		}else{
			$beneval_fund_amount=0;
		}

		   $this->CI =& get_instance();
			$this->CI->load->database();

			$this->CI->db->trans_start();

			if($main_payment_category_id==2 || $main_payment_category_id==73){

					$array = array(
					'name' => $name,
					'address' => $address,
					'nic' => $nic,
					'member_ship_number' => $member_ship_number,
					'main_payment_category_id' => $main_payment_category_id,
					/*'sub_payment_category_id' => $sub_payment_category_id,*/
					'membership_class_id' => $membership_class_id,
					'due_amount'=> $due_amount,
					'subscrip_amount_for_registration'=> $subscrip_amount_for_registration,
					'surcharge'=> $surcharge,
					'arrias'=> $arrias,
					'user_id' => $user_id,
					'group_id' => $group_id,
					/*'description' => $description,*/
					'pay_recept_required'=> $pay_recepy_req,
					'beneval_fund_req'=> $beneval_fund_req,
					'beneval_fund_amount'=> $beneval_fund_amount,
					/*'assign_date' => $assign_date,
					'assign_time' => $assign_time,*/
					'state' => $state
					);

			}else{

					$array = array(
					'name' => $name,
					'address' => $address,
					'nic' => $nic,
					'member_ship_number' => $member_ship_number,
					'main_payment_category_id' => $main_payment_category_id,
					'sub_payment_category_id' => $sub_payment_category_id,
					'membership_class_id' => $membership_class_id,
					'due_amount'=> $due_amount,
					'subscrip_amount_for_registration'=> $subscrip_amount_for_registration,
					'surcharge'=> $surcharge,
					'arrias'=> $arrias,
					'user_id' => $user_id,
					'group_id' => $group_id,
					'description' => $description,
					'pay_recept_required'=> $pay_recepy_req,
					'beneval_fund_req'=> $beneval_fund_req,
					'beneval_fund_amount'=> $beneval_fund_amount,
					/*'assign_date' => $assign_date,
					'assign_time' => $assign_time,*/
					'state' => $state
					);

			}



			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->where('state', 0);
			$flag = $this->CI->db->update('outstanding_payments', $array);


			if($subscrip_amount_for_registration>0){
				$is_subscrip_for_reg=1;
			}else{
				$is_subscrip_for_reg=0;
			}

			if($surcharge>0){
				$is_surcharge=1;
			}else{
				$is_surcharge=0;
			}

			if($arrias>0){
				$is_arrias=1;
			}else{
				$is_arrias=0;
			}


			if($main_payment_category_id==2 || $main_payment_category_id==73){

					$array2 = array(
					'name' => $name,
					'address' => $address,
					'nic' => $nic,
					'member_ship_number' => $member_ship_number,
					'main_payment_category_id' => $main_payment_category_id,
					/*'sub_payment_category_id' => $sub_payment_category_id,*/
					'membership_class_id' => $membership_class_id,
					'amount'=> $due_amount,
					'user_id' => $user_id,
					/*'description' => $description,*/
					/*'invoice_date' => $assign_date,
					'invoice_date_time' => $assign_time,*/
					'beneval_fund_req'=> $beneval_fund_req,
					'beneval_fund_amount'=> $beneval_fund_amount,
					'is_subscrip_for_reg'=> $is_subscrip_for_reg,
					'is_surcharge'=> $is_surcharge,
					'is_arrias'=> $is_arrias,
					'state' =>1
					);

			}else{

					$array2 = array(
					'name' => $name,
					'address' => $address,
					'nic' => $nic,
					'member_ship_number' => $member_ship_number,
					'main_payment_category_id' => $main_payment_category_id,
					'sub_payment_category_id' => $sub_payment_category_id,
					'membership_class_id' => $membership_class_id,
					'amount'=> $due_amount,
					'user_id' => $user_id,
					'description' => $description,
				/*	'invoice_date' => $assign_date,
					'invoice_date_time' => $assign_time,*/
					'beneval_fund_req'=> $beneval_fund_req,
					'beneval_fund_amount'=> $beneval_fund_amount,
					'is_subscrip_for_reg'=> $is_subscrip_for_reg,
					'is_surcharge'=> $is_surcharge,
					'is_arrias'=> $is_arrias,
					'state' =>1
					);

			}




			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->where('payment_status_id', 0);
			$this->CI->db->update('invoices', $array2);

			if($is_subscrip_for_reg==1){

				$registrationfinalamount=$due_amount-$subscrip_amount_for_registration-$surcharge-$arrias;




				$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id,$registrationfinalamount,$is_subscrip_for_reg,$user_id,1);

				$sub_payment_category_id_subs=$this->GetSubpymentCatID($membership_class_id,2);

				$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id_subs,$subscrip_amount_for_registration,$is_subscrip_for_reg,$user_id,2);


				if($is_surcharge==1){

					//Insert surcharge details of reinstatement
					$sub_payment_category_id_surchrge=$this->GetSubpymentCatID($membership_class_id,63);			
					$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id_surchrge,$surcharge,$is_subscrip_for_reg,$user_id,3);

				  }	

				  	if($is_arrias==1){

					//Insert arrias details of reinstatement
					//$sub_payment_category_id_arrias=$this->GetSubpymentCatID($membership_class_id,64);	
					$sub_payment_category_id_subs=$this->GetSubpymentCatID($membership_class_id,2);			
					$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id_subs,$arrias,$is_subscrip_for_reg,$user_id,4);

				  }




			}else{



						if($main_payment_category_id==4 || $main_payment_category_id==3){



							if($main_payment_category_id==4){

								 $totalguest=$this->getNumberofGest($master_table_record_id);

							}else if($main_payment_category_id==3){
								$totalguest=$this->getNumberofGestCPD($master_table_record_id);
							}
														 
						
							if($totalguest>0){

							if($main_payment_category_id==4){

								 $gestsubpaycat_array=$this->GetSubpymentCatIDEventRegisterGuest($master_table_record_id);

							}else if($main_payment_category_id==3){
								$gestsubpaycat_array=$this->GetSubpymentCatIDCPDRegisterGuest($master_table_record_id);
							}

								

								$gestsubpaycat=$gestsubpaycat_array[0]->sub_payment_category_id;

								if($gestsubpaycat_array[0]->is_tax_enable_guest==3){
								 $gestsamounts=$gestsubpaycat_array[0]->event_participant_gest_fee_with_tax*$totalguest;

								}else{
								$gestsamounts=$gestsubpaycat_array[0]->event_participant_gest_fee*$totalguest;
								}


								

								//Insert guest details
								$checkguestrecord=$this->CheckGuestRecord($master_table_name,$master_table_record_id,$gestsubpaycat);

								if($checkguestrecord>0){


									//update guest
									$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$gestsubpaycat,$gestsamounts,$is_subscrip_for_reg,$user_id,0,$totalguest);

								}else{


								//Insert guest details
									$invoice_id=$this->getInvoiceID($master_table_name,$master_table_record_id);
								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$gestsubpaycat,$gestsamounts,$is_subscrip_for_reg,$user_id,0,$totalguest);
								}

								

								//Insert member details 
								 
								 $memberamount=$due_amount-$gestsamounts;
								$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id,$memberamount,$is_subscrip_for_reg,$user_id,0);


									
							}else{



								//Insert member details 
								$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount,$is_subscrip_for_reg,$user_id,0);


								//remove guest record
							if($main_payment_category_id==4){

								 $gestsubpaycat_array=$this->GetSubpymentCatIDEventRegisterGuest($master_table_record_id);

							}else if($main_payment_category_id==3){
								$gestsubpaycat_array=$this->GetSubpymentCatIDCPDRegisterGuest($master_table_record_id);
							}
								

								$gestsubpaycat=$gestsubpaycat_array[0]->sub_payment_category_id;	 
								$this->Removerecordinvoicerelatedtax($master_table_name,$master_table_record_id,$gestsubpaycat);

							}
						}else if($main_payment_category_id==33){

							$totaldicipline=$this->getNumberofTrainingOrganizationDicipline($master_table_record_id);

							$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount-$beneval_fund_amount,$is_subscrip_for_reg,$user_id,0,$totaldicipline);



						}else if($main_payment_category_id==71){

							$invoice_id=$this->getInvoiceID($master_table_name,$master_table_record_id);

							$this->RemoverecordinvoicerelatedtaxbyInvoiceID($invoice_id);


							$master_table_results=$this->getMasterTableResults($master_table_name,$master_table_record_id);

							

							$subject_results=$this->getSubjectofExamApplication($master_table_record_id,$master_table_results->exam_id);
							$subamounttot=0;
							foreach ($subject_results as $key => $value) {

								$sub1_results=$this->getPaymentAmountByMemSUBCat($value->sub_payment_category_id);
								if($sub1_results[0]->is_tax_enable==1){
									$subamount=$sub1_results[0]->amount_with_tax;
								}else{
									$subamount=$sub1_results[0]->amount;
								}

								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$value->sub_payment_category_id,$subamount,$is_subscrip_for_reg,$user_id,0);


								$subamounttot+=$subamount;
							}
							
							$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount-$subamounttot,$is_subscrip_for_reg,$user_id,0);

							



						}else if($master_table_name=="ceo_building_services_application"){

							$totalCategoryceo=$this->getCeoBuildingSpecialistArea($master_table_record_id);


							$master_table_results=$this->getMasterTableResults($master_table_name,$master_table_record_id);

							if($master_table_results->new_or_count==0){

								$getdefaultcatamount=$master_table_results->new_no_of_categories; 
								$getamountextra=$master_table_results->new_amount_for_extra_category;
								$subpaycatceo=$master_table_results->sub_cat_new_extra;

							}else{
								$getdefaultcatamount=$master_table_results->con_no_of_categories; 
								$getamountextra=$master_table_results->con_amount_for_extra_category;
								$subpaycatceo=$master_table_results->sub_cat_cont_extra;
							}

							//extra category amount
							$extracatamount=0;
							$extracatcount=$totalCategoryceo-$getdefaultcatamount;
							$extracatamount=$extracatcount*$getamountextra;

							
							$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount-$extracatamount,$is_subscrip_for_reg,$user_id,0);

							if($extracatamount>0){
								$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$subpaycatceo,$extracatamount,$is_subscrip_for_reg,$user_id,0,$extracatcount);
							}

							



						}else{



							if($beneval_fund_req==1){

								$beneval_fund_amount=getFundAmount($master_table_record_id);
								$sub_payment_category_id_fund=$this->GetSubpymentCatID($membership_class_id,61);


								$checkbenualfundrecord=$this->CheckGuestRecord($master_table_name,$master_table_record_id,$sub_payment_category_id_fund);

								if($checkbenualfundrecord>0){

						    	//benual fund update
								$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id_fund,$beneval_fund_amount,$is_subscrip_for_reg,$user_id,0);

								}else{
									$invoice_id=$this->getInvoiceID($master_table_name,$master_table_record_id);
									$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id_fund,$beneval_fund_amount,$is_subscrip_for_reg,$user_id,0);

								}






									//is not event and not subscription payments
									$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount-$beneval_fund_amount,$is_subscrip_for_reg,$user_id,0);


								}else{

								//is not event and not subscription payments
								$this->UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount,$is_subscrip_for_reg,$user_id,0);

									if($master_table_name=='member_subscription'){

								//remove benual fund record
								$sub_payment_category_id_fund=$this->GetSubpymentCatID($membership_class_id,61);	 
								$this->Removerecordinvoicerelatedtax($master_table_name,$master_table_record_id,$sub_payment_category_id_fund);

									}


								}



						}




			}

/*			if($main_payment_category_id==4){
				$totalguest=$this->getNumberofGest($master_table_record_id);
				if($totalguest>0){
				  $gestsubpaycat=$this->GetSubpymentCatIDEventRegisterGuest($master_table_record_id);
				   $gestsubpaycat=$gestsubpaycat[0]->sub_payment_category_id;
				  $this->UpdateTaxDetails($master_table_name,$master_table_record_id,$gestsubpaycat,$due_amount,$is_subscrip_for_reg,$user_id,0);
				}
			}*/



			       $this->CI->db->trans_complete();

			return $flag;

	

			//$this->CI->where('master_table_name', $master_table_name);
			//$this->CI->where('master_table_record_id', $master_table_record_id);
			//$this->CI->update('outstanding_payments', $array);

	}


	public function InsertTransactionDetailsofPayment($name,$address, $nic, $member_ship_number, $main_payment_category_id, $membership_class_id, $due_amount,  $user_id, $group_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$sub_payment_category_id,$pay_recepy_req,$beneval_fund_req,$subscrip_amount_for_registration,$surcharge,$arrias){


		//insert payment details

		if($beneval_fund_req==1){
			$beneval_fund_amount=getFundAmount($master_table_record_id);
		}else{
			$beneval_fund_amount=0;
		}

		

			$this->CI =& get_instance();
			$this->CI->load->database();

			$this->CI->db->trans_start();

			$array = array(
			'name' => $name,
			'address' => $address,
			'nic' => $nic,
			'member_ship_number' => $member_ship_number,
			'main_payment_category_id' => $main_payment_category_id,
			'sub_payment_category_id' => $sub_payment_category_id,
			'membership_class_id' => $membership_class_id,
			'due_amount'=> $due_amount,
			'subscrip_amount_for_registration'=> $subscrip_amount_for_registration,
			'surcharge'=> $surcharge,
			'arrias'=> $arrias,
			'user_id' => $user_id,
			'group_id' => $group_id,
			'description' => $description,
			'master_table_name' => $master_table_name,
			'master_table_record_id' => $master_table_record_id,
			'pay_recept_required'=> $pay_recepy_req,
			'beneval_fund_req'=> $beneval_fund_req,
			'beneval_fund_amount'=> $beneval_fund_amount,
			'assign_date' => $assign_date,
			'assign_time' => $assign_time,
			'state' => $state

			);

			$this->CI->db->set($array);
			$this->CI->db->insert('outstanding_payments');
			$insert_id = $this->CI->db->insert_id();


			if($subscrip_amount_for_registration>0){
				$is_subscrip_for_reg=1;
			}else{
				$is_subscrip_for_reg=0;
			}

			if($surcharge>0){
				$is_surcharge=1;
			}else{
				$is_surcharge=0;
			}

			if($arrias>0){
				$is_arrias=1;
			}else{
				$is_arrias=0;
			}



			$array2 = array(				
			'payment_dashboard_id' => $insert_id,
			'master_table_name' => $master_table_name,
			'master_table_record_id' => $master_table_record_id,
			'name' => $name,
			'address' => $address,
			'nic' => $nic,
			'member_ship_number' => $member_ship_number,
			'main_payment_category_id' => $main_payment_category_id,
			'sub_payment_category_id' => $sub_payment_category_id,
			'membership_class_id' => $membership_class_id,
			'amount'=> $due_amount,
			'description' => $description,
			'user_id' => $user_id,
			'invoice_date' => $assign_date,
			'invoice_date_time' => $assign_time,
			'beneval_fund_req'=> $beneval_fund_req,
			'beneval_fund_amount'=> $beneval_fund_amount,
			'is_subscrip_for_reg'=> $is_subscrip_for_reg,
			'is_surcharge'=> $is_surcharge,
			'is_arrias'=> $is_arrias,
			'state' =>1

			);

			$this->CI->db->set($array2);
			$this->CI->db->insert('invoices');
			$invoice_id = $this->CI->db->insert_id();


		


			if($is_subscrip_for_reg==1){




				$registrationfinalamount=$due_amount-$subscrip_amount_for_registration-$surcharge-$arrias;
				//Insert member details of registration
				$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$registrationfinalamount,$is_subscrip_for_reg,$user_id,1);


				$sub_payment_category_id_subs=$this->GetSubpymentCatID($membership_class_id,2);
				//Insert member details of subscription
				$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id_subs,$subscrip_amount_for_registration,$is_subscrip_for_reg,$user_id,2);



				if($is_surcharge==1){
					//Insert surcharge details of reinstatement
					$sub_payment_category_id_surchrge=$this->GetSubpymentCatID($membership_class_id,63);
					$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id_surchrge,$surcharge,$is_subscrip_for_reg,$user_id,3);

				  }	
				  	if($is_arrias==1){
					//Insert arrias details of reinstatement
					//$sub_payment_category_id_arrias=$this->GetSubpymentCatID($membership_class_id,64);


				  	$sub_payment_category_id_subs=$this->GetSubpymentCatID($membership_class_id,2);	


					$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id_subs,$arrias,$is_subscrip_for_reg,$user_id,4);

				  }	


			}else{



						if($main_payment_category_id==4 || $main_payment_category_id==3){



							if($main_payment_category_id==4){

								 $totalguest=$this->getNumberofGest($master_table_record_id);

							}else if($main_payment_category_id==3){
								$totalguest=$this->getNumberofGestCPD($master_table_record_id);
							}



							if($totalguest>0){


							if($main_payment_category_id==4){

								 $gestsubpaycat_array=$this->GetSubpymentCatIDEventRegisterGuest($master_table_record_id);

							}else if($main_payment_category_id==3){
								$gestsubpaycat_array=$this->GetSubpymentCatIDCPDRegisterGuest($master_table_record_id);
							}


								$gestsubpaycat=$gestsubpaycat_array[0]->sub_payment_category_id;

								if($gestsubpaycat_array[0]->is_tax_enable_guest==3){
								$gestsamounts=$gestsubpaycat_array[0]->event_participant_gest_fee_with_tax*$totalguest;
								}else{
								$gestsamounts=$gestsubpaycat_array[0]->event_participant_gest_fee*$totalguest;
								}

								//Insert guest details
								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$gestsubpaycat,$gestsamounts,$is_subscrip_for_reg,$user_id,0,$totalguest);

								//Insert member details 
								$memberamount=$due_amount-$gestsamounts;
								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$memberamount,$is_subscrip_for_reg,$user_id,0);
							}else{



								//Insert member details 
								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount,$is_subscrip_for_reg,$user_id,0);

							}

						}else if($main_payment_category_id==33){

							$totaldicipline=$this->getNumberofTrainingOrganizationDicipline($master_table_record_id);

							$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount,$is_subscrip_for_reg,$user_id,0,$totaldicipline);



						}else if($main_payment_category_id==71){
							$master_table_results=$this->getMasterTableResults($master_table_name,$master_table_record_id);

							

							$subject_results=$this->getSubjectofExamApplication($master_table_record_id,$master_table_results->exam_id);
							$subamounttot=0;
							foreach ($subject_results as $key => $value) {

								$sub1_results=$this->getPaymentAmountByMemSUBCat($value->sub_payment_category_id);
								if($sub1_results[0]->is_tax_enable==1){
									$subamount=$sub1_results[0]->amount_with_tax;
								}else{
									$subamount=$sub1_results[0]->amount;
								}

								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$value->sub_payment_category_id,$subamount,$is_subscrip_for_reg,$user_id,0);


								$subamounttot+=$subamount;
							}
							

							$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount-$subamounttot,$is_subscrip_for_reg,$user_id,0);

							



						}else if($master_table_name=="ceo_building_services_application"){

							$totalCategoryceo=$this->getCeoBuildingSpecialistArea($master_table_record_id);


							$master_table_results=$this->getMasterTableResults($master_table_name,$master_table_record_id);

							if($master_table_results->new_or_count==0){

								$getdefaultcatamount=$master_table_results->new_no_of_categories; 
								$getamountextra=$master_table_results->new_amount_for_extra_category;
								$subpaycatceo=$master_table_results->sub_cat_new_extra;

							}else{
								$getdefaultcatamount=$master_table_results->con_no_of_categories; 
								$getamountextra=$master_table_results->con_amount_for_extra_category;
								$subpaycatceo=$master_table_results->sub_cat_cont_extra;
							}

							//extra category amount
							$extracatamount=0;
							$extracatcount=$totalCategoryceo-$getdefaultcatamount;
							$extracatamount=$extracatcount*$getamountextra;

							
							$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount-$extracatamount,$is_subscrip_for_reg,$user_id,0);

							if($extracatamount>0){
								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$subpaycatceo,$extracatamount,$is_subscrip_for_reg,$user_id,0,$extracatcount);
							}

							



						}else{


							

								if($beneval_fund_req==1){

								$beneval_fund_amount=getFundAmount($master_table_record_id);
								$sub_payment_category_id_fund=$this->GetSubpymentCatID($membership_class_id,61);
								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id_fund,$beneval_fund_amount,$is_subscrip_for_reg,$user_id,0);

								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount-$beneval_fund_amount,$is_subscrip_for_reg,$user_id,0);


								}else{

										//is not event and not subscription payments
								$this->InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount,$is_subscrip_for_reg,$user_id,0);
								}
						}

				
			}



			//Reinstatement_wallet
			if($main_payment_category_id==29){


				$this->CI->load->model('Member_subscription_model','',TRUE);

				$wallet_ballance=$this->CI->Member_subscription_model->getWalletAmount($user_id)->wallet_ballance;

					if($wallet_ballance>0){

				 if($wallet_ballance>$arrias){
				 		$wallet_ballance=$wallet_ballance-$arrias;

				 		$arrias=0;
				 		$subscription=$subscrip_amount_for_registration-$wallet_ballance;
	
				        


				   }else{

				   	$arrias=$arrias-$wallet_ballance;
				   	$subscription=$subscrip_amount_for_registration;


				   

				   }


					   if($arrias>0){

			          $invoice_related_taxes_arrias=$this->getInvoiceRelatedTaxResults($invoice_id,64);


						if($invoice_related_taxes_arrias[0]->is_tax_enable==1){

						if($invoice_related_taxes_arrias[0]->vat_amount>0){

						$vatamount=$this->CalculateVatGivenAmount($arrias,$invoice_related_taxes_arrias[0]->vat_presentage);

						}else{
						$vatamount=0;
						}

						if($invoice_related_taxes_arrias[0]->nbt_amount>0){

						$nbtamount=$this->CalculateNbtGivenAmount($arrias,$invoice_related_taxes_arrias[0]->nbt_presentage,$vatamount);

						}else{
						$nbtamount=0;
						} 

						$item_amount=$arrias-$vatamount-$nbtamount;

				   	  $this->insertInvoiceRelatedTaxesAdvanceReinstatement($invoice_id,$invoice_related_taxes_arrias[0]->master_table_name,$invoice_related_taxes_arrias[0]->master_table_record_id,$item_amount,$arrias,$nbtamount,$vatamount,$invoice_related_taxes_arrias[0]->is_tax_enable,$invoice_related_taxes_arrias[0]->nbt_presentage,$invoice_related_taxes_arrias[0]->vat_presentage,$is_subscrip_for_reg,4,$invoice_related_taxes_arrias[0]->main_payment_category_id,$invoice_related_taxes_arrias[0]->sub_payment_category_id,0,0,$user_id);




						}else{
							$nbtamount=0;
							$vatamount=0;
							$item_amount=$arrias;

							 $this->insertInvoiceRelatedTaxesAdvanceReinstatement($invoice_id,$invoice_related_taxes_arrias[0]->master_table_name,$invoice_related_taxes_arrias[0]->master_table_record_id,$item_amount,$arrias,$nbtamount,$vatamount,$invoice_related_taxes_arrias[0]->is_tax_enable,$invoice_related_taxes_arrias[0]->nbt_presentage,$invoice_related_taxes_arrias[0]->vat_presentage,$is_subscrip_for_reg,4,$invoice_related_taxes_arrias[0]->main_payment_category_id,$invoice_related_taxes_arrias[0]->sub_payment_category_id,0,0,$user_id);


						}



				   }			   



				   if($subscription>0){

				   	$invoice_related_taxes_arrias=$this->getInvoiceRelatedTaxResults($invoice_id,2);


						if($invoice_related_taxes_arrias[0]->is_tax_enable==1){

						if($invoice_related_taxes_arrias[0]->vat_amount>0){

						$vatamount=$this->CalculateVatGivenAmount($subscription,$invoice_related_taxes_arrias[0]->vat_presentage);

						}else{
						$vatamount=0;
						}

						if($invoice_related_taxes_arrias[0]->nbt_amount>0){

						$nbtamount=$this->CalculateNbtGivenAmount($subscription,$invoice_related_taxes_arrias[0]->nbt_presentage,$vatamount);

						}else{
						$nbtamount=0;
						} 

						$item_amount=$subscription-$vatamount-$nbtamount;

				   	  $this->insertInvoiceRelatedTaxesAdvanceReinstatement($invoice_id,$invoice_related_taxes_arrias[0]->master_table_name,$invoice_related_taxes_arrias[0]->master_table_record_id,$item_amount,$subscription,$nbtamount,$vatamount,$invoice_related_taxes_arrias[0]->is_tax_enable,$invoice_related_taxes_arrias[0]->nbt_presentage,$invoice_related_taxes_arrias[0]->vat_presentage,$is_subscrip_for_reg,2,$invoice_related_taxes_arrias[0]->main_payment_category_id,$invoice_related_taxes_arrias[0]->sub_payment_category_id,0,0,$user_id);




						}else{
							$nbtamount=0;
							$vatamount=0;
							$item_amount=$subscription;

							$this->insertInvoiceRelatedTaxesAdvanceReinstatement($invoice_id,$invoice_related_taxes_arrias[0]->master_table_name,$invoice_related_taxes_arrias[0]->master_table_record_id,$item_amount,$subscription,$nbtamount,$vatamount,$invoice_related_taxes_arrias[0]->is_tax_enable,$invoice_related_taxes_arrias[0]->nbt_presentage,$invoice_related_taxes_arrias[0]->vat_presentage,$is_subscrip_for_reg,2,$invoice_related_taxes_arrias[0]->main_payment_category_id,$invoice_related_taxes_arrias[0]->sub_payment_category_id,0,0,$user_id);


						}




				   }



				   	if($surcharge>0){

				   		$invoice_related_taxes_arrias=$this->getInvoiceRelatedTaxResults($invoice_id,63);

				   $this->insertInvoiceRelatedTaxesAdvanceReinstatement($invoice_id,$invoice_related_taxes_arrias[0]->master_table_name,$invoice_related_taxes_arrias[0]->master_table_record_id,$surcharge,$surcharge,0,0,$invoice_related_taxes_arrias[0]->is_tax_enable,$invoice_related_taxes_arrias[0]->nbt_presentage,$invoice_related_taxes_arrias[0]->vat_presentage,$is_subscrip_for_reg,3,$invoice_related_taxes_arrias[0]->main_payment_category_id,$invoice_related_taxes_arrias[0]->sub_payment_category_id,0,0,$user_id);

				   }

				}

				
				//$this->CheckWalletandUpdateReinstatementPayment($user_id,$insert_id,$master_table_record_id,$due_amount);	
			}
	


		

			$this->CI->db->trans_complete();

			if($user_id>0){

				$CI =& get_instance();
				$CI->load->library('email_service_system');
				$CI->load->helper('finance');
				$CI->load->helper('misc');

				$paymentsummeryforreceipt=$this->PaymentSummeryresforReceipt($insert_id);
				$beneval_fund_amount=getFundAmount($paymentsummeryforreceipt[0]->master_table_record_id);

				
				$paymentrecept=getInvoiceByWithTaxBreakDown($paymentsummeryforreceipt,1,1);

				$salutation=getSalutation($user_id)->master_salutation;
				$memdetails=getMemberDetails($user_id);
				

				if($paymentsummeryforreceipt[0]->main_payment_category_id==2){

					$years_title=getSubscriptionYears($paymentsummeryforreceipt[0]->master_table_record_id,$paymentsummeryforreceipt[0]->master_table_name);

					$body = $this->getSubsReminderNoticeMsg($salutation,$memdetails,$years_title[0]->year,$member_ship_number,$beneval_fund_amount).$paymentrecept;
					$subjectemail="ANNUAL test MEMBERSHIP SUBSCRIPTIONS – ".$years_title[0]->year;

				}else if($paymentsummeryforreceipt[0]->main_payment_category_id==73){

					$years_title=getECSLYears($paymentsummeryforreceipt[0]->master_table_record_id,$paymentsummeryforreceipt[0]->master_table_name);

					$body = $this->getECSLReminderNoticeMsg($salutation,$memdetails,$years_title[0]->year,$member_ship_number).$paymentrecept;
					$subjectemail="LEGAL - Please PAY YOUR Engineering Council Registration Dues for ".$years_title[0]->year;

				}else{
					$body = $paymentrecept;
					$subjectemail="Invoice Notification";
				}
												
				$user_id_array=array($user_id);
				$email_array=getUserEmails($user_id_array);
				$recipients = $email_array;
				
				$CI->email_service->sendEmail($recipients, $subjectemail, $body);



			}



	    return $insert_id;

	}

function getSubsReminderNoticeMsg($salutation,$mem_details,$year,$member_ship_number,$beneval_fund_amount){


						date_default_timezone_set('Asia/Colombo');
						$current_date=date('Y-m-d');


                     
        				$name=$mem_details->user_name_initials.' '.$mem_details->user_name_lastname;
        				$member_ship_number=$member_ship_number;
						$CI =& get_instance();
						$CI->load->library('config_variables');
						//Discount End Date
						$sub_discount_date=$CI->config_variables->getVariable('sub_discount_date');
						$discount_end_date=$year.$sub_discount_date;


        				
        				$msg_body.='<br><br><b> Dear '.$salutation.' '.$name.' </b> <br>';
        				$msg_body.='<b>'.$member_ship_number.' </b><br><br>';
        				//$msg_body.='Dear  Member, <br><br>';

        				$msg_body.='<h3><font color="red">ANNUAL test MEMBERSHIP SUBSCRIPTIONS – '.$year.'</font></h3><br>';

        				$msg_body.='Kindly be notified that, your test Membership Subscription payment for the Year '.$year.' is due on 01st January '.$year.'.</br></br>';

        				if($current_date<=$discount_end_date){

        					$msg_body.='<b>1.</b> A discount of 10% will apply to all categories of Members (excluding Students), who pay test subscription fees for the year '.$year.' on or before 31st January '.$year.'. The related invoice (with 10% discount) is indicated below.</br></br>';  

        				    $msg_body.='<b>2.</b> A discount of 25% will apply to all categories of Members (excluding Students), who are above 60 years of age and who declare that their annual income is less than Rs. 600,000/-.</br></br>';    
        				}


                        $msg_body.='*Note: Although optional, your contribution to the Benevolent Fund will be mostly appreciated. The fund supports Members and their dependents who are in distress. Minimum Contribution for the Benevolent fund is Rs. '.$beneval_fund_amount.'. <br><br>';

                        $msg_body.='While thanking you for your support extended to the institution in its activities in the past, we are looking forward to your continued support in the future too by sustaining your membership at the institution. <br><br>';

        			   				
        			//	$msg_body.='The related invoice is indicated below. Kindly settle the payment at your earliest to get registered with the test for year '.$year.'.</br></br>'; 

        			   

//$msg_body.='A separate invoice will be sent to you for the Engineering Council Sri Lanka (ECSL) registration. <br><br>';


        				$msg_body.='The easiest and simplest way to pay your subscription is to use our Online Payment Gateway <br>';
						$Click='<a href="https://test.lk/mis/">Click here</a>';
						$msg_body.='<h3><font color="red">Please </font> '.$Click.' (for Online payments)
</h3> <br>';

						$msg_body.='If you have already paid your subscription for '.$year.', please ignore this notice. For any clarifications in this regard, please contact Mr Praneeth Costa (email: praneeth@test.lk) with a copy to the Finance Manager (email: mgr.fin@test.lk).</br></br>';
						
						$msg_body.='<b>Kind regards,</b> <br><br>';
						$msg_body.='<b>Chief Executive Officer/Executive Secretary</b> <br><br>';
						$msg_body.='<b>test</b> <br><br>';
						$msg_body.='<b>'.$current_date.'</b> <br><br>';


				$msg_body.='<b><u>INSTRUCTIONS FOR PAYMENT</u></b> <br><br>';

                $msg_body.='Please note that payment modes (a), (b) and (c) mentioned below are highly recommended due to the current situation in the country. <br><br>';

                $msg_body.='<ul><li> a) <b><u>Online payment</u></b> by using the test MIS system which is the easiest and simplest way. Please click the link,  <br>';

                	$Click='<a href="https://test.lk/mis/">https://test.lk/mis/</a>';
						$msg_body.='<h3>'.$Click.'</h3></li>';

			 $msg_body.='<li> b) <b><u>Online banking</u></b> to the Institution of Engineers, Sri Lanka Account No: 0002323113 maintained at the Torrington Square Branch of the Bank of Ceylon. The confirmation of payment received from the bank has to be sent  via email to praneeth@test.lk  indicating  your membership number and full name. </li><br>';

	       $msg_body.='<li>c) <b><u>Cash payments</u></b> made directly at any branch of Bank of Ceylon to the Account No. 002323113 of the Institution of Engineers, Sri Lanka maintained at the Torrington Square Branch of the Bank of Ceylon using the special payment slip available at the bank. A scanned copy of the slip has to be sent via email to  praneeth@test.lk indicating your membership no and full name.    </li> <br><br>';


  //$msg_body.='<li>d) Cheques drawn in favor of The Institution of Engineers, Sri Lanka and posted to test.</li><br>';
    //$msg_body.='<li>e) Cash/Cheque /Credit Card/Debit card payments made in person during normal working hours(8.30 am to 4.30 pm)at test Headquarters, Wijerama Mawatha, Colombo 7.</li></ul>';

						return $msg_body;


											


}        


function getECSLReminderNoticeMsg($salutation,$mem_details,$year,$member_ship_number){


                
        				$name=$mem_details->user_name_initials.' '.$mem_details->user_name_lastname;
        				$member_ship_number=$member_ship_number;

        				$msg_body.='</br></br><b> Dear '.$salutation.' '.$name.' </b> <br>';
        				$msg_body.='<b>'.$member_ship_number.' </b><br><br>';
        				$msg_body.='<h3><font color="red">ANNUAL REGISTRATION - ENGINEERING COUNCIL SRI LANKA  (ECSL) – '.$year.'</font></h3><br>';
        				//$msg_body.='Dear  Member, <br><br>';
        				$msg_body.='Provided that you are currently serving as an engineering practitioner in Sri Lanka, you should register annually at the ECSL. This is the prevailing law of the country and year '.$year.' registration payment is due on 01st January '.$year.'. The related invoice is indicated below. Kindly settle the payment at your earliest to get legally registered at ECSL for year '.$year.'.</br></br>';    				
        			   				
        				$msg_body.='If you are NOT serving as an engineering practitioner in Sri Lanka, please inform our Finance Manager in writing (email: mgr.fin@test.lk) with a copy to DCEO/DES (email: des.mem@test.lk) for us to de-list you from being invoiced in the future. A record of test members who declared that they do not serve as engineering practitioners in Sri Lanka, will be sent to ECSL periodically. For further details on Engineering Council registration, please refer the link,</br>'; 

    

    $Click='<a href="https://test.lk/index.php?option=com_content&view=article&id=169&Itemid=388&lang=en">https://test.lk/index.php?option=com_content&view=article&id=169&Itemid=388&lang=en</a>';
						$msg_body.='<h3>'.$Click.'
</h3> <br>';

//$msg_body.='The related invoice is indicated below. Kindly settle the payment at your earliest to get legally registered with ECSL for year '.$year.'. <br><br>';


        				$msg_body.='The easiest and simplest way to pay your subscription is to use our Online Payment Gateway. Please refer the link, <br>';
						$Click='<a href="https://test.lk/mis/">Click here</a>';
						$msg_body.='<h3><font color="red">Please </font> '.$Click.' (for Online payments)
</h3> <br>';

		
						
						$msg_body.='<b>Best regards,</b> <br><br>';
						$msg_body.='<b>Chief Executive Officer/Executive Secretary</b> <br><br>';
						$msg_body.='<b>test</b> <br><br>';
						$msg_body.='<b>'.$current_date.'</b> <br><br>';

						return $msg_body;


						
						


}  





function CheckWalletandUpdateReinstatementPayment($user_id=0,$insert_id=0,$master_table_record_id=0,$due_amount=0){

			$this->CI =& get_instance();
			$this->CI->load->database();

		$this->CI->load->helper('master_tables');
		$this->CI->load->model('Member_subscription_model','',TRUE);
	    date_default_timezone_set('Asia/Colombo');
        $created_date = date('Y-m-d');

        $walletamount=$this->CI->Member_subscription_model->getWalletAmountReinstatementTemp($user_id);
        $walletamount=$walletamount->wallet_ballance;
        if($walletamount==''){
            $walletamount=0;
        }

          if($due_amount>$walletamount && $walletamount>0){

                $payment_status_id=0;
                $wallet_balance=0;
                $dataw = array(
                'wallet_ballance' =>$wallet_balance         
                );
                 $this->CI->db->where('user_id', $user_id);
                $flage =  $this->CI->db->update('member_wallet', $dataw);


                $walletdeyails=$this->CI->Member_subscription_model->getWalletDetails($user_id);
                $update_log=insertWalletLogs($walletdeyails->wallet_id,$walletamount,2,$user_id,$insert_id);


                $payment_ref_number = 'WALLET_REINSTATE_'.$master_table_record_id.rand(1000,10000).date("Y-m-d").date("h:i:s");
               $payment_ref_number = $this->CI->Member_subscription_model->getWalletReferenceNo($payment_ref_number);
         

                                $array = array(
                                'low_payment_amount' => $walletamount,
                                'user_id'  => $user_id,
                                'payment_dashboard_id' => $insert_id,
                                'reference_no' => $payment_ref_number[0],
                                'payment_status_id' => 0,
                                  'final_payment_date' => $created_date,
                                'check_or_bank_slip_no' => '',
                                'check_or_bankslip_date' => '',
                                'remarks' => 'Advance payment via wallet',
                                'payment_method_id' => 7,
                                'payment_date' => $created_date,
                                'state' => '1'

                                );
                                $this->CI->db->set($array);
                                $this->CI->db->insert('member_low_payment');

            }

       
}



function GetSubpymentCatIDEventRegisterGuest($master_table_record_id) {
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('B.gest_sub_payment_category_id AS sub_payment_category_id, B.*');
    $this->CI->db->from('event_member_registration AS A');
    $this->CI->db->join('event_initiation AS B', 'B.event_initiation_id = A.event_initiation_id', 'left');
    $this->CI->db->where('A.event_registration_id', $master_table_record_id);
    $query = $this->CI->db->get();
    return $master_sub_payment_categories_id = $query->result();

}

function GetSubpymentCatIDCPDRegisterGuest($master_table_record_id) {
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('B.gest_sub_payment_category_id AS sub_payment_category_id, B.*');
    $this->CI->db->from('cpd_member_registration AS A');
    $this->CI->db->join('cpd_initiation AS B', 'B.event_initiation_id = A.event_initiation_id', 'left');
    $this->CI->db->where('A.event_registration_id', $master_table_record_id);
    $query = $this->CI->db->get();
    return $master_sub_payment_categories_id = $query->result();

}

function Removerecordinvoicerelatedtax($master_table_name,$master_table_record_id,$gestsubpaycat){

				$this->CI =& get_instance();
			$this->CI->load->database();

			$data1 = array(
			'state' =>  -2,
			);

    $this->CI->db->where('master_table_name', $master_table_name);
    $this->CI->db->where('master_table_record_id', $master_table_record_id);
    $this->CI->db->where('sub_payment_category_id', $gestsubpaycat);
			return $flag = $this->CI->db->update('invoice_related_taxes', $data1);

}

function RemoverecordinvoicerelatedtaxbyInvoiceID($invoice_id){

				$this->CI =& get_instance();
			$this->CI->load->database();

			$data1 = array(
			'state' =>  -2,
			);
    $this->CI->db->where('invoice_id', $invoice_id);
			return $flag = $this->CI->db->update('invoice_related_taxes', $data1);

}


function CheckGuestRecord($master_table_name,$master_table_record_id,$gestsubpaycat){
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('COUNT(invoice_related_tax_id) AS totalguest');
    $this->CI->db->from('invoice_related_taxes');
    $this->CI->db->where('master_table_name', $master_table_name);
    $this->CI->db->where('master_table_record_id', $master_table_record_id);
    $this->CI->db->where('sub_payment_category_id', $gestsubpaycat);
    $this->CI->db->where('state =', 1);
    $query = $this->CI->db->get();
    return $totalguest = $query->result()[0]->totalguest;

}


	function getCeoBuildingSpecialistArea($master_table_record_id) {
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('COUNT(building_id) AS totalguest');
    $this->CI->db->from('ceo_buildig_speciality_area');
    $this->CI->db->where('status', 1);
    $this->CI->db->where('building_service_id', $master_table_record_id);
    $query = $this->CI->db->get();
    return $totalguest = $query->result()[0]->totalguest;

}

	function getNumberofGest($master_table_record_id) {
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('COUNT(event_registration_gust_details_id) AS totalguest');
    $this->CI->db->from('event_registration_gust_details');
    $this->CI->db->where('state', 1);
    $this->CI->db->where('event_registration_id', $master_table_record_id);
    $query = $this->CI->db->get();
    return $totalguest = $query->result()[0]->totalguest;

}



	function getSubjectofExamApplication($master_table_record_id,$exam_id) {
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('B.sub_payment_category_id');
    $this->CI->db->from('edu_exam_application_subjects AS A');
    $this->CI->db->join('edu_exam_subjects AS B', 'B.subject_id = A.exam_subject_id', 'inner');
    $this->CI->db->where('A.state', 1);
    $this->CI->db->where('A.exam_application_id', $master_table_record_id);
    $this->CI->db->where('B.exam_id', $exam_id);
    $query = $this->CI->db->get();
  
   return  $totalguest = $query->result();
 

}

	function getNumberofTrainingOrganizationDicipline($master_table_record_id) {
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('COUNT(training_org_dicipline_id) AS totalguest');
    $this->CI->db->from('training_org_dicipline');
    $this->CI->db->where('state', 1);
    $this->CI->db->where('tranining_org_id', $master_table_record_id);
    $query = $this->CI->db->get();
    return $totalguest = $query->result()[0]->totalguest;

}


	function getNumberofGestCPD($master_table_record_id) {
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('COUNT(event_registration_gust_details_id) AS totalguest');
    $this->CI->db->from('cpd_registration_gust_details');
    $this->CI->db->where('state', 1);
    $this->CI->db->where('event_registration_id', $master_table_record_id);
    $query = $this->CI->db->get();
    return $totalguest = $query->result()[0]->totalguest;

}


function GetSubpymentCatID($memberCategory, $mainPaymentCategory) {
		    $this->CI =& get_instance();
			$this->CI->load->database();

    $this->CI->db->select('sub_payment_category_id');
    $this->CI->db->from('sub_payment_category_membership_class');
    $this->CI->db->where('state', 1);
    $this->CI->db->where('main_payment_category_id', $mainPaymentCategory);
    $this->CI->db->where('class_of_membership_id', $memberCategory);
    $this->CI->db->order_by('sub_payment_category_id', 'DESC');
    $this->CI->db->limit(1);
    $query = $this->CI->db->get();
    return $master_sub_payment_categories_id = $query->result()[0]->sub_payment_category_id;

}


function InsertTaxDetails($invoice_id,$master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount,$is_subscrip_for_reg,$user_id,$reg_or_subscrip,$totalguest=1){




		$results=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);



		if($user_id>0){

			$master_table_results=$this->getMasterTableResults($master_table_name,$master_table_record_id);

		}else{

			$master_table_results=$this->getMasterTableResultsPublic($master_table_name,$master_table_record_id);

		}




		
	    $member_age_membership_year=$this->GetMemberAgeandMembershipYear($user_id,$master_table_results->user_dob);
                    $member_age=$member_age_membership_year['age'];
                     $membership_year=$member_age_membership_year['mem_duration'];
    $subscriptionstatus=$this->getNewRegisteredUserAmount($results[0]->amount,$member_age,$membership_year,$master_table_results->subscription_half_rate,$results,$due_amount,$master_table_results->user_member_class);



            date_default_timezone_set('Asia/Colombo');
	  $current_date=date('Y-m-d');	

      $subscription_year=$this->getHavetoSubscriptionPayYear();

     $CI =& get_instance();
     $CI->load->library('config_variables');
     //Discount End Date
	 $sub_discount_date=$CI->config_variables->getVariable('sub_discount_date');
	 $discount_end_date=$subscription_year.$sub_discount_date;
		

		$nbtamount=0.00;
		$vatamount=0.00;
		$nbt_presentage='';
		$vat_presentage='';
		$is_registration_with_subscription=$is_subscrip_for_reg;

		if($master_table_name=='member_reinstatement' && $reg_or_subscrip==4){
			$totalyear=$this->TotalReinsmentYears($master_table_record_id)-1;
		}else{
			$totalyear=1;
		}


		if($master_table_name=='event_member_registration'){

			$ecdiscount=$this->CheckDiscountEvent($master_table_results);

		}else if($master_table_name=='cpd_member_registration'){
			$ecdiscount=$this->CheckDiscountCPD($master_table_results);
		}else if($master_table_name=='member_reinstatement'){
			$subscriptionstatus=1;
		}else{
			$ecdiscount=0;
		}



		$taxcount=count($results);
		if($taxcount==2){

		    for ($i=0; $i < $taxcount; $i++) { 
		    	  
		    	  if($results[$i]->taxid==1){

		    	  			if($results[$i]->main_payment_category_id==2 && $subscriptionstatus==2){


									if($current_date<=$discount_end_date){
									$nbtamount=(($results[$i]->amount/2-$results[$i]->discount_amount/2)*$results[$i]->rate_value)/100;
									}else{
									$nbtamount=($results[$i]->amount/2*$results[$i]->rate_value)/100;
									}

		    	  			}else{

		    	  				

									if( ($results[$i]->is_discount==1 && $results[$i]->main_payment_category_id!=2 && $results[$i]->main_payment_category_id!=3 && $results[$i]->main_payment_category_id!=4) ||  ($current_date<=$discount_end_date && $results[$i]->main_payment_category_id==2) || ($ecdiscount==1 && $results[$i]->is_discount==1) ){
									$nbtamount=(($results[$i]->amount-$results[$i]->discount_amount)*$results[$i]->rate_value)/100;
									}else{

									    $nbtamount=(($results[$i]->amount*$results[$i]->rate_value)/100)*$totalyear;
									
									}
  

		    	  			}



		    	  		
		    	  		$nbt_presentage=$results[$i]->rate_value;
		    	  }else{
		    	  		$vat_presentage=$results[$i]->rate_value;
		    	  }
		       }

		       	if($results[0]->main_payment_category_id==2 && $subscriptionstatus==2){

						if($current_date<=$discount_end_date){
						$vatamount=($results[0]->amount_with_tax_and_discount/2-($results[0]->amount/2-$results[0]->discount_amount/2))-$nbtamount;
						}else{
						$vatamount=($results[0]->amount_with_tax/2-$results[0]->amount/2)-$nbtamount;
						}

		       	}else{

						if( ($results[0]->is_discount==1 && $results[0]->main_payment_category_id!=2 && $results[0]->main_payment_category_id!=3 && $results[0]->main_payment_category_id!=4) ||  ($current_date<=$discount_end_date && $results[0]->main_payment_category_id==2) || ($ecdiscount==1 && $results[0]->is_discount==1)){
						$vatamount=($results[0]->amount_with_tax_and_discount-($results[0]->amount-$results[0]->discount_amount))-$nbtamount;
						}else{
						$vatamount=($results[0]->amount_with_tax-$results[0]->amount)*$totalyear-$nbtamount;
						}




		       	}
		           
 

		}else{


				if($results[0]->main_payment_category_id==2 && $subscriptionstatus==2){

		    	  		if($current_date<=$discount_end_date){

		    	  			if($results[0]->taxid==1){
							$nbtamount=(($results[0]->amount/2-$results[0]->discount_amount/2)*$results[0]->rate_value)/100;
							$nbt_presentage=$results[0]->rate_value;
							}
							if($results[0]->taxid==2){
							$vatamount=(($results[0]->amount/2-$results[0]->discount_amount/2)*$results[0]->rate_value)/100;
							$vat_presentage=$results[0]->rate_value;
							}

		    	  		}else{

							if($results[0]->taxid==1){
							$nbtamount=($results[0]->amount/2*$results[0]->rate_value)/100;
							$nbt_presentage=$results[0]->rate_value;
							}
							if($results[0]->taxid==2){
							$vatamount=($results[0]->amount/2*$results[0]->rate_value)/100;
							$vat_presentage=$results[0]->rate_value;
							}

		    	  		}



				}else{

						if( ($results[0]->is_discount==1 && $results[0]->main_payment_category_id!=2 && $results[0]->main_payment_category_id!=3 && $results[0]->main_payment_category_id!=4) ||  ($current_date<=$discount_end_date && $results[0]->main_payment_category_id==2 && $master_table_name=='member_subscription') || ($ecdiscount==1 && $results[0]->is_discount==1)){
		    	  			if($results[0]->taxid==1){
							$nbtamount=(($results[0]->amount-$results[0]->discount_amount)*$results[0]->rate_value)/100;
							$nbt_presentage=$results[0]->rate_value;
							}
							if($results[0]->taxid==2){
							$vatamount=(($results[0]->amount-$results[0]->discount_amount)*$results[0]->rate_value)/100;
							$vat_presentage=$results[0]->rate_value;
							}
		    	  		}else{

							if($results[0]->taxid==1){
							$nbtamount=(($results[0]->amount*$results[0]->rate_value)/100)*$totalyear;
							$nbt_presentage=$results[0]->rate_value;
							}
							if($results[0]->taxid==2){
							$vatamount=(($results[0]->amount*$results[0]->rate_value)/100)*$totalyear;
							$vat_presentage=$results[0]->rate_value;
							}

		    	  		}

				}	



		}

		$nbtamount;
		$vatamount;

		$discount_amount=0.00;

		if($results[0]->main_payment_category_id==2 || $results[0]->main_payment_category_id==3 || $results[0]->main_payment_category_id==4){

			if(($current_date<=$discount_end_date && $master_table_name=='member_subscription') || $ecdiscount==1){

				if($subscriptionstatus==2 && $results[0]->main_payment_category_id==2){

					$discount_amount=$results[0]->discount_amount/2;

				}else{
					$discount_amount=$results[0]->discount_amount;
				}

			     

			}else{

				 $results[0]->is_discount=0;
		         $results[0]->discount=0;
			     $discount_amount=0;

			     //$results[0]->amount=($due_amount-$nbtamount)-$vatamount;
			}
			 


		}else{

			if($results[0]->is_discount==1){
			 $results[0]->discount;
			 $discount_amount=$results[0]->discount_amount;
		      }
		}

		if($results[0]->amount==0){
			$results[0]->amount=$due_amount;
		}

				//arrias exsist
		if($reg_or_subscrip==4){
          $sub_payment_category_id_arrias=$this->GetSubpymentCatID($master_table_results->user_member_class,64);
			$sub_payment_category_id=$sub_payment_category_id_arrias;
			$results[0]->main_payment_category_id=64;
			$results[0]->amount=$results[0]->amount*$totalyear;

		}

		if($results[0]->main_payment_category_id==2 && $subscriptionstatus==2){

			$results[0]->amount=$results[0]->amount/2;

		}	

	

		    $this->CI =& get_instance();
			$this->CI->load->database();

			$array2 = array(					
			'invoice_id' => $invoice_id,		
			'master_table_name' => $master_table_name,
			'master_table_record_id' => $master_table_record_id,
			'amount_without_tax' => $results[0]->amount*$totalguest,
			'final_amount' => $due_amount,
			'nbt_amount' => $nbtamount*$totalguest,
			'vat_amount' => $vatamount*$totalguest,
			'is_tax_enable' => $results[0]->is_tax_enable,
			'nbt_presentage' => $nbt_presentage,
			'vat_presentage' => $vat_presentage,
			'is_registration_with_subscription' => $is_registration_with_subscription,
			'reg_or_subscrip' => $reg_or_subscrip,
			'main_payment_category_id' => $results[0]->main_payment_category_id,
			'sub_payment_category_id' => $sub_payment_category_id,
			'is_discount' => $results[0]->is_discount,
			'discount_amount' => $discount_amount,
	/*		'discount_presentage'=> $results[0]->discount_amount,*/
			'user_id' => $user_id

			);

			$this->CI->db->set($array2);
			$this->CI->db->insert('invoice_related_taxes');

			$this->CI->db->last_query();
			$this->CI->db->insert_id();



			

		
}




   function getMembersStasticInfo($user_id){

        $this->CI->db->select('*');
        $this->CI->db->from('member_profile_statistics');
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('state', 1);
        return $this->CI->db->get()->row();
    }

public function getYearsfromDate($fromdate){
         $fromdate=date("m/d/Y", strtotime($fromdate));
         $birthDate = $fromdate;
  //explode the date to get month, day and year
  $birthDate = explode("/", $birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[2]) - 1)
    : (date("Y") - $birthDate[2]));


  return $age;
}


public function GetMemberAgeandMembershipYear($user_id,$user_dob){

        $stat_array=$this->getMembersStasticInfo($user_id);

        if($user_dob!='' && $user_dob!='0000-00-00'){
          $age=$this->getYearsfromDate($user_dob);
         }else{
          $age=0;  
         }

      

         if($stat_array->profile_created_date!='' && $stat_array->profile_created_date!='0000-00-00'){
                $memship_years=$this->getYearsfromDate($stat_array->profile_created_date);
                $reinstatement_years = ($stat_array->reinstatement_duration_days / 365) ; // days / 365 days
                $reinstatement_years = floor($reinstatement_years);
                $mem_duration=$memship_years-$reinstatement_years;

         }else{
          $mem_duration=0;  
         }
         
    return $arrayName = array('age' => $age, 'mem_duration' => $mem_duration);   


}

public function getNewRegisteredUserAmount($amount,$member_age,$membership_year,$subscription_half_rate,$results,$due_amount,$user_member_class=0){


if($results[0]->is_tax_enable==1){
	$newregamount=$results[0]->amount_with_tax/2;
}else{
	$newregamount=$results[0]->amount/2;
}


	$year=date('Y');
                     $CI =& get_instance();
                     $CI->load->library('config_variables');
     $new_user_register_from=$CI->config_variables->getVariable('new_user_register_from');
     $new_user_register_to=$CI->config_variables->getVariable('new_user_register_to');
     
                $from_date=$year.$new_user_register_from;
                $to_date=$year.$new_user_register_to;
                $default_age=$CI->config_variables->getVariable('default_age');
                $default_membership_years=$CI->config_variables->getVariable('default_membership_years');
                $default_age=$default_age;
                $default_membership_years=$default_membership_years;


                if($subscription_half_rate==1 || ($member_age>=$default_age && $membership_year>=$default_membership_years && ($user_member_class==8 || $user_member_class==9 )) || $newregamount==$due_amount){

                    return  2;

                }else{

                    return 1;
                }

                       
}



function UpdateTaxDetails($master_table_name,$master_table_record_id,$sub_payment_category_id,$due_amount,$is_subscrip_for_reg,$user_id,$reg_or_subscrip,$totalguest=1){

		$results=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);


		if($user_id>0){

			$master_table_results=$this->getMasterTableResults($master_table_name,$master_table_record_id);

		}else{

			$master_table_results=$this->getMasterTableResultsPublic($master_table_name,$master_table_record_id);

		}
		






	    $member_age_membership_year=$this->GetMemberAgeandMembershipYear($user_id,$master_table_results->user_dob);
                    $member_age=$member_age_membership_year['age'];
                     $membership_year=$member_age_membership_year['mem_duration'];
      $subscriptionstatus=$this->getNewRegisteredUserAmount($results[0]->amount,$member_age,$membership_year,$master_table_results->subscription_half_rate,$results,$due_amount,$master_table_results->user_member_class);

      date_default_timezone_set('Asia/Colombo');
	  $current_date=date('Y-m-d');	


	  $subscriptin_years=getSubscriptionYears($master_table_record_id,$master_table_name);
	   $subscription_year=$subscriptin_years[0]->year;
	   if($subscription_year>0){

	   }else{
	   	$subscription_year=$this->getHavetoSubscriptionPayYear();
	   }
      

     $CI =& get_instance();
     $CI->load->library('config_variables');
     //Discount End Date
	 $sub_discount_date=$CI->config_variables->getVariable('sub_discount_date');
	 $discount_end_date=$subscription_year.$sub_discount_date;

		

		$nbtamount=0.00;
		$vatamount=0.00;
		$nbt_presentage='';
		$vat_presentage='';
		$is_registration_with_subscription=$is_subscrip_for_reg;

		$taxcount=count($results);

		if($master_table_name=='member_reinstatement' && $reg_or_subscrip==4){
			$totalyear=$this->TotalReinsmentYears($master_table_record_id)-1;

			
		}else{
			$totalyear=1;
		}


		if($master_table_name=='event_member_registration'){

			 $ecdiscount=$this->CheckDiscountEvent($master_table_results);

		}else if($master_table_name=='cpd_member_registration'){
			$ecdiscount=$this->CheckDiscountCPD($master_table_results);
		}else if($master_table_name=='member_reinstatement'){
			$subscriptionstatus=1;
		}else{
			$ecdiscount=0;
		}
	

		
	
		if($taxcount==2){

		    for ($i=0; $i < $taxcount; $i++) { 
		    	  
		    	  if($results[$i]->taxtype=='NBT'){

		    	  			if($results[$i]->main_payment_category_id==2 && $subscriptionstatus==2){


									if($current_date<=$discount_end_date){
									$nbtamount=(($results[$i]->amount/2-$results[$i]->discount_amount/2)*$results[$i]->rate_value)/100;
									}else{
									$nbtamount=($results[$i]->amount/2*$results[$i]->rate_value)/100;
									}

		    	  			}else{

									if( ($results[$i]->is_discount==1 && $results[$i]->main_payment_category_id!=2 && $results[$i]->main_payment_category_id!=3 && $results[$i]->main_payment_category_id!=4) ||  ($current_date<=$discount_end_date && $results[$i]->main_payment_category_id==2) || ($ecdiscount==1 && $results[$i]->is_discount==1)){
									$nbtamount=(($results[$i]->amount-$results[$i]->discount_amount)*$results[$i]->rate_value)/100;
									}else{



									    $nbtamount=(($results[$i]->amount*$results[$i]->rate_value)/100)*$totalyear;

									    
									
									}

		    	  			}



		    	  		
		    	  		$nbt_presentage=$results[$i]->rate_value;
		    	  }else{
		    	  		$vat_presentage=$results[$i]->rate_value;
		    	  }
		       }

		       	if($results[0]->main_payment_category_id==2 && $subscriptionstatus==2){

						if($current_date<=$discount_end_date){
						$vatamount=($results[0]->amount_with_tax_and_discount/2-($results[0]->amount/2-$results[0]->discount_amount/2))-$nbtamount;
						}else{
						$vatamount=($results[0]->amount_with_tax/2-$results[0]->amount/2)-$nbtamount;
						}

		       	}else{




						if(($results[0]->is_discount==1 && $results[0]->main_payment_category_id!=2 && $results[0]->main_payment_category_id!=3 && $results[0]->main_payment_category_id!=4) ||  ($current_date<=$discount_end_date && $results[0]->main_payment_category_id==2) || ($ecdiscount==1 && $results[0]->is_discount==1) ){

						 $vatamount=($results[0]->amount_with_tax_and_discount-($results[0]->amount-$results[0]->discount_amount))-$nbtamount;

						}else{
						 $vatamount=($results[0]->amount_with_tax-$results[0]->amount)*$totalyear-$nbtamount;

						}


						

		       	}
		           


		}else{


				if($results[0]->main_payment_category_id==2 && $subscriptionstatus==2){

		    	  		if($current_date<=$discount_end_date){
		    	  			if($results[0]->taxid==1){
							$nbtamount=(($results[0]->amount/2-$results[0]->discount_amount/2)*$results[0]->rate_value)/100;
							$nbt_presentage=$results[0]->rate_value;
							}
							if($results[0]->taxid==2){
							$vatamount=(($results[0]->amount/2-$results[0]->discount_amount/2)*$results[0]->rate_value)/100;
							$vat_presentage=$results[0]->rate_value;
							}
		    	  		}else{

							if($results[0]->taxid==1){
							$nbtamount=($results[0]->amount/2*$results[0]->rate_value)/100;
							$nbt_presentage=$results[0]->rate_value;
							}
							if($results[0]->taxid==2){
							$vatamount=($results[0]->amount/2*$results[0]->rate_value)/100;
							$vat_presentage=$results[0]->rate_value;
							}

		    	  		}



				}else{




							if(($results[0]->is_discount==1 && $results[0]->main_payment_category_id!=2 && $results[0]->main_payment_category_id!=3 && $results[0]->main_payment_category_id!=4) ||  ($current_date<=$discount_end_date && $results[0]->main_payment_category_id==2 && $master_table_name=='member_subscription') || ($ecdiscount==1 && $results[0]->is_discount==1) ){

		    	  			if($results[0]->taxid==1){
							$nbtamount=(($results[0]->amount-$results[0]->discount_amount)*$results[0]->rate_value)/100;
							$nbt_presentage=$results[0]->rate_value;
							}
							if($results[0]->taxid==2){
							$vatamount=(($results[0]->amount-$results[0]->discount_amount)*$results[0]->rate_value)/100;
							$vat_presentage=$results[0]->rate_value;
							}
		    	  		}else{

	

							if($results[0]->taxid==1){
							$nbtamount=(($results[0]->amount*$results[0]->rate_value)/100)*$totalyear;
							$nbt_presentage=$results[0]->rate_value;
							}
							if($results[0]->taxid==2){
							$vatamount=(($results[0]->amount*$results[0]->rate_value)/100)*$totalyear;
							$vat_presentage=$results[0]->rate_value;
							}

		    	  		}

				}	



		}



		$nbtamount;
		$vatamount;

		$discount_amount=0.00;

		if($results[0]->main_payment_category_id==2 || $results[0]->main_payment_category_id==3 || $results[0]->main_payment_category_id==4){

			if(($current_date<=$discount_end_date && $master_table_name=='member_subscription')  || $ecdiscount==1){


				if($subscriptionstatus==2 && $results[0]->main_payment_category_id==2){

				$discount_amount=$results[0]->discount_amount/2;

				}else{
				$discount_amount=$results[0]->discount_amount;
				}

			     

			}else{

				 $results[0]->is_discount=0;
		         $results[0]->discount=0;
			     $discount_amount=0;

			     //$results[0]->amount=($due_amount-$nbtamount)-$vatamount;
			}			 		


		}else{

			if($results[0]->is_discount==1){
			 $results[0]->discount;
			 $discount_amount=$results[0]->discount_amount;
		      }
		}

		if($results[0]->amount==0){
			$results[0]->amount=$due_amount;
		}

		//arrias exsist
		if($reg_or_subscrip==4){
          $sub_payment_category_id_arrias=$this->GetSubpymentCatID($master_table_results->user_member_class,64);
            $sub_payment_category_id=$sub_payment_category_id_arrias;
			$results[0]->main_payment_category_id=64;
			$results[0]->amount=$results[0]->amount*$totalyear;

		}


		if($results[0]->main_payment_category_id==2 && $subscriptionstatus==2){

			$results[0]->amount=$results[0]->amount/2;

		}	
		



		    $this->CI =& get_instance();
			$this->CI->load->database();

			if($results[0]->main_payment_category_id==2){

					$array2 = array(				
					'amount_without_tax' => $results[0]->amount*$totalguest,
					'final_amount' => $due_amount,
					'nbt_amount' => $nbtamount*$totalguest,
					'vat_amount' => $vatamount*$totalguest,
					'is_tax_enable' => $results[0]->is_tax_enable,
					'nbt_presentage' => $nbt_presentage,
					'vat_presentage' => $vat_presentage,
					'is_registration_with_subscription' => $is_registration_with_subscription,
					'reg_or_subscrip' => $reg_or_subscrip,
					'main_payment_category_id' => $results[0]->main_payment_category_id,
			/*		'sub_payment_category_id' => $sub_payment_category_id,*/
					'is_discount' => $results[0]->is_discount,
					'discount_amount' => $discount_amount,
			/*		'discount_presentage'=> $results[0]->discount,*/
					'user_id' => $user_id
					);

			}else{




					$array2 = array(				
					'amount_without_tax' => $results[0]->amount*$totalguest,
					'final_amount' => $due_amount,
					'nbt_amount' => $nbtamount*$totalguest,
					'vat_amount' => $vatamount*$totalguest,
					'is_tax_enable' => $results[0]->is_tax_enable,
					'nbt_presentage' => $nbt_presentage,
					'vat_presentage' => $vat_presentage,
					'is_registration_with_subscription' => $is_registration_with_subscription,
					'reg_or_subscrip' => $reg_or_subscrip,
					'main_payment_category_id' => $results[0]->main_payment_category_id,
					'sub_payment_category_id' => $sub_payment_category_id,
					'is_discount' => $results[0]->is_discount,
					'discount_amount' => $discount_amount,
			/*		'discount_presentage'=> $results[0]->discount,*/
					'user_id' => $user_id,
					'state' => 1
					);

			}


			$this->CI->db->where('state', 1);
			$this->CI->db->where('sub_payment_category_id', $sub_payment_category_id);
			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->update('invoice_related_taxes', $array2);



			

		
}

function CheckDiscountCPD($master_table_results){
		 date_default_timezone_set('Asia/Colombo');
     $today = date('Y-m-d');

     if($master_table_results->user_id>0){

	     $countregisterduser=$this->CountRegisterdUsersCPD($master_table_results->event_initiation_id,2);

		 if(($master_table_results->is_discount==1 && $countregisterduser<$master_table_results->discount_max_member) || ($master_table_results->is_discount==1 && $today<=$master_table_results->discount_closing_date)){ 

		 	return 1;

		 }else{
		 	return 0;
		 }

     }else{

     	$countregisterduser=$this->CountRegisterdUsersCPD($master_table_results->event_initiation_id,1);

		if(( $master_table_results->is_discount==1 && $countregisterduser<$master_table_results->discount_max_non_member) || ( $master_table_results->is_discount==1 && $today<=$master_table_results->discount_closing_date)){ 

		 	return 1;

		 }else{
		 	return 0;
		 }

     }


}


function CheckDiscountEvent($master_table_results){

	 date_default_timezone_set('Asia/Colombo');
     $today = date('Y-m-d');



     if($master_table_results->user_id>0){

		  $countregisterduser=$this->CountRegisterdUsersEvent($master_table_results->event_initiation_id,2);

		 if(($master_table_results->is_discount_amount_or_percentage > 0 && $master_table_results->is_discount==1 && $countregisterduser<$master_table_results->discount_max_member) || ($master_table_results->is_discount_amount_or_percentage > 0 && $master_table_results->is_discount==1 && $today<=$master_table_results->discount_closing_date)){ 

		 	return 1;

		 }else{
		 	return 0;
		 }

	}else{



	$countregisterduser=$this->CountRegisterdUsersEvent($master_table_results->event_initiation_id,1);



		 //print_r();	

		 if(($master_table_results->is_discount_amount_or_percentage_non_member > 0 && $master_table_results->is_discount==1 && $countregisterduser<$master_table_results->discount_max_non_member) || ($master_table_results->is_discount_amount_or_percentage_non_member > 0 && $master_table_results->is_discount==1 && $today<=$master_table_results->discount_closing_date)){ 

		 	return 1;

		 }else{


		 	return 0;
		 }


	}
}

public function  CountRegisterdUsersCPD($event_initiation_id,$public_or_member){
	  $this->CI =& get_instance();
	  $this->CI->load->database();
      $this->CI->db->from('cpd_member_registration');
      $this->CI->db->where('event_initiation_id', $event_initiation_id);
      $this->CI->db->where('payment_status', 2);
      $this->CI->db->where('state', 1);
      $this->CI->db->where('public_or_member',$public_or_member);
     return $this->CI->db->count_all_results();
}

public function  CountRegisterdUsersEvent($event_initiation_id,$public_or_member){
	  $this->CI =& get_instance();
	  $this->CI->load->database();
      $this->CI->db->from('event_member_registration');
      $this->CI->db->where('event_initiation_id', $event_initiation_id);
      $this->CI->db->where('payment_status', 2);
      $this->CI->db->where('state', 1);
      $this->CI->db->where('public_or_member',$public_or_member);
     return $this->CI->db->count_all_results();
}



	function getPaymentAmountByMemSUBCat($master_sub_payment_categories_id) {
    // get sub_payment_category_id from 'sub_payment_category_membership_class' for 'membership_class' and 'main_payement_category_id'

		//Get User Group Id
		$this->CI =& get_instance();
		$this->CI->load->database();

       $this->CI->db->select('master_sub_payment_categories.*, master_sub_payment_categories.amount AS amount, 
                        master_sub_payment_categories.is_tax_enable AS is_tax_enable, 
                        master_sub_payment_categories.amount_with_tax AS amount_with_tax,
                        sub_payment_related_tax.taxtype AS taxtype,
                        sub_payment_related_tax.taxid AS taxid,
                        system_tax_rate.presentage AS rate_value');
        $this->CI->db->from('master_sub_payment_categories');
        $this->CI->db->join('sub_payment_related_tax', 'sub_payment_related_tax.sub_payment_category_id = master_sub_payment_categories.sub_payment_category_id', 'left');
        $this->CI->db->join('system_tax_rate', 'system_tax_rate.taxid = sub_payment_related_tax.taxid', 'left');
        /*      $CI->db->join('qb_tax_rates', 'qb_tax_rates.qb_tax_id = system_tax_rate.qb_tax_id', 'left'); */
       $this->CI->db->where('master_sub_payment_categories.state', 1);
        $this->CI->db->where('master_sub_payment_categories.sub_payment_category_id', $master_sub_payment_categories_id);
        $query = $this->CI->db->get();
		// echo $this->CI->db->last_query();
		// echo $master_sub_payment_categories_id;
		// exit;
		//returns an empty array
        if ($query->result()) {

            return $query->result();
        } else {
           show_error('This member class is not eligible for payment category');
        }
   

}

    //Get Subscription pay year
    public function getHavetoSubscriptionPayYear(){

        $this->CI =& get_instance();
		$this->CI->load->database();

        $this->CI->db->select('year');
        $this->CI->db->from('subscription_fire_log');
        $this->CI->db->where('state', 1);
        $this->CI->db->order_by('subscription_fire_log', 'desc');
        return $this->CI->db->get()->row()->year;

    }


	public function getGroupID($user_id=0){

		//Get User Group Id
		$this->CI =& get_instance();
		$this->CI->load->database();
		$query = $this->CI->db->query('SELECT group_id FROM users_groups where user_id="'.$user_id.'" order by id DESC');
		//echo $this->CI->db->last_query();
		$row = $query->row();
		$query->free_result(); // The $query result object will no longer be available
		if($row->group_id>0){
			return  $row->group_id;
		}else{
			return 0;
		}
		


	}

		public function getMasterTableResults($master_table_name='',$master_table_record_id=0){

		if($master_table_name=='adjudicator_application_publication'){
			$master_table_name='adjudicator_application';
		}else if($master_table_name=='ceo_building_services_application_publication'){
			$master_table_name='ceo_building_services_application';
		}else if($master_table_name=='structural_engineers_application_publication'){
			$master_table_name='structural_engineers_application';
		}else if($master_table_name=='adjudicator_and_arbitrator_application_publication'){
			$master_table_name='adjudicator_and_arbitrator_application';
		}
		
			 $profileStates = array(0,1);
		//Get Master Table Results
		$this->CI =& get_instance();
		$this->CI->load->database();

		if($master_table_name=='user_registrations'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('user_registrations A');
		    $this->CI->db->where('A.user_tbl_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}
		if($master_table_name=='b_paper_application'){

            $this->CI->db->select('A.*,B.*,C.*');
            $this->CI->db->from('b_paper_application A');
            $this->CI->db->join('member_profile_data B', 'B.user_id = A.member_id', 'INNER');
            $this->CI->db->join('b_paper_batch C', 'C.b_paper_batch_id = A.batch_id', 'INNER');
            $this->CI->db->where('A.b_paper_app_id', $master_table_record_id);
            $this->CI->db->where('B.state', 1);
            $query = $this->CI->db->get();
		}

		if($master_table_name=='pr_viva_application'){

		$querytwo = $this->CI->db->query('SELECT is_direct_route FROM pr_viva_application where pr_viva_app_id="'.$master_table_record_id.'" order by pr_viva_app_id DESC');
		//echo $this->CI->db->last_query();
		$rowtwo = $querytwo->row();
		$querytwo->free_result(); // The $query result object will no longer be available
		if($rowtwo->is_direct_route==1){

			$this->CI->db->select('A.*,B.*,C.*');
            $this->CI->db->from('pr_viva_application A');
            $this->CI->db->join('directroute_registrations B', 'B.user_id = A.member_id', 'INNER');
            $this->CI->db->join('pr_viva_batch C', 'C.pr_viva_batch_id = A.batch_id', 'INNER');
            $this->CI->db->where('A.pr_viva_app_id', $master_table_record_id);
            $this->CI->db->where('B.state', 1);
            $query = $this->CI->db->get();

		}else{

			$this->CI->db->select('A.*,B.*,C.*');
            $this->CI->db->from('pr_viva_application A');
            $this->CI->db->join('member_profile_data B', 'B.user_id = A.member_id', 'INNER');
            $this->CI->db->join('pr_viva_batch C', 'C.pr_viva_batch_id = A.batch_id', 'INNER');
            $this->CI->db->where('A.pr_viva_app_id', $master_table_record_id);
            $this->CI->db->where('B.state', 1);
            $query = $this->CI->db->get();
		}
		}

		if($master_table_name=='event_member_registration'){

			$this->CI->db->select('A.*,B.*,C.*');
			$this->CI->db->from('event_member_registration A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
			$this->CI->db->join('event_initiation C', 'C.event_initiation_id = A.event_initiation_id', 'INNER');
		    $this->CI->db->where('A.event_registration_id', $master_table_record_id);
		     $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='cpd_member_registration'){

			$this->CI->db->select('A.*,B.*,C.*');
			$this->CI->db->from('cpd_member_registration A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
			$this->CI->db->join('cpd_initiation C', 'C.event_initiation_id = A.event_initiation_id', 'INNER');
		    $this->CI->db->where('A.event_registration_id', $master_table_record_id);
		     $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='elearning_registrations'){

			$this->CI->db->select('A.*,B.*,C.*');
			$this->CI->db->from('elearning_registrations A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
			$this->CI->db->join('elearning_courses C', 'C.Elearning_course_id = A.Elearning_course_id', 'INNER');
		    $this->CI->db->where('A.elearning_registration_id', $master_table_record_id);
		     $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}


		if($master_table_name=='techeng_registrations'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('techeng_registrations A');
		    $this->CI->db->where('A.user_tbl_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}
		if($master_table_name=='member_reinstatement'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('member_reinstatement A');
		    $this->CI->db->where('A.rein_tbl_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}
		if($master_table_name=='mem_transfer_registrations'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('mem_transfer_registrations A');
		    $this->CI->db->where('A.mem_transfer_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}
		if($master_table_name=='training_org_recommendation'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('training_org_recommendation A');
		    $this->CI->db->where('A.org_tbl_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='member_subscription'){

			$this->CI->db->select('A.*,B.*');
			$this->CI->db->from('member_subscription A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
		    $this->CI->db->where('A.subscription_id', $master_table_record_id);
		     $this->CI->db->where_in('B.state', $profileStates);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='cdp_applications'){

			$this->CI->db->select('A.*,B.*');
			$this->CI->db->from('cdp_applications A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
		    $this->CI->db->where('A.cdp_tbl_id', $master_table_record_id);
		    $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='directroute_registrations'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('directroute_registrations A');
		    $this->CI->db->where('A.user_tbl_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}

		//test
		if($master_table_name=='adjudicator_application'){
			$this->CI->db->select('A.*,B.*,C.*');
			$this->CI->db->from('adjudicator_application A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
			$this->CI->db->join('ceo_directories C', 'C.directory_id = A.ceo_directory_id', 'INNER');
		    $this->CI->db->where('A.adj_app_id', $master_table_record_id);
		    $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}

		//adjudicator_and_arbitrator_application
		if($master_table_name=='adjudicator_and_arbitrator_application'){
			$this->CI->db->select('A.*,B.*,C.*');
			$this->CI->db->from('adjudicator_and_arbitrator_application A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
			$this->CI->db->join('ceo_directories C', 'C.directory_id = A.ceo_directory_id', 'INNER');
		    $this->CI->db->where('A.adj_app_id', $master_table_record_id);
		    $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}


		if($master_table_name=='ceo_building_services_application'){
			$this->CI->db->select('A.*,B.*,C.*');
			$this->CI->db->from('ceo_building_services_application A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.created_by', 'INNER');
			$this->CI->db->join('ceo_directories C', 'C.directory_id = A.ceo_directory_id', 'INNER');
		    $this->CI->db->where('A.building_service_id', $master_table_record_id);
		    $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
                    //    print_r($this->CI->db->last_query());
                    //    exit;
		}

		if($master_table_name=='structural_engineers_application'){
			$this->CI->db->select('A.*,B.*,C.*');
			$this->CI->db->from('structural_engineers_application A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
			$this->CI->db->join('ceo_directories C', 'C.directory_id = A.ceo_directory_id', 'INNER');
		    $this->CI->db->where('A.structural_eng_id', $master_table_record_id);
		    $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
                        
		}


		if($master_table_name=='edu_de_application'){
			$this->CI->db->select('A.*');
			$this->CI->db->from('edu_de_application A');
		    $this->CI->db->where('A.edu_de_application_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}


		if($master_table_name=='member_fund_payment'){

			$this->CI->db->select('A.*,B.*');
			$this->CI->db->from('member_fund_payment A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
		    $this->CI->db->where('A.fund_payment_id', $master_table_record_id);
		   // $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='member_recover'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('member_recover A');
		    $this->CI->db->where('A.rein_tbl_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}

	  if($master_table_name=='edu_exam_application'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('edu_exam_application A');
		    $this->CI->db->where('A.exam_application_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}

				if($master_table_name=='member_wallet_logs'){

			$this->CI->db->select('A.*,B.*');
			$this->CI->db->from('member_wallet_logs A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
		    $this->CI->db->where('A.wallet_log_id', $master_table_record_id);
		   // $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='ecsl_member'){

			$this->CI->db->select('A.*,B.*');
			$this->CI->db->from('ecsl_member A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
		    $this->CI->db->where('A.subscription_id', $master_table_record_id);
		    $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}


		if($master_table_name=='pe_data'){

			$this->CI->db->select('B.user_id, B.user_name_initials, B.user_name_lastname, A.pe_membership_number AS membership_number, A.pe_permanent_addr AS user_permanent_addr, B.user_nic_old, B.user_nic, B.user_member_class');
			$this->CI->db->from('pe_data A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
		    $this->CI->db->where('A.pe_tbl_id', $master_table_record_id);
		    $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}

	    if($master_table_name=='de_member_registrations'){

			$this->CI->db->select('A.*');
			$this->CI->db->from('de_member_registrations A');
		    $this->CI->db->where('A.user_tbl_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}	


	      $this->CI->db->last_query();
		$row = $query->row();
		$query->free_result(); // The $query result object will no longer be available
		if(!empty($row)){
			return  $row;
		}else{
			return 0;
		}

	}

		public function getSubPaymentDetails($membership_class_id,$main_payment_category_id){

		//Get Sub Payment Results
		$this->CI =& get_instance();
		$this->CI->load->database();
			$this->CI->db->select('A.*,B.*,C.*,D.*');
			$this->CI->db->from('sub_payment_category_membership_class A');
			$this->CI->db->join('master_sub_payment_categories B', 'B.sub_payment_category_id = A.sub_payment_category_id', 'INNER');
			$this->CI->db->join('master_classes_of_membership C', 'C.class_of_membership_id = A.class_of_membership_id', 'INNER');
			$this->CI->db->join('master_main_payment_categories D', 'D.main_payment_category_id = A.main_payment_category_id', 'INNER');
		    $this->CI->db->where('A.class_of_membership_id', $membership_class_id);
		    $this->CI->db->where('A.main_payment_category_id', $main_payment_category_id);
		     $this->CI->db->order_by("B.sub_payment_category_id", "DESC");
			$query = $this->CI->db->get(); 
	      $this->CI->db->last_query();
		$row = $query->row();
		$query->free_result(); // The $query result object will no longer be available
		if(!empty($row)){
			return  $row;
		}else{
			return 0;
		}

	}


	public function RemoveOutstandingPaymentFromList($master_table_name,$master_table_record_id){

		if($master_table_record_id>0){

			//remove outstanding payment record after online payment 
			$this->CI =& get_instance();
			$this->CI->load->database();

			$data1 = array(
			'state' =>  -2,
			);

			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->where('state', 0);
			return $flag = $this->CI->db->update('outstanding_payments', $data1);

		}

		return true;


	}	

		public function RemoveInvoiceFromList($master_table_name,$master_table_record_id,$user_id,$cancel_remarks){
			//remove outstanding payment record after online payment 
			$this->CI =& get_instance();
			$this->CI->load->database();

			$data1 = array(
			'cancel_remarks' => $cancel_remarks,	
			'state' =>  -2,
			);

			$this->CI->db->where('user_id', $user_id);
			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->order_by('invoice_id', 'DESC');
 			$this->CI->db->limit(1);
			return $flag = $this->CI->db->update('invoices', $data1);



	}

		public function UpdateOutstandingPaymentFromStatus($master_table_name,$master_table_record_id){
			//remove outstanding payment record after online payment 
			$this->CI =& get_instance();
			$this->CI->load->database();

			$data1 = array(
			'payment_status_id' =>  2,
			'state' =>  1,
			);

			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->where('state', 0);
			return $flag = $this->CI->db->update('outstanding_payments', $data1);



	}	

		public function UpdateInvoiceTablePaymentStatus($master_table_name,$master_table_record_id,$paymethod){

		   date_default_timezone_set('Asia/Colombo');
           $payment_date=date("Y-m-d")." ".date("h:i:s");


			//remove outstanding payment record after online payment 
			$this->CI =& get_instance();
			$this->CI->load->database();

			$data1 = array(
			'payment_status_id' =>  2,
			'payment_date' =>  $payment_date,
			'paymethod' =>  $paymethod,
			);

			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->where('state', 1);
			$this->CI->db->order_by('invoice_id', 'DESC');
 			$this->CI->db->limit(1);
			return $flag = $this->CI->db->update('invoices', $data1);



	}


		public function UpdateInvoiceTablePaymentReferenceNo($payment_dashboard_id){
       	   date_default_timezone_set('Asia/Colombo');
           $payment_date_time=date("Y-m-d")." ".date("h:i:s");
           $payment_date=date("Y-m-d");

           for ($ig=0; $ig < 10 ; $ig++) { 

           	 $receipt_no=$this->getMaxReferenceNumber();
              $receipt_no=$receipt_no+1;

           		$checkalreadyexsist=$this->CheckMaxReferenceNumber($receipt_no);
           		if($checkalreadyexsist==0){
           			
           			break;
           		}
        
           }


			//remove outstanding payment record after online payment 
			$this->CI =& get_instance();
			$this->CI->load->database();

			$data1 = array(
			'receipt_no' =>  $receipt_no,
			'is_new_receipt' =>  1,
			'payment_date' =>  $payment_date,
			'payment_date_time' =>  $payment_date_time
			);

			$this->CI->db->where('payment_dashboard_id', $payment_dashboard_id);
			$this->CI->db->where('receipt_no', 0);
			$this->CI->db->where('reverse_status', 0);
			$this->CI->db->order_by('low_payment_id', 'DESC');
			return $flag = $this->CI->db->update('member_low_payment', $data1);



	}

	public function getReceiptNo(){
		  $this->CI =& get_instance();
	      $this->CI->load->database();
	      $session_id=session_id();
	
	      $incrementStatus = $this->CI->db->query("UPDATE receiptno_sequences SET sequence_value = sequence_value + 1, session_id='".$session_id."'");
	      if($incrementStatus){
	      		  $this->CI->db->select('MAX(sequence_value) AS sequence_value');
                  $this->CI->db->from('receiptno_sequences');
                  $this->CI->db->where('session_id', $session_id);
                  $this->CI->db->limit(1);
       			return  $result_array= $this->CI->db->get()->row()->sequence_value;

	      }
	}


	public function DeleteReceiptRelatedcategories($payment_dashboard_id,$low_payment_id){
		   $this->CI =& get_instance();
		   $this->CI->load->database();
	       $this->CI->db->where('payment_dashboard_id', $payment_dashboard_id);
	       $this->CI->db->where('low_payment_id', $low_payment_id);
           $this->CI->db->delete('receipt_related_taxes');
	}

		public function DeleteReceiptRelatedFundcategories($payment_dashboard_id,$main_payment_category_id){
		   $this->CI =& get_instance();
		   $this->CI->load->database();
	       $this->CI->db->where('payment_dashboard_id', $payment_dashboard_id);
           $this->CI->db->where('main_payment_category_id', $main_payment_category_id);
           $this->CI->db->delete('receipt_related_taxes');
	}


	public function getLowPaymentResult($low_payment_id){

	   $this->CI =& get_instance();
	   $this->CI->load->database();
	   $this->CI->db->select('*');
       $this->CI->db->from('member_low_payment');
       $this->CI->db->where('low_payment_id', $low_payment_id);
       return  $result_array= $this->CI->db->get()->row();

	}
	


	public function CheckMaxReferenceNumber($receipt_no){

	   $this->CI =& get_instance();
	   $this->CI->load->database();
	   $this->CI->db->select('COUNT(receipt_no) AS total');
       $this->CI->db->from('member_low_payment');
       $this->CI->db->where('receipt_no', $receipt_no);
       return  $result_array= $this->CI->db->get()->row()->total;

	}


	public function getMaxReferenceNumber(){

	   $this->CI =& get_instance();
	   $this->CI->load->database();
	   $this->CI->db->select('MAX(receipt_no) AS receipt_no');
       $this->CI->db->from('member_low_payment');
       return  $result_array= $this->CI->db->get()->row()->receipt_no;

	}

		public function CheckAndGetWalletAmountRelatedInvoice($payment_dashboard_id){

	   $this->CI =& get_instance();
	   $this->CI->load->database();
	   $this->CI->db->select('low_payment_id,low_payment_amount');
       $this->CI->db->from('member_low_payment');
       $this->CI->db->where('payment_dashboard_id =', $payment_dashboard_id);
       $this->CI->db->where('payment_status_id =', 0);
       $this->CI->db->where('receipt_no =', 0);
       $this->CI->db->where('payment_method_id =', 7);
       $this->CI->db->where('state =', 1);       
       $result_array= $this->CI->db->get()->row();
       if($result_array){
       		return $result_array;
       }else{
       		return 0;
       }

	}

   public function insertInvoiceRelatedTaxesAdvanceReinstatement($invoice_id,$master_table_name,$master_table_record_id,$amount_without_tax,$final_amount,$nbt_amount,$vat_amount,$is_tax_enable,$nbt_presentage,$vat_presentage,$is_registration_with_subscription,$reg_or_subscrip,$main_payment_category_id,$sub_payment_category_id,$is_discount,$discount_amount,$user_id){

   		   $this->CI =& get_instance();
	   $this->CI->load->database();


			$array2 = array(					
			'invoice_id' => $invoice_id,		
			'master_table_name' => $master_table_name,
			'master_table_record_id' => $master_table_record_id,
			'amount_without_tax' => $amount_without_tax,
			'final_amount' => $final_amount,
			'nbt_amount' => $nbt_amount,
			'vat_amount' => $vat_amount,
			'is_tax_enable' => $is_tax_enable,
			'nbt_presentage' => $nbt_presentage,
			'vat_presentage' => $vat_presentage,
			'is_registration_with_subscription' => $is_registration_with_subscription,
			'reg_or_subscrip' => $reg_or_subscrip,
			'main_payment_category_id' => $main_payment_category_id,
			'sub_payment_category_id' => $sub_payment_category_id,
			'is_discount' => $is_discount,
			'discount_amount' => $discount_amount,
			'user_id' => $user_id

			);

			$this->CI->db->set($array2);
			$this->CI->db->insert('reinstate_advance_pay_related_taxes');

			$this->CI->db->last_query();
			$this->CI->db->insert_id();
    }










public function SavePaymentCategoryWiseDataSaveReinstatement($low_payment_id,$low_payment_amount,$payment_dashboard_id,$invoice_id,$main_payment_category_id){

	$invoice_related_taxes_arrias=$this->getInvoiceRelatedTaxResults($invoice_id,64);
	$receipt_related_taxes_arrias=$this->getReceiptRelatedTaxResults($invoice_id,64);
	$receipttotal_arrias=$receipt_related_taxes_arrias[0]->receipttotal;
	if($receipt_related_taxes_arrias[0]->receipttotal==''){
		$receipttotal_arrias=0;
	}

	

	$paidarriasamount=$receipttotal_arrias+$low_payment_amount;
	if($invoice_related_taxes_arrias[0]->total>=$paidarriasamount){

            if($invoice_related_taxes_arrias[0]->is_tax_enable==1){


            if($invoice_related_taxes_arrias[0]->vat_amount>0){

			 	$vatamount=$this->CalculateVatGivenAmount($low_payment_amount,$invoice_related_taxes_arrias[0]->vat_presentage);
					 				
				}else{
				   $vatamount=0;
				}


		if($invoice_related_taxes_arrias[0]->nbt_amount>0){

		$nbtamount=$this->CalculateNbtGivenAmount($low_payment_amount,$invoice_related_taxes_arrias[0]->nbt_presentage,$vatamount);
					 			
		}else{
			$nbtamount=0;
		} 		

	     	
	     	 $item_amount=$low_payment_amount-$vatamount-$nbtamount;
	     	   

	     	  }else{
	     	$item_amount=$low_payment_amount;
	     	$nbtamount=0;
	     	$vatamount=0;
	          }

			$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_arrias);	
	 }else{


	 	    $rest_arras_amount=$invoice_related_taxes_arrias[0]->total-$receipttotal_arrias;

	
	 	  if($rest_arras_amount>0){	
	 	if($invoice_related_taxes_arrias[0]->is_tax_enable==1){

            if($invoice_related_taxes_arrias[0]->vat_amount>0){

			 	$vatamount=$this->CalculateVatGivenAmount($rest_arras_amount,$invoice_related_taxes_arrias[0]->vat_presentage);
					 				
				}else{
				   $vatamount=0;
				}

		if($invoice_related_taxes_arrias[0]->nbt_amount>0){

		$nbtamount=$this->CalculateNbtGivenAmount($rest_arras_amount,$invoice_related_taxes_arrias[0]->nbt_presentage,$vatamount);
					 			
		}else{
			$nbtamount=0;
		} 



	     	 $item_amount=$rest_arras_amount-$vatamount-$nbtamount;
	     	  

	     	  }else{
	     	$item_amount=$rest_arras_amount;
	     	$nbtamount=0;
	     	$vatamount=0;
	          }

			$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_arrias);	

			}  



			$pay_subs_amount=$low_payment_amount-$rest_arras_amount;



			$invoice_related_taxes_subs=$this->getInvoiceRelatedTaxResults($invoice_id,2);
			$receipt_related_taxes_subs=$this->getReceiptRelatedTaxResults($invoice_id,2);
			$receipttotal_subs=$receipt_related_taxes_subs[0]->receipttotal;
			if($receipt_related_taxes_subs[0]->receipttotal==''){
			$receipttotal_subs=0;
			}

			$paidsubsamount=$receipttotal_subs+$pay_subs_amount;

			if($invoice_related_taxes_subs[0]->total>=$paidsubsamount){

            if($invoice_related_taxes_subs[0]->is_tax_enable==1){

               if($invoice_related_taxes_subs[0]->vat_amount>0){

			 	$vatamount=$this->CalculateVatGivenAmount($pay_subs_amount,$invoice_related_taxes_subs[0]->vat_presentage);
					 				
				}else{
				   $vatamount=0;
				}

		if($invoice_related_taxes_subs[0]->nbt_amount>0){

		$nbtamount=$this->CalculateNbtGivenAmount($pay_subs_amount,$invoice_related_taxes_subs[0]->nbt_presentage,$vatamount);
					 			
		}else{
			$nbtamount=0;
		}


	     	 $item_amount=$pay_subs_amount-$vatamount-$nbtamount;
	     	 

	     	  }else{
	     	$item_amount=$pay_subs_amount;
	     	$nbtamount=0;
	     	$vatamount=0;
	          }

			$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_subs);	
	 

	         }else{

	 	        $rest_subs_amount=$invoice_related_taxes_subs[0]->total-$receipttotal_subs;

	 	        	if($rest_subs_amount>0){
					if($invoice_related_taxes_subs[0]->is_tax_enable==1){

		               if($invoice_related_taxes_subs[0]->vat_amount>0){

					 	$vatamount=$this->CalculateVatGivenAmount($rest_subs_amount,$invoice_related_taxes_subs[0]->vat_presentage);
							 				
						}else{
						   $vatamount=0;
						}

		if($invoice_related_taxes_subs[0]->nbt_amount>0){

		$nbtamount=$this->CalculateNbtGivenAmount($rest_subs_amount,$invoice_related_taxes_subs[0]->nbt_presentage,$vatamount);
					 			
		}else{
			$nbtamount=0;
		}



					$item_amount=$rest_subs_amount-$vatamount-$nbtamount;
					  

					}else{
					$item_amount=$rest_subs_amount;
					$nbtamount=0;
					$vatamount=0;
					}

					$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_subs);	

			    	}

					  $pay_surcharge_amount=$low_payment_amount-$rest_subs_amount-$rest_arras_amount;

					$invoice_related_taxes_surcharge=$this->getInvoiceRelatedTaxResults($invoice_id,63);
					$receipt_related_taxes_surcharge=$this->getReceiptRelatedTaxResults($invoice_id,63);
					$receipttotal_surcharge=$receipt_related_taxes_surcharge[0]->receipttotal;
					if($receipt_related_taxes_surcharge[0]->receipttotal==''){
					$receipttotal_surcharge=0;
					}


					if(!empty($invoice_related_taxes_surcharge)){

					$paidsurchargeamount=$receipttotal_surcharge+$pay_surcharge_amount;
						if($paidsurchargeamount>0){

							$item_amount=$pay_surcharge_amount;
						$nbtamount=0;
						$vatamount=0;

						if($invoice_related_taxes_surcharge[0]->total<$item_amount){
					          		$item_amount=$invoice_related_taxes_surcharge[0]->total;
					          }

				
						$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_surcharge);

						}
			
							
						}
					

	 	      }

}

}


public function CalculateVatGivenAmount($amount,$presentage){

  return $vatamount=($amount*$presentage)/(100+$presentage);

}

public function CalculateNbtGivenAmount($amount,$presentage,$vatamount){

  return $nbtamount=(($amount-$vatamount)*$presentage)/(100+$presentage);

}


public function SavePaymentCategoryWiseMore($low_payment_id,$low_payment_amount,$payment_dashboard_id,$invoice_id,$main_payment_category_id){

	$array_res=$this->getRecordCountInvoiceRelatedTax($invoice_id);

	

	foreach ($array_res as $key => $valueres) {

	
		

		   $invoice_related_taxes_one=$this->getInvoiceRelatedTaxResults($invoice_id,$valueres->main_payment_category_id,$valueres->sub_payment_category_id);

			$receipt_related_taxes_one=$this->getReceiptRelatedTaxResults($invoice_id,$valueres->main_payment_category_id,$valueres->sub_payment_category_id);

/*echo $invoice_related_taxes_one[0]->total;
echo "<br>";
echo $receipt_related_taxes_one[0]->receipttotal;
	echo "<br>,";	*/	


		

			$receipttotal_one=$receipt_related_taxes_one[0]->receipttotal;
			if($receipt_related_taxes_one[0]->receipttotal==''){
				$receipttotal_one=0;
			}

				//$paidoneamount=$receipttotal_one+$low_payment_amount;



			if($low_payment_amount>=$invoice_related_taxes_one[0]->total-$receipttotal_one){

				$low_payment_amount1=$invoice_related_taxes_one[0]->total-$receipttotal_one;
			}else{
				$low_payment_amount1=$low_payment_amount;
			}

				

		            if($invoice_related_taxes_one[0]->is_tax_enable==1){

			 		if($invoice_related_taxes_one[0]->vat_amount>0){

			 				$vatamount=$this->CalculateVatGivenAmount($low_payment_amount1,$invoice_related_taxes_one[0]->vat_presentage);
					 				
					 		}else{
					 			$vatamount=0;
					 		}

						if($invoice_related_taxes_one[0]->nbt_amount>0){


								$nbtamount=$this->CalculateNbtGivenAmount($low_payment_amount1,$invoice_related_taxes_one[0]->nbt_presentage,$vatamount);

					 			
					 		}else{
					 			$nbtamount=0;
					 		} 		

			     	 
			     	 $item_amount=$low_payment_amount1-$vatamount-$nbtamount;
			     	   	//$nbtamount=0;

			     	  }else{

			     	$item_amount=$low_payment_amount1;
			     	$nbtamount=0;
			     	$vatamount=0;
			          }

			          if($item_amount>0){
			          	$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_one);	
			          }
					

					

$low_payment_amount=$low_payment_amount+$receipttotal_one-$invoice_related_taxes_one[0]->total;




			 




			
	}
}



public function SavePaymentCategoryWiseDataSaveOther($low_payment_id,$low_payment_amount,$payment_dashboard_id,$invoice_id,$main_payment_category_id,$advance_pay=0){


	if($main_payment_category_id==2 and $advance_pay>0){
       $array_res=$this->getRecordCountInvoiceRelatedTaxforSubscription($invoice_id);
	}else{
		$array_res=$this->getRecordCountInvoiceRelatedTax($invoice_id);
	}

	
	$total_record=count($array_res);

	
	if($total_record==2){

			$invoice_related_taxes_one=$this->getInvoiceRelatedTaxResults($invoice_id,$array_res[0]->main_payment_category_id,$array_res[0]->sub_payment_category_id);
			$receipt_related_taxes_one=$this->getReceiptRelatedTaxResults($invoice_id,$array_res[0]->main_payment_category_id,$array_res[0]->sub_payment_category_id);
			$receipttotal_one=$receipt_related_taxes_one[0]->receipttotal;
			if($receipt_related_taxes_one[0]->receipttotal==''){
				$receipttotal_one=0;
			}

			

			$paidoneamount=$receipttotal_one+$low_payment_amount;
			if($invoice_related_taxes_one[0]->total>=$paidoneamount){

		            if($invoice_related_taxes_one[0]->is_tax_enable==1){

			 		if($invoice_related_taxes_one[0]->vat_amount>0){

			 				$vatamount=$this->CalculateVatGivenAmount($low_payment_amount,$invoice_related_taxes_one[0]->vat_presentage);
					 				
					 		}else{
					 			$vatamount=0;
					 		}

						if($invoice_related_taxes_one[0]->nbt_amount>0){


								$nbtamount=$this->CalculateNbtGivenAmount($low_payment_amount,$invoice_related_taxes_one[0]->nbt_presentage,$vatamount);

					 			
					 		}else{
					 			$nbtamount=0;
					 		} 		

			     	 
			     	 $item_amount=$low_payment_amount-$vatamount-$nbtamount;
			     	   	//$nbtamount=0;

			     	  }else{
			     	$item_amount=$low_payment_amount;
			     	$nbtamount=0;
			     	$vatamount=0;
			          }

					$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_one);	
			 }else{


				 $rest_one_amount=$invoice_related_taxes_one[0]->total-$receipttotal_one;

					
					 	  if($rest_one_amount>0){	

					 	  	if(!empty($invoice_related_taxes_one)){
					 	if($invoice_related_taxes_one[0]->is_tax_enable==1){

					 		if($invoice_related_taxes_one[0]->vat_amount>0){

					 			$vatamount=$this->CalculateVatGivenAmount($rest_one_amount,$invoice_related_taxes_one[0]->vat_presentage);

					 		}else{
					 			$vatamount=0;
					 		}

					 		if($invoice_related_taxes_one[0]->nbt_amount>0){

								$nbtamount=$this->CalculateNbtGivenAmount($rest_one_amount,$invoice_related_taxes_one[0]->nbt_presentage,$vatamount);
					 				
					 		}else{
					 			$nbtamount=0;
					 		}
					     	 
					     	 $item_amount=$rest_one_amount-$vatamount-$nbtamount;
					     	   

					     	  }else{
					     	$item_amount=$rest_one_amount;
					     	$nbtamount=0;
					     	$vatamount=0;
					          }

							$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_one);	

							}  

						}

							$pay_two_amount=$low_payment_amount-$rest_one_amount;



							$invoice_related_taxes_two=$this->getInvoiceRelatedTaxResults($invoice_id,$array_res[1]->main_payment_category_id,$array_res[1]->sub_payment_category_id);
							$receipt_related_taxes_two=$this->getReceiptRelatedTaxResults($invoice_id,$array_res[1]->main_payment_category_id,$array_res[1]->sub_payment_category_id);
							$receipttotal_two=$receipt_related_taxes_two[0]->receipttotal;
							if($receipt_related_taxes_two[0]->receipttotal==''){
							$receipttotal_two=0;
							}

			if($main_payment_category_id==2 and $advance_pay>0){
				$invoice_related_taxes_two[0]->total=$invoice_related_taxes_two[0]->total-$advance_pay;

			}



							if(!empty($invoice_related_taxes_two)){				
				            if($invoice_related_taxes_two[0]->is_tax_enable==1){

				            if($invoice_related_taxes_two[0]->vat_amount>0){

				            	$vatamount=$this->CalculateVatGivenAmount($pay_two_amount,$invoice_related_taxes_two[0]->vat_presentage);

					     	}else{
					 			$vatamount=0;
					 		}

				 		if($invoice_related_taxes_two[0]->nbt_amount>0){

				 			$nbtamount=$this->CalculateNbtGivenAmount($pay_two_amount,$invoice_related_taxes_two[0]->nbt_presentage,$vatamount);

					 			
					 		}else{
					 			$nbtamount=0;
					 		}



					     	 $item_amount=$pay_two_amount-$vatamount-$nbtamount;
					     	   	//$nbtamount=0;





					     	  }else{
					     	$item_amount=$pay_two_amount;
					     	$nbtamount=0;
					     	$vatamount=0;
					          }

					          if($invoice_related_taxes_two[0]->total<$item_amount){
					          		$item_amount=$invoice_related_taxes_two[0]->total;
					          }

							$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_two);

							}		

			 }


	}else if($total_record>2){

		$this->SavePaymentCategoryWiseMore($low_payment_id,$low_payment_amount,$payment_dashboard_id,$invoice_id,$main_payment_category_id);

	}else{
	$this->SavePaymentCategoryWiseDataSave($low_payment_id,$low_payment_amount,$payment_dashboard_id,$invoice_id,$array_res[0]->main_payment_category_id);

	}

}

public function getRecordCountInvoiceRelatedTaxforSubscription($invoice_id){


	   $this->CI =& get_instance();
	   $this->CI->load->database();

        $this->CI->db->select('A.*');
        $this->CI->db->from('invoice_related_taxes AS A');
        $this->CI->db->join('invoices AS B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('A.invoice_id =', $invoice_id);
        $this->CI->db->where('A.state =', 1); 
        $this->CI->db->order_by('A.invoice_related_tax_id', 'desc');
        $data_result= $this->CI->db->get();
        return $data_result->result();



}


public function getRecordCountInvoiceRelatedTax($invoice_id){


	   $this->CI =& get_instance();
	   $this->CI->load->database();

        $this->CI->db->select('A.*');
        $this->CI->db->from('invoice_related_taxes AS A');
        $this->CI->db->join('invoices AS B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('A.invoice_id =', $invoice_id);
        $this->CI->db->where('A.state =', 1); 
        $this->CI->db->order_by('A.invoice_related_tax_id', 'asc');
        $data_result= $this->CI->db->get();
        return $data_result->result();



}

public function getRecordCountInvoiceRelatedTaxAdvancePay($invoice_id){


	   $this->CI =& get_instance();
	   $this->CI->load->database();

        $this->CI->db->select('A.*');
        $this->CI->db->from('reinstate_advance_pay_related_taxes AS A');
        $this->CI->db->join('invoices AS B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('A.invoice_id =', $invoice_id);
        $this->CI->db->where('A.state =', 1); 
        $this->CI->db->order_by('A.invoice_related_tax_id', 'asc');
        $data_result= $this->CI->db->get();
        return $data_result->result();



}


public function SavePaymentCategoryWiseDataSaveAdvancePayment($low_payment_id,$low_payment_amount,$payment_dashboard_id,$invoice_id,$main_payment_category_id,$membership_class_id,$dateupdate=''){

			//this condition only for data migration
			date_default_timezone_set('Asia/Colombo');
            $payment_date=date("Y-m-d")." ".date("h:i:s");
            if($dateupdate=='' || $dateupdate=='0000-00-00 00:00:00'){
            	$dateupdate=$payment_date;
            }
            //end condition


	        $this->CI =& get_instance();
			$this->CI->load->database();
			$invoice_related_taxes=$this->getInvoiceRelatedTaxResults($invoice_id,2);
            $vat_amount=$this->CalculateVatGivenAmount($low_payment_amount,$invoice_related_taxes[0]->vat_presentage);  
            $amount_without_tax=$low_payment_amount-$vat_amount;           
            $total_amount=$low_payment_amount;
            $nbtamount=0;

             

             $sub_payment_category_id=$this->GetSubpymentCatID($membership_class_id,$main_payment_category_id); 

			if($invoice_related_taxes[0]->is_tax_enable==''){
				$invoice_related_taxes[0]->is_tax_enable=0;
			}

			$array2 = array(									
			'low_payment_id' => $low_payment_id,
			'payment_dashboard_id' => $payment_dashboard_id,
			'invoice_id' => $invoice_id,	
			'amount_without_tax' => $amount_without_tax,
			'final_amount' => $total_amount,
			'is_tax_enable' => $invoice_related_taxes[0]->is_tax_enable,
			'nbt_amount' => $nbtamount,
			'vat_amount' => $vat_amount,
			'nbt_presentage' => $invoice_related_taxes[0]->nbt_presentage,
			'vat_presentage' => $invoice_related_taxes[0]->vat_presentage,
			'main_payment_category_id' => $main_payment_category_id,
			'sub_payment_category_id' => $sub_payment_category_id,

			//this condition only for data migration
				'created_date' => $dateupdate,	
			//end condition				
		
			'user_id' => $invoice_related_taxes[0]->user_id
			);

			$this->CI->db->set($array2);
			$this->CI->db->insert('receipt_related_taxes');

			$this->CI->db->last_query();
			$this->CI->db->insert_id();

}


public function SavePaymentCategoryWiseMoreAdvancePayReinstatement($low_payment_id,$low_payment_amount,$payment_dashboard_id,$invoice_id,$main_payment_category_id){

	$array_res=$this->getRecordCountInvoiceRelatedTaxAdvancePay($invoice_id);

	
	foreach ($array_res as $key => $valueres) {

	
		

		   $invoice_related_taxes_one=$this->getInvoiceRelatedTaxResultsAdvancePayReinstate($invoice_id,$valueres->main_payment_category_id,$valueres->sub_payment_category_id);

			$receipt_related_taxes_one=$this->getReceiptRelatedTaxResults($invoice_id,$valueres->main_payment_category_id,$valueres->sub_payment_category_id);

/*echo $invoice_related_taxes_one[0]->total;
echo "<br>";
echo $receipt_related_taxes_one[0]->receipttotal;
	echo "<br>,";	*/	


		

			$receipttotal_one=$receipt_related_taxes_one[0]->receipttotal;
			if($receipt_related_taxes_one[0]->receipttotal==''){
				$receipttotal_one=0;
			}

				//$paidoneamount=$receipttotal_one+$low_payment_amount;



			if($low_payment_amount>=$invoice_related_taxes_one[0]->total-$receipttotal_one){

				$low_payment_amount1=$invoice_related_taxes_one[0]->total-$receipttotal_one;
			}else{
				$low_payment_amount1=$low_payment_amount;
			}

				

		            if($invoice_related_taxes_one[0]->is_tax_enable==1){

			 		if($invoice_related_taxes_one[0]->vat_amount>0){

			 				$vatamount=$this->CalculateVatGivenAmount($low_payment_amount1,$invoice_related_taxes_one[0]->vat_presentage);
					 				
					 		}else{
					 			$vatamount=0;
					 		}

						if($invoice_related_taxes_one[0]->nbt_amount>0){


								$nbtamount=$this->CalculateNbtGivenAmount($low_payment_amount1,$invoice_related_taxes_one[0]->nbt_presentage,$vatamount);

					 			
					 		}else{
					 			$nbtamount=0;
					 		} 		

			     	 
			     	 $item_amount=$low_payment_amount1-$vatamount-$nbtamount;
			     	   	//$nbtamount=0;

			     	  }else{

			     	$item_amount=$low_payment_amount1;
			     	$nbtamount=0;
			     	$vatamount=0;
			          }

			          if($item_amount>0){
			          	$this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes_one);	
			          }
					

					

$low_payment_amount=$low_payment_amount+$receipttotal_one-$invoice_related_taxes_one[0]->total;




			 




			
	}
}




public function SavePaymentCategoryWiseDataSave($low_payment_id,$low_payment_amount,$payment_dashboard_id,$invoice_id,$main_payment_category_id){

	     $invoice_related_taxes=$this->getInvoiceRelatedTaxResults($invoice_id,$main_payment_category_id);
	      $paywalletamount=$low_payment_amount;

	     

	     if($invoice_related_taxes[0]->is_tax_enable==1){
	     	
	     	




			 		if($invoice_related_taxes[0]->vat_amount>0){

			 			$vatamount=$this->CalculateVatGivenAmount($paywalletamount,$invoice_related_taxes[0]->vat_presentage);
					 			
					 		}else{
					 			$vatamount=0;
					 		}

						if($invoice_related_taxes[0]->nbt_amount>0){

							$nbtamount=$this->CalculateNbtGivenAmount($paywalletamount,$invoice_related_taxes[0]->nbt_presentage,$vatamount);

					 			
					 		}else{
					 			$nbtamount=0;
					 		} 

				 $item_amount=$paywalletamount-$vatamount-$nbtamount;	 		


/*	     	if($invoice_related_taxes->nbt_amount[0]>0){
	     		$nbtamount=((($paywalletamount*$invoice_related_taxes[0]->vat_presentage)/100-$vatamount)*$invoice_related_taxes[0]->nbt_presentage)/100;
	     	}else{*/
	     		//$nbtamount=0;
	     /*	}*/
	     	

	     }else{
	     	$item_amount=$paywalletamount;
	     	$nbtamount=0;
	     	$vatamount=0;
	     }

							if($invoice_related_taxes[0]->total<$item_amount){
					          		$item_amount=$invoice_related_taxes[0]->total;
					          }

	     $this->InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes);	

	    

}

public function InsertReceiptRelatedTaxes($low_payment_id,$item_amount,$payment_dashboard_id,$invoice_id,$nbtamount,$vatamount,$invoice_related_taxes){

		    $this->CI =& get_instance();
			$this->CI->load->database();

			$lowPayRes=$this->getLowPaymentResult($low_payment_id);
			//this condition only for data migration
			date_default_timezone_set('Asia/Colombo');
            $dateupdate=date("Y-m-d")." ".date("h:i:s");
            if($lowPayRes->update_status==1){
            	$dateupdate=$lowPayRes->payment_date_time;
            }
            //end condition



			if($invoice_related_taxes[0]->is_tax_enable==''){
				$invoice_related_taxes[0]->is_tax_enable=0;
			}

			$array2 = array(									
			'low_payment_id' => $low_payment_id,
			'payment_dashboard_id' => $payment_dashboard_id,
			'invoice_id' => $invoice_id,	
			'amount_without_tax' => $item_amount,
			'final_amount' => $item_amount+$vatamount+$nbtamount,
			'is_tax_enable' => $invoice_related_taxes[0]->is_tax_enable,
			'nbt_amount' => $nbtamount,
			'vat_amount' => $vatamount,
			'nbt_presentage' => $invoice_related_taxes[0]->nbt_presentage,
			'vat_presentage' => $invoice_related_taxes[0]->vat_presentage,
			'main_payment_category_id' => $invoice_related_taxes[0]->main_payment_category_id,
			'sub_payment_category_id' => $invoice_related_taxes[0]->sub_payment_category_id,
			'user_id' => $invoice_related_taxes[0]->user_id,
			'created_date' => $dateupdate,	

			);

			$this->CI->db->set($array2);
			$this->CI->db->insert('receipt_related_taxes');

			$this->CI->db->last_query();
			$this->CI->db->insert_id();


}

public function getReceiptRelatedTaxResults($invoice_id,$main_payment_category_id,$sub_payment_category_id=0){

	   $this->CI =& get_instance();
	   $this->CI->load->database();

        $this->CI->db->select('A.*, SUM(A.amount_without_tax + A.vat_amount + A.nbt_amount) AS receipttotal');
        $this->CI->db->from('receipt_related_taxes AS A');
        $this->CI->db->join('invoices AS B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('A.invoice_id =', $invoice_id);
        $this->CI->db->where('A.state =', 1);
        $this->CI->db->where('A.main_payment_category_id =', $main_payment_category_id); 
        if($sub_payment_category_id>0){
        	 $this->CI->db->where('A.sub_payment_category_id =', $sub_payment_category_id); 
        }    
        $data_result= $this->CI->db->get();
        return $data_result->result();

       
    }

public function getInvoiceRelatedTaxResults($invoice_id,$main_payment_category_id,$sub_payment_category_id=0){

	   $this->CI =& get_instance();
	   $this->CI->load->database();

        $this->CI->db->select('IF(A.is_discount=1, (A.amount_without_tax- A.discount_amount), A.amount_without_tax) AS amount_without_tax, A.vat_amount AS vat_amount, A.nbt_amount AS nbt_amount,   IF(A.is_discount=1, ((A.amount_without_tax + A.vat_amount + A.nbt_amount)- A.discount_amount), (A.amount_without_tax + A.vat_amount + A.nbt_amount)) AS total, A.*');
        $this->CI->db->from('invoice_related_taxes AS A');
        $this->CI->db->join('invoices AS B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('A.invoice_id =', $invoice_id);
        $this->CI->db->where('A.state =', 1);
        $this->CI->db->where('A.main_payment_category_id =', $main_payment_category_id); 
        if($sub_payment_category_id>0){
        	 $this->CI->db->where('A.sub_payment_category_id =', $sub_payment_category_id); 
        }   
        $data_result= $this->CI->db->get();
        return $data_result->result();

       
    }


    public function getInvoiceRelatedTaxResultsAdvancePayReinstate($invoice_id,$main_payment_category_id,$sub_payment_category_id=0){

	   $this->CI =& get_instance();
	   $this->CI->load->database();

        $this->CI->db->select('IF(A.is_discount=1, (A.amount_without_tax- A.discount_amount), A.amount_without_tax) AS amount_without_tax, A.vat_amount AS vat_amount, A.nbt_amount AS nbt_amount,   IF(A.is_discount=1, ((A.amount_without_tax + A.vat_amount + A.nbt_amount)- A.discount_amount), (A.amount_without_tax + A.vat_amount + A.nbt_amount)) AS total, A.*');
        $this->CI->db->from('reinstate_advance_pay_related_taxes AS A');
        $this->CI->db->join('invoices AS B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('A.invoice_id =', $invoice_id);
        $this->CI->db->where('A.state =', 1);
        $this->CI->db->where('A.main_payment_category_id =', $main_payment_category_id); 
        if($sub_payment_category_id>0){
        	 $this->CI->db->where('A.sub_payment_category_id =', $sub_payment_category_id); 
        }   
        $data_result= $this->CI->db->get();
        return $data_result->result();

       
    }


	    public function getAllInvoiceRelatedTaxResults($invoice_id){

	   $this->CI =& get_instance();
	   $this->CI->load->database();

        $this->CI->db->select('SUM(IF(A.is_discount=1, (A.amount_without_tax- A.discount_amount), A.amount_without_tax)) AS amount_without_tax, SUM(A.vat_amount) AS vat_amount, SUM(A.nbt_amount) AS nbt_amount, SUM(   IF(A.is_discount=1, ((A.amount_without_tax + A.vat_amount + A.nbt_amount)- A.discount_amount), (A.amount_without_tax + A.vat_amount + A.nbt_amount))) AS total');
        $this->CI->db->from('invoice_related_taxes AS A');
        $this->CI->db->join('invoices AS B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('A.invoice_id =', $invoice_id);
        $this->CI->db->where('A.main_payment_category_id !=', 29);    
        $data_result= $this->CI->db->get();
        return $data_result->row();

       
    }

    public function getOutstandingResults($master_table_name,$master_table_record_id){

    	//Check already register member
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('*');
		$this->CI->db->from('outstanding_payments');
		$this->CI->db->where('master_table_name', $master_table_name);
		$this->CI->db->where('master_table_record_id', $master_table_record_id);
		$this->CI->db->order_by('payment_dashboard_id', 'DESC');
        $this->CI->db->limit(1);
		//$this->CI->db->where('state', 0);
		return $num_results = $this->CI->db->get()->row();
    }


	public function getAdvancePaymentAmount($master_table_name,$master_table_record_id){
		
		//Check already register member
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('*');
		$this->CI->db->from('outstanding_payments');
		$this->CI->db->where('master_table_name', $master_table_name);
		$this->CI->db->where('master_table_record_id', $master_table_record_id);
		$this->CI->db->order_by('payment_dashboard_id', 'DESC');
        $this->CI->db->limit(1);
		//$this->CI->db->where('state', 0);
		$num_results = $this->CI->db->get()->row();
		//print_r($num_results->payment_dashboard_id);

	   $this->CI->db->select('SUM(low_payment_amount) AS total');
       $this->CI->db->from('member_low_payment');
       $this->CI->db->where('payment_dashboard_id', $num_results->payment_dashboard_id);
       $this->CI->db->where('(payment_method_id<9 or payment_method_id=11 or payment_method_id=12 or payment_method_id=13)');
        $this->CI->db->where('reverse_status', 0);
       $this->CI->db->where('state', 1);
       $paid_amount=$this->CI->db->get()->row()->total;

/*       $this->CI->db->select('SUM(discount_amount) AS total');
       $this->CI->db->from('member_low_payment');
       $this->CI->db->where('payment_dashboard_id', $num_results->payment_dashboard_id);
       $this->CI->db->where('(payment_method_id<8 or payment_method_id=11 or payment_method_id=12 or payment_method_id=13)');
       $this->CI->db->where('state', 1);
       $discount_amount=$this->CI->db->get()->row()->total;*/

       return  $result_array=$paid_amount;


	}



	public function getAdvancePaymentAmountfromWallet($user_id){
		
		//Check already register member
		$this->CI =& get_instance();
		$this->CI->load->database();

        $this->CI->db->select('wallet_id,wallet_ballance');
        $this->CI->db->from('member_wallet');
        $this->CI->db->where('user_id', $user_id);
        $paid_amount=$this->CI->db->get()->row()->wallet_ballance;

       return  $result_array=$paid_amount;


	}



	public function getDiscountPaymentAmount($master_table_name,$master_table_record_id){
				//Check already register member
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('*');
		$this->CI->db->from('outstanding_payments');
		$this->CI->db->where('master_table_name', $master_table_name);
		$this->CI->db->where('master_table_record_id', $master_table_record_id);
		$this->CI->db->order_by('payment_dashboard_id', 'DESC');
        $this->CI->db->limit(1);
		//$this->CI->db->where('state', 0);
		$num_results = $this->CI->db->get()->row();
		//print_r($num_results->payment_dashboard_id);


       $this->CI->db->select('SUM(discount_amount) AS total');
       $this->CI->db->from('member_low_payment');
       $this->CI->db->where('payment_dashboard_id', $num_results->payment_dashboard_id);
       $this->CI->db->where('(payment_method_id<8 or payment_method_id=11 or payment_method_id=12 or payment_method_id=13)');
             $this->CI->db->where('reverse_status', 0);
       $this->CI->db->where('state', 1);
       $discount_amount=$this->CI->db->get()->row()->total;

       return  $result_array=$discount_amount;
	}


	    public function PaymentSummeryresforReceipt($payment_dashboard_id){

		$this->CI =& get_instance();
		$this->CI->load->database();

         $this->CI->db->select('A.*,C.*,');
        $this->CI->db->from('invoices AS A');
         //$this->db->join('outstanding_payments AS B', 'A.payment_dashboard_id = B.payment_dashboard_id', 'INNER');
         $this->CI->db->join('master_main_payment_categories AS C', 'A.`main_payment_category_id` = C.`main_payment_category_id`', 'INNER');
        $this->CI->db->where('A.payment_dashboard_id', $payment_dashboard_id); 
        return $this->CI->db->get()->result();
        
    }


    	    public function TotalReinsmentYears($master_table_record_id){

		$this->CI =& get_instance();
		$this->CI->load->database();

		$this->CI->db->select('from_year,to_year');
		$this->CI->db->from('member_reinstatement');
		$this->CI->db->where('rein_tbl_id', $master_table_record_id);
		//$this->CI->db->where('state', 0);
		$result = $this->CI->db->get()->row();
		$from_year = $result->from_year;
		$to_year = $result->to_year;

		                 $totalyear=$to_year-$from_year;
                          if($totalyear==0){
                                $totalyear=1;
                           }else{
                            $totalyear=$totalyear+1;
                           }

               return $totalyear;            
        
    }


    public function RefundAmountforCPDEVENT($master_table_name, $master_table_record_id,$cancel_remarks,$user_id){
    	$receipt_res=$this->getReceiptDetails($master_table_name,$master_table_record_id);

    	$update_remarks_user_level_11_111=$this->getReceiptLowPayDetailsUpdateRemark($receipt_res->payment_dashboard_id);
    	if(strlen($update_remarks_user_level_11_111)>1){
    		$update_remarks_user_level_11_111=$update_remarks_user_level_11_111.', '.$cancel_remarks;
    	}else{
    		$update_remarks_user_level_11_111=$cancel_remarks;
    	}



				date_default_timezone_set('Asia/Colombo');
				$payment_date=date("Y-m-d");
				$update_date_user_level_11_111=date("Y-m-d")." ".date("h:i:s");

    	        $array = array(
                'advance_payment_amount' => $receipt_res->amount,
                'user_id'  => $receipt_res->user_id,
                'payment_dashboard_id' => $receipt_res->payment_dashboard_id,
                'payment_date' => $payment_date,
                'remarks' =>$cancel_remarks,
                'updated_by' =>$user_id,
                'registration_cancel_status' => '1',
                'state' => '1'

                );

                $this->CI->db->set($array);
                $this->CI->db->insert('member_advance_payment');

				$data1 = array(
				'update_status' =>  1,
				'update_remarks_user_level_11_111' =>  $update_remarks_user_level_11_111,
				'update_by_user_level_11_111' =>  $user_id,
				'update_date_user_level_11_111' =>  $update_date_user_level_11_111
				);

				$this->CI->db->where('payment_dashboard_id', $receipt_res->payment_dashboard_id);
				return $flag = $this->CI->db->update('member_low_payment', $data1);



    }

    public function getReceiptDetails($master_table_name,$master_table_record_id){
   	    $this->CI =& get_instance();
		$this->CI->load->database();
        $this->CI->db->select('*');
        $this->CI->db->from('invoices');
        $this->CI->db->where('master_table_name', $master_table_name);
        $this->CI->db->where('master_table_record_id', $master_table_record_id);
        $this->CI->db->where('payment_status_id', 2);
        $this->CI->db->where('state', 1);
        $this->CI->db->order_by('invoice_id', 'DESC');
 		$this->CI->db->limit(1);
        return $this->CI->db->get()->row();
    }

        public function getReceiptLowPayDetailsUpdateRemark($payment_dashboard_id){
   	    $this->CI =& get_instance();
		$this->CI->load->database();
        $this->CI->db->select('update_remarks_user_level_11_111');
        $this->CI->db->from('member_low_payment');
        $this->CI->db->where('payment_dashboard_id', $payment_dashboard_id);
        $this->CI->db->where('update_status', 1);
        $this->CI->db->where('state', 1);
        $this->CI->db->order_by('low_payment_id', 'DESC');
 		$this->CI->db->limit(1);
        return $this->CI->db->get()->row()->update_remarks_user_level_11_111;
    }



   public function  RemovedPendingInvoice($master_table_name, $master_table_record_id){

   	    $this->CI =& get_instance();
		$this->CI->load->database();

   		date_default_timezone_set('Asia/Colombo');
        $today = date('Y-m-d');

         $this->CI->load->library('session');
         $user_id=$this->CI->session->userdata('user_id');

         $this->CI->db->trans_start();


	  		$remarks="Invoices removed by test on ".$today;
	     	$dataw = array(
	     	'cancel_status'=> 2,
            'state' =>-2,
            'cancel_by' =>$user_id,
            'cancel_date '=>$today,
            'cancel_remarks' =>$remarks            
            );
	        $this->CI->db->where('payment_status_id', 0);    
            $this->CI->db->where('master_table_name', $master_table_name);
            $this->CI->db->where('master_table_record_id', $master_table_record_id);
            $flage = $this->CI->db->update('invoices', $dataw);


            if($flage){

	            $dataw2 = array(
	            'state' =>-2        
	            );
		     
		     	$this->CI->db->where('state', 0);            
	            $this->CI->db->where('master_table_name', $master_table_name);
	            $this->CI->db->where('master_table_record_id', $master_table_record_id);
	            $flage2 = $this->CI->db->update('outstanding_payments', $dataw2);



	             $dataw3 = array(
	            'state' =>-2        
	            );
	            $this->CI->db->where('master_table_name', $master_table_name);
	            $this->CI->db->where('master_table_record_id', $master_table_record_id);
	            $flage3 = $this->CI->db->update('invoice_related_taxes', $dataw3);

            }
	          
            $this->CI->db->trans_complete();


    }



    public function ResetWalletAccount($user_id,$restwallet){

   	    $this->CI =& get_instance();
		$this->CI->load->database();
			     $dataw2 = array(
	            'wallet_ballance' =>$restwallet      
	            );
		            
	            $this->CI->db->where('user_id', $user_id);
	            $flage2 = $this->CI->db->update('member_wallet', $dataw2);

    }

    
    public function ResetWalletLogAccount($user_id,$advancepaywallet,$subscriptin_years=0,$main_payment_category_id){

    	$this->CI =& get_instance();
		$this->CI->load->database();

		date_default_timezone_set('Asia/Colombo');
		$assign_time=date("Y-m-d")." ".date("h:i:s");

		$this->CI->db->select('*');
		$this->CI->db->from('member_wallet_logs');
		$this->CI->db->where('user_id', $user_id);
		$this->CI->db->where('paid_status_subs', 1);
		$this->CI->db->where('wallet_status', 3);
		$this->CI->db->where('state', 1);
		$this->CI->db->order_by('wallet_log_id', 'asc');
		$result = $this->CI->db->get()->result();

	

			foreach ($result as $key => $value) {

				if($main_payment_category_id==2){
					$remarksnew=$value->remarks.", Settled Subscription Payment - ".$subscriptin_years.". Date -".$assign_time;
				}else if($main_payment_category_id==29){
					$remarksnew=$value->remarks.", Settled Reinstatement Payment. Date -".$assign_time;
				}

				

				$havetopaidamount=$value->transaction_amount-$value->paid_amount_subs;

				if($advancepaywallet>=$havetopaidamount){
					$addpaidval=$havetopaidamount+$value->paid_amount_subs;
					$this->updatewalletlogrecord($value->wallet_log_id,$addpaidval,2,$remarksnew);
					$advancepaywallet=$advancepaywallet-$havetopaidamount;
				}else{
					$advancepaywallet=$advancepaywallet+$value->paid_amount_subs;
					$this->updatewalletlogrecord($value->wallet_log_id,$advancepaywallet,1,$remarksnew);
				}

				$this->UpdateAdvancePaymentInvoice($value->payment_dashboard_id,$subscriptin_years,$main_payment_category_id);

				$payment_dashboard_id_list[$key]=$value->payment_dashboard_id;
			}

				return $payment_dashboard_id_list;

    }

    public function updatewalletlogrecord($wallet_log_id,$havetopaidamount,$paid_status_subs,$remarksnew){

   	            $this->CI =& get_instance();
		        $this->CI->load->database();
			     $dataw2 = array(
	            'paid_amount_subs' =>$havetopaidamount ,
	            'paid_status_subs' =>$paid_status_subs,
	            'remarks' =>$remarksnew       
	            );
		            
	            $this->CI->db->where('wallet_log_id', $wallet_log_id);
	            $flage2 = $this->CI->db->update('member_wallet_logs', $dataw2);

    }


    public function InsertWalletLogAccount($wallet_id,$wallet_status,$payment_dashboard_id,$updated_by,$main_payment_category_id,$user_id,$advancepaywallet,$payment_dashboard_id_list=''){


			$this->CI =& get_instance();
			$this->CI->load->database();

			if(!empty($payment_dashboard_id_list)){

				$payment_dashboard_id_list=implode(",",$payment_dashboard_id_list);

				$this->CI->db->select(' IF(A.is_new_receipt=1,A.receipt_no, CONCAT("T-",B.reference_no)) AS receipt_no  ,  A.payment_date');
				$this->CI->db->from('member_low_payment AS A');
				$this->CI->db->join('invoices AS B', 'A.payment_dashboard_id = B.payment_dashboard_id', 'INNER');
				$this->CI->db->where('B.main_payment_category_id', 72);
				$this->CI->db->where('A.state', 1);
				$this->CI->db->where('A.payment_dashboard_id  IN ('.$payment_dashboard_id_list.')');
				$this->CI->db->order_by('A.low_payment_id', 'asc');
				$resultlist = $this->CI->db->get()->result();


				foreach ($resultlist as $key => $value) {
				$reciptnores[$key]=" Receipt No :- ".$value->receipt_no.' Payment Date :- '.$value->payment_date." ";

				}

				$reciptnores=implode(",",$reciptnores) ;

			}else{
				$reciptnores='';
			}







			$data = array(
			'wallet_id' => $wallet_id,
			'transaction_amount' => $advancepaywallet,
			'wallet_status' => $wallet_status,
			'user_id'  => $user_id,
			'payment_dashboard_id'  => $payment_dashboard_id,
			'update_by' => $updated_by,
			'main_payment_category_id'=>$main_payment_category_id,
			'remarks'=>$reciptnores,
			'state' => '1'
			);

			$this->CI->db->insert('member_wallet_logs', $data);
			$insert_id = $this->CI->db->insert_id();

    }


     public function  UpdateAdvancePaymentInvoice($payment_dashboard_id,$subscriptin_years,$main_payment_category_id){

		    date_default_timezone_set('Asia/Colombo');
				$updated_date = date('Y-m-d');

     		$this->CI =& get_instance();
			$this->CI->load->database();

					$this->CI->db->select('A.remarks, A.low_payment_id');
		$this->CI->db->from('member_low_payment AS A');
		$this->CI->db->join('invoices AS B', 'A.payment_dashboard_id = B.payment_dashboard_id', 'INNER');
		$this->CI->db->where('(B.main_payment_category_id=72 or A.refund_or_wallet_status =1)');
		$this->CI->db->where('A.state', 1);
		$this->CI->db->where('A.payment_dashboard_id', $payment_dashboard_id);
		$this->CI->db->order_by('A.low_payment_id', 'asc');
		$resultlist = $this->CI->db->get()->row();	

		if($main_payment_category_id==2){
			$remarksnew=$resultlist->remarks.", Settled Subscription Payment- ".$subscriptin_years.". Payment Date -".$updated_date.'. ';
		}else if($main_payment_category_id==29){
			$remarksnew=$resultlist->remarks.", Settled Reinstatement Payment. Payment Date -".$updated_date.'. ';
		}
		
			$this->UpdateLowPayResult($remarksnew,$resultlist->low_payment_id);


     }

     	public function UpdateLowPayResult($remarksnew,$low_payment_id){

		

				$this->CI =& get_instance();
				$this->CI->load->database();

				$data1 = array(
				'remarks' =>  $remarksnew
				);

				$this->CI->db->where('low_payment_id', $low_payment_id);
				return $flag = $this->CI->db->update('member_low_payment', $data1);

     	}

}

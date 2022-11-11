
<?php
/*
Developer - sandun
This library use for manage online payment. test
*/


class CI_Payment_log_online
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
	public $ip='';
	public $main_payment_category_id=0;
	public $sub_payment_category_id=0;
	public $payamount=0;
	public $total_amount=0;

	    public function __construct() {

  				error_reporting(0);
    }


		//This function use inser payment detail. After It redirect to payment gateway;
	public function InsertPaymentLogPublic($master_table_name,$master_table_record_id,$payamount,$pay_recepy_req=0,$gatewayport=0,$ishalfpay=0)
	{

		//die('Temporary Disabled');

		error_reporting(0);
		
		//Load Time Zone
		date_default_timezone_set('Asia/Colombo');
		//Load CodeIgniter’s resources from externally
		$this->CI =& get_instance();
		//Returns your site URL, as specified in your config file.
		$this->CI->load->helper('url');
		//Sessions will typically run globally with each page load
		$this->CI->load->library('session');

	    //Get User Id from session
	    $user_id=0;

	    //Get Group Id using user id
	    $group_id=17;

	    //get master table record details
	    $master_table_results=$this->getMasterTableResultsPublic($master_table_name,$master_table_record_id);

	  


	    //Member Name
	    $name=$master_table_results->non_mem_name;

	    //Member Member Ship Number
	    $member_ship_number='';

	    //Member Address
	    $address=$master_table_results->non_mem_address;

	    //Member Member Class ID
	    $membership_class_id=0;

	    //Member Member NIC
	    $nic=$master_table_results->non_mem_nic;

	    //Member Member Email
	    $email=$master_table_results->non_mem_email;

	    //Member Member IP
	    $ip=$this->get_real_IP_address();

	    //Nomal registration category id is 1
       if ($master_table_name=='event_member_registration') {
	    	$main_payment_category_id=4;
	    	$sub_payment_category_id=$master_table_results->non_member_sub_payment_category_id;
	    	$payment_description=$master_table_results->event_title;
	    }


	    if ($master_table_name=='cpd_member_registration') {
		    	$main_payment_category_id=3;
	    	$sub_payment_category_id=$master_table_results->non_member_sub_payment_category_id;
	    	$payment_description=$master_table_results->event_title;
	    }

	    if ($master_table_name=='elearning_registrations') {
	    	$main_payment_category_id=76;
	    	$sub_payment_category_id=$master_table_results->Nonmember_subpayment_id;
	    	$payment_description=$master_table_results->Course_title;
	    }




	    //Payment Status (Redirect to payment gate way)
	    $payment_status_id=3;

	    //Total Amount
	    $total_amount=$payamount;

	    //Payment Date
	    $payment_date=date("Y-m-d");

	    //Payment Time 		
		$payment_time=date("Y-m-d")." ".date("h:i:s");

		if($gatewayport==1){
		//Bank
		$bank="BOC";
		}else{
		$bank="test";
		}

		// To create uniq payment reference number
		$payment_ref_number_prepare=$this->PaymentRefNoPrepared($nic);
		//get transaction id
		$referencenumbe=$this->getTransactionId($payment_ref_number_prepare);
		$payment_reference_number=$referencenumbe[0];

		


		//Insert payment details before redirect to payment gateway 
		$ResInsetDataPaymentLog = $this->InsertTransactionDetailsofPayment($user_id,$group_id, $membership_class_id, $nic, $ip, $bank, $payment_description, $payment_status_id, $total_amount, $payment_date, $payment_time, $payment_reference_number, $master_table_name, $master_table_record_id, $email, $main_payment_category_id, $sub_payment_category_id, $name, $member_ship_number,$address,$pay_recepy_req,0,0,0,0,0,$ishalfpay);


		//Convert total amount for send payment gate way.
		$total_amount=$total_amount;
		$total_amount=number_format($total_amount,2);
		$total_amount_for_gateway = str_replace(array('.', ','), '' , $total_amount);


		if($gatewayport==1){

			$this->CI->session->unset_userdata('successIndicator');
			$this->CI->session->unset_userdata('orderID');
			$this->CI->session->unset_userdata('orderReference');
			$this->CI->session->unset_userdata('sessionboc_ipg');
			$this->CI->session->set_userdata('sessionboc_ipg', 0);

			$referenceencode=base64_encode($payment_reference_number);
			redirect('Bocipg/SendRequest?encript='.$referenceencode, 'refresh');

		}else{
			$this->CalltestGateWay($payment_reference_number,$master_table_name,$master_table_record_id,$transactionAmount,$total_amount_for_gateway);
		}

	}



	//This function use inser payment detail. After It redirect to payment gateway;
	public function InsertPaymentLog($master_table_name,$master_table_record_id,$payamount,$pay_recepy_req=0,$beneval_fund_req=0,$subscrip_amount_for_registration=0,$surcharge=0,$arrias=0,$gatewayport=0,$ismobile=0,$ishalfpay=0)
	{


		//die('Temporary Disabled');

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

	    //Get User Id from session
	    $user_id=$this->CI->session->userdata('user_id');


	    //get master table record details
	    $master_table_results=$this->getMasterTableResults($master_table_name,$master_table_record_id);

	    if($ismobile==1){
	    	$user_id=$master_table_results->user_id;
	    }


	    //Get Group Id using user id
	    $group_id=$this->getGroupID($user_id);

	    if ($master_table_name=='training_org_recommendation') {
	    	//Member Name
			$name=$master_table_results->org_name;

			//Member Address
			$address=$master_table_results->org_address;

			//Member Member NIC
			$nic=' - ';

			//Member Member Email
	    	$email=$master_table_results->org_contact_email;

	        //Member Member Ship Number
	    	$member_ship_number=$master_table_results->reg_application_id;

	    }else{

	    	if ($master_table_name=='user_registrations' || $master_table_name=='techeng_registrations' || $master_table_name=='directroute_registrations' || $master_table_name=='edu_de_application' || $master_table_name=='de_member_registrations') {

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
					$address=$master_table_results->addr_line1. ' ,'.$master_table_results->addr_line1.' ,'.$master_table_results->addr_line2.' ,'.$master_table_results->addr_city;

								//Member Member NIC
					if($master_table_results->nic_old=='' || $master_table_results->nic_old==NULL){
						$nic=$master_table_results->nic;
					}else{
						$nic=$master_table_results->nic_old;
					}



			}else{

					//Member Name
					$name=$master_table_results->user_name_w_initials;
					if($master_table_name=='pe_data'){
					$name=$master_table_results->user_name_initials.' '.$master_table_results->user_name_lastname;
				     }

					//Member Address
					$address=$master_table_results->user_permanent_addr;

					//Member Member NIC
					if($master_table_results->user_nic_old=='' || $master_table_results->user_nic_old==NULL){
						$nic=$master_table_results->user_nic;
					}else{
						$nic=$master_table_results->user_nic_old;
					}

			}


			//Member Member Email
	    	$email=$master_table_results->user_email;


	    	
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


	    //Member Member IP
	    $ip=$this->get_real_IP_address();

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
	    	
	    }else if ($master_table_name=='adjudicator_application' || $master_table_name=='ceo_building_services_application' || $master_table_name=='structural_engineers_application' || $master_table_name=='adjudicator_application_publication' || $master_table_name=='ceo_building_services_application_publication' || $master_table_name=='structural_engineers_application_publication'|| $master_table_name=='adjudicator_and_arbitrator_application' || $master_table_name=='adjudicator_and_arbitrator_application_publication') {

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
	    	$email=$master_table_results->email;
	    	
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

	    	
	    	$payment_description=$master_table_results->event_title;



	    }else if($master_table_name=='cpd_member_registration'){

	    	$sub_payment_category_id=$master_table_results->member_sub_payment_category_id;
	    	$payment_description=$master_table_results->event_title;

        }else if($master_table_name=='elearning_registrations'){

	    	$sub_payment_category_id=$master_table_results->Member_subpayment_id;
	    	$payment_description=$master_table_results->Course_title;

        }else if($master_table_name=='b_paper_application'){

			$sub_payment_category_id=$master_table_results->sub_payment_cat_id;
			$payment_description=$master_table_results->b_paper_batch_title;

        }else if($master_table_name=='pr_viva_application'){


			$sub_payment_category_id=$master_table_results->sub_payment_cat_id;
			$payment_description=$master_table_results->pr_viva_batch_title;


        }else if($master_table_name=='adjudicator_application' || $master_table_name=='ceo_building_services_application' || $master_table_name=='structural_engineers_application' || $master_table_name=='adjudicator_application_publication' || $master_table_name=='ceo_building_services_application_publication' || $master_table_name=='structural_engineers_application_publication' || $master_table_name=='adjudicator_and_arbitrator_application' || $master_table_name=='adjudicator_and_arbitrator_application_publication'){

        	if($master_table_results->application_fee==0 && $master_table_results->new_or_count==0){

        		$sub_payment_category_id=$master_table_results->sub_cat_new_reg;
        		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$payment_description=$desres[0]->user_defined_sub_payment_category;


        	}else if($master_table_results->application_fee==0 && $master_table_results->new_or_count==1){

        		$sub_payment_category_id=$master_table_results->sub_cat_cont_reg;
        		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$payment_description=$desres[0]->user_defined_sub_payment_category;

        	}else if($master_table_results->application_fee==2 && $master_table_results->new_or_count==0){

        		$sub_payment_category_id=$master_table_results->sub_cat_new_pub;
        		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$payment_description=$desres[0]->user_defined_sub_payment_category;

        	}else if($master_table_results->application_fee==2 && $master_table_results->new_or_count==1){

        		$sub_payment_category_id=$master_table_results->sub_cat_cont_pub;
        		$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$payment_description=$desres[0]->user_defined_sub_payment_category;

        	}
        	

        }else if($master_table_name=='member_fund_payment'){

			$sub_payment_category_id=$master_table_results->sub_payment_category_id;
			$desres=$this->getPaymentAmountByMemSUBCat($sub_payment_category_id);
        		$payment_description=$desres[0]->user_defined_sub_payment_category;

        }else{

	    //get payment details
	    $master_sub_payment_results=$this->getSubPaymentDetails($membership_class_id,$main_payment_category_id);
	    //Member Sub Payment Category
	    $sub_payment_category_id=$master_sub_payment_results->sub_payment_category_id;
	    //Payment Description
	    $payment_description=$master_sub_payment_results->main_payment_category;
	    
	    }


	    //Payment Status (Redirect to payment gate way)
	    $payment_status_id=3;

	    //Total Amount
	    $total_amount=$payamount;

	    //Payment Date
	    $payment_date=date("Y-m-d");

	    //Payment Time 		
		$payment_time=date("Y-m-d")." ".date("h:i:s");

		if($gatewayport==1){
			//Bank
			$bank="BOC";
		}else{
			//Bank
			$bank="test";
		}


		// To create uniq payment reference number
		
		 if ($master_table_name=='training_org_recommendation') {

		 		$reap=rand(100,1000);
		 	$payment_ref_number_prepare=$this->PaymentRefNoPrepared($reap);

		 }else{

		 	$payment_ref_number_prepare=$this->PaymentRefNoPrepared($nic);
		 }


		//get transaction id
		$referencenumbe=$this->getTransactionId($payment_ref_number_prepare);
		$payment_reference_number=$referencenumbe[0];


		if($master_table_name=='adjudicator_application_publication'){
			$master_table_name='adjudicator_application';
		}else if($master_table_name=='ceo_building_services_application_publication'){
			$master_table_name='ceo_building_services_application';
		}else if($master_table_name=='structural_engineers_application_publication'){
			$master_table_name='structural_engineers_application';
		}else if($master_table_name=='adjudicator_and_arbitrator_application_publication'){
			$master_table_name='adjudicator_and_arbitrator_application';
		}


		//Insert payment details before redirect to payment gateway 
		$ResInsetDataPaymentLog = $this->InsertTransactionDetailsofPayment($user_id,$group_id, $membership_class_id, $nic, $ip, $bank, $payment_description, $payment_status_id, $total_amount, $payment_date, $payment_time, $payment_reference_number, $master_table_name, $master_table_record_id, $email, $main_payment_category_id, $sub_payment_category_id, $name, $member_ship_number,$address,$pay_recepy_req,$beneval_fund_req,$subscrip_amount_for_registration,$surcharge,$arrias,$ismobile,$ishalfpay);

		
		$CI =& get_instance();
		$CI->load->library('Payment_log_offline_outstanding');

		   //if($main_payment_category_id==4){
		   	// add offline payment table for event
		//$CI->payment_log_offline_outstanding->OutstandingPayments($master_table_name,$master_table_record_id,$total_amount,$pay_recepy_req);
			//}


		//Convert total amount for send payment gate way.
		$total_amount=$total_amount;
		$total_amount=number_format($total_amount,2);
		$total_amount_for_gateway = str_replace(array('.', ','), '' , $total_amount);


		if($gatewayport==1){

			
			$this->CI->session->unset_userdata('successIndicator');
			$this->CI->session->unset_userdata('orderID');
			$this->CI->session->unset_userdata('orderReference');
			$this->CI->session->unset_userdata('sessionboc_ipg');
			$this->CI->session->set_userdata('sessionboc_ipg', 0);

			$referenceencode=base64_encode($payment_reference_number);
			redirect('Bocipg/SendRequest?encript='.$referenceencode, 'refresh');

			//$this->CallBocGateWay($payment_reference_number,$master_table_name,$master_table_record_id,$payamount,$email);

		}else{
			$this->CalltestGateWay($payment_reference_number,$master_table_name,$master_table_record_id,$transactionAmount,$total_amount_for_gateway);
		}

	}






	function CalltestGateWay($payment_reference_number,$master_table_name,$master_table_record_id,$transactionAmount,$total_amount_for_gateway){


		$CI =& get_instance();
        $CI->load->library('config_variables');
        //client_id
	    $client_id=$CI->config_variables->getVariable('client_id');

		//set token, secret key, client id, currency, returnurl
		$auth_token = "45bf5c2e-1f06-4e86-8aec-4495a9669e35";
		$hmac_secret = "TzkbyM6GTiiKM2Eg";
		$client_id = $client_id;
		$currency="LKR";
		$returnurl=site_url()."Payment_log_online/ResponsePayment";			

		
		?>
		<?php include 'system/libraries/IPG/au.com.gateway.client/GatewayClient.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.config/ClientConfig.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.component/RequestHeader.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.component/CreditCard.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.component/TransactionAmount.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.component/Redirect.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.facade/BaseFacade.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.facade/Payment.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.payment/PaymentInitRequest.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.payment/PaymentInitResponse.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.root/PaycorpRequest.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.utils/IJsonHelper.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.helpers/PaymentInitJsonHelper.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.utils/HmacUtils.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.utils/CommonUtils.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.utils/RestClient.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.enums/TransactionType.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.enums/Version.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.enums/Operation.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.facade/Vault.php'; ?>
		<?php include 'system/libraries/IPG/au.com.gateway.client.facade/Report.php'; ?>

		<?php		

		/*------------------------------------------------------------------------------
		STEP1: Build ClientConfig object
		------------------------------------------------------------------------------*/
		$ClientConfig = new ClientConfig();
		$ClientConfig->setServiceEndpoint("https://test.paycorp.com.au/rest/service/proxy");
		$ClientConfig->setAuthToken($auth_token);
		$ClientConfig->setHmacSecret($hmac_secret);
		$ClientConfig->setValidateOnly(FALSE);
		/*------------------------------------------------------------------------------
		STEP2: Build Client object
		------------------------------------------------------------------------------*/
		$Client = new GatewayClient($ClientConfig);
		/*------------------------------------------------------------------------------
		STEP3: Build PaymentInitRequest object
		------------------------------------------------------------------------------*/
		$initRequest = new PaymentInitRequest();
		$initRequest->setClientId($client_id);
		$initRequest->setTransactionType(TransactionType::$PURCHASE);
		$initRequest->setClientRef($payment_reference_number);
		//$initRequest->setComment("merchant_additional_data");
		$initRequest->setTokenize(FALSE);
		$initRequest->setExtraData(array("master_table_name" => $master_table_name, "master_table_record_id" => $master_table_record_id));
		// sets transaction-amounts details (all amounts are in cents)
		$transactionAmount = new TransactionAmount($transactionAmount);
		//$transactionAmount->setTotalAmount(0);
		//$transactionAmount->setServiceFeeAmount(0);
		$transactionAmount->setPaymentAmount($total_amount_for_gateway);
		$transactionAmount->setCurrency($currency);
		$initRequest->setTransactionAmount($transactionAmount);
		// sets redirect settings
		$redirect = new Redirect($returnurl);
		//$redirect->setReturnUrl();
		$redirect->setReturnMethod("GET");
		$initRequest->setRedirect($redirect);

		/*------------------------------------------------------------------------------
		STEP4: Process PaymentInitRequest object
		------------------------------------------------------------------------------*/
		$initResponse = $Client->payment()->init($initRequest);


		redirect($initResponse->getPaymentPageUrl(), 'refresh');

?>
      

	    <section style="text-align: center;" class="content-header">
        <h1>Thank You, Your will be redirected to payment gateway.  <br/> Please wait!......................</h1>

        <div id="setpre"></div>
    </section>
<?php


		//temporary check redirect
		//redirect('Payment_log_online/temporaryfunction/'.$payment_reference_number.'/'.$master_table_record_id, 'refresh');

	}



	public function InsertTransactionDetailsofPayment($user_id,$group_id, $membership_class_id, $nic, $ip, $bank, $payment_description, $payment_status_id, $total_amount, $payment_date, $payment_time, $payment_reference_number, $master_table_name, $master_table_record_id, $email, $main_payment_category_id, $sub_payment_category_id, $name, $member_ship_number,$address,$pay_recepy_req,$beneval_fund_req,$subscrip_amount_for_registration,$surcharge,$arrias,$ismobile=0,$ishalfpay=0){


		if($beneval_fund_req==1){
			$beneval_fund_amount=getFundAmount($master_table_record_id);
		}else{
			$beneval_fund_amount=0;
		}

			$this->CI =& get_instance();
			$this->CI->load->database();

			$array = array(
			'user_id' => $user_id,
			'group_id' => $group_id,
			'main_payment_category_id' => $main_payment_category_id,
			'sub_payment_category_id' => $sub_payment_category_id,
			'name' => $name,
			'address' => $address,
			'member_ship_number' => $member_ship_number,
			'membership_class_id' => $membership_class_id,
			'nic' => $nic,
			'ip' => $ip,
			'bank'=> $bank,
			'payment_description' => $payment_description,
			'payment_status_id' => $payment_status_id,
			'total_amount' => $total_amount,
			'subscrip_amount_for_registration'=> $subscrip_amount_for_registration,
			'surcharge'=> $surcharge,
			'arrias'=> $arrias,
			'payment_date' => $payment_date,
			'payment_time' => $payment_time,
			'payment_reference_number' => $payment_reference_number,
			'master_table_name' => $master_table_name,
			'master_table_record_id' => $master_table_record_id,
			'pay_recept_required'=> $pay_recepy_req,
			'beneval_fund_req'=> $beneval_fund_req,
			'beneval_fund_amount'=> $beneval_fund_amount,
			'email' => $email,
			'ismobile' => $ismobile,
			'ishalfpay' => $ishalfpay

			);

			$this->CI->db->set($array);
			$this->CI->db->insert('payment_log_online');

	}



	public function getGroupID($user_id=0){

		//Get User Group Id from userid
		$this->CI =& get_instance();
		$this->CI->load->database();
		$query = $this->CI->db->query('SELECT group_id FROM users_groups where user_id="'.$user_id.'" order by id DESC');
		//echo $this->CI->db->last_query();
		$row = $query->row();
		$query->free_result(); // The $query result object will no longer be available
		if($row->group_id>0){
			return  $row->group_id;
		}else{
			return 17;
		}
		


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
                        system_tax_rate.presentage AS rate_value');
        $this->CI->db->from('master_sub_payment_categories');
        $this->CI->db->join('sub_payment_related_tax', 'sub_payment_related_tax.sub_payment_category_id = master_sub_payment_categories.sub_payment_category_id', 'left');
        $this->CI->db->join('system_tax_rate', 'system_tax_rate.taxid = sub_payment_related_tax.taxid', 'left');
        /*      $CI->db->join('qb_tax_rates', 'qb_tax_rates.qb_tax_id = system_tax_rate.qb_tax_id', 'left'); */
       $this->CI->db->where('master_sub_payment_categories.state', 1);
        $this->CI->db->where('master_sub_payment_categories.sub_payment_category_id', $master_sub_payment_categories_id);
        $query = $this->CI->db->get();
//echo $this->CI->db->last_query();

        if ($query->result()) {

            return $query->result();
        } else {
           show_error('This member class is not eligible for payment category');
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
			//no memship no
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
			//no memship no
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
			//no memship no
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
			//no memship no
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
		    $this->CI->db->where('B.state', 1);
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
		
		if($master_table_name=='ecsl_member'){

			$this->CI->db->select('A.*,B.*');
			$this->CI->db->from('ecsl_member A');
			$this->CI->db->join('member_profile_data B', 'B.user_id = A.user_id', 'INNER');
		    $this->CI->db->where('A.subscription_id', $master_table_record_id);
		    $this->CI->db->where('B.state', 1);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='pe_data'){

			$this->CI->db->select('B.user_id, B.user_name_initials, B.user_name_lastname, A.pe_membership_number AS membership_number, A.pe_permanent_addr AS user_permanent_addr, B.user_nic_old, B.user_nic, B.user_member_class, B.user_email');
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


	public  function get_real_IP_address(){

		// get ip address
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
        {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
        {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
        $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

       
    function PaymentRefNoPrepared($nic)
	{

		 $nic = str_replace(' ', '', $nic);
		 $lastid=$this->getLastRecordTable();
		 $lastid=$lastid+1;
		 // Payment reference number create
		date_default_timezone_set("Asia/Colombo"); 	
		$payment_ref_number = 'P_'.$lastid.$nic.rand(1000,10000).date("Y-m-d").date("h:i:s");
		return  $payment_ref_number;

	
	}

	function getLastRecordTable(){
		    $this->CI =& get_instance();
		    $this->CI->load->database();
			$this->CI->db->select('MAX(A.payment_log_id) AS lastid');
			$this->CI->db->from('payment_log_online A');
			return $query = $this->CI->db->get()->row()->lastid; 
	}

		
	function getTransactionId($val)
	{

		//get transaction id
		$arrVals = array('W',0,'','','i','l','K');
		$arrReps = array('*','$','-',':','!','`','^');		
		$genVals =  str_replace($arrReps,$arrVals,$val);		
		$valueArray = explode('|',$genVals);
	
		return $valueArray;

	
	}



}


<?php
/*
Developer - sandun
This library use for manage online payment. test
*/


class CI_Public_payment_log_online
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
	public function InsertPaymentLogPublic($master_table_name,$master_table_record_id,$payamount,$pay_recepy_req=0)
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



	    //get master table record details
	    $master_table_results=$this->getMasterTableResultsPublic($master_table_name,$master_table_record_id);


		//Company Name
		$name=$master_table_results->company;

	    //Company Address
  		$addressarray=array(str_replace(',','',$master_table_results->address1),str_replace(',','',$master_table_results->address2),str_replace(',','',$master_table_results->address3));
  		$addressarray = array_filter($addressarray);   
  		$address=implode(",",$addressarray);

  		$email=$master_table_results->email;

  		$phone=$master_table_results->phone;

	    //Member Member IP
	    $ip=$this->get_real_IP_address();

       $payment_description=$master_table_results->exhibition_title." - ".$master_table_results->year;



	    //Payment Status (Redirect to payment gate way)
	    $payment_status_id=3;

	    //Total Amount
	    $total_amount=$payamount;

	    //Payment Date
	    $payment_date=date("Y-m-d");

	    //Payment Time 		
		$payment_time=date("Y-m-d")." ".date("h:i:s");

		//Bank
		$bank="test";

		// To create uniq payment reference number
		$payment_ref_number_prepare=$this->PaymentRefNoPrepared($nic);
		//get transaction id
		$referencenumbe=$this->getTransactionId($payment_ref_number_prepare);
		$payment_reference_number=$referencenumbe[0];

		


		//Insert payment details before redirect to payment gateway 
		$ResInsetDataPaymentLog = $this->InsertTransactionDetailsofPayment($user_id ,$ip, $bank, $payment_description, $payment_status_id, $total_amount, $payment_date, $payment_time, $payment_reference_number, $master_table_name, $master_table_record_id, $email,$phone, $name,$address,$pay_recepy_req);


		//Convert total amount for send payment gate way.
		$total_amount=$total_amount;
		$total_amount=number_format($total_amount,2);
		$total_amount_for_gateway = str_replace(array('.', ','), '' , $total_amount);

	   $CI =& get_instance();
       $CI->load->library('config_variables');
       //client_id
	   $client_id=$CI->config_variables->getVariable('client_id');

		//set token, secret key, client id, currency, returnurl
		$auth_token = "45bf5c2e-1f06-4e86-8aec-4495a9669e35";
		$hmac_secret = "TzkbyM6GTiiKM2Eg";
		$client_id = $client_id;
		$currency="LKR";
		$returnurl=site_url()."Public_payment_log_online/ResponsePayment";			

		
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

		//temporary check redirect
		//redirect('Payment_log_online/temporaryfunction/'.$payment_reference_number.'/'.$master_table_record_id, 'refresh');


	}





	public function InsertTransactionDetailsofPayment($user_id ,$ip, $bank, $payment_description, $payment_status_id, $total_amount, $payment_date, $payment_time, $payment_reference_number, $master_table_name, $master_table_record_id, $email,$phone, $name,$address,$pay_recepy_req){


			$this->CI =& get_instance();
			$this->CI->load->database();

			$array = array(
			'user_id' => $user_id,
			'name' => $name,
			'address' => $address,
			'email' => $email,
			'ip' => $ip,
			'phone' => $phone,
			'bank'=> $bank,
			'payment_description' => $payment_description,
			'payment_status_id' => $payment_status_id,
			'total_amount' => $total_amount,
			'payment_date' => $payment_date,
			'payment_time' => $payment_time,
			'payment_reference_number' => $payment_reference_number,
			'master_table_name' => $master_table_name,
			'master_table_record_id' => $master_table_record_id,
			'pay_recept_required'=> $pay_recepy_req,
			'state'=>1

			);

			$this->CI->db->set($array);
			$this->CI->db->insert('public_payment_log_online');

	}



	public function getMasterTableResultsPublic($master_table_name='',$master_table_record_id=0){

				//Get Master Table Results
		$this->CI =& get_instance();
		$this->CI->load->database();

		if($master_table_name=='techno_company_details'){

			$this->CI->db->select('A.*,B.*');
			$this->CI->db->from('techno_company_details A');
			$this->CI->db->join('techno_event_initiation B', 'B.event_id = A.event_id', 'INNER');
		    $this->CI->db->where('A.form_id', $master_table_record_id);
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
			$this->CI->db->from('public_payment_log_online A');
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

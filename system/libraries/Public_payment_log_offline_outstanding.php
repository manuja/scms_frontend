<?php
/*
Developer - sandun
This library use for manage online payment.
*/

class CI_Public_payment_log_offline_outstanding
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


	public function OutstandingPaymentsPublic($master_table_name,$master_table_record_id,$payamount,$pay_recepy_req=0)
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

		$this->CI->load->helper('public_finance');

		$this->CI->load->helper('master_tables');

	    
		//Get values from master table
	    $master_table_results=$this->getMasterTableResultsPublic($master_table_name,$master_table_record_id);

	    //Get User Id from session
	    $user_id=0;

		//Company Name
		$name=$master_table_results->company;

	    //Company Address
  		$addressarray=array(str_replace(',','',$master_table_results->address1),str_replace(',','',$master_table_results->address2),str_replace(',','',$master_table_results->address3));
  		$addressarray = array_filter($addressarray);   
  		$address=implode(",",$addressarray);

  		$email=$master_table_results->email;

  		$phone=$master_table_results->phone;



	    //Payment Status still pending
	    $payment_status_id=0;


		//Total Amount
	    $due_amount=$payamount;

   		//Assign Date
	    $assign_date=date("Y-m-d");	

   		//Assign Time
		$assign_time=date("Y-m-d")." ".date("h:i:s");

		//State 
		$state=1;

		//Description
		$description=$master_table_results->exhibition_title." - ".$master_table_results->year;





		//Check table exist row
		$countRecord=$this->CountRecords($master_table_name,$master_table_record_id);
		if($countRecord==0){
		//Insert registration details
		return $ResInsetDataPaymentLog = $this->InsertTransactionDetailsofPayment($name,$address, $due_amount,  $user_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$pay_recepy_req,$email,$phone);	
		}else{


			$ResUpdateDataPaymentLog = $this->UpdateTransactionDetailsofPayment($name,$address, $due_amount,  $user_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$pay_recepy_req,$email,$phone);	

			 $invoice_id=$this->DashboardLogId($master_table_name,$master_table_record_id);

			$this->deleteAlreadyExistPaymentDetailsCategoryWise($invoice_id);

			return $invoice_id;
		}


		

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

		if($master_table_name=='techno_form_stalls'){

			$this->CI->db->select('A.*,B.*,C.*,D.*');
			$this->CI->db->from('techno_form_stalls A');
			$this->CI->db->join('techno_stall_numbers B', 'B.techno_stall_no_id = A.techno_stall_no_id', 'INNER');
			$this->CI->db->join('techno_stalls C', 'C.techno_stall_id = B.techno_stalls_id', 'INNER');
			$this->CI->db->join('techno_stall_categories D', 'D.category_id = C.stall_category_id', 'INNER');
		    $this->CI->db->where('A.stall_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='techno_form_extra_acc'){

			$this->CI->db->select('A.*,B.*,C.*');
			$this->CI->db->from('techno_form_extra_acc A');
			$this->CI->db->join('techno_form_stalls B', 'B.stall_id = A.stall_id', 'INNER');
			$this->CI->db->join('techno_stall_numbers C', 'C.techno_stall_no_id = B.techno_stall_no_id', 'INNER');
			$this->CI->db->join('techno_stalls D', 'D.techno_stall_id = C.techno_stalls_id', 'INNER');
			$this->CI->db->join('techno_stall_categories E', 'E.category_id = D.stall_category_id', 'INNER');
		    $this->CI->db->where('A.extra_acc_id', $master_table_record_id);
			$query = $this->CI->db->get(); 
		}

		if($master_table_name=='techno_form_ads'){

			$this->CI->db->select('A.*,B.*');
			$this->CI->db->from('techno_form_ads A');
			$this->CI->db->join('techno_ads B', 'B.ad_id = A.techno_ads_id', 'INNER');
		    $this->CI->db->where('A.form_ad_id', $master_table_record_id);
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




	public function DashboardLogId($master_table_name,$master_table_record_id){
		//Check already register member
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('invoice_id');
		$this->CI->db->from('public_invoices');
		$this->CI->db->where('master_table_name', $master_table_name);
		$this->CI->db->where('master_table_record_id', $master_table_record_id);
		$this->CI->db->where('payment_status_id', 0);
		$this->CI->db->order_by('invoice_id', 'DESC');
 		$this->CI->db->limit(1);
		//$this->CI->db->where('state', 0);
		  $num_results = $this->CI->db->get()->row();
		return $num_results->invoice_id;


	}


	public function getStallsIdfromFormId($formid){
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('techno_stall_no_id');
		$this->CI->db->from('techno_form_stalls');
		$this->CI->db->where('form_id', $formid);
		$this->CI->db->where('state', 1);
		//$this->CI->db->where('state', 0);
		return $id_results = $this->CI->db->get()->result();


	}

	public function getFormsfromstalId($id_results,$formid){

		if(!empty($id_results)){
        for ($i=0; $i < count($id_results) ; $i++) { 
        $srb_sr_id_result[$i]=$id_results[$i]->techno_stall_no_id;
        }
    	}
        
        $srb_sm_id_result=implode(",",$srb_sr_id_result);

        $this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('form_id');
		$this->CI->db->from('techno_form_stalls');
		$this->CI->db->where('techno_stall_no_id IN ('.$srb_sm_id_result.')');
		$this->CI->db->where('form_id !=', $formid);
		$this->CI->db->where('state', 1);
		//$this->CI->db->where('state', 0);
		return $id_results = $this->CI->db->get()->result();

	}


	public function RemoveInvoicesFromList($id_results){

		if(!empty($id_results)){
        for ($i=0; $i < count($id_results) ; $i++) { 
        $srb_sr_id_result[$i]=$id_results[$i]->form_id;
        }
    	}
        
 		$this->RemoveInvoicesFromListwithArray($srb_sr_id_result);

	}


	function RemoveInvoicesFromListwithArray($srb_sr_id_result){

		 $srb_sm_id_result=implode(",",$srb_sr_id_result);

		if(!empty($srb_sr_id_result)){
        $this->CI =& get_instance();
		$this->CI->load->database();
		   date_default_timezone_set('Asia/Colombo');
            $updated_date = date('Y-m-d');

           //update invoices table
        $datain = array(
        'cancel_status' =>1,
        'cancel_date' => $updated_date ,
        'state' =>-2,
        'cancel_request_remarks' => "Sorry!. Invoice Rejected. Already Booked Invoice Related Stall."  
        );

        $this->CI->db->where('master_table_name', 'techno_company_details');
        $this->CI->db->where('master_table_record_id IN ('.$srb_sm_id_result.')');
        $flag = $this->CI->db->update('public_invoices', $datain);

        }

	}



	public function PaidStallIdList(){

		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('B.master_table_record_id');
		$this->CI->db->from('public_payment AS A');
		$this->CI->db->join('public_invoices B', 'B.invoice_id = A.invoice_id', 'INNER');
		$this->CI->db->where('B.master_table_name', 'techno_company_details');
		$this->CI->db->where('A.state', 1);
		$this->CI->db->group_by('B.master_table_record_id');
		//$this->CI->db->where('state', 0);
		$num_results = $this->CI->db->get()->result();

        if(!empty($num_results)){
            for ($i=0; $i < count($num_results) ; $i++) { 
            $srb_sr_id_result[$i]=$num_results[$i]->master_table_record_id;
            }
            
         $srb_sm_id_result=implode(",",$srb_sr_id_result);

        $this->CI->db->select('A.techno_stall_no_id');
		$this->CI->db->from('techno_form_stalls AS A');
		$this->CI->db->where('A.form_id IN ('.$srb_sm_id_result.')');
		$this->CI->db->where('A.state', 1);
		$this->CI->db->group_by('A.techno_stall_no_id');
		$num_results2 = $this->CI->db->get()->result();

		    for ($i=0; $i < count($num_results2) ; $i++) { 
            $srb_sr_id_result2[$i]=$num_results2[$i]->techno_stall_no_id;
            }

		return $srb_sr_id_result2;

        }else{
            return 0;
        }

		

	}

    public function updateAllPartialPaymentStatus($invoice_id,$payment_status_id){

	         $this->CI =& get_instance();
		     $this->CI->load->database();	
            date_default_timezone_set('Asia/Colombo');
            $updated_date = date('Y-m-d');

               //update invoices table
        $datain = array(
        'payment_status_id' =>$payment_status_id,
         'final_payment_date' => $updated_date  
        );

        $this->CI->db->where('invoice_id', $invoice_id);
        $flag = $this->CI->db->update('public_payment', $datain);

    }


    public function manualPaymentMade($master_table_name,$master_table_record_id){
    	$this->CI =& get_instance();
		$this->CI->load->database();
        $this->CI->db->set('payment_made', 1);
        $this->CI->db->set('is_confirmed', 1);
        $this->CI->db->where('form_id', $master_table_record_id);
        $this->CI->db->update($master_table_name);
        
        return $this->CI->db->affected_rows();
    }

    function InsertLowPaymentOption2($amount_pay_now=0,$invoice_id=0,$user_id=0,$reference_no='',$payment_status_id=0,$payment_method_id=0,$check_or_bank_slip_no='',$check_or_bankslip_date='0000-00-00',$remarks='',$attachment='',$advance_pay_status=0,$refund_amount=0,$discount_amount=0,$item_amount_with_discount=0,$nbt_amount=0,$vat_amount=0){

   			$this->CI =& get_instance();
		     $this->CI->load->database();	
             $updated_by=$this->CI->session->userdata('user_id');
             if($updated_by==''){
             	$updated_by=0;
             }

             if($nbt_amount>0 || $vat_amount>0){
             	$is_tax_enable=1;
             	$nbt_presentage=$this->getTaxPresentage(1);
             	$vat_presentage=$this->getTaxPresentage(2);
             }else{
             	$is_tax_enable=0;
             	$nbt_presentage=0;
             	$vat_presentage=0;
             }
             if($discount_amount>0){
             	$is_discount=1;
             }else{
             	$is_discount=0;
             }



            date_default_timezone_set('Asia/Colombo');
            $updated_date = date('Y-m-d');

                $array = array(
                'payment_amount' => $amount_pay_now,
                'user_id'  => $user_id,
                'invoice_id' => $invoice_id,
                'advance_pay_status' => $advance_pay_status,
                'refund_amount' => $refund_amount,
                'item_amount_with_discount' => $item_amount_with_discount,
                'is_tax_enable' => $is_tax_enable,
                'nbt_amount' => $nbt_amount,
                'vat_amount' => $vat_amount,
                'nbt_presentage' => $nbt_presentage,
                'vat_presentage' => $vat_presentage,
                'is_discount' => $is_discount,
                'discount_amount' => $discount_amount,
                'reference_no' => $reference_no,
                'payment_status_id' => $payment_status_id,
                'final_payment_date' => $updated_date,
                'check_or_bank_slip_no' => $check_or_bank_slip_no,
                'check_or_bankslip_date' => $check_or_bankslip_date,
                 'attachment' => $attachment,
                'remarks' => $remarks,
                'payment_method_id' => $payment_method_id,
                 'updated_by' => $updated_by,
                'payment_date' => $updated_date,
                'state' => '1'

                );

           $this->CI->db->set($array);
           $this->CI->db->insert('public_payment');


           return $payment_id = $this->CI->db->insert_id();


    }



	 function InsertLowPayment($amount_pay_now=0,$invoice_id=0,$user_id=0,$reference_no='',$payment_status_id=0,$payment_method_id=0,$check_or_bank_slip_no='',$check_or_bankslip_date='0000-00-00',$remarks='',$attachment='',$advance_pay_status=0,$refund_amount=0){

	 	$taxwithcategoriesAll=getPaymentWithCategoriesAll($invoice_id);

	         $this->CI =& get_instance();
		     $this->CI->load->database();	
             $updated_by=$this->CI->session->userdata('user_id');
             if($updated_by==''){
             	$updated_by=0;
             }

            date_default_timezone_set('Asia/Colombo');
            $updated_date = date('Y-m-d');

                $array = array(
                'payment_amount' => $amount_pay_now,
                'user_id'  => $user_id,
                'invoice_id' => $invoice_id,
                'advance_pay_status' => $advance_pay_status,
                'refund_amount' => $refund_amount,
                'item_amount_with_discount' => $taxwithcategoriesAll->amount_without_tax- $taxwithcategoriesAll->discount_amount,
                'is_tax_enable' => $taxwithcategoriesAll->is_tax_enable,
                'nbt_amount' => $taxwithcategoriesAll->nbt_amount,
                'vat_amount' => $taxwithcategoriesAll->vat_amount,
                'nbt_presentage' => $taxwithcategoriesAll->nbt_presentage,
                'vat_presentage' => $taxwithcategoriesAll->vat_presentage,
                'is_discount' => $taxwithcategoriesAll->is_discount,
                'discount_amount' => $taxwithcategoriesAll->discount_amount,
                'reference_no' => $reference_no,
                'payment_status_id' => $payment_status_id,
                'final_payment_date' => $updated_date,
                'check_or_bank_slip_no' => $check_or_bank_slip_no,
                'check_or_bankslip_date' => $check_or_bankslip_date,
                 'attachment' => $attachment,
                'remarks' => $remarks,
                'payment_method_id' => $payment_method_id,
                 'updated_by' => $updated_by,
                'payment_date' => $updated_date,
                'state' => '1'

                );

           $this->CI->db->set($array);
           $this->CI->db->insert('public_payment');


           return $payment_id = $this->CI->db->insert_id();
        }


	public function CountRecords($master_table_name,$master_table_record_id){
		//Check already register member
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->db->select('*');
		$this->CI->db->from('public_invoices');
		$this->CI->db->where('master_table_name', $master_table_name);
		$this->CI->db->where('master_table_record_id', $master_table_record_id);
		$this->CI->db->where('payment_status_id', 0);
		return  $num_results = $this->CI->db->count_all_results();


	}




	public function UpdateTransactionDetailsofPayment($name,$address, $due_amount,  $user_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$pay_recepy_req,$email,$phone){



		   $this->CI =& get_instance();
			$this->CI->load->database();

			$this->CI->db->trans_start();


					$array2 = array(
						'name' => $name,
						'address' => $address,
						'email' => $email,
						'phone' => $phone,
						'amount'=> $due_amount,
						'payment_status_id'=> 0,
						'pay_recepy_req'=> $pay_recepy_req,			
						'description' => $description,
						'user_id' => $user_id,
						'invoice_date' => $assign_date,
						'invoice_date_time' => $assign_time,
						'state' =>1
					);

		
			$this->CI->db->where('master_table_record_id', $master_table_record_id);
			$this->CI->db->where('master_table_name', $master_table_name);
			$this->CI->db->where('payment_status_id', 0);
			$this->CI->db->update('public_invoices', $array2);



			       $this->CI->db->trans_complete();

			return $flag;

	

	}


	public function InsertTransactionDetailsofPayment($name,$address, $due_amount,  $user_id, $description, $master_table_name, $master_table_record_id, $assign_date, $assign_time, $state,$pay_recepy_req=0,$email,$phone){



			$this->CI =& get_instance();
			$this->CI->load->database();

			$this->CI->db->trans_start();


			$array2 = array(				
			'master_table_name' => $master_table_name,
			'master_table_record_id' => $master_table_record_id,
			'payment_status_id'=> 0,
			'name' => $name,
			'address' => $address,
			'email' => $email,
			'phone' => $phone,
			'amount'=> $due_amount,
			'pay_recepy_req'=> $pay_recepy_req,			
			'description' => $description,
			'user_id' => $user_id,
			'invoice_date' => $assign_date,
			'invoice_date_time' => $assign_time,
			'state' =>1
			);

			$this->CI->db->set($array2);
			$this->CI->db->insert('public_invoices');
			$invoice_id = $this->CI->db->insert_id();

			$this->CI->db->trans_complete();


/*		$CI =& get_instance();
        $CI->load->library('email_service_system');
		$CI->load->helper('public_finance');
		$CI->load->helper('misc');

		$paymentsummeryforreceipt=$this->PaymentSummeryresforReceipt($insert_id);
        $paymentrecept=getInvoiceByWithTaxBreakDown($paymentsummeryforreceipt,1);
	
	    $user_id_array=array($user_id);
        $email_array=getUserEmails($user_id_array);
        $recipients = $email_array;
        $body = $paymentrecept;
        $CI->email_service->sendEmail($recipients, 'Invoice Notification', $body);*/

	    return $invoice_id;

	}



/*
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

}*/

    	 function getTaxPresentage($taxid){

	   $this->CI =& get_instance();
	   $this->CI->load->database();
	   $this->CI->db->select('presentage');
       $this->CI->db->from('system_tax_rate');
       $this->CI->db->where('taxid', $taxid); 
       return  $result_array= $this->CI->db->get()->row()->presentage;

	}


function InsertPaymentDetailsCategoryWise($invoice_id,$master_table_name,$master_table_record_id,$main_payment_category_id,$amount_without_tax,$nbt_amount,$vat_amount,$final_amount,$quantity,$description){


            //$master_table_results=$this->getMasterTableResultsPublic($master_table_name,$master_table_record_id);

				if($nbt_amount>0 || $vat_amount>0 ){
					$is_tax_enable=1;
				}else{
					$is_tax_enable=0;
				}
              
				if($is_tax_enable>0){
					$nbt_presentage=$this->getTaxPresentage(1);
					$vat_presentage=$this->getTaxPresentage(2);
				}else{
					$nbt_presentage=0;
					$vat_presentage=0;
				}

		   //$this->deleteAlreadyExistPaymentDetailsCategoryWise($invoice_id,$master_table_name,$main_payment_category_id);


            date_default_timezone_set('Asia/Colombo');
	        $current_date=date('Y-m-d');	
	

		    $this->CI =& get_instance();
			$this->CI->load->database();

			$array2 = array(					
			'invoice_id' => $invoice_id,		
			'master_table_name' => $master_table_name,
			'master_table_record_id' => $master_table_record_id,
			'description' => $description,
			'quantity' => $quantity,
			'amount_without_tax' => $amount_without_tax,
			'final_amount' => $final_amount,
			'nbt_amount' => $nbt_amount,
			'vat_amount' => $vat_amount,
			'is_tax_enable' => $is_tax_enable,
			'nbt_presentage' => $nbt_presentage,
			'vat_presentage' => $vat_presentage,
			'main_payment_category_id' => $main_payment_category_id,
			'sub_payment_category_id' => 0

			);

			$this->CI->db->set($array2);
			$this->CI->db->insert('public_invoice_related_taxes');

			$this->CI->db->last_query();
			$this->CI->db->insert_id();



}

function  deleteAlreadyExistPaymentDetailsCategoryWise($invoice_id){

			$result=$this->getExistPaymentDetailsCategoryWise($invoice_id);


			$this->insertHistoryExistPaymentDetailsCategoryWise($result);

		   $this->CI =& get_instance();
		   $this->CI->load->database();
	       $this->CI->db->where('invoice_id', $invoice_id);
/*	       $this->CI->db->where('master_table_name', $master_table_name);
	       $this->CI->db->where('main_payment_category_id', $main_payment_category_id);*/
           $this->CI->db->delete('public_invoice_related_taxes');
}


function insertHistoryExistPaymentDetailsCategoryWise($results){

			$this->CI =& get_instance();
			$this->CI->load->database();

	foreach ($results as $key => $value) {
		$array2 = array(	
			'invoice_related_tax_id' => $value->invoice_related_tax_id,				
			'invoice_id' => $value->invoice_id,		
			'master_table_name' => $value->master_table_name,
			'master_table_record_id' => $value->master_table_record_id,
			'amount_without_tax' => $value->amount_without_tax,
			'final_amount' => $value->final_amount,
			'nbt_amount' => $value->nbt_amount,
			'vat_amount' => $value->vat_amount,
			'is_tax_enable' => $value->is_tax_enable,
			'nbt_presentage' => $value->nbt_presentage,
			'vat_presentage' => $value->vat_presentage,
			'main_payment_category_id' => $value->main_payment_category_id,
			'sub_payment_category_id' => 0

			);

			$this->CI->db->set($array2);
			$this->CI->db->insert('public_his_invoice_related_taxes');
	}

}


	    public function getExistPaymentDetailsCategoryWise($invoice_id){

		$this->CI =& get_instance();
		$this->CI->load->database();

         $this->CI->db->select('A.*');
        $this->CI->db->from('public_invoice_related_taxes AS A');
        $this->CI->db->where('A.invoice_id', $invoice_id); 
   /*     $this->CI->db->where('A.master_table_name', $master_table_name); 
        $this->CI->db->where('A.main_payment_category_id', $main_payment_category_id); */
        return $this->CI->db->get()->result();
        
    }




/*

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



	}*/

	

		public function UpdateInvoiceTablePaymentStatus($invoice_id,$paymethod){

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


			$this->CI->db->where('invoice_id', $invoice_id);
			$this->CI->db->where('payment_status_id', 0);
			$this->CI->db->where('state', 1);
			$this->CI->db->order_by('invoice_id', 'DESC');
 			$this->CI->db->limit(1);
			return $flag = $this->CI->db->update('public_invoices', $data1);



	}


		public function UpdateInvoiceTablePaymentReferenceNo($payment_id){
       

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
			'receipt_no' =>  $receipt_no
			);

			$this->CI->db->where('payment_id', $payment_id);
			$this->CI->db->order_by('payment_id', 'DESC');
 			$this->CI->db->limit(1);
			return $flag = $this->CI->db->update('public_payment', $data1);



	}


	 function CheckMaxReferenceNumber($receipt_no){

	   $this->CI =& get_instance();
	   $this->CI->load->database();
	   $this->CI->db->select('COUNT(receipt_no) AS total');
       $this->CI->db->from('public_payment');
       $this->CI->db->where('receipt_no', $receipt_no);
       return  $result_array= $this->CI->db->get()->row()->total;

	}


	 function getMaxReferenceNumber(){

	   $this->CI =& get_instance();
	   $this->CI->load->database();
	   $this->CI->db->select('MAX(receipt_no) AS receipt_no');
       $this->CI->db->from('public_payment');
       return  $result_array= $this->CI->db->get()->row()->receipt_no;

	}



	     function PaymentSummeryresforReceipt($payment_id){

		$this->CI =& get_instance();
		$this->CI->load->database();

        $this->CI->db->select('A.*,B.*');
        $this->CI->db->from('public_payment AS A');
        $this->CI->db->join('public_invoices B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('A.payment_id', $payment_id); 
        $this->CI->db->order_by('A.invoice_id', 'desc');
        return $this->CI->db->get()->result();
        
    }

	     function PaymentSummeryresforReceiptwithoutPaymentid($master_table_name,$master_table_record_id){

		$this->CI =& get_instance();
		$this->CI->load->database();

        $this->CI->db->select('A.*,B.*');
        $this->CI->db->from('public_payment AS A');
        $this->CI->db->join('public_invoices B', 'B.invoice_id = A.invoice_id', 'INNER');
        $this->CI->db->where('B.master_table_name', $master_table_name); 
        $this->CI->db->where('B.master_table_record_id', $master_table_record_id); 
        $this->CI->db->order_by('A.invoice_id', 'desc');
        return $this->CI->db->get()->result();
        
    }


    	     function PaymentSummeryresforInvoice($invoice_id){

		$this->CI =& get_instance();
		$this->CI->load->database();

        $this->CI->db->select('A.*');
        $this->CI->db->from('public_invoices AS A');
        $this->CI->db->where('A.invoice_id', $invoice_id); 
        $this->CI->db->order_by('A.invoice_id', 'desc');
        return $this->CI->db->get()->result();
        
    }



}

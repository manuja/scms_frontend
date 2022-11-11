<?php
	
	
	function get_price($check_in,$check_out,$room_type_id,$adults,$kids,$bungalow_or_room){
					$CI =& get_instance();
					$prices	=	array();
					    $CI->db->where('id',$room_type_id);
					    $CI->db->select('room_types.*,base_price as price');
						$room_type	=	$CI->db->get('room_types')->row_array();
						if($check_in==$check_out){
							$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
						}
						if($bungalow_or_room==2){
							if($adults	>	$room_type['higher_occupancy']){
								unset($_GET['room_type']);
								unset($_GET['search']);  
								// $CI->session->set_flashdata('error', "Adults are more than Higher Occupancy ".$room_type['higher_occupancy']);
								// redirect(current_url().'?'.http_build_query($_GET));
								// redirect('bookings/booking_page');
								return 'higher_occupancy';
								// echo json_encode(array("status" => 2, "msg" => "Adults are more than Higher Occupancy ".$room_type['higher_occupancy']));
								
							}
							if($kids	>	$room_type['kids_occupancy']){
								unset($_GET['room_type']);
								unset($_GET['search']);
								// $CI->session->set_flashdata('error', "Kids are more than Higher Kids Occupancy ".$room_type['kids_occupancy']);
								// redirect(current_url().'?'.http_build_query($_GET));
								// redirect('bookings/booking_page');
								return 'kids_occupancy';
								// echo json_encode(array("status" => 2, "msg" => "Kids are more than Higher Kids Occupancy ".$room_type['kids_occupancy']));
							
							}
						}
							
						if($adults	>	$room_type['base_occupancy']){
							$additional_person			=	 $adults	-	$room_type['base_occupancy'];
							$additional_person_price	=	$room_type['additional_person'];
						}else{
							$additional_person			=	0;
							$additional_person_price	=	0;
						}
						
					$amount	=	0;
					$additional_price_amount	=	0;
					$price_manager	=	array();
					$begin = new DateTime($check_in);
					$end = new DateTime($check_out);
					
					$interval = DateInterval::createFromDateString('1 day');
					$period = new DatePeriod($begin, $interval, $end);
					foreach ( $period as $dt ){
					  	$date		=	 $dt->format( "Y-m-d" );	
						$dayno		=	 $dt->format( "N" );
						$day		=	 $dt->format( "D" );
						$day		=	strtolower($day);
						
						
						//check for special date	
											$CI->db->where('date_from <=',$date);
											$CI->db->where('date_to >=',$date);
											$CI->db->select(''.$day.' as price');
						$special_price	=	$CI->db->get('special_price')->row_array();
						if(!empty($special_price)){
							$amount				+= $special_price['price'];
							$additional_price_amount	+=	$additional_person_price;
							$prices[$date]		= $special_price;	
							$prices[$date]['type']	=	'Special Price';
							$prices[$date]['add_person']	=	$additional_person;
							$prices[$date]['add_person_price']	=	$additional_person_price;
							continue;
						}else{
											$CI->db->where('room_type_id',$room_type_id);
											$CI->db->select(''.$day.' as price');
						$price_manager	=	$CI->db->get('price_manager')->row_array();
						}
						
						//echo '<pre>';print_r($price_manger);die;
						//echo $price_manager['price'];die;
						if(!empty($price_manager)){
							$amount								+= $price_manager['price'];
							$additional_price_amount			+=	$additional_person_price;
							$prices[$date]						=	$price_manager;
							$prices[$date]['type']				=	'Regular Price';
							$prices[$date]['add_person']		=	$additional_person;
							$prices[$date]['add_person_price']	=	$additional_person_price;
							continue;
						}else{
										
							$amount								+=  $room_type['price'];
							$additional_price_amount			+=	$additional_person_price;
							$prices[$date]						=	$room_type;
							$prices[$date]['type']				=	'Base Price';
							$prices[$date]['add_person']		=	$additional_person;
							$prices[$date]['add_person_price']	=	$additional_person_price;
							continue;	
						}
					}
			
			//echo $amount;
			//echo '<pre>'; print_r($prices);die;
		//	$amount	=	$amount	+	$additional_price_amount*$additional_person
				return $booking_price	= 	array('amount'=> $amount,'additional_person_amount'=>$additional_price_amount*$additional_person,'total_price'=>$amount+$additional_price_amount*$additional_person,'price_details'=> $prices,'additional_person'=>$additional_person);	
	}
	
	
	
	
?>
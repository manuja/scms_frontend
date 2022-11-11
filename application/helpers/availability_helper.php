<?php

	function check_availability_for_invoice($check_in,$check_out,$adults,$kids,$room_numbers, $bungalow_id){
		$query		=	'?date_from='.$check_in.'&bungalow='.$bungalow_id.'&date_to='.$check_out.'&adults='.$adults.'&kids='.$kids.'&room_type=';	
		$CI =& get_instance();

		if($check_in==$check_out){
			$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
		}
					
		if($adults<1){
			$CI->session->set_flashdata('error', "Invalid Adult Value");
			redirect('front/book/index'.$query);
		}

		$CI->db->where('id',1);
		$settings	=	$CI->db->get('settings')->row_array();

		$total_rooms	=	count($room_numbers);

		$begin = new DateTime($check_in);
		$end = new DateTime($check_out);
		
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		foreach($period as $dt){
			$date		=	 $dt->format( "Y-m-d" );	
			$dayno		=	 $dt->format( "N" );
			$day		=	 $dt->format( "D" );
			$day		=	strtolower($day);
		
			if($date >= $settings['room_block_start_date'] && $date <=$settings['room_block_end_date'])
			{
				$block_message	=	"Sorry.. No Room Available Between ".date('d/m/Y',strtotime($settings['room_block_start_date']))." to ".date('d/m/Y',strtotime($settings['room_block_end_date']))."  ";
				$CI->session->set_flashdata('error', $block_message);

				redirect('');
			}
			foreach ($room_numbers as $room_number) {
				$rooms = $CI->db->where('bungalow_id', $bungalow_id)
			    	->where('room_no', $room_number)
			    	->get('rooms')->row_array();

			    $room_type_id = $rooms['room_type_id'];

				$CI->db->where('O.room_type_id',$room_type_id);
				$CI->db->where('R.date',$date);
				$CI->db->select('R.*,');
				$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
				$orders = $CI->db->get('rel_orders_prices R')->result_array();

				if($total_rooms > 0) {
					//echo count($orders);die;
					if(count($orders) >= $total_rooms){
						$CI->session->unset_userdata('booking_data');
						$CI->session->unset_userdata('coupon_data');
						$CI->session->set_flashdata('error', "Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room");

						redirect('front/book/index'.$query);
					}else{
						continue;	// continue loop
					}
				} else {
					$CI->session->unset_userdata('booking_data');
					$CI->session->unset_userdata('coupon_data');
					$CI->session->set_flashdata('error', "Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room");
					redirect('front/book/index'.$query);
				}
			}
		}
		return;
	}

	function check_availability($check_in,$check_out,$adults,$kids,$room_type_id){
		$query		=	'?date_from='.$check_in.'&date_to='.$check_out.'&adults='.$adults.'&kids='.$kids.'&room_type=';	
		$CI =& get_instance();
		if($check_in==$check_out){
			$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
		}
					
		if($adults<1){
			$CI->session->set_flashdata('error', "Invalid Adult Value");
			redirect('front/book/index'.$query);
		}
		$CI->db->where('id',1);
		$settings	=	$CI->db->get('settings')->row_array();
				
		$CI->db->where('id',$room_type_id);
		$CI->db->select('room_types.*,base_price as price');
		$room_type	=	$CI->db->get('room_types')->row_array();
			//echo '<pre>'; print_r($room_type);die;
			
		$CI->db->where('room_type_id',$room_type_id);
		$CI->db->select('id,floor_id,room_no,room_type_id,count(room_no) as total_rooms');
		$rooms	  	=	$CI->db->get('rooms')->row_array();
		$total_rooms	=	$rooms['total_rooms'];
		//echo '<pre>'; print_r($rooms);die;
		$begin = new DateTime($check_in);
		$end = new DateTime($check_out);
		
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
			
		foreach($period as $dt){
			$date		=	 $dt->format( "Y-m-d" );	
			$dayno		=	 $dt->format( "N" );
			$day		=	 $dt->format( "D" );
			$day		=	strtolower($day);
			///echo $date;die;			
			//check for room block period
		
			if($date >= $settings['room_block_start_date'] && $date <=$settings['room_block_end_date'])
			{
				$block_message	=	"Sorry.. No Room Available Between ".date('d/m/Y',strtotime($settings['room_block_start_date']))." to ".date('d/m/Y',strtotime($settings['room_block_end_date']))."  ";
				$CI->session->set_flashdata('error', $block_message);

				redirect('');
			}
							$CI->db->where('O.room_type_id',$room_type_id);
							$CI->db->where('R.date',$date);
							$CI->db->select('R.*,');
							$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
			$orders	  	=	$CI->db->get('rel_orders_prices R')->result_array();
			//echo '<pre>'; print_r($orders);die;
			//echo $total_rooms;die; 
			if($total_rooms > 0){
				//echo count($orders);die;
				if(count($orders) >= $total_rooms){
					$CI->session->unset_userdata('booking_data');
					$CI->session->unset_userdata('coupon_data');
					$CI->session->set_flashdata('error', "Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room");

					redirect('front/book/index'.$query);
				}else{
					continue;	// continue loop
				}
			}else{
					$CI->session->unset_userdata('booking_data');
					$CI->session->unset_userdata('coupon_data');
					$CI->session->set_flashdata('error', "Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room");
					redirect('front/book/index'.$query);
			}
		}
		
		return;
	}
	
	function check_availability_ajax($check_in,$check_out,$adults,$kids,$bungalow_id){
					$query		=	'?date_from='.$check_in.'&date_to='.$check_out.'&adults='.$adults.'&kids='.$kids.'&bungalow=';	
					$CI =& get_instance();
						if($check_in==$check_out){
							$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
						}
						if($adults<1){
							return  "Invalid Adult Value";
							
						}
											$CI->db->where('id',1);
						$settings	=	$CI->db->get('settings')->row_array();
						
											$CI->db->where('id',$bungalow_id);
											$CI->db->select('room_types.*,base_price as price');
						$bungalow	=	$CI->db->get('room_types')->row_array();
						//echo '<pre>'; print_r($settings);die;
						
											$CI->db->where('rooms.bungalow_id',$bungalow_id);
											$CI->db->select('id,floor_id,room_no,bungalow_id,count(room_no) as total_rooms');
						$rooms	  	=	$CI->db->get('rooms')->row_array();
						$total_rooms	=	$rooms['total_rooms'];
						//echo '<pre>'; print_r($rooms);die;
						$begin = new DateTime($check_in);
						$end = new DateTime($check_out);
						
						$interval = DateInterval::createFromDateString('1 day');
						$period = new DatePeriod($begin, $interval, $end);
						
						foreach($period as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							
							if($date >= $settings['room_block_start_date'] && $date <=$settings['room_block_end_date'])
							{
								$block_message	=	"Sorry.. No Room Available Between ".date('d/m/Y',strtotime($settings['room_block_start_date']))." to ".date('d/m/Y',strtotime($settings['room_block_end_date']))."  ";
								return $block_message;
								
						
							}
										
											$CI->db->where('O.bungalow_id',$bungalow_id);
											$CI->db->where('R.date',$date);
											$CI->db->select('R.*,');
											$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
						$orders	  	=	$CI->db->get('rel_orders_prices R')->result_array();
							//echo '<pre>'; print_r($orders);die;
							//echo $total_rooms;die; 
							if($total_rooms > 0){
								if(count($orders) > $total_rooms){
									$CI->session->unset_userdata('booking_data');
									$CI->session->unset_userdata('coupon_data');
									return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
								}else{
									continue;	// continue loop
								}
							}else{
									$CI->session->unset_userdata('booking_data');
									$CI->session->unset_userdata('coupon_data');
									return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
							}
						}
						
		return 1;
	}
	
	
	
	function room_alot($check_in,$check_out,$room_type_id,$bungalow_or_room,$bungalow_id){
					//echo $check_in;echo $check_out;
					$CI =& get_instance();
					if($check_in==$check_out){
						$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
					}
					
											//$CI->CI->db->where("(status=1 OR status=3)", NULL, FALSE);
											$CI->db->where_in('O.status',array(1,0));	//for check booking status succes/pending
											$CI->db->where('O.room_type_id',$room_type_id);
											$CI->db->where('R.date >=',$check_in);
											$CI->db->where('R.date <',$check_out);
											$CI->db->select('R.*');
											$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
											
						$orders	  		=	$CI->db->get('rel_orders_prices R')->result_array();
						//echo '<pre>'; print_r($orders);die;
						$rids	=	array();
						foreach($orders as $od){
							//echo $od['room_id'];
							if($od['room_id'] >  0){
								$rids[]	=	$od['room_id'];
							}
						}
						//echo '<pre>'; print_r($rids);die;
										if(!empty($rids)){
											$CI->db->where_not_in('R.id', $rids);
										}
										if($bungalow_or_room==1){
											$CI->db->where('R.bungalow_id',$bungalow_id);
										}else{
											$CI->db->where('R.room_type_id',$room_type_id);
										}
										$CI->db->select('R.id,R.floor_id,R.room_no,R.room_type_id');
										// $CI->db->join('floors F', 'F.id = R.floor_id', 'LEFT');
						$rooms	=		$CI->db->get('rooms R')->result();
						//echo '<pre>'; print_r($rooms);die;
						
							
		return $rooms;
	}	

	// function check_availability_ajax_tab1($check_in,$check_out,$adults,$kids,$bungalow_id){ 
	function check_availability_ajax_tab1($check_in, $check_out, $adults, $kids, $bungalow_id, $child_age, $bungalow_or_room, $number_of_rooms){ 

		$CI = & get_instance();
		$CI->load->database();

			$query		=	'?date_from='.$check_in.'&date_to='.$check_out.'&adults='.$adults.'&kids='.$kids.'&bungalow=';	
	
				if($check_in==$check_out){
					$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
				}
				if($adults<1){
					return  "Invalid Adult Value"; 
				}
				// $CI->db->where('id',1);
				// $settings	=	$CI->db->get('settings')->row_array();
				// if($bungalow_or_room==2){  
				// 	$CI->db->select('room_types.*,base_price as price');
				// 	$CI->db->where('id',$room_type_id);
				// 	$bungalow	=	$CI->db->get('room_types')->row_array();
				// }
				
				// $CI->db->select('id,room_no,bungalow_id,count(room_no) as total_rooms');
				$CI->db->select('count(room_no) as total_rooms');
				$CI->db->where('rooms.bungalow_id',$bungalow_id); 
				// if($bungalow_or_room==2){ 
				// 	$CI->db->where('rooms.room_type_id',$room_type_id); 
				// }
				// $CI->db->group_by('id');
				$rooms	  	=	$CI->db->get('rooms')->row_array();
				$total_rooms	=	$rooms['total_rooms'];
			// echo '<pre>'; print_r($total_rooms);die();
				$begin = new DateTime($check_in);
				$end = new DateTime($check_out);
				
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($begin, $interval, $end);
				
				foreach($period as $dt){
					$date		=	 $dt->format( "Y-m-d" );	
					$dayno		=	 $dt->format( "N" );
					$day		=	 $dt->format( "D" );
					$day		=	strtolower($day);
					
					// if($date >= $settings['room_block_start_date'] && $date <=$settings['room_block_end_date'])
					// {
					// 	$block_message	=	"Sorry.. No Room Available Between ".date('d/m/Y',strtotime($settings['room_block_start_date']))." to ".date('d/m/Y',strtotime($settings['room_block_end_date']))."  ";
					// 	return $block_message;
					// }

					//	
					$CI->db->select('R.*,O.id,O.bungalow_or_room');
					$CI->db->where('O.bungalow_id',$bungalow_id);
					$CI->db->where('R.date',$date);
					$CI->db->where('O.bungalow_or_room',1);
					$CI->db->where_not_in('O.status', array('2'));
					$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
				    $orders_before	 =	$CI->db->get('rel_orders_prices R')->result_array();
					// echo '<pre>'; print_r($orders_before);die();
					if(count($orders_before) > 0){
						$CI->session->unset_userdata('booking_data'); 
						return 5;
					}
					//

					$CI->db->select('R.*,O.id,O.bungalow_or_room');
					$CI->db->where('O.bungalow_id',$bungalow_id);
					// if($bungalow_or_room==2 && !empty($room_type_id)){ 
					// 	$CI->db->where('O.room_type_id',$room_type_id); 
					// }
					$CI->db->where('R.date',$date);
					$CI->db->where_not_in('O.status', array('2'));
					$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
				    $orders	 =	$CI->db->get('rel_orders_prices R')->result_array();
					// echo '<pre>'; print_r($orders);die();
					//echo $total_rooms;die; 
					if($total_rooms > 0){

						if($bungalow_or_room==1){
							if(count($orders) > 0){
								$CI->session->unset_userdata('booking_data'); 
								// $CI->session->unset_userdata('coupon_data');
								// return 'Sorry.. Bungalow Is Not Available. Please Try With Another Date, Bungalow!';
								return 5;
							}else{
								continue;	// continue loop
							}
						}else{
							if(count($orders) > $total_rooms){
								$CI->session->unset_userdata('booking_data'); 
								// $CI->session->unset_userdata('coupon_data');
								// return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
								return 4;
							}else{
								continue;	// continue loop
							}
						}
							// if(count($orders) > $total_rooms){
							// 	$CI->session->unset_userdata('booking_data'); 
							// 	// $CI->session->unset_userdata('coupon_data');
							// 	// return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
							// 	return 4;
							// }else{
							// 	continue;	// continue loop
							// }

					}else{
						$CI->session->unset_userdata('booking_data');
						// $CI->session->unset_userdata('coupon_data');
							// return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
							return 4;
					}
				}
				
	return 1;
	}

	function check_availability_ajax_tab2($check_in, $check_out, $adults, $kids, $bungalow_id, $room_type_id, $child_age, $bungalow_or_room, $number_of_rooms){ 

		$CI = & get_instance();
		$CI->load->database();

			$query		=	'?date_from='.$check_in.'&date_to='.$check_out.'&adults='.$adults.'&kids='.$kids.'&bungalow=';	
	
				if($check_in==$check_out){
					$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
				}
				if($adults<1){
					return  "Invalid Adult Value"; 
				}
				// $CI->db->where('id',1);
				// $settings	=	$CI->db->get('settings')->row_array();
				if($bungalow_or_room==2){  
					$CI->db->select('room_types.*,base_price as price');
					$CI->db->where('id',$room_type_id);
					$bungalow	=	$CI->db->get('room_types')->row_array();
				}
				
				// $CI->db->select('id,room_no,bungalow_id,count(room_no) as total_rooms');
				$CI->db->select('count(room_no) as total_rooms');
				$CI->db->where('rooms.bungalow_id',$bungalow_id); 
				if($bungalow_or_room==2){ 
					$CI->db->where('rooms.room_type_id',$room_type_id); 
				}
				// $CI->db->group_by('id');
				$rooms	  	=	$CI->db->get('rooms')->row_array();
				$total_rooms	=	$rooms['total_rooms'];
			// echo '<pre>'; print_r($total_rooms);die();
				$begin = new DateTime($check_in);
				$end = new DateTime($check_out);
				
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($begin, $interval, $end);
				
				foreach($period as $dt){
					$date		=	 $dt->format( "Y-m-d" );	
					$dayno		=	 $dt->format( "N" );
					$day		=	 $dt->format( "D" );
					$day		=	strtolower($day);
					
					// if($date >= $settings['room_block_start_date'] && $date <=$settings['room_block_end_date'])
					// {
					// 	$block_message	=	"Sorry.. No Room Available Between ".date('d/m/Y',strtotime($settings['room_block_start_date']))." to ".date('d/m/Y',strtotime($settings['room_block_end_date']))."  ";
					// 	return $block_message;
					// }
						
					//
					$CI->db->select('R.*,O.id,O.bungalow_or_room');	
					$CI->db->where('O.bungalow_id',$bungalow_id);
					$CI->db->where('R.date',$date);
					$CI->db->where('O.bungalow_or_room',1);
					$CI->db->where_not_in('O.status', array('2'));
					$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
				    $orders_before	 =	$CI->db->get('rel_orders_prices R')->result_array();
					// echo '<pre>'; print_r($orders_before);die();
					if(count($orders_before) > 0){
						$CI->session->unset_userdata('booking_data'); 
						return 5;
					}
					//

					$CI->db->select('R.*,O.id,O.bungalow_or_room');
					$CI->db->where('O.bungalow_id',$bungalow_id);
					if($bungalow_or_room==2 && !empty($room_type_id)){ 
						$CI->db->where('O.room_type_id',$room_type_id); 
					}
					$CI->db->where('R.date',$date);
					$CI->db->where_not_in('O.status', array('2'));
					$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
				    $orders	 =	$CI->db->get('rel_orders_prices R')->result_array();
					// echo '<pre>'; print_r($orders);die();
					//echo $total_rooms;die; 
					if($total_rooms > 0){
						if($bungalow_or_room==1){
							if(count($orders) > 0){
								$CI->session->unset_userdata('booking_data'); 
								// $CI->session->unset_userdata('coupon_data');
								// return 'Sorry.. Bungalow Is Not Available. Please Try With Another Date OR Bungalow!';
								return 5;
							}else{
								continue;	// continue loop
							}
						}else{
							if(count($orders) > $total_rooms){
								$CI->session->unset_userdata('booking_data'); 
								// $CI->session->unset_userdata('coupon_data');
								// return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
								return 4;
							}else{
								continue;	// continue loop
							}
						}
						// if(count($orders) > $total_rooms){
						// 	$CI->session->unset_userdata('booking_data'); 
						// 	// $CI->session->unset_userdata('coupon_data');
						// 	// return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
						// 	return 4;
						// }else{
						// 	continue;	// continue loop
						// }
					}else{
						$CI->session->unset_userdata('booking_data');
						// $CI->session->unset_userdata('coupon_data');
							// return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
							return 4;
						}
				}
				
	return 1;
	}

	function get_all_rooms_count_in_bungalow($bungalow_id){
		$CI = & get_instance();
		$CI->load->database();

		$CI->db->select('count(room_no) as total_rooms');
		$CI->db->where('rooms.bungalow_id',$bungalow_id); 
		// $CI->db->group_by('id');
		$rooms	  	=	$CI->db->get('rooms')->row_array();
		$total_rooms	=	$rooms['total_rooms'];

		return $total_rooms;
	}
	
?>
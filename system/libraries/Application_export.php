<?php

/*
 * Created by test
 */

class CI_Application_export {

    public function __construct() {
        
    }

    //$application_type 1-normal member application,2-Tech Engineer,3-reinstatements,4-transfer,5-Account Recovery
    public function applicationData($idsArr, $application_type) {
        $html = '';
        if ($application_type == 1) {
            $html .= '<h3>Normal Membership Applications</h3>';
        } else if ($application_type == 2) {
            $html .= '<h3>Technical Engineer Applications</h3>';
        } else if ($application_type == 3) {
            $html .= '<h3>Membership Reinstatement Applications</h3>';
        } else if ($application_type == 4) {
            $html .= '<h3>Membership Transfer Applications</h3>';
        }else if($application_type == 5){
            $html .= '<h3>Membership Account Recovery Applications</h3>';
        }
        $html .= '<table border="1">';

        $html .= '<tr>'
                . '<th with="200" rowspan="2">Application No</th>';
        if ($application_type == 3 || $application_type == 4) {
            $html .= "<th rowspan='2'>Memebership Number</th>";
        }else if($application_type== 5){
            $html .= "<th rowspan='2'>New Memebership Number</th>"
                    . "<th rowspan='2'>Old Memebership Number</th>";
        }
        $html .= '<th with="200" rowspan="2">Class of Membership</th>';
        if ($application_type == 4) {
            $html .= '<th with="200" rowspan="2">New Class of Membership</th>';
        }
        $html .= '<th rowspan="2">Engineering Discipline</th>'
                . '<th rowspan="2">Salutation</th>'
                . '<th rowspan="2">Name with initials</th>'
                . '<th rowspan="2">Full Name</th>'
                . '<th rowspan="2">Gender</th>'
                . '<th rowspan="2">Date of Birth</th>'
                . '<th rowspan="2">NIC</th>'
                . '<th rowspan="2">Passport Number</th>'
                . '<th rowspan="2">Mobile Number</th>'
                . '<th rowspan="2">Home Telephone Number</th>'
                . '<th rowspan="2">Office Telephone Number</th>'
                . '<th rowspan="2">Email</th>'
                . '<th colspan="3">Current Address</th>'
                . '<th rowspan="2">Permanent Address</th>'
                . '<th rowspan="2">Official Address</th>';
        if ($application_type == 1 || $application_type == 4) {
            $html .= '<th rowspan="2">Current Place of Work</th>'
                    . '<th rowspan="2">Current Designation</th>';
        }
        $html .= '<th colspan="10">AL Results</th>'
                . '<th colspan="5">Primary Qualification</th>'
                . '<th colspan="6">Proposers</th>'
                . '<th rowspan="2">Training Place of Work</th>'
                . '<th rowspan="2">Position Held</th>'
                . '<th rowspan="2">Period of Work</th>'
                . '<th colspan="3">Professional Membership</th>'
                . '<th colspan="2">Payments</th>'
                . '<th rowspan="2">Payment Status</th>'
                . '<th rowspan="2">Payment Date</th>';
        if ($application_type == 3) {
            $html .= '<td rowspan="2">Laps Fom Year</td>'
                    . '<td rowspan="2">Laps To Year</td>';
        }
        $html .= '<th rowspan="2">Application Submit Date</th>'
                . '<th rowspan="2">Application Status</th>'
                . '<th rowspan="2">PSMC Decision</th>'
                . '<th rowspan="2">Council Decision</th>'
                . '</tr>';

        $html .= '<tr>'
                . '<th>Line 1</th>'
                . '<th>Line 2</th>'
                . '<th>city</th>'
                . '<th>Type of AL Examination</th>'
                . '<th>Year</th>'
                . '<th>Subject 1</th>'
                . '<th>Credit 1</th>'
                . '<th>Subject 2</th>'
                . '<th>Credit 2</th>'
                . '<th>Subject 3</th>'
                . '<th>Credit 3</th>'
                . '<th>Subject 4</th>'
                . '<th>Credit 4</th>'
                . '<th>Name of Institution</th>'
                . '<th>Type of Institution</th>'
                . '<th>Period of Study</th>'
                . '<th>Name of Qualification</th>'
                . '<th>Awarded Year</th>'
                . '<th>Proposer 1 Name</th>'
                . '<th>Proposer 1 Class of Membership</th>'
                . '<th>Proposer 1 Membership Number</th>'
                . '<th>Proposer 2 Name</th>'
                . '<th>Proposer 2 Class of Membership</th>'
                . '<th>Proposer 2 Membership Number</th>'
                . '<th>Institution</th>'
                . '<th>Membership Number</th>'
                . '<th>Joined Year</th>'
                . '<th>Invoice Amount (Rs.)</th>'
                . '<th>Paid Amount (Rs.)</th>'
                . '</tr>';

        foreach ($idsArr as $user_tbl_id) {
            $result_data = '';
            if ($application_type == 1) {
                //normal membership applicaation
                $result_data = $this->getNormalApplicationDetails($user_tbl_id);
                $invoice = $this->getInvoiceforApplication('user_registrations', $user_tbl_id, 1);
                $paid_amount = $this->getAdvancePaymentAmount('user_registrations', $user_tbl_id);              
            } else if ($application_type == 2) {
                //tech engineer registration
                $result_data = $this->getTechengApplication($user_tbl_id);
                $invoice = $this->getInvoiceforApplication('techeng_registrations', $user_tbl_id, 30);
                $paid_amount = $this->getAdvancePaymentAmount('techeng_registrations', $user_tbl_id);
            } else if ($application_type == 3) {
                // reinstatement
                $result_data = $this->getReinstatementApplicationDetail($user_tbl_id);
                $invoice = $this->getInvoiceforApplication('member_reinstatement', $user_tbl_id, 29);
                $paid_amount = $this->getAdvancePaymentAmount('member_reinstatement', $user_tbl_id);
            } else if ($application_type == 4) {
                // transfer
                $result_data = $this->getTransferApplicationDetail($user_tbl_id);
                $current_mem_cls = $result_data['user_registrations'][0]->user_member_class;
                $new_mem_cls = $result_data['user_registrations'][0]->applied_member_class;
                
                $payment_category = $this->getPaymentMethodForTransfer($current_mem_cls,$new_mem_cls);
                $invoice = $this->getInvoiceforApplication('mem_transfer_registrations', $user_tbl_id, $payment_category);
                $paid_amount = $this->getAdvancePaymentAmount('mem_transfer_registrations', $user_tbl_id);
            }else if($application_type == 5){
                // recovery
                $result_data = $this->getRecoverApplication($user_tbl_id);
                $invoice = $this->getInvoiceforApplication('member_recover', $user_tbl_id, 62);
                $paid_amount = $this->getAdvancePaymentAmount('member_recover', $user_tbl_id);
            }

            $nic = '';
            $html .= '<tr>';
            if ($result_data['user_registrations'][0]->user_nic_old) {
                $nic = $result_data['user_registrations'][0]->user_nic_old;
            } else {
                $nic = $result_data['user_registrations'][0]->user_nic;
            }
            $html .= '<td>' . $result_data['user_registrations'][0]->reg_application_id . '</td>';
            if ($application_type == 3 || $application_type == 4) {
                $html .= "<td>" . $result_data['user_registrations'][0]->membership_number . "</td>";
            }else if($application_type == 5){
                 $html .= "<td>" . $result_data['user_registrations'][0]->membership_no_new . "</td>";
                 $html .= "<td>" . $result_data['user_registrations'][0]->membership_number . "</td>";
            }
            $html .= '<td>' . $result_data['user_registrations'][0]->class_of_membership_name . '</td>';
            if ($application_type == 4) {
                $html .= '<th>'.$result_data['user_registrations'][0]->new_class_of_membership_name.'</th>';
            }
            $html.= '<td>' . $result_data['user_registrations'][0]->core_engineering_discipline_name . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->salutation . '</td>'; //salutation
            if ($application_type == 3 || $application_type == 5 || $application_type == 4) {
                $html .= '<td>' . $result_data['user_registrations'][0]->user_name_initials . ' ' . $result_data['user_registrations'][0]->user_name_lastname . '</td>'//name with initials
                        . '<td>' . $result_data['user_registrations'][0]->user_names_by_initials . ' ' . $result_data['user_registrations'][0]->user_name_lastname . '</td>'; //full name
            } else {
                $html .= '<td>' . $result_data['user_registrations'][0]->user_name_w_initials . '</td>'//name with initials
                        . '<td>' . $result_data['user_registrations'][0]->user_names_by_initials . ' ' . $result_data['user_registrations'][0]->user_name_lastname . '</td>'; //full name
            }

            $html.= '<td>' . $result_data['user_registrations'][0]->person_gender . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_dob . '</td>'
                    . '<td>' . $nic . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_passport . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_mobile . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_home_tel . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_office_tel . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_email . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_current_addr_line1 . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_current_addr_line2 . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_current_addr_city . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_permanent_addr . '</td>'
                    . '<td>' . $result_data['user_registrations'][0]->user_official_addr . '</td>';
            if ($application_type == 1 || $application_type == 4) {
                $html .= '<td>' . $result_data['user_registrations'][0]->current_work_place . '</td>'
                        . '<td>' . $result_data['user_registrations'][0]->current_designation . '</td>';
            }

            // AL Results
            if (count($result_data['member_al_result']) >= 3) {
                if ($result_data['member_al_result'][0]->type_of_exam == '1') {
                    $html .= '<td>GCE Advanced Level (Sri Lanka)</td>';
                } else {
                    $html .= '<td>GCE Advanced Level (UK)</td>';
                }
                $html .= '<td>' . $result_data['member_al_result'][0]->year_of_award . '</td>'
                        . '<td>' . $result_data['member_al_result'][0]->master_al_subjects_name . '</td>'
                        . '<td>' . $result_data['member_al_result'][0]->result_id_code . '</td>'
                        . '<td>' . $result_data['member_al_result'][1]->master_al_subjects_name . '</td>'
                        . '<td>' . $result_data['member_al_result'][1]->result_id_code . '</td>'
                        . '<td>' . $result_data['member_al_result'][2]->master_al_subjects_name . '</td>'
                        . '<td>' . $result_data['member_al_result'][2]->result_id_code . '</td>';
                if (count($result_data['member_al_result']) > 3) {
                    $html .= '<td>' . $result_data['member_al_result'][3]->master_al_subjects_name . '</td>'
                            . '<td>' . $result_data['member_al_result'][3]->result_id_code . '</td>';
                } else {
                    $html .= '<td></td><td></td>';
                }
            } else {
                $html .= '<td> AL Not completed </td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
            }
            // primary qualification
            if (count($result_data['member_academic_qualifications']) > 0) {
                $to = '';

                if ($result_data['member_academic_qualifications'][0]->ongoing == "1") {
                    $to = 'Present';
                } else {
                    $to = $result_data['member_academic_qualifications'][0]->study_period_to;
                }
                $html .= '<td>' . $result_data['member_academic_qualifications'][0]->institute_name . '</td>'
                        . '<td>' . $result_data['member_academic_qualifications'][0]->type_of_institution_type . '</td>'
                        . '<td>' . $result_data['member_academic_qualifications'][0]->study_period_from . ' - ' . $to . '</td>'
                        . '<td>' . $result_data['member_academic_qualifications'][0]->qualification_awarded . '</td>'
                        . '<td>' . $result_data['member_academic_qualifications'][0]->year_of_award . '</td>';
            } else {
                $html .= '<td></td><td></td><td></td><td></td><td></td>';
            }

            if (count($result_data['member_proposers']) > 0) {
                $html .= '<td>' . $result_data['member_proposers'][0]->proposer_name_w_initials . '</td>'
                        . '<td>' . $result_data['member_proposers'][0]->class_of_membership_name . '</td>'
                        . '<td>' . $result_data['member_proposers'][0]->proposer_membership_no . '</td>'
                        . '<td>' . $result_data['member_proposers'][1]->proposer_name_w_initials . '</td>'
                        . '<td>' . $result_data['member_proposers'][1]->class_of_membership_name . '</td>'
                        . '<td>' . $result_data['member_proposers'][1]->proposer_membership_no . '</td>';
            } else {
                $html .= '<td></td><td></td><td></td><td></td><td></td><td></td>';
            }
            if (count($result_data['member_training_experience']) > 0) {
                $html .='<td>' . $result_data['member_training_experience'][0]->place_of_work_name . '</td>'
                        . '<td>' . $result_data['member_training_experience'][0]->exp_position_held . '</td>'
                        . '<td>' . $result_data['member_training_experience'][0]->exp_work_period_from . '</td>';
            } else {
                $html .='<td></td><td></td><td></td>';
            }
            if (count($result_data['member_professional_membership']) > 0) {
                $html .= '<td>' . $result_data['member_professional_membership'][0]->mem_institute . '</td>'
                        . '<td>' . $result_data['member_professional_membership'][0]->mem_membership_no . '</td>'
                        . '<td>' . $result_data['member_professional_membership'][0]->mem_joined_year . '</td>';
            } else {
                $html .= '<td></td><td></td><td></td>';
            }

            //application status
            $status = '';
            if ($result_data['user_registrations'][0]->user_i_second_approval_date == "0000-00-00 00:00:00" && $result_data['user_registrations'][0]->user_ii_approval_date == "0000-00-00 00:00:00") {
                $status = 'Operational Action Pending';
            } else if ($result_data['user_registrations'][0]->user_i_second_approval_date != "0000-00-00 00:00:00" && $result_data['user_registrations'][0]->user_ii_approval_date == "0000-00-00 00:00:00") {
                $status = 'Manegerial Action Pending';
            } else if ($result_data['user_registrations'][0]->user_ii_approval_date != "0000-00-00 00:00:00" && $result_data['user_registrations'][0]->final_approval == '0' && $result_data['user_registrations'][0]->payment_made == '0') {
                $status = 'Payment Pending';
            } else if ($result_data['user_registrations'][0]->payment_made == '1' && $result_data['user_registrations'][0]->psmc_approval_date == "0000-00-00 00:00:00" && $result_data['user_registrations'][0]->council_approval_date == "0000-00-00 00:00:00") {
                $status = 'PSMC Pending';
            } else if ($result_data['user_registrations'][0]->payment_made == '1' && $result_data['user_registrations'][0]->psmc_approval_date != "0000-00-00 00:00:00" && $result_data['user_registrations'][0]->council_approval_date == "0000-00-00 00:00:00") {
                $status = 'Council Pending';
            } else if ($result_data['user_registrations'][0]->final_approval == '1') {
                $status = 'Approved';
            } else if ($result_data['user_registrations'][0]->final_approval == '2') {
                $status = 'Rejected';
            } else if ($result_data['user_registrations'][0]->final_approval == '0') {
                $status = 'Pending';
            } else {
                $status = 'Pending';
            }

            if ($result_data['user_registrations'][0]->payment_made == 1) {
                $payment_status = 'Complete';
            } else {
                $payment_status = 'Pending';
            }

            $psmc = $council = '';
            if ($result_data['user_registrations'][0]->psmc_approval == '1') {
                $psmc = 'Approved';
            } else if ($result_data['user_registrations'][0]->psmc_approval == '2') {
                $psmc = 'Rejected';
            } else {
                $psmc = 'Pending';
            }

            if ($result_data['user_registrations'][0]->council_approval == '1') {
                $council = 'Approved';
            } else if ($result_data['user_registrations'][0]->council_approval == '2') {
                $council = 'Rejected';
            } else {
                $council = 'Pending';
            }

            $invoice_amount = 0;
            if ($invoice) {
                $invoice_amount = $invoice[0]->amount;
            }
            
            if($paid_amount){      
            	$paid_date = $paid_amount->payment_date;
                $paid_amount = $paid_amount->total;
                
            }else{
            	$paid_amount = 0;
            	$paid_date = "";
            }
            $html .= '<td>' . number_format($invoice_amount, 2) . '</td>'
                    . '<td>' . number_format($paid_amount, 2) . '</td>'
                    . '<td>' . $payment_status . '</td>'
                    . '<td>' . $paid_date . '</td>';
            if($application_type == 3){
                $html .= '<td>'.$result_data['user_registrations'][0]->from_year.'</td>'
                        . '<td>'.$result_data['user_registrations'][0]->to_year.'</td>';
            }
                $html .= '<td>' . $result_data['user_registrations'][0]->submit_date . '</td>'
                    . '<td>' . $status . '</td>'
                    . '<td>' . $psmc . '</td>'
                    . '<td>' . $council . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        return $html;
    }

    /**
     * 
     * created by test
     * date : 05/06/2019
     * normal membership application details
     */
    public function getNormalApplicationDetails($user_tbl_id) {
        $this->CI = & get_instance();
        $this->CI->load->database();
        // collect from 'user_registrations'
        $this->CI->db->select('*,DATE(user_registrations.created_datetime) as submit_date, user_registrations.state AS state,master_places_of_work.place_of_work_name as current_work_place,master_person_title.person_title as salutation');
        $this->CI->db->from('user_registrations');
        $this->CI->db->join('master_person_gender', 'master_person_gender.person_gender_id = user_registrations.user_gender', 'left');
        $this->CI->db->join('master_sl_provinces_tbl', 'master_sl_provinces_tbl.sl_provinces_id = user_registrations.user_province', 'left');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = user_registrations.user_member_class', 'left');
        $this->CI->db->join('master_core_engineering_disciplines', 'master_core_engineering_disciplines.core_engineering_discipline_id = user_registrations.user_member_discipline', 'left');
        $this->CI->db->join('master_places_of_work', 'master_places_of_work.place_of_work_id = user_registrations.place_of_work_id', 'left');
        $this->CI->db->join('master_person_title', 'master_person_title.person_title_id = user_registrations.user_title', 'left');
        $this->CI->db->where('user_registrations.user_tbl_id', $user_tbl_id);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_user_registrations = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_academic_qualifications'
        $this->CI->db->select('*, master_types_of_institutions.type_of_institution_type AS type_of_institution_type, test_recognized_institute.inst_name AS institute_name, member_academic_qualifications.state AS state');
        $this->CI->db->from('member_academic_qualifications');
        $this->CI->db->join('test_recognized_institute', 'test_recognized_institute.institute_id = member_academic_qualifications.institute_name', 'left');
        $this->CI->db->join('master_types_of_institutions', 'master_types_of_institutions.type_of_institution_id = member_academic_qualifications.institute_type', 'left');
        $this->CI->db->where('member_academic_qualifications.user_tbl_id', $user_tbl_id);
        $this->CI->db->where('member_academic_qualifications.primary_qualification', 1);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_member_academic_qualifications = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_proposers'
        $this->CI->db->select('*, member_proposers.state AS state');
        $this->CI->db->from('member_proposers');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = member_proposers.proposer_membership_class', 'left');
        $this->CI->db->where('member_proposers.user_tbl_id', $user_tbl_id);
        $query = $this->CI->db->get();
        $result_member_proposers = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_training_experience'
        $this->CI->db->select('*, master_places_of_work.place_of_work_name AS place_of_work_name, member_training_experience.state AS state');
        $this->CI->db->from('member_training_experience');
        $this->CI->db->join('master_places_of_work', 'master_places_of_work.place_of_work_id = member_training_experience.exp_place_of_work', 'left');
        $this->CI->db->where('member_training_experience.user_tbl_id', $user_tbl_id);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_member_training_experience = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_professional_membership'
        $this->CI->db->select('*, member_professional_membership.state AS state');
        $this->CI->db->from('member_professional_membership');
        $this->CI->db->where('member_professional_membership.user_tbl_id', $user_tbl_id);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_member_professional_membership = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_al_result'
        $this->CI->db->select('*, master_al_subject.master_al_subjects_name AS subject_id_name, master_al_result.master_al_results_name AS result_id_name, master_al_result.master_al_results_code AS result_id_code, member_al_result.state AS state');
        $this->CI->db->from('member_al_result');
        $this->CI->db->join('master_al_result', 'master_al_result.master_al_results_id = member_al_result.result_id', 'left');
        $this->CI->db->join('master_al_subject', 'master_al_subject.master_al_subjects_id = member_al_result.subject_id', 'left');
        $this->CI->db->where('member_al_result.user_tbl_id', $user_tbl_id);
        $query = $this->CI->db->get();
        $result_member_al_result = $query->result();
        $this->CI->db->reset_query();

        // combined result
        $result_array = array(
            'user_registrations' => $result_user_registrations,
            'member_academic_qualifications' => $result_member_academic_qualifications,
            'member_proposers' => $result_member_proposers,
            'member_training_experience' => $result_member_training_experience,
            'member_professional_membership' => $result_member_professional_membership,
            'member_al_result' => $result_member_al_result
        );

        return $result_array;
    }

    /**
     * created by : test
     * date : 06/06/2019
     * get techeng application details
     */
    public function getTechengApplication($user_tbl_id) {
        $this->CI = & get_instance();
        $this->CI->load->database();
        // collect from 'techeng_registrations'
        $this->CI->db->select('*,DATE(techeng_registrations.created_datetime) as submit_date,users_i.name_initials AS admin_i_name, users_i.id AS admin_i_name_id, users_ii.name_initials AS admin_ii_name, users_ii.id AS admin_ii_name_id, users_iii.name_initials AS admin_iii_name, users_iii.id AS admin_iii_name_id, techeng_registrations.state AS state,master_person_title.person_title as salutation');
        $this->CI->db->from('techeng_registrations');
        $this->CI->db->join('master_person_gender', 'master_person_gender.person_gender_id = techeng_registrations.user_gender', 'left');
        $this->CI->db->join('master_sl_provinces_tbl', 'master_sl_provinces_tbl.sl_provinces_id = techeng_registrations.user_province', 'left');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = techeng_registrations.user_member_class', 'left');
        $this->CI->db->join('master_core_engineering_disciplines', 'master_core_engineering_disciplines.core_engineering_discipline_id = techeng_registrations.user_member_discipline', 'left');
        $this->CI->db->join('users AS users_i', 'users_i.id = techeng_registrations.user_i_first_approval_user_id', 'left');
        $this->CI->db->join('users AS users_ii', 'users_ii.id = techeng_registrations.user_i_second_approval_user_id', 'left');
        $this->CI->db->join('users AS users_iii', 'users_iii.id = techeng_registrations.user_ii_approval_user_id', 'left');
        $this->CI->db->join('master_person_title', 'master_person_title.person_title_id = techeng_registrations.user_title', 'left');
        $this->CI->db->where('techeng_registrations.user_tbl_id', $user_tbl_id);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_user_registrations = $query->result();
        $this->CI->db->reset_query();

        // collect from 'techeng_academic_qualifications'
        $this->CI->db->select('*, master_types_of_institutions.type_of_institution_type AS type_of_institution_type, test_recognized_institute.inst_name AS institute_name, techeng_academic_qualifications.state AS state');
        $this->CI->db->from('techeng_academic_qualifications');
        $this->CI->db->join('test_recognized_institute', 'test_recognized_institute.institute_id = techeng_academic_qualifications.institute_name', 'left');
        $this->CI->db->join('master_types_of_institutions', 'master_types_of_institutions.type_of_institution_id = techeng_academic_qualifications.institute_type', 'left');
        $this->CI->db->where('techeng_academic_qualifications.user_tbl_id', $user_tbl_id);
        $this->CI->db->where('techeng_academic_qualifications.primary_qualification', 1);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_member_academic_qualifications = $query->result();
        $this->CI->db->reset_query();

        // collect from 'techeng_proposers'
        $this->CI->db->select('*, techeng_proposers.state AS state');
        $this->CI->db->from('techeng_proposers');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = techeng_proposers.proposer_membership_class', 'left');
        $this->CI->db->where('techeng_proposers.user_tbl_id', $user_tbl_id);
        $query = $this->CI->db->get();
        $result_member_proposers = $query->result();
        $this->CI->db->reset_query();

        // collect from 'techeng_training_experience'
        $this->CI->db->select('*, master_places_of_work.place_of_work_name AS place_of_work_name, techeng_training_experience.state AS state');
        $this->CI->db->from('techeng_training_experience');
        $this->CI->db->join('master_places_of_work', 'master_places_of_work.place_of_work_id = techeng_training_experience.exp_place_of_work', 'left');
        $this->CI->db->where('techeng_training_experience.user_tbl_id', $user_tbl_id);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_member_training_experience = $query->result();
        $this->CI->db->reset_query();

        // collect from 'techeng_professional_membership'
        $this->CI->db->select('*, techeng_professional_membership.state AS state');
        $this->CI->db->from('techeng_professional_membership');
        $this->CI->db->where('techeng_professional_membership.user_tbl_id', $user_tbl_id);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_member_professional_membership = $query->result();
        $this->CI->db->reset_query();

        // collect from 'techeng_al_result'
        $this->CI->db->select('*, master_al_subject.master_al_subjects_name AS subject_id_name, master_al_result.master_al_results_name AS result_id_name, master_al_result.master_al_results_code AS result_id_code, techeng_al_result.state AS state');
        $this->CI->db->from('techeng_al_result');
        $this->CI->db->join('master_al_result', 'master_al_result.master_al_results_id = techeng_al_result.result_id', 'left');
        $this->CI->db->join('master_al_subject', 'master_al_subject.master_al_subjects_id = techeng_al_result.subject_id', 'left');
        $this->CI->db->where('techeng_al_result.user_tbl_id', $user_tbl_id);
        $query = $this->CI->db->get();
        $result_member_al_result = $query->result();
        $this->CI->db->reset_query();

        // collect from 'techeng_registrations_viva'
        $this->CI->db->select('*, techeng_registrations_viva.state AS state');
        $this->CI->db->from('techeng_registrations_viva');
        $this->CI->db->join('techeng_registrations_viva_reviewer', 'techeng_registrations_viva_reviewer.techeng_registrations_viva_id = techeng_registrations_viva.techeng_registrations_viva_id', 'left');
        $this->CI->db->where('techeng_registrations_viva.techeng_registration_id', $user_tbl_id);
        $query = $this->CI->db->get();
        $result_member_viva_result = $query->result();
        $this->CI->db->reset_query();

        // combined result
        $result_array = array(
            'user_registrations' => $result_user_registrations,
            'member_academic_qualifications' => $result_member_academic_qualifications,
            'member_proposers' => $result_member_proposers,
            'member_training_experience' => $result_member_training_experience,
            'member_professional_membership' => $result_member_professional_membership,
            'member_al_result' => $result_member_al_result,
        );

        return $result_array;
    }

    /**
     * 
     * @param type $rein_tbl_id
     * @param type $user_tbl_id
     * @return array
     * get member reinstatement details
     */
    public function getReinstatementApplicationDetail($rein_tbl_id) {
        $this->CI = & get_instance();
        $this->CI->load->database();
        // collect from 'member_reinstatement'
        $this->CI->db->select('*,master_salutation.master_salutation as salutation,DATE(member_reinstatement.created_datetime) as submit_date,member_reinstatement.rein_application_id as reg_application_id,users_i.name_initials AS admin_i_name, users_i.id AS admin_i_name_id, users_ii.name_initials AS admin_ii_name, users_ii.id AS admin_ii_name_id, users_iii.name_initials AS admin_iii_name, users_iii.id AS admin_iii_name_id, member_reinstatement.state AS state');
        $this->CI->db->from('member_reinstatement');
        $this->CI->db->join('master_person_gender', 'master_person_gender.person_gender_id = member_reinstatement.user_gender', 'left');
        $this->CI->db->join('master_sl_provinces_tbl', 'master_sl_provinces_tbl.sl_provinces_id = member_reinstatement.user_province', 'left');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = member_reinstatement.user_member_class', 'left');
        $this->CI->db->join('master_core_engineering_disciplines', 'master_core_engineering_disciplines.core_engineering_discipline_id = member_reinstatement.user_member_discipline', 'left');
        $this->CI->db->join('users AS users_i', 'users_i.id = member_reinstatement.user_i_first_approval_user_id', 'left');
        $this->CI->db->join('users AS users_ii', 'users_ii.id = member_reinstatement.user_i_second_approval_user_id', 'left');
        $this->CI->db->join('users AS users_iii', 'users_iii.id = member_reinstatement.user_ii_approval_user_id', 'left');
        $this->CI->db->join('member_profile_data', 'member_profile_data.user_tbl_id = member_reinstatement.user_tbl_id', 'left');
        $this->CI->db->join('master_salutation', 'master_salutation.master_salutation_id = member_profile_data.user_salutation', 'left');
        $this->CI->db->where('member_reinstatement.rein_tbl_id', $rein_tbl_id);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_user_registrations = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_reinstatement_academic_qualifications'
        $this->CI->db->select('*, master_types_of_institutions.type_of_institution_type AS type_of_institution_type, test_recognized_institute.inst_name AS institute_name_word, member_reinstatement_academic_qualifications.state AS state');
        $this->CI->db->from('member_reinstatement_academic_qualifications');
        $this->CI->db->join('test_recognized_institute', 'test_recognized_institute.institute_id = member_reinstatement_academic_qualifications.institute_name', 'left');
        $this->CI->db->join('master_types_of_institutions', 'master_types_of_institutions.type_of_institution_id = member_reinstatement_academic_qualifications.institute_type', 'left');
        $this->CI->db->where('member_reinstatement_academic_qualifications.user_tbl_id', $rein_tbl_id);
        $this->CI->db->where('member_reinstatement_academic_qualifications.primary_qualification', 1);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_member_academic_qualifications = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_reinstatement_proposers'
        $this->CI->db->select('*, member_reinstatement_proposers.state AS state');
        $this->CI->db->from('member_reinstatement_proposers');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = member_reinstatement_proposers.proposer_membership_class', 'left');
        $this->CI->db->where('member_reinstatement_proposers.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_proposers = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_reinstatement_training_experience'
        $this->CI->db->select('*, master_places_of_work.place_of_work_name AS place_of_work_name, member_reinstatement_training_experience.state AS state');
        $this->CI->db->from('member_reinstatement_training_experience');
        $this->CI->db->join('master_places_of_work', 'master_places_of_work.place_of_work_id = member_reinstatement_training_experience.exp_place_of_work', 'left');
        $this->CI->db->where('member_reinstatement_training_experience.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_training_experience = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_reinstatement_professional_membership'
        $this->CI->db->select('*, member_reinstatement_professional_membership.state AS state');
        $this->CI->db->from('member_reinstatement_professional_membership');
        $this->CI->db->where('member_reinstatement_professional_membership.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_professional_membership = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_reinstatement_al_result'
        $this->CI->db->select('*, master_al_subject.master_al_subjects_name AS subject_id_name, master_al_result.master_al_results_name AS result_id_name, master_al_result.master_al_results_code AS result_id_code, member_reinstatement_al_result.state AS state');
        $this->CI->db->from('member_reinstatement_al_result');
        $this->CI->db->join('master_al_result', 'master_al_result.master_al_results_id = member_reinstatement_al_result.result_id', 'left');
        $this->CI->db->join('master_al_subject', 'master_al_subject.master_al_subjects_id = member_reinstatement_al_result.subject_id', 'left');
        $this->CI->db->where('member_reinstatement_al_result.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_al_result = $query->result();
        $this->CI->db->reset_query();

        // combined result
        $result_array = array(
            'user_registrations' => $result_user_registrations,
            'member_academic_qualifications' => $result_member_academic_qualifications,
            'member_proposers' => $result_member_proposers,
            'member_training_experience' => $result_member_training_experience,
            'member_professional_membership' => $result_member_professional_membership,
            'member_al_result' => $result_member_al_result
        );

//        echo "<pre>";var_dump($result_array);echo "</pre><br><br>";
        return $result_array;
    }
    /**
     * 
     * @param type $rein_tbl_id
     * @param type $user_tbl_id
     * @return array
     * get member transfer details
     */
    public function getTransferApplicationDetail($trans_tbl_id) {
        $this->CI = & get_instance();
        $this->CI->load->database();
       // collect from 'mem_transfer_registrations'
        $this->CI->db->select('*,master_places_of_work.place_of_work_name as current_work_place,member_profile_data.current_designation,master_salutation.master_salutation as salutation,mem_transfer_registrations.trans_application_id as reg_application_id, A.class_of_membership_name AS class_of_membership_name, B.class_of_membership_name AS new_class_of_membership_name, users_i.name_initials AS admin_i_name, users_i.id AS admin_i_name_id, users_ii.name_initials AS admin_ii_name, users_ii.id AS admin_ii_name_id, users_iii.name_initials AS admin_iii_name, users_iii.id AS admin_iii_name_id, mem_transfer_registrations.state AS state,date(mem_transfer_registrations.created_datetime) as submit_date');
        $this->CI->db->from('mem_transfer_registrations');
        $this->CI->db->join('master_person_title', 'master_person_title.person_title_id = mem_transfer_registrations.user_title', 'left');
        $this->CI->db->join('master_person_gender', 'master_person_gender.person_gender_id = mem_transfer_registrations.user_gender', 'left');
        $this->CI->db->join('master_sl_provinces_tbl', 'master_sl_provinces_tbl.sl_provinces_id = mem_transfer_registrations.user_province', 'left');
        $this->CI->db->join('master_classes_of_membership AS A', 'A.class_of_membership_id = mem_transfer_registrations.user_member_class', 'left');
        $this->CI->db->join('master_classes_of_membership AS B', 'B.class_of_membership_id = mem_transfer_registrations.applied_member_class', 'left');
        $this->CI->db->join('master_core_engineering_disciplines', 'master_core_engineering_disciplines.core_engineering_discipline_id = mem_transfer_registrations.user_member_discipline', 'left');
        $this->CI->db->join('users AS users_i', 'users_i.id = mem_transfer_registrations.user_i_first_approval_user_id', 'left');
        $this->CI->db->join('users AS users_ii', 'users_ii.id = mem_transfer_registrations.user_i_second_approval_user_id', 'left');
        $this->CI->db->join('users AS users_iii', 'users_iii.id = mem_transfer_registrations.user_ii_approval_user_id', 'left');
        $this->CI->db->join('member_profile_data', 'member_profile_data.user_tbl_id = mem_transfer_registrations.user_tbl_id', 'left');
        $this->CI->db->join('master_salutation', 'master_salutation.master_salutation_id = member_profile_data.user_salutation', 'left');
        $this->CI->db->join('master_places_of_work', 'master_places_of_work.place_of_work_id = member_profile_data.place_of_work_id', 'left');
        $this->CI->db->where('mem_transfer_registrations.mem_transfer_id', $trans_tbl_id);
        $this->CI->db->where('mem_transfer_registrations.state', 1);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_user_registrations = $query->result();
        $this->CI->db->reset_query();

        // collect from 'mem_transfer_academic_qualifications'
        $this->CI->db->select('*, master_types_of_institutions.type_of_institution_type AS type_of_institution_type, mem_transfer_academic_qualifications.institute_name AS institute_name_word, mem_transfer_academic_qualifications.state AS state');
        $this->CI->db->from('mem_transfer_academic_qualifications');
//        $this->CI->db->join('test_recognized_institute', 'test_recognized_institute.institute_id = mem_transfer_academic_qualifications.institute_name', 'left');
        $this->CI->db->join('master_types_of_institutions', 'master_types_of_institutions.type_of_institution_id = mem_transfer_academic_qualifications.institute_type', 'left');
        $this->CI->db->where('mem_transfer_academic_qualifications.user_tbl_id', $trans_tbl_id);
        $this->CI->db->where('mem_transfer_academic_qualifications.primary_qualification', 1);
        $this->CI->db->where('mem_transfer_academic_qualifications.state', 1);
        $query = $this->CI->db->get();
        $result_member_academic_qualifications = $query->result();
        $this->CI->db->reset_query();
        
        if(!count($result_member_academic_qualifications) > 0){
           $this->CI->db->select('*, master_types_of_institutions.type_of_institution_type AS type_of_institution_type, mem_transfer_academic_qualifications.institute_name AS institute_name_word, mem_transfer_academic_qualifications.state AS state');
            $this->CI->db->from('mem_transfer_academic_qualifications');
    //        $this->CI->db->join('test_recognized_institute', 'test_recognized_institute.institute_id = mem_transfer_academic_qualifications.institute_name', 'left');
            $this->CI->db->join('master_types_of_institutions', 'master_types_of_institutions.type_of_institution_id = mem_transfer_academic_qualifications.institute_type', 'left');
            $this->CI->db->where('mem_transfer_academic_qualifications.user_tbl_id', $trans_tbl_id);
            $this->CI->db->where('mem_transfer_academic_qualifications.state', 1);
            $this->CI->db->limit(1);
            $query = $this->CI->db->get();
            $result_member_academic_qualifications = $query->result();
            $this->CI->db->reset_query(); 
        }
        
        // collect from 'mem_transfer_proposers'
        $this->CI->db->select('*, mem_transfer_proposers.state AS state');
        $this->CI->db->from('mem_transfer_proposers');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = mem_transfer_proposers.proposer_membership_class', 'left');
        $this->CI->db->where('mem_transfer_proposers.user_tbl_id', $trans_tbl_id);
        $this->CI->db->where('mem_transfer_proposers.state', 1);
        $query = $this->CI->db->get();
        $result_member_proposers = $query->result();
        $this->CI->db->reset_query();

        // collect from 'mem_transfer_training_experience'
        $this->CI->db->select('*, master_places_of_work.place_of_work_name AS place_of_work_name, mem_transfer_training_experience.state AS state');
        $this->CI->db->from('mem_transfer_training_experience');
        $this->CI->db->join('master_places_of_work', 'master_places_of_work.place_of_work_id = mem_transfer_training_experience.exp_place_of_work', 'left');
        $this->CI->db->where('mem_transfer_training_experience.user_tbl_id', $trans_tbl_id);
        $this->CI->db->where('mem_transfer_training_experience.state', 1);
        $query = $this->CI->db->get();
        $result_member_training_experience = $query->result();
        $this->CI->db->reset_query();

        // collect from 'mem_transfer_professional_membership'
        $this->CI->db->select('*, mem_transfer_professional_membership.state AS state');
        $this->CI->db->from('mem_transfer_professional_membership');
        $this->CI->db->where('mem_transfer_professional_membership.user_tbl_id', $trans_tbl_id);
        $this->CI->db->where('mem_transfer_professional_membership.state', 1);
        $query = $this->CI->db->get();
        $result_member_professional_membership = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_al_result'
        $this->CI->db->select('*, master_al_subject.master_al_subjects_name AS subject_id_name, master_al_result.master_al_results_name AS result_id_name, master_al_result.master_al_results_code AS result_id_code, mem_transfer_al_result.state AS state');
        $this->CI->db->from('mem_transfer_al_result');
        $this->CI->db->join('master_al_result', 'master_al_result.master_al_results_id = mem_transfer_al_result.result_id', 'left');
        $this->CI->db->join('master_al_subject', 'master_al_subject.master_al_subjects_id = mem_transfer_al_result.subject_id', 'left');
        $this->CI->db->where('mem_transfer_al_result.user_tbl_id', $trans_tbl_id);
        $this->CI->db->where('mem_transfer_al_result.state', 1);
        $query = $this->CI->db->get();
        $result_member_al_result = $query->result();
        $this->CI->db->reset_query();

        // combined result     
        $result_array = array(
            'user_registrations' => $result_user_registrations,
            'member_academic_qualifications' => $result_member_academic_qualifications,
            'member_proposers' => $result_member_proposers,
            'member_training_experience' => $result_member_training_experience,
            'member_professional_membership' => $result_member_professional_membership,
            'member_al_result' => $result_member_al_result
        );

        return $result_array;
    }

    public function getInvoiceforApplication($table_name, $table_pk, $payment_category) {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->db->select('amount');
        $this->CI->db->from('invoices');
        $this->CI->db->where('master_table_name', $table_name);
        $this->CI->db->where('master_table_record_id', $table_pk);
        $this->CI->db->where('main_payment_category_id', $payment_category);
        $query = $this->CI->db->get();
        $result_invoice = $query->result();

        return $result_invoice;
    }

    public function getAdvancePaymentAmount($master_table_name, $master_table_record_id) {

        //Check already register member
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->db->select('*');
        $this->CI->db->from('outstanding_payments');
        $this->CI->db->where('master_table_name', $master_table_name);
        $this->CI->db->where('master_table_record_id', $master_table_record_id);
        //$this->CI->db->where('state', 0);
        $num_results = $this->CI->db->get()->row();
        //print_r($num_results->payment_dashboard_id);
        if ($num_results) {
            $this->CI->db->select('SUM(low_payment_amount) AS total,MAX(`payment_date`) AS payment_date');
            $this->CI->db->from('member_low_payment');
            $this->CI->db->where('payment_dashboard_id', $num_results->payment_dashboard_id);
            $this->CI->db->where('(payment_method_id<9 or payment_method_id=11)');
            $this->CI->db->where('state', 1);
            return $result_array = $this->CI->db->get()->row();
        } else {
            
            return 0;
        }
    }

    public function insertExportDetails($save_data) {
        $data = array(
            'export_by' => $this->CI->session->userdata('user_id'),
            'export_application_name' => $save_data['application_name'],
            'main_table_name' => $save_data['main_table_name'],
            'exported_ids' => $save_data['data_ids']
        );
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->db->insert('application_export_details', $data);
        $insert_id = $this->CI->db->insert_id();

        return $insert_id;
    }
    
    public function getPaymentMethodForTransfer($current_class,$new_class){
        $payment_method = '';
        //Student to AMIE
         if($current_class == 1 && $new_class == 6){
             $payment_method = 31;
         }
        //Student to AffiMIE
        if($current_class == 1 && $new_class == 7){
             $payment_method = 32;
         }
        //AffiMIE to AMIE
        if($current_class == 7 && $new_class == 6){
             $payment_method = 36;
         }
        //AMIE to MIE
        if($current_class == 6 && $new_class == 8){
             $payment_method = 37;
         }
        //MIE to FIE
        if($current_class == 8 && $new_class == 9){
             $payment_method = 38;
         }
        //MIE to HLM
        if($current_class == 8 && $new_class == 11){
             $payment_method = 39;
         }
        //FIE to HLF
         if($current_class == 9 && $new_class == 12){
             $payment_method = 40;
         }
        return $payment_method;
       
    }
    
    public function getRecoverApplication($rein_tbl_id){
        $this->CI = & get_instance();
        $this->CI->load->database();
        // collect from 'member_recover'
        $this->CI->db->select('*,member_recover.rein_application_id as reg_application_id,master_salutation.master_salutation as salutation,DATE(member_recover.created_datetime) as submit_date, users_i.name_initials AS admin_i_name, users_i.id AS admin_i_name_id, users_ii.name_initials AS admin_ii_name, users_ii.id AS admin_ii_name_id, users_iii.name_initials AS admin_iii_name, users_iii.id AS admin_iii_name_id, member_recover.state AS state');
        $this->CI->db->from('member_recover');
        $this->CI->db->join('master_person_gender', 'master_person_gender.person_gender_id = member_recover.user_gender', 'left');
        $this->CI->db->join('master_sl_provinces_tbl', 'master_sl_provinces_tbl.sl_provinces_id = member_recover.user_province', 'left');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = member_recover.user_member_class', 'left');
        $this->CI->db->join('master_core_engineering_disciplines', 'master_core_engineering_disciplines.core_engineering_discipline_id = member_recover.user_member_discipline', 'left');
        $this->CI->db->join('users AS users_i', 'users_i.id = member_recover.user_i_first_approval_user_id', 'left');
        $this->CI->db->join('users AS users_ii', 'users_ii.id = member_recover.user_i_second_approval_user_id', 'left');
        $this->CI->db->join('users AS users_iii', 'users_iii.id = member_recover.user_ii_approval_user_id', 'left');
        $this->CI->db->join('member_profile_data', 'member_profile_data.user_tbl_id = member_recover.user_tbl_id', 'left');
        $this->CI->db->join('master_salutation', 'master_salutation.master_salutation_id = member_profile_data.user_salutation', 'left');
        $this->CI->db->where('member_recover.rein_tbl_id', $rein_tbl_id);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();
        $result_user_registrations = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_recover_academic_qualifications'
        $this->CI->db->select('*, master_types_of_institutions.type_of_institution_type AS type_of_institution_type, test_recognized_institute.inst_name AS institute_name_word, member_recover_academic_qualifications.state AS state');
        $this->CI->db->from('member_recover_academic_qualifications');
        $this->CI->db->join('test_recognized_institute', 'test_recognized_institute.institute_id = member_recover_academic_qualifications.institute_name', 'left');
        $this->CI->db->join('master_types_of_institutions', 'master_types_of_institutions.type_of_institution_id = member_recover_academic_qualifications.institute_type', 'left');
        $this->CI->db->where('member_recover_academic_qualifications.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_academic_qualifications = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_recover_proposers'
        $this->CI->db->select('*, member_recover_proposers.state AS state');
        $this->CI->db->from('member_recover_proposers');
        $this->CI->db->join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = member_recover_proposers.proposer_membership_class', 'left');
        $this->CI->db->where('member_recover_proposers.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_proposers = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_recover_training_experience'
        $this->CI->db->select('*, master_places_of_work.place_of_work_name AS place_of_work_name, member_recover_training_experience.state AS state');
        $this->CI->db->from('member_recover_training_experience');
        $this->CI->db->join('master_places_of_work', 'master_places_of_work.place_of_work_id = member_recover_training_experience.exp_place_of_work', 'left');
        $this->CI->db->where('member_recover_training_experience.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_training_experience = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_recover_professional_membership'
        $this->CI->db->select('*, member_recover_professional_membership.state AS state');
        $this->CI->db->from('member_recover_professional_membership');
        $this->CI->db->where('member_recover_professional_membership.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_professional_membership = $query->result();
        $this->CI->db->reset_query();

        // collect from 'member_recover_al_result'
        $this->CI->db->select('*, master_al_subject.master_al_subjects_name AS subject_id_name, master_al_result.master_al_results_name AS result_id_name, master_al_result.master_al_results_code AS result_id_code, member_recover_al_result.state AS state');
        $this->CI->db->from('member_recover_al_result');
        $this->CI->db->join('master_al_result', 'master_al_result.master_al_results_id = member_recover_al_result.result_id', 'left');
        $this->CI->db->join('master_al_subject', 'master_al_subject.master_al_subjects_id = member_recover_al_result.subject_id', 'left');
        $this->CI->db->where('member_recover_al_result.user_tbl_id', $rein_tbl_id);
        $query = $this->CI->db->get();
        $result_member_al_result = $query->result();
        $this->CI->db->reset_query();

        // combined result
        $result_array = array(
            'user_registrations' => $result_user_registrations,
            'member_academic_qualifications' => $result_member_academic_qualifications,
            'member_proposers' => $result_member_proposers,
            'member_training_experience' => $result_member_training_experience,
            'member_professional_membership' => $result_member_professional_membership,
            'member_al_result' => $result_member_al_result
        );

//        echo "<pre>";var_dump($result_array);echo "</pre><br><br>";
        return $result_array;
    }

}

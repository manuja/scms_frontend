<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config_variables
 *
 * @author testMJ <test@test=lk>
 */
class config_variables {

    //put your code here
    private $data = array(
        // member division
        'userIFirstActionTaken' => FALSE,
        'userISecondActionTaken' => FALSE,
        'userIIActionTaken' => FALSE,
        'operationalUserLevel' => 20,
        'managerialUserLevel' => 21,
        'topManagementUserLevel' => 22,
        'pub_dev_parent_id' => 35,
        'pub_dev_user_1_group_id' => 36,
        'pub_dev_user_2_group_id' => 37,
        'pub_dev_user_3_group_id' => 38,
        'fin_dev_user_1_group_id' => 29,
        'fin_dev_user_2_group_id' => 33,
        'fin_dev_user_3_group_id' => 34,
        'ceo_user1_group_id' => 40,
        'ceo_user2_group_id' => 41,
        'ceo_user3_group_id' => 42,
        'sub_fire_date' => '-10-31',
        'sub_discount_date' => '-01-31',
        'sub_pay_start_from_dec' => '-12-01',
        'sub_pay_end_to_dec' => '-12-31',
        'sub_pay_from_update' => '-01-01',
        'sub_pay_to_update' => '-10-31',
        'sub_pay_from_inactive' => '-12-01',
        'sub_pay_to_inactive' => '-12-31',
        'sub_pay_warning_notify_from' => '-11-01',
        'sub_pay_warning_notify_to' => '-11-31',
        'default_age' => 60,
        'default_membership_years_for_HLM_HLF' => 40,
        'default_membership_years' => 30,
        'new_user_register_from' => '-07-01',
        'new_user_register_to' => '-12-31',
        'beneval_fund' => '1000',
        'ceo_user_3_group' => 42,
        'it_division_user_1_group' => 83,
        'edu_dev_parent_id' => 23,
        'edu_user_1_group' => 30,
        'edu_user_2_group' => 31,
        'edu_user_3_group' => 32,
        'fin_dev_parent_id' => 28,
        'subs_defined_time_gap' =>'-03-31',
        'client_id' =>'14000043',
       // 'client_id' =>'14003167',
        'web_base_url' => 'https://test.lk/',
         'bocipgenabled' =>'1',
        'bocipglive' =>'1'
    );

    public function getVariable($varName)
    {
        return $this->data[$varName];
    }

}

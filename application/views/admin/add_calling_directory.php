<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-users text-blue"></i>
            <h3 class="box-title">Calling for Directory Application</h3>
        </div>
        <?php
//        echo '<pre>';
//        print_r($directory_data->reg_open_date);
//        exit;
        if (!empty($disable_stat)) {
            if ($disable_stat == 1) {
                $disable = 'disabled';
            } else {
                $disable = '';
            }
        } else {
            $disable = '';
        }
        ?>
        <div class="box-body">
            <div class="row">
                <div id="messages_div"></div>
                <form name="calling_directory" id="calling_directory" data-toggle ="validator">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="subcat_hidden_id" id="subcat_hidden_id" value="<?php echo isset($directory_data->sub_paymet_category) ? $directory_data->sub_paymet_category : ''; ?>">
                                <input type="hidden" name="directory_id" id="directory_id" value="<?php echo isset($directory_data->directory_id) ? $directory_data->directory_id : ''; ?>">
                                <input type="hidden" name="disable_stat" id="disable_stat" value="<?php echo isset($disable_stat) ? $disable_stat : ''; ?>">
                                <input type="hidden" name="date_status" id="date_status" value="<?php echo $date_status;?>">

                                <div class="form-group">
                                    <label class="control-label" for="directory_type">Directory Type</label> 

                                    <?php
                                    echo form_dropdown('directory_type', $directory_type, isset($directory_data->directory_type) ? $directory_data->directory_type : '', 'id="directory_type" class="form-control text-left" required ' . $disable);
                                    ?>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="directory_title" class="control-label">Directory Title</label> 
                                    <input id="directory_title" name="directory_title" value="<?php echo isset($directory_data->directory_title) ? $directory_data->directory_title : ''; ?>" type="text" required="required" class="form-control" <?php echo $disable; ?> <?php echo $disable_date_sts;?> <?php echo $disable_published_date_sts;?>>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="reg_open_date">Registration Opening Date</label> 
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div> 
                                        <input id="reg_open_date" name="reg_open_date" type="text" value="<?php echo isset($directory_data->reg_open_date) ? $directory_data->reg_open_date : ''; ?>" required="required" autocomplete="off" class="form-control direct_date_picker" <?php echo $disable; ?> <?php echo $disable_date_sts;?> <?php echo $disable_published_date_sts;?>>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="reg_closing_date" class="control-label">Registration Closing Date</label> 
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div> 
                                        <input id="reg_closing_date" name="reg_closing_date" type="text" value="<?php echo isset($directory_data->reg_closing_date) ? $directory_data->reg_closing_date : ''; ?>" required="required" autocomplete="off" class="form-control direct_date_picker" <?php echo $disable; ?> <?php echo $disable_date_sts;?>>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>
              
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6"> 
                                <h3> <span class="label label-default">New Registrations</span></h3>
                                <div id="app_fee" class="app_fee">
                                    <div class="form-group">
                                        <label for="new_application_fee" class="control-label">Application Fee</label> 
                                        <input id="new_application_fee" name="new_application_fee" value="<?php echo isset($directory_data->new_application_fee) ? $directory_data->new_application_fee : ''; ?>" type="number" step="0.01" min="0" class="form-control req_field_app" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>



                                <div id="building_div" class="building_div hidden">
                                    <div class="form-group">
                                        <label for="new_no_of_categories" class="control-label">Number of Categories</label> 
                                        <input id="new_no_of_categories" name="new_no_of_categories" value="<?php echo isset($directory_data->new_no_of_categories) ? $directory_data->new_no_of_categories : ''; ?>" type="number" min="0" class="form-control req_field" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_default_amount" class="control-label">Default Amount</label> 
                                        <input id="new_default_amount" name="new_default_amount" value="<?php echo isset($directory_data->new_default_amount) ? $directory_data->new_default_amount : ''; ?>" type="number" step="0.01" min="0" class="form-control req_field" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_amount_for_extra_category" class="control-label">Amount for Extra Category</label> 
                                        <input id="new_amount_for_extra_category" name="new_amount_for_extra_category" value="<?php echo isset($directory_data->new_amount_for_extra_category) ? $directory_data->new_amount_for_extra_category : ''; ?>" type="number" step="0.01" min="0" class="form-control req_field" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="new_publication_fee" class="control-label">Publication Fee</label> 
                                    <input id="new_publication_fee" name="new_publication_fee" type="number" value="<?php echo isset($directory_data->new_publication_fee) ? $directory_data->new_publication_fee : ''; ?>" step="0.01" min="0" required="required" class="form-control" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3> <span class="label label-default">Continuous Registrations</span></h3>
                                <!-- <div id="app_fee" class="app_fee">
                                    <div class="form-group">
                                        <label for="con_application_fee" class="control-label">Application Fee</label> 
                                        <input id="con_application_fee" name="con_application_fee" value="<?php echo isset($directory_data->con_application_fee) ? $directory_data->con_application_fee : ''; ?>" type="number" step="0.01" min="0" class="form-control req_field_app" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div> -->

                                <!-- <div id="building_div" class="building_div hidden">
                                    <div class="form-group">
                                        <label for="con_no_of_categories" class="control-label">Number of Categories</label> 
                                        <input id="con_no_of_categories" name="con_no_of_categories" value="<?php echo isset($directory_data->con_no_of_categories) ? $directory_data->con_no_of_categories : ''; ?>" type="number" min="0" class="form-control req_field" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <label for="con_default_amount" class="control-label">Default Amount</label> 
                                        <input id="con_default_amount" name="con_default_amount" type="number" step="0.01" min="0" value="<?php //echo isset($directory_data->con_default_amount) ? $directory_data->con_default_amount : ''; ?>" class="form-control req_field" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <label for="con_amount_for_extra_category" class="control-label">Amount for Extra Category</label> 
                                        <input id="con_amount_for_extra_category" name="con_amount_for_extra_category" type="number" step="0.01" min="0" value="<?php echo isset($directory_data->con_amount_for_extra_category) ? $directory_data->con_amount_for_extra_category : ''; ?>" class="form-control req_field" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div> 
                                </div>  -->
                                <div class="form-group">
                                    <label for="con_publication_fee" class="control-label">Publication Fee</label> 
                                    <!-- <input id="con_publication_fee" name="con_publication_fee" value="<?php //echo isset($directory_data->con_publication_fee) ? $directory_data->con_publication_fee : ''; ?>" type="text" required="required" class="form-control" <?php // echo $disable; ?>> -->
                                    <input id="con_publication_fee" name="con_publication_fee" value="<?php echo isset($directory_data->con_publication_fee) ? $directory_data->con_publication_fee : ''; ?>" type="number" step="0.01" min="0" required="required" class="form-control" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group" style="height:41px;">
                                    <!-- empty div space -->
                                </div>
                                <?php
                                // if (!empty($disable_stat) && $disable_stat == 1) {
                                    
                                // } else {
                                //     if($disable_date_sts != "readonly"){

                                    ?>
                                    <!-- <div class="form-group">
                                        <button name="calling_directory_save" id="calling_directory_save" type="submit" class="btn btn-success">Submit</button>
                                    </div> -->
                                <?php 
                                //     }else{

                                //     }
                                // }
                             ?>
                            </div>
                        </div>

                    </div>
                    
                   
                  <div id="adjudicator_arbitrator_div" class="col-md-12 adjudicator_arbitrator_div hidden">
                    <hr/>
                    <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="box-title">Adjudicator & Arbitrator Both</h4>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="adj_arbi_directory_title" class="control-label">Directory Title</label> 
                                <input id="adj_arbi_directory_title" name="adj_arbi_directory_title" value="<?php echo isset($both_dir_data->directory_title) ? $both_dir_data->directory_title : ''; ?>" type="text" class="form-control req_field_both" <?php echo $disable; ?> <?php echo $disable_date_sts;?>>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>          
                        <div class="row">
                            <div class="col-md-6"> 
                                <h3> <span class="label label-default">New Registrations</span></h3>
                                <div id="app_fee" class="app_fee">
                                    <div class="form-group">
                                        <label for="adj_arbi_new_application_fee" class="control-label">Application Fee</label> 
                                        <input id="adj_arbi_new_application_fee" name="adj_arbi_new_application_fee" value="<?php echo isset($both_dir_data->new_application_fee) ? $both_dir_data->new_application_fee : ''; ?>" type="number" step="0.01" min="0" class="form-control req_field_both" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="adj_arbi_new_publication_fee" class="control-label">Publication Fee</label> 
                                    <input id="adj_arbi_new_publication_fee" name="adj_arbi_new_publication_fee" type="number" value="<?php echo isset($both_dir_data->new_publication_fee) ? $both_dir_data->new_publication_fee : ''; ?>" step="0.01" min="0" class="form-control req_field_both" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3> <span class="label label-default">Continuous Registrations</span></h3>
                                <!-- <div id="app_fee" class="app_fee">
                                    <div class="form-group">
                                        <label for="con_application_fee" class="control-label">Application Fee</label> 
                                        <input id="con_application_fee" name="con_application_fee" value="<?php //echo isset($both_dir_data->con_application_fee) ? $both_dir_data->con_application_fee : ''; ?>" type="number" step="0.01" min="0" class="form-control req_field_app" <?php //echo $disable; ?><?php //echo $disable_pay_sts;?>>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="adj_arbi_con_publication_fee" class="control-label">Publication Fee</label> 
                                    <!-- <input id="con_publication_fee" name="con_publication_fee" value="<?php //echo isset($directory_data->con_publication_fee) ? $directory_data->con_publication_fee : ''; ?>" type="text" required="required" class="form-control" <?php // echo $disable; ?>> -->
                                    <input id="adj_arbi_con_publication_fee" name="adj_arbi_con_publication_fee" value="<?php echo isset($both_dir_data->con_publication_fee) ? $both_dir_data->con_publication_fee : ''; ?>" type="number" step="0.01" min="0" class="form-control req_field_both" <?php echo $disable; ?><?php echo $disable_pay_sts;?>>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group" style="height:41px;">
                                    <!-- empty div space -->
                                </div>
                             
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10">
                        </div>
                        <div class="col-md-2">
                            <?php
                                if (!empty($disable_stat) && $disable_stat == 1) {
                                            
                                } else {
                                    if($disable_date_sts != "readonly"){
                            ?>
                                        <div class="form-group">
                                            <button name="calling_directory_save" id="calling_directory_save" type="submit" class="btn btn-success">Submit</button>
                                        </div>
                            <?php 
                                    }else{

                                    }
                                }
                            ?> 
                        </div>    
                    </div>          
                
                </form>

            </div>
            <?php

            if (!empty($disable_stat) && $disable_stat == 1) { ?>
                <?php
                if (!empty($directory_data->finance_approve_stat) && $directory_data->finance_approve_stat == 1) {
                    $dis_app = 'disabled';
                } else {
                    $dis_app = '';
                }
                
                ?>
                <div class="panel panel-default">

                    <div class="panel-body">
                        <form id="adjudicator_payment_form" name="adjudicator_payment_form"> 
                            
                           <input id="con_amount_for_extra_category" name="con_amount_for_extra_category" type="hidden" value="<?php echo isset($directory_data->con_amount_for_extra_category) ? $directory_data->con_amount_for_extra_category : ''; ?>" class="form-control req_field" > 
                            <input id="new_amount_for_extra_category" name="new_amount_for_extra_category" value="<?php echo isset($directory_data->new_amount_for_extra_category) ? $directory_data->new_amount_for_extra_category : ''; ?>" type="hidden" step="0.01" class="form-control req_field" >
                            
                            <div class="row">
                                <!--payment for applications******************************-->
                                <div class="col-md-6"> 

                                    <h3> <span class="label label-default"><?php echo $main_pay->main_payment_category ?> - (<?php echo $main_pay->main_payment_category_code ?>)</span></h3>
                                    <input type="hidden" name="directory_id_approve" id="directory_id_approve" value="<?php echo isset($directory_data->directory_id) ? $directory_data->directory_id : ''; ?>">
                                    <input type="hidden" id="payment_cat_applications" name="payment_cat_applications" value="<?php echo $main_pay->main_payment_category_id; ?>">





                                </div>
                                <div class="col-md-12">

                                    <div id="app_fee_view" class="app_fee_view">

                                        <div class="row">
                                            <div class="col-sm-12">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4"><p>New Registration</p></div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="payment_div">
                                                            <!-- <div class="col-md-2"><p>New Registrations</p></div>    -->
                                                            <div class="col-md-5">
                                                                <input id="finace_new_application" name="finace_new_application" value="<?php echo isset($directory_data->directory_title) ? $directory_data->directory_title . " - New Application" : ''; ?>" type="text" class="form-control" readonly="">
                                                            </div>   
                                                            <div class="col-md-2"><input id="finace_sub_cat_amount_new" name="finace_sub_cat_amount_new_application" value="<?php echo isset($directory_data->new_application_fee) ? $directory_data->new_application_fee : ''; ?>" type="number" step="0.01"  class="form-control req_field_app" readonly=""></div>   
                                                            <div class="col-md-1"><div class="checkbox">
                                                                    <label for=""><input  type="checkbox" value="1" <?php echo $dis_app; ?> name="is_tax_enable_new_reg" <?php
                                                                        if ($directory_data->tax_enable_new_reg == 1) {
                                                                            echo 'checked="checked"';
                                                                        } else {
                                                                            
                                                                        }
                                                                        ?>  class="checkclass" id="is_tax_enable_new_reg"> Enable Tax</label>
                                                                </div></div>   
                                                            <div class="col-md-4"><div <?php
                                                                if ($directory_data->tax_enable_new_reg == 1) {
                                                                    
                                                                } else {
                                                                    echo "style='display:none;'";
                                                                }
                                                                ?> id="loadmembervat_new_reg">

                                                                    <!--<div class="row">-->
                                                                    <div class="col-sm-6">
                                                                        <?php
                                                                        foreach ($Taxres as $key => $tax)
                                                                        {
//                                                                            print_r($tax);
                                                                            ?>


                                                                            <div class="form-group">
                                                                                <div class="checkbox">
                                                                                    <label for="">

                                                                                        <input type="checkbox" value="<?php echo $tax->taxid; ?>" <?php
                                                                                        // if ($tax->taxid == 1) {
                                                                                        //     if (!empty($directory_data->new_reg_vat) && $directory_data->new_reg_vat > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // } else {
                                                                                        //     if (!empty($directory_data->new_reg_nbt) && $directory_data->new_reg_nbt > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // }
                                                                                        if ($tax->taxid == 1) {
                                                                                            if (!empty($directory_data->new_reg_nbt) && $directory_data->new_reg_nbt > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        } else {
                                                                                            if (!empty($directory_data->new_reg_vat) && $directory_data->new_reg_vat > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        }
                                                                                        ?> name="tax_type_id_new_reg[]" <?php echo $dis_app; ?>  class="checkclassmem new_app_check new_app_check<?php echo $key + 1; ?>" id="mem_tax_type_id<?php echo $key + 1; ?>"> <?php echo $tax->taxtype; ?> ( <?php echo $tax->rate_value; ?>% ) 

                                                                                    </label>
                                                                                </div><input  type="hidden" placeholder="Percentage (%)" value="<?php echo $tax->rate_value; ?>"  id="mem_tax_prsentage<?php echo $key + 1; ?>" name="mem_tax_prsentage_new_reg[]" class="form-control "> 
                                                                                <input  type="hidden"  value="<?php echo $tax->taxtype; ?>"  id="mem_tax_type<?php echo $key + 1; ?>" name="tax_type_new_reg[]" class="form-control ">
                                                                            </div>


                                                                        <?php }
                                                                        ?>
                                                                    </div>
                                                                    <input type="hidden" id="memnbtwithprice" value="" name="memnbtwithprice">

                                                                    <!--</div>-->


                                                                </div>
                                                            </div>   

                                                        </div>                                                    


                                                    </div>
                                                    <!-- <div class="row">
                                                        <div class="col-md-4"><p>Continuous Registration</p></div>
                                                    </div> -->
                                                    <!-- <div class="row">
                                                        <div class="payment_div">
                                                            
                                                            <div class="col-md-5">
                                                                <input id="finace_continuous_registration" name="finace_continuous_registration" value="<?php echo isset($directory_data->directory_title) ? $directory_data->directory_title . " - Continuous Application" : ''; ?>" type="text" class="form-control" readonly="">
                                                            </div>   
                                                            <div class="col-md-2"><input id="finace_sub_cat_amount_continuous_registration" name="finace_sub_cat_amount_continuous_registration" value="<?php echo isset($directory_data->con_application_fee) ? $directory_data->con_application_fee : ''; ?>" type="text" required="required" class="form-control" readonly=""></div>   
                                                            <div class="col-md-1"><div class="checkbox">
                                                                    <label for=""><input  type="checkbox" value="1" <?php echo $dis_app; ?> name="is_tax_enable_cont_reg" <?php
                                                                        if ($directory_data->tax_enable_cont_reg == 1) {
                                                                            echo 'checked="checked"';
                                                                        } else {
                                                                            
                                                                        }
                                                                        ?>  class="checkclass" id="is_tax_enable_cont_reg"> Enable Tax</label>
                                                                </div></div>   
                                                            <div class="col-md-4">
                                                                <div <?php
                                                                if ($directory_data->tax_enable_cont_reg == 1) {
                                                                    
                                                                } else {
                                                                    echo "style='display:none;'";
                                                                }
                                                                ?> id="loadmembervat_cont_reg">

                                                         
                                                                    <div class="col-sm-6">
                                                                        <?php
                                                                        foreach ($Taxres as $key => $tax)
                                                                        {
                                                                            ?>


                                                                            <div class="form-group">
                                                                                <div class="checkbox">
                                                                                    <label for="">
                                                                                        <input type="checkbox" value="<?php echo $tax->taxid; ?>" <?php
                                                                                       
                                                                                        if ($tax->taxid == 1) {
                                                                                            if (!empty($directory_data->cont_reg_nbt) && $directory_data->cont_reg_nbt > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        } else {
                                                                                            if (!empty($directory_data->cont_reg_vat) && $directory_data->cont_reg_vat > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        }
                                                                                        ?> name="tax_type_id_cont_reg[]" <?php echo $dis_app; ?> class="checkclassmem cont_reg_check cont_reg_check<?php echo $key + 1; ?>" id="mem_tax_type_id<?php echo $key + 1; ?>"> <?php echo $tax->taxtype; ?> ( <?php echo $tax->rate_value; ?>% ) 

                                                                                    </label>
                                                                                </div><input  type="hidden" placeholder="Percentage (%)" value="<?php echo $tax->rate_value; ?>"  id="mem_tax_prsentage<?php echo $key + 1; ?>" name="mem_tax_prsentage_cont_reg[]" class="form-control "> 
                                                                                <input  type="hidden"  value="<?php echo $tax->taxtype; ?>"  id="mem_tax_type<?php echo $key + 1; ?>" name="tax_type_cont_reg[]" class="form-control ">
                                                                            </div>


                                                                        <?php }
                                                                        ?>
                                                                    </div>
                                                                    <input type="hidden" id="memnbtwithprice" value="" name="memnbtwithprice">

                                                               


                                                                </div>
                                                            </div>   

                                                        </div>                                                    


                                                    </div>   -->
                                                </div>



                                            </div>
                                        </div>

                                    </div>



                                </div>    
                            </div>
                            <div class="row">
                                <!--// Continous application ++++++++++++++++++++++++++-->
                                <div class="col-md-6"> 
                                    <h3> <span class="label label-default"><?php echo $main_pay_cont->main_payment_category ?> - (<?php echo $main_pay_cont->main_payment_category_code ?>)</span></h3>
                                    <input type="hidden" id="payment_cat_id" name="payment_cat_publications" value="<?php echo $main_pay_cont->main_payment_category_id; ?>">

                                </div>
                                
                            
                                <div class="col-md-12">
                                       
                                    <div id="app_fee_view" class="app_fee_view">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4"><p>New Publication</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="payment_div">
                                                            <!-- <div class="col-md-2"><p>New Publication Fee</p></div>    -->
                                                            <div class="col-md-5">
                                                                <input id="finace_new_publications" name="finace_new_publications" value="<?php echo isset($directory_data->directory_title) ? $directory_data->directory_title . "- New Publication" : ''; ?>" type="text" class="form-control" readonly="">
                                                            </div>   
                                                            <div class="col-md-2"><input id="finace_sub_cat_amount_new_publications" name="finace_sub_cat_amount_new_publications" value="<?php echo isset($directory_data->new_publication_fee) ? $directory_data->new_publication_fee : ''; ?>" type="number" step="0.01"  class="form-control req_field_app" readonly=""></div>   
                                                            <div class="col-md-1"><div class="checkbox">
                                                                    <label for=""><input  type="checkbox" value="1" <?php echo $dis_app; ?> name="is_tax_enable_new_pub" <?php
                                                                        if ($directory_data->tax_enable_new_pub == 1) {
                                                                            echo 'checked="checked"';
                                                                        } else {
                                                                            
                                                                        }
                                                                        ?>  class="checkclass" id="is_tax_enable_new_pub"> Enable Tax</label>
                                                                </div></div>   
                                                            <div class="col-md-4"><div <?php
                                                                if ($directory_data->tax_enable_new_pub == 1) {
                                                                    
                                                                } else {
                                                                    echo "style='display:none;'";
                                                                }
                                                                ?> id="loadmembervat_new_pub">

                                                                    <!--<div class="row">-->
                                                                    <div class="col-sm-6">
                                                                        <?php
                                                                        foreach ($Taxres as $key => $tax)
                                                                        {
                                                                            ?>


                                                                            <div class="form-group">
                                                                                <div class="checkbox">
                                                                                    <label for="">

                                                                                        <input type="checkbox" value="<?php echo $tax->taxid; ?>" <?php
                                                                                        // if ($tax->taxid == 1) {
                                                                                        //     if (!empty($directory_data->new_pub_vat) && $directory_data->new_pub_vat > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // } else {
                                                                                        //     if (!empty($directory_data->new_pub_nbt) && $directory_data->new_pub_nbt > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // }
                                                                                        if ($tax->taxid == 1) {
                                                                                            if (!empty($directory_data->new_pub_nbt) && $directory_data->new_pub_nbt > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        } else {
                                                                                            if (!empty($directory_data->new_pub_vat) && $directory_data->new_pub_vat > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        }
                                                                                        ?> name="tax_type_id_new_pub[]"  class="checkclassmem ne_pub_check ne_pub_check<?php echo $key + 1; ?>" <?php echo $dis_app; ?> id="mem_tax_type_id<?php echo $key + 1; ?>"> <?php echo $tax->taxtype; ?> ( <?php echo $tax->rate_value; ?>% ) 

                                                                                    </label>
                                                                                </div><input  type="hidden" placeholder="Percentage (%)" value="<?php echo $tax->rate_value; ?>"  id="mem_tax_prsentage<?php echo $key + 1; ?>" name="mem_tax_prsentage_new_pub[]" class="form-control "> 
                                                                                <input  type="hidden"  value="<?php echo $tax->taxtype; ?>"  id="mem_tax_type<?php echo $key + 1; ?>" name="tax_type_new_pub[]" class="form-control ">
                                                                            </div>


                                                                        <?php }
                                                                        ?>
                                                                    </div>
                                                                    <input type="hidden" id="memnbtwithprice" value="" name="memnbtwithprice">

                                                                    <!--</div>-->


                                                                </div>
                                                            </div>   

                                                        </div>                                                    


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Continuous Publication</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="payment_div">
                                                            <!-- <div class="col-md-2"><p>Continuous Publication Fee</p></div>    -->
                                                            <div class="col-md-5">
                                                                <input id="finace_countinous_publication" name="finace_countinous_publication" value="<?php echo isset($directory_data->directory_title) ? $directory_data->directory_title . "- Continuous Publication" : ''; ?>" type="text" class="form-control" readonly="">
                                                            </div>   
                                                            <div class="col-md-2"><input id="finace_sub_cat_amount_countinous_publication" name="finace_sub_cat_amount_countinous_publication" value="<?php echo isset($directory_data->con_publication_fee) ? $directory_data->con_publication_fee : ''; ?>" type="text" required="required" class="form-control" readonly=""></div>   
                                                            <div class="col-md-1"><div class="checkbox">
                                                                    <label for=""><input  type="checkbox" value="1" <?php echo $dis_app; ?> name="is_tax_enable_cont_pub" <?php
                                                                        if ($directory_data->tax_enable_cont_pub == 1) {
                                                                            echo 'checked="checked"';
                                                                        } else {
                                                                            
                                                                        }
                                                                        ?>  class="checkclass" id="is_tax_enable_cont_pub"> Enable Tax</label>
                                                                </div></div>   
                                                            <div class="col-md-4"><div <?php
                                                                if ($directory_data->tax_enable_cont_pub == 1) {
                                                                    
                                                                } else {
                                                                    echo "style='display:none;'";
                                                                }
                                                                ?> id="loadmembervat_cont_pub">

                                                                    <!--<div class="row">-->
                                                                    <div class="col-sm-6">
                                                                        <?php
                                                                        foreach ($Taxres as $key => $tax)
                                                                        {
                                                                            ?>


                                                                            <div class="form-group">
                                                                                <div class="checkbox">
                                                                                    <label for=""><input type="checkbox" value="<?php echo $tax->taxid; ?>" <?php
                                                                                        // if ($tax->taxid == 1) {
                                                                                        //     if (!empty($directory_data->cont_pub_vat) && $directory_data->cont_pub_vat > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // } else {
                                                                                        //     if (!empty($directory_data->cont_pub_nbt) && $directory_data->cont_pub_nbt > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // }
                                                                                        if ($tax->taxid == 1) {
                                                                                            if (!empty($directory_data->cont_pub_nbt) && $directory_data->cont_pub_nbt > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        } else {
                                                                                            if (!empty($directory_data->cont_pub_vat) && $directory_data->cont_pub_vat > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        }
                                                                                        ?> name="tax_type_id_cont_pub[]"  class="checkclassmem cont_pub_check cont_pub_check<?php echo $key + 1; ?>" <?php echo $dis_app; ?> id="mem_tax_type_id<?php echo $key + 1; ?>"> <?php echo $tax->taxtype; ?> ( <?php echo $tax->rate_value; ?>% ) </label>
                                                                                </div><input  type="hidden" placeholder="Percentage (%)" value="<?php echo $tax->rate_value; ?>"  id="mem_tax_prsentage<?php echo $key + 1; ?>" name="mem_tax_prsentage_cont_pub[]" class="form-control "> 
                                                                                <input  type="hidden"  value="<?php echo $tax->taxtype; ?>"  id="mem_tax_type<?php echo $key + 1; ?>" name="tax_type_cont_pub[]" class="form-control "></div><?php } ?></div>
                                                                    <input type="hidden" id="memnbtwithprice" value="" name="memnbtwithprice">

                                                                    <!--</div>-->


                                                                </div>
                                                            </div>   

                                                        </div>                                                    


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                </div>    
                            </div>
                        <!-- Test -->
                        <!-- start both adjudicator & arbitrator -->
                        <div class="adjudicator_arbitrator_div hidden">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="box-title">Adjudicator & Arbitrator Both</h4>
                                </div>
                            </div>
                            <div class="row ">
                                <!--payment for applications******************************-->
                                <div class="col-md-6"> 

                                    <h3> <span class="label label-default"><?php echo $main_pay->main_payment_category ?> - (<?php echo $main_pay->main_payment_category_code ?>)</span></h3>
                                    <!-- <input type="hidden" name="directory_id_approve" id="directory_id_approve" value="<?php //echo isset($directory_data->directory_id) ? $directory_data->directory_id : ''; ?>">
                                    <input type="hidden" id="payment_cat_applications" name="payment_cat_applications" value="<?php //echo $main_pay->main_payment_category_id; ?>"> -->

                                </div>
                                <div class="col-md-12">

                                    <div id="app_fee_view" class="app_fee_view">

                                        <div class="row">
                                            <div class="col-sm-12">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4"><p>New Registration</p></div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="payment_div">
                                                            <!-- <div class="col-md-2"><p>New Registrations</p></div>    -->
                                                            <div class="col-md-5">
                                                                <input id="adj_arbi_finace_new_application" name="adj_arbi_finace_new_application" value="<?php echo isset($both_dir_data->directory_title) ? $both_dir_data->directory_title . " - New Application" : ''; ?>" type="text" class="form-control" readonly="">
                                                            </div>   
                                                            <div class="col-md-2"><input id="adj_arbi_finace_sub_cat_amount_new" name="adj_arbi_finace_sub_cat_amount_new_application" value="<?php echo isset($both_dir_data->new_application_fee) ? $both_dir_data->new_application_fee : ''; ?>" type="number" step="0.01"  class="form-control" readonly=""></div>   
                                                            <div class="col-md-1"><div class="checkbox">
                                                                    <label for=""><input  type="checkbox" value="1" <?php echo $dis_app; ?> name="adj_arbi_is_tax_enable_new_reg" <?php
                                                                        if ($both_dir_data->tax_enable_new_reg == 1) {
                                                                            echo 'checked="checked"';
                                                                        } else {
                                                                            
                                                                        }
                                                                        ?>  class="checkclass" id="adj_arbi_is_tax_enable_new_reg"> Enable Tax</label>
                                                                </div></div>   
                                                            <div class="col-md-4"><div <?php
                                                                if ($both_dir_data->tax_enable_new_reg == 1) {
                                                                    
                                                                } else {
                                                                    echo "style='display:none;'";
                                                                }
                                                                ?> id="adj_arbi_loadmembervat_new_reg">

                                                                    <!--<div class="row">-->
                                                                    <div class="col-sm-6">
                                                                        <?php
                                                                        foreach ($Taxres as $key => $tax)
                                                                        {
//                                                                            print_r($tax);
                                                                            ?>


                                                                            <div class="form-group">
                                                                                <div class="checkbox">
                                                                                    <label for="">

                                                                                        <input type="checkbox" value="<?php echo $tax->taxid; ?>" <?php
                                                                                        // if ($tax->taxid == 1) {
                                                                                        //     if (!empty($directory_data->new_reg_vat) && $directory_data->new_reg_vat > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // } else {
                                                                                        //     if (!empty($directory_data->new_reg_nbt) && $directory_data->new_reg_nbt > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // }
                                                                                        if ($tax->taxid == 1) {
                                                                                            if (!empty($both_dir_data->new_reg_nbt) && $both_dir_data->new_reg_nbt > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        } else {
                                                                                            if (!empty($both_dir_data->new_reg_vat) && $both_dir_data->new_reg_vat > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        }
                                                                                        ?> name="adj_arbi_tax_type_id_new_reg[]" <?php echo $dis_app; ?>  class="adj_arbi_checkclassmem adj_arbi_new_app_check adj_arbi_new_app_check<?php echo $key + 1; ?>" id="adj_arbi_mem_tax_type_id<?php echo $key + 1; ?>"> <?php echo $tax->taxtype; ?> ( <?php echo $tax->rate_value; ?>% ) 

                                                                                    </label>
                                                                                </div><input  type="hidden" placeholder="Percentage (%)" value="<?php echo $tax->rate_value; ?>"  id="adj_arbi_mem_tax_prsentage<?php echo $key + 1; ?>" name="adj_arbi_mem_tax_prsentage_new_reg[]" class="form-control "> 
                                                                                <input  type="hidden"  value="<?php echo $tax->taxtype; ?>"  id="adj_arbi_mem_tax_type<?php echo $key + 1; ?>" name="adj_arbi_tax_type_new_reg[]" class="form-control ">
                                                                            </div>


                                                                        <?php }
                                                                        ?>
                                                                    </div>
                                                                    <input type="hidden" id="adj_arbi_memnbtwithprice" value="" name="adj_arbi_memnbtwithprice">

                                                                    <!--</div>-->


                                                                </div>
                                                            </div>   

                                                        </div>                                                    


                                                    </div>
                                                    <!-- <div class="row">
                                                        <div class="col-md-4"><p>Continuous Registration</p></div>
                                                    </div> -->
                                                    <!-- <div class="row">
                                                        <div class="payment_div">
                                                            
                                                            <div class="col-md-5">
                                                                <input id="finace_continuous_registration" name="finace_continuous_registration" value="<?php echo isset($both_dir_data->directory_title) ? $both_dir_data->directory_title . " - Continuous Application" : ''; ?>" type="text" class="form-control" readonly="">
                                                            </div>   
                                                            <div class="col-md-2"><input id="finace_sub_cat_amount_continuous_registration" name="finace_sub_cat_amount_continuous_registration" value="<?php echo isset($both_dir_data->con_application_fee) ? $both_dir_data->con_application_fee : ''; ?>" type="text" required="required" class="form-control" readonly=""></div>   
                                                            <div class="col-md-1"><div class="checkbox">
                                                                    <label for=""><input  type="checkbox" value="1" <?php echo $dis_app; ?> name="is_tax_enable_cont_reg" <?php
                                                                        if ($both_dir_data->tax_enable_cont_reg == 1) {
                                                                            echo 'checked="checked"';
                                                                        } else {
                                                                            
                                                                        }
                                                                        ?>  class="checkclass" id="is_tax_enable_cont_reg"> Enable Tax</label>
                                                                </div></div>   
                                                            <div class="col-md-4">
                                                                <div <?php
                                                                if ($both_dir_data->tax_enable_cont_reg == 1) {
                                                                    
                                                                } else {
                                                                    echo "style='display:none;'";
                                                                }
                                                                ?> id="loadmembervat_cont_reg">

                                                         
                                                                    <div class="col-sm-6">
                                                                        <?php
                                                                        foreach ($Taxres as $key => $tax)
                                                                        {
                                                                            ?>


                                                                            <div class="form-group">
                                                                                <div class="checkbox">
                                                                                    <label for="">
                                                                                        <input type="checkbox" value="<?php echo $tax->taxid; ?>" <?php
                                                                                       
                                                                                        if ($tax->taxid == 1) {
                                                                                            if (!empty($both_dir_data->cont_reg_nbt) && $both_dir_data->cont_reg_nbt > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        } else {
                                                                                            if (!empty($both_dir_data->cont_reg_vat) && $both_dir_data->cont_reg_vat > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        }
                                                                                        ?> name="tax_type_id_cont_reg[]" <?php echo $dis_app; ?> class="checkclassmem cont_reg_check cont_reg_check<?php echo $key + 1; ?>" id="mem_tax_type_id<?php echo $key + 1; ?>"> <?php echo $tax->taxtype; ?> ( <?php echo $tax->rate_value; ?>% ) 

                                                                                    </label>
                                                                                </div><input  type="hidden" placeholder="Percentage (%)" value="<?php echo $tax->rate_value; ?>"  id="mem_tax_prsentage<?php echo $key + 1; ?>" name="mem_tax_prsentage_cont_reg[]" class="form-control "> 
                                                                                <input  type="hidden"  value="<?php echo $tax->taxtype; ?>"  id="mem_tax_type<?php echo $key + 1; ?>" name="tax_type_cont_reg[]" class="form-control ">
                                                                            </div>


                                                                        <?php }
                                                                        ?>
                                                                    </div>
                                                                    <input type="hidden" id="memnbtwithprice" value="" name="memnbtwithprice">

                                                               


                                                                </div>
                                                            </div>   

                                                        </div>                                                    


                                                    </div>   -->
                                                </div>



                                            </div>
                                        </div>

                                    </div>



                                </div>    
                            </div>
                            <div class="row">
                                <!--// Continous application ++++++++++++++++++++++++++-->
                                <div class="col-md-6"> 
                                    <h3> <span class="label label-default"><?php echo $main_pay_cont->main_payment_category ?> - (<?php echo $main_pay_cont->main_payment_category_code ?>)</span></h3>
                                    <input type="hidden" id="adj_arbi_payment_cat_id" name="adj_arbi_payment_cat_publications" value="<?php echo $main_pay_cont->main_payment_category_id; ?>">

                                </div>
                                
                            
                                <div class="col-md-12">
                                       
                                    <div id="app_fee_view" class="app_fee_view">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4"><p>New Publication</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="payment_div">
                                                            <!-- <div class="col-md-2"><p>New Publication Fee</p></div>    -->
                                                            <div class="col-md-5">
                                                                <input id="adj_arbi_finace_new_publications" name="adj_arbi_finace_new_publications" value="<?php echo isset($both_dir_data->directory_title) ? $both_dir_data->directory_title . "- New Publication" : ''; ?>" type="text" class="form-control" readonly="">
                                                            </div>   
                                                            <div class="col-md-2"><input id="adj_arbi_finace_sub_cat_amount_new_publications" name="adj_arbi_finace_sub_cat_amount_new_publications" value="<?php echo isset($both_dir_data->new_publication_fee) ? $both_dir_data->new_publication_fee : ''; ?>" type="number" step="0.01"  class="form-control" readonly=""></div>   
                                                            <div class="col-md-1"><div class="checkbox">
                                                                    <label for=""><input  type="checkbox" value="1" <?php echo $dis_app; ?> name="adj_arbi_is_tax_enable_new_pub" <?php
                                                                        if ($both_dir_data->tax_enable_new_pub == 1) {
                                                                            echo 'checked="checked"';
                                                                        } else {
                                                                            
                                                                        }
                                                                        ?>  class="checkclass" id="adj_arbi_is_tax_enable_new_pub"> Enable Tax</label>
                                                                </div></div>   
                                                            <div class="col-md-4"><div <?php
                                                                if ($both_dir_data->tax_enable_new_pub == 1) {
                                                                    
                                                                } else {
                                                                    echo "style='display:none;'";
                                                                }
                                                                ?> id="adj_arbi_loadmembervat_new_pub">

                                                                    <!--<div class="row">-->
                                                                    <div class="col-sm-6">
                                                                        <?php
                                                                        foreach ($Taxres as $key => $tax)
                                                                        {
                                                                            ?>


                                                                            <div class="form-group">
                                                                                <div class="checkbox">
                                                                                    <label for="">

                                                                                        <input type="checkbox" value="<?php echo $tax->taxid; ?>" <?php
                                                                                        // if ($tax->taxid == 1) {
                                                                                        //     if (!empty($directory_data->new_pub_vat) && $directory_data->new_pub_vat > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // } else {
                                                                                        //     if (!empty($directory_data->new_pub_nbt) && $directory_data->new_pub_nbt > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // }
                                                                                        if ($tax->taxid == 1) {
                                                                                            if (!empty($both_dir_data->new_pub_nbt) && $both_dir_data->new_pub_nbt > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        } else {
                                                                                            if (!empty($both_dir_data->new_pub_vat) && $both_dir_data->new_pub_vat > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        }
                                                                                        ?> name="adj_arbi_tax_type_id_new_pub[]"  class="adj_arbi_checkclassmem adj_arbi_ne_pub_check adj_arbi_ne_pub_check<?php echo $key + 1; ?>" <?php echo $dis_app; ?> id="adj_arbi_mem_tax_type_id<?php echo $key + 1; ?>"> <?php echo $tax->taxtype; ?> ( <?php echo $tax->rate_value; ?>% ) 

                                                                                    </label>
                                                                                </div><input  type="hidden" placeholder="Percentage (%)" value="<?php echo $tax->rate_value; ?>"  id="adj_arbi_mem_tax_prsentage<?php echo $key + 1; ?>" name="adj_arbi_mem_tax_prsentage_new_pub[]" class="form-control "> 
                                                                                <input  type="hidden"  value="<?php echo $tax->taxtype; ?>"  id="adj_arbi_mem_tax_type<?php echo $key + 1; ?>" name="adj_arbi_tax_type_new_pub[]" class="form-control ">
                                                                            </div>


                                                                        <?php }
                                                                        ?>
                                                                    </div>
                                                                    <input type="hidden" id="adj_arbi_memnbtwithprice" value="" name="adj_arbi_memnbtwithprice">

                                                                    <!--</div>-->


                                                                </div>
                                                            </div>   

                                                        </div>                                                    


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4"><p>Continuous Publication</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="payment_div">
                                                            <!-- <div class="col-md-2"><p>Continuous Publication Fee</p></div>    -->
                                                            <div class="col-md-5">
                                                                <input id="adj_arbi_finace_countinous_publication" name="adj_arbi_finace_countinous_publication" value="<?php echo isset($both_dir_data->directory_title) ? $both_dir_data->directory_title . "- Continuous Publication" : ''; ?>" type="text" class="form-control" readonly="">
                                                            </div>   
                                                            <div class="col-md-2"><input id="adj_arbi_finace_sub_cat_amount_countinous_publication" name="adj_arbi_finace_sub_cat_amount_countinous_publication" value="<?php echo isset($both_dir_data->con_publication_fee) ? $both_dir_data->con_publication_fee : ''; ?>" type="text" class="form-control" readonly=""></div>   
                                                            <div class="col-md-1"><div class="checkbox">
                                                                    <label for=""><input  type="checkbox" value="1" <?php echo $dis_app; ?> name="adj_arbi_is_tax_enable_cont_pub" <?php
                                                                        if ($both_dir_data->tax_enable_cont_pub == 1) {
                                                                            echo 'checked="checked"';
                                                                        } else {
                                                                            
                                                                        }
                                                                        ?>  class="checkclass" id="adj_arbi_is_tax_enable_cont_pub"> Enable Tax</label>
                                                                </div></div>   
                                                            <div class="col-md-4"><div <?php
                                                                if ($both_dir_data->tax_enable_cont_pub == 1) {
                                                                    
                                                                } else {
                                                                    echo "style='display:none;'";
                                                                }
                                                                ?> id="adj_arbi_loadmembervat_cont_pub">

                                                                    <!--<div class="row">-->
                                                                    <div class="col-sm-6">
                                                                        <?php
                                                                        foreach ($Taxres as $key => $tax)
                                                                        {
                                                                            ?>


                                                                            <div class="form-group">
                                                                                <div class="checkbox">
                                                                                    <label for=""><input type="checkbox" value="<?php echo $tax->taxid; ?>" <?php
                                                                                        // if ($tax->taxid == 1) {
                                                                                        //     if (!empty($directory_data->cont_pub_vat) && $directory_data->cont_pub_vat > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // } else {
                                                                                        //     if (!empty($directory_data->cont_pub_nbt) && $directory_data->cont_pub_nbt > 0) {
                                                                                        //         echo 'checked="checked"';
                                                                                        //     }
                                                                                        // }
                                                                                        if ($tax->taxid == 1) {
                                                                                            if (!empty($both_dir_data->cont_pub_nbt) && $both_dir_data->cont_pub_nbt > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        } else {
                                                                                            if (!empty($both_dir_data->cont_pub_vat) && $both_dir_data->cont_pub_vat > 0) {
                                                                                                echo 'checked="checked"';
                                                                                            }
                                                                                        }
                                                                                        ?> name="adj_arbi_tax_type_id_cont_pub[]"  class="adj_arbi_checkclassmem adj_arbi_cont_pub_check adj_arbi_cont_pub_check<?php echo $key + 1; ?>" <?php echo $dis_app; ?> id="adj_arbi_mem_tax_type_id<?php echo $key + 1; ?>"> <?php echo $tax->taxtype; ?> ( <?php echo $tax->rate_value; ?>% ) </label>
                                                                                </div><input  type="hidden" placeholder="Percentage (%)" value="<?php echo $tax->rate_value; ?>"  id="adj_arbi_mem_tax_prsentage<?php echo $key + 1; ?>" name="adj_arbi_mem_tax_prsentage_cont_pub[]" class="form-control "> 
                                                                                <input  type="hidden"  value="<?php echo $tax->taxtype; ?>"  id="adj_arbi_mem_tax_type<?php echo $key + 1; ?>" name="adj_arbi_tax_type_cont_pub[]" class="form-control "></div><?php } ?></div>
                                                                    <input type="hidden" id="adj_arbi_memnbtwithprice" value="" name="adj_arbi_memnbtwithprice">

                                                                    <!--</div>-->


                                                                </div>
                                                            </div>   

                                                        </div>                                                    


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                </div>    
                            </div>    
                        </div>                                                        
                              <!-- end both adjudicator & arbitrator -->

                        </form>
                    </div>

                </div>
                <!--</div>-->

                <?php
                if (!empty($directory_data->finance_approve_stat) && $directory_data->finance_approve_stat == 1) {
                    
                } else {
                    ?>


                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary" id="save_ceo_approval" <?php echo $dis_app; ?>><i class="fa fa-fw fa-check"></i>Approve</button>
                        </div>
                    </div>




                    <!--</div>-->


                <?php }
            } 
            
//            echo $directory_data->finance_approve_stat;            echo '<br>';
//            echo $user_group; echo '<br>';
//            echo $user1; echo '<br>';
//            echo $user2; echo '<br>';
//            echo $user3; echo '<br>';
//            exit;
            if (!empty($directory_data->finance_approve_stat) && $directory_data->finance_approve_stat == 1 && ($user_group == $user1 || $user_group == $user2 || $user_group == $user3)) {
                ?>

                <!--//Announcemenets-->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="create_announcement_form" action="<?php echo base_url(); ?>Announcements/create?ceo_app=1" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Title</label>
                                                    <input type="text" name="announcement_title" class="form-control" value="<?php echo isset($directory_data->directory_title) ? $directory_data->directory_title : ''; ?>" required>
                                                    <div class="help-block with-errors"></div>
                                                    <div style="font-size: 16px; color: red"><?php echo form_error('announcement_title'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <textarea name="announcement_description" class="form-control" required></textarea>
                                                    <div class="help-block with-errors"></div>
                                                    <div style="font-size: 16px; color: red"><?php echo form_error('announcement_description'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Tags</label>
                                                    <input type="text" name="announcement_tags" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Display Until</label>
                                                    <input type="text" name="announcement_display_until" class="form-control datetimepicker" required>
                                                    <div class="help-block with-errors"></div>
                                                    <div style="font-size: 16px; color: red"><?php echo form_error('announcement_display_until'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Meta Tags</label>
                                                    <textarea name="announcement_meta_tags" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Meta Description</label>
                                                    <textarea name="announcement_meta_description" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Announcement From</label>
                                                    <input type="text" name="announcement_from" class="form-control" required>
                                                    <div class="help-block with-errors"></div>
                                                    <div style="font-size: 16px; color: red"><?php echo form_error('announcement_from'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <textarea name="announcement_content" id="rich_text_editor"></textarea>
                                                    <div id="content_err" style="color: #dd4b39;"></div>
                                                    <div style="font-size: 16px; color: red"><?php echo form_error('announcement_content'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="announcement_published_by" value="<?php echo $user_id; ?>">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane-o"></i> &nbsp; Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>              
                </div>
                <!--//Announcemenets-->
<?php } ?>
        </div>

    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-money text-orange"></i>
                    <h3 class="box-title"><?php if($read_only){ echo 'View'; }else if($is_edit){ echo 'Update';}else{ echo 'Add'; } ?> Loan & Dependency Details</h3> 
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <form id="form_add_insurance" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php if($is_edit){ echo base_url('EmployeeController/saveUpdatedEmployeeLoan'); }else{ echo base_url('EmployeeController/saveEmployeeLoan'); }?>">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Employee ID</label>
                                                    <input type="text" name="employee_id" id="employee_id" class="form-control" value="<?php if($is_edit){ echo $loan->employee_no; } ?>" required <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Employee Name</label>
                                                    <input type="text" name="emp_name" id="emp_name"  value="<?php if($is_edit){ echo $loan->name_w_initials; } ?>"  class="form-control" readonly="">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Loan Type *</label>
                                                    <input type="text" name="loan_type" id="loan_type"  value="<?php if($is_edit){ echo $loan->loan_type; } ?>"  class="form-control"  required <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Reason *</label>
                                                    <input type="text" name="reason" id="reason"  value="<?php if($is_edit){ echo $loan->reason; } ?>"  class="form-control"  required <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Date *</label>
                                                    <input type="text" name="date" id="date"  value="<?php if($is_edit){ echo $loan->date; } ?>"  class="form-control datepicker"  required <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Amount *</label>
                                                    <input type="text" name="amount" id="amount" required="" value="<?php if($is_edit){ echo number_format($loan->amount,2); } ?>"  class="form-control" <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Period *</label>
                                                    <input type="text" name="period" id="period" required=""  class="form-control" value="<?php if($is_edit){ echo $loan->period; } ?>" <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Upload (if any) <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                                    <input type="file" name="upload_document" id="upload_document" class="form-control-file" <?php if($read_only){ echo 'hidden';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                    <?php if($is_edit){ ?>
                                                    <?php if($loan->attachment){ ?>
                                                    <a target="_blank" href="<?php echo base_url('uploads/employee_loan/'.$loan->attachment);?>" class=""> <i class="fa fa-certificate btn btn-primary">  View Attachment</i></a>
                                                    <?php }else{?>
                                                    <label class="btn btn-warning">No Attachment</label>
                                                    <?php } ?>
                                                    <input type="hidden" name="old_upload_document" value="<?php if($is_edit){ echo $loan->attachment; } ?>"/>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <h4>Dependency Details</h4>
                                        <br />
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Relationship with the loan taker</label>
                                                    <input type="text" name="relationsip" id="relationsip"  value="<?php if($is_edit){ echo $loan->depend_relationship; } ?>"  class="form-control"  <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Full Name *</label>
                                                    <input type="text" name="full_name" id="full_name" required=""  value="<?php if($is_edit){ echo $loan->depend_full_name; } ?>"  class="form-control" <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">NIC *</label>
                                                    <input type="text" name="nic" id="nic"  
                                                           value="<?php if($is_edit){ echo $loan->depend_nic; } ?>"  
                                                           class="form-control"  required <?php if($read_only){ echo 'readonly';} ?>  
                                                           pattern="([0-9]{9})([0-9]{3}|V|v|X|x)"
                                                            data-pattern-error="Please enter a valid NIC number"  >
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Other Details</label>
                                                    <input type="text" name="other" id="other"  value="<?php if($is_edit){ echo $loan->depend_other; } ?>"  class="form-control" <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="profile_id" id="profile_id" value="<?php if($is_edit){ echo $loan->emp_profile_id; } ?>" required=""/>
                                        <input type="hidden" name="loan_id" id="loan_id" value="<?php if($is_edit){ echo $loan->emp_loan_id; } ?>" required=""/>
                                        <?php if(!$read_only){?>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group  pull-right">
                                                    
                                                        <button type="reset" class="btn btn-danger">Cancel</button>&nbsp;
                                                        <button type="submit" id="save_training" class="btn btn-success">Save</button>&nbsp;   
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
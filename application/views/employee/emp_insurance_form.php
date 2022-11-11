<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-medkit text-orange"></i>
                    <h3 class="box-title">Add Medical Insurance Details</h3> 
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <form id="form_add_insurance" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php if($is_edit){ echo base_url('EmployeeController/updatesInsuranceDetails'); }else{ echo base_url('EmployeeController/saveInsuranceDetails'); }?>">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Employee ID</label>
                                                    <input type="text" name="employee_id" id="employee_id" class="form-control" value="<?php if($is_edit){ echo $insurance->employee_no; } ?>" required <?php if($read_only){ echo 'readonly';} ?>>
                                                    <lablel id="emp_name" style="color: red"></lablel>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Insurance Type *</label>
                                                    <input type="text" name="insurance_type" id="insurance_type"  value="<?php if($is_edit){ echo $insurance->insurance_type; } ?>"  class="form-control"  required <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Reason *</label>
                                                    <input type="text" name="reason" id="reason"  value="<?php if($is_edit){ echo $insurance->reason; } ?>"  class="form-control"  required <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Date *</label>
                                                    <input type="text" name="date" id="date"  value="<?php if($is_edit){ echo $insurance->date; } ?>"  class="form-control datepicker"  required <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Approved by</label>
                                                    <input type="text" name="approved_by" id="approved_by"  value="<?php if($is_edit){ echo $insurance->approved_by; } ?>"  class="form-control" <?php if($read_only){ echo 'readonly';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" name="description" id="description"  class="form-control" <?php if($read_only){ echo 'readonly';} ?>><?php if($is_edit){ echo $insurance->description; } ?></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Upload (if any) <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                                    <input type="file" name="upload_document" id="upload_document" class="form-control-file" <?php if($read_only){ echo 'hidden';} ?>>
                                                    <div class="help-block with-errors"></div>
                                                    <?php if($is_edit){ ?>
                                                    <a target="_blank" href="<?php echo base_url('uploads/employee_insurance/'.$insurance->attachment);?>" class=""> <i class="fa fa-certificate btn btn-primary">  View Attachment</i></a>
                                                    
                                                    <input type="hidden" name="old_upload_document" value="<?php if($is_edit){ echo $insurance->attachment; } ?>"/>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="profile_id" id="profile_id" value="<?php if($is_edit){ echo $insurance->emp_profile_id; } ?>" required=""/>
                                        <input type="hidden" name="insurance_id" id="insurance_id" value="<?php if($is_edit){ echo $insurance->emp_medical_insurance_id; } ?>" required=""/>
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
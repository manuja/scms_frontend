
<section class="content">
    <?php $this->load->view('employee/emp_form_tab'); ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!--/<i class="fa fa-users text-orange"></i>-->
                    <h3 class="box-title">Former Employment Details</h3>
                   
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <form id="form_emp_pre_employment" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/saveFormerEmployment') ?>">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Job Title *</label>
                                                    <input class="form-control" name="job_title" required/>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Organization *</label>
                                                    <input type="text" name="organization" class="form-control" value="" required />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">From *</label>
                                                    <input type="text" name="from"  class="form-control datepicker" value="" required />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Till *</label>
                                                    <input type="text" name="till" class="form-control datepicker"  value="">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Upload Document <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                                    <input type="file" name="emp_doc" class="form-control-file" value="">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" name="description"  class="form-control" required></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <input  name="profile_id" value="<?php echo $profile_id; ?>" type="hidden"/>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group  pull-right">
                                                    <a href="<?php echo base_url('employee/academic-details/'.$profile_id); ?>" class="btn btn-danger"><i class="fa fa-step-backward" aria-hidden="true"></i>  Back</a>&nbsp;
                                                    <button type="submit" id="save_employment" class="btn btn-success">Save</button>&nbsp;                                                    
                                                    <a href="<?php echo base_url('employee/other-documents/'.$profile_id); ?>" class="btn btn-info"> Next <i class="fa fa-step-forward" aria-hidden="true"></i></a>&nbsp;                                                    
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <h4>Added Records</h4>
                                    <?php if($employemt_data){ ?>
                                    <table class="table">
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Organization</th>
                                            <th>From</th>
                                            <th>Till</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php 
                                           
                                                foreach ($employemt_data as $row){ ?>
                                                    <tr>
                                                        <td><?php echo $row->job_title; ?></td>
                                                        <td><?php echo $row->organization; ?></td>
                                                        <td><?php echo $row->from_date; ?></td>
                                                        <td><?php echo $row->to_date; ?></td>
                                                        <td>
                                                            <button class="btn btn-info btn_view" data-id="<?php echo $row->emp_former_employment_id; ?>" id="btn_view" title="View"><i class="fa fa-eye"></i></button>
                                                            
                                                            <?php if($this->userpermission->checkUserPermissions2('emp_edit_former_emp')){ ?>
                                                            <button class="btn btn-warning btn_view" data-id="<?php echo $row->emp_former_employment_id; ?>" id="btn_edit" title="Edit"><i class="fa fa-pencil"></i></button>
                                                            <?php } ?>
                                                            
                                                            <?php if($this->userpermission->checkUserPermissions2('emp_delete_former_emp')){ ?>
                                                            <button class="btn btn-danger delete_btn" data-id="<?php echo $row->emp_former_employment_id; ?>" id="delete_btn" title="Delete"><i class="fa fa-trash"></i></button>
                                                            <?php } ?>
                                                        </td>
                                                        
                                                    </tr> 
                                           <?php }
                                            
                                        ?>
                                       
                                    </table>
                                    <?php }else{
                                        echo "There is no added records.";
                                    } ?>
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
<div class="modal fade" id="femployment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Former Employment Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_emp_academic" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/updateFormerEmployment') ?>">                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Job Title *</label>
                                <input class="form-control" name="job_title" id="job_title" required/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Organization *</label>
                                <input type="text" name="organization" id="organization" class="form-control" value="" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">From *</label>
                                <input type="text" name="from" id="from" class="form-control datepicker" value="" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Till *</label>
                                <input type="text" name="till" id="till" class="form-control datepicker"  value="">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Upload Document <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                <input type="file" name="emp_doc" id="emp_doc" class="form-control-file" value="">
                                 <input type="hidden" name="old_emp_doc" value=""/>
                                <span id="view_doc"></span>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea type="text" name="description" id="description" class="form-control" required></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <input  name="former_emp_id" id="former_emp_id" value="" type="hidden"/>
                    <input  name="profile_id" value="<?php echo $profile_id; ?>" type="hidden"/>
                    
                </div>               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success update_btn" id="update_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
<!-- /.content-wrapper -->
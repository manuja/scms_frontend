
<section class="content">
    <?php $this->load->view('employee/emp_form_tab'); ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!--/<i class="fa fa-users text-orange"></i>-->
                    <h3 class="box-title">Upload Document</h3>
                   
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <form id="form_add_training" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/saveEmpOtherDocs') ?>">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Document Type *</label>
                                                    <select name="doc_type" class="form-control"  required="">
                                                        <option>Select...</option>
                                                        <?php 
                                                        foreach ($doc_types as $doc) {?>
                                                        <option value="<?php echo $doc->doc_type_id; ?>"><?php echo $doc->doc_type; ?></option>
                                                       <?php }
                                                        ?>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Upload Document * <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                                    <input type="file" name="other_doc" class="form-control-file" value="" required />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Comment *</label>
                                                    <textarea name="comment" class="form-control" value="" required ></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="profile_id" value="<?php echo $profile_id; ?>"/>
                                            <div class="col-sm-6">
                                                <div class="form-group  pull-right" style="margin-top: 30px">
                                                    <a href="<?php echo base_url('employee/former-employee-details/'.$profile_id); ?>" class="btn btn-danger"><i class="fa fa-step-backward" aria-hidden="true"></i> Back</a>&nbsp;
                                                    <button type="submit" id="save_docs" class="btn btn-success">Save</button>&nbsp;                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <h4>Added Records</h4>
                                    <?php if($other_docs_list){ ?>
                                    <table class="table">
                                        <tr>
                                            <th>Document Type</th>
                                            <th>Comment</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php 
                                           
                                                foreach ($other_docs_list as $row){ ?>
                                                    <tr>
                                                        <td><?php echo $row->doc_type_name; ?></td>
                                                        <td><?php echo $row->comment; ?></td>
                                                        <td>
                                                            <button class="btn btn-info btn_view" data-id="<?php echo $row->attachment_id; ?>" id="btn_view" title="View"><i class="fa fa-eye"></i></button>
                                                            <?php if($this->userpermission->checkUserPermissions2('emp_edit_other_doc')){ ?>
                                                            <button class="btn btn-warning btn_view" data-id="<?php echo $row->attachment_id; ?>" id="btn_edit" title="Edit"><i class="fa fa-pencil"></i></button>
                                                            <?php } ?>
                                                            <?php if($this->userpermission->checkUserPermissions2('emp_delete_other_doc')){ ?>
                                                            <button class="btn btn-danger delete_btn" data-id="<?php echo $row->attachment_id; ?>" id="delete_btn" title="Delete"><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="other_doc_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Upload Document</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_emp_academic" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('EmployeeController/updateEmpOtherDocs') ?>">               
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Document Type *</label>
                                <select name="doc_type" id="doc_type" class="form-control"  required="">
                                    <option>Select...</option>
                                    <?php 
                                    foreach ($doc_types as $doc) {?>
                                    <option value="<?php echo $doc->doc_type_id; ?>"><?php echo $doc->doc_type; ?></option>
                                   <?php }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Upload Document * <i class="fa fa-info-circle" title="Max File Size is 5MB" style="cursor:help;"></i></label>
                                <input type="file" name="other_doc" id="other_doc" class="form-control-file" value="" />
                                <input type="hidden" name="old_other_doc" id="old_other_doc" value=""/>
                                <span id="view_doc"></span>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Comment *</label>
                                <textarea name="comment" id="comment" class="form-control" value="" required ></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    
                    <input  name="other_doc_id" id="other_doc_id" value="" type="hidden"/>
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
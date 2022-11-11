
<?php
//    print_r($document);
//    exit;
?>

<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-users text-blue"></i>
            <h3 class="box-title">Add Documents</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row" id="document_archive_div"></div>
                    <form action="document_archive_form" data-toggle ="validator" id="document_archive_form">
                        <?php
//                          echo  base_url() . 'uploads/membership_group_document_archives' . 'ssss';
                        ?>
<!--                        <input id="hidden_group_document_id" name="hidden_group_id" type="hidden" value="<?php
//                        if (!empty($document['group_id']))
                        {
//                            echo $document['group_id'];
                        }
                        ?>">-->
                        <input id="hidden_doc_name" name="hidden_doc_name" type="hidden" value="<?php
                        if (!empty($document['document_name']))
                        {
                            echo $document['document_name'];
                        }
                        ?>">
                        <input id="hidden_document_id" name="hidden_document_id" type="hidden" value="<?php
                        if (!empty($document['document_id']))
                        {
                            echo $document['document_id'];
                        }
                        ?>">
                        <div class="form-group">
                            <!--                            <label for="">Group</label>
                                                        <input type="text" name="group_name" id="group_name" class="form-control" value="<?php // echo $group_name->mem_goup_name;  ?>" readonly="" />   -->
                            <?php
                            echo form_dropdown('hidden_group_id" id="hidden_group_id" class="form-control text-left"', $mem_groups, isset($document['group_id']) ? $document['group_id'] : '');
                            ?>  

                        </div>
                        <div class="form-group">
                            <label for="">Title <span>*</span></label>
                            <input type="text" name="title" id="title" value="<?php
                            if (!empty($document['document_title']))
                            {
                                echo $document['document_title'];
                            }
                            ?>" class="form-control" required="">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Description<span>*</span></label>
                            <textarea name="description" id="description" class="form-control" required=""> <?php
                                if (!empty($document['document_description']))
                                {
                                    echo $document['document_description'];
                                }
                                ?></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Upload File</label><br />
                            <label class="btn btn-primary"> Browse... <input type="file" name="group_document" id="group_document" onchange="document.getElementById('file_info').innerHTML = this.files[0].name" hidden required=""> </label>
                            <span class="label label-info" id="file_info"></span>
                            <div class="help-block with-errors"></div>
                            <?php
                            if (!empty($document['document_name']))
                            {
//                                    echo 'fgdfgfgdfgd';
                                ?>

                                <div id="">
                                    <a href="<?php echo base_url() ?>/uploads/membership_group_document_archives/<?php echo $document['document_name']; ?>"> <?php echo base_url() ?>/uploads/membership_group_document_archives/<?php echo $document['document_name']; ?> </a>

                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <?php
                            if (!empty($document['group_id']))
                            {
                                ?>
                                <button type="submit" id="update_documents" class="btn btn-success">Submit</button>
                                <?php
                            }
                            else
                            {
                                ?>
                                <button type="submit" id="add_documents" class="btn btn-success">Submit</button>
                            <?php }
                            ?>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


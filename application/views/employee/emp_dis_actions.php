<section class="content">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-gavel text-orange"></i>
                    <h3 class="box-title">Disciplinary action Details</h3>
                    <div class="box-tools">
                        <?php if ($this->userpermission->checkUserPermissions2('emp_disciplinary_action_add')) { ?>
                            <a href="<?php echo site_url('employee/add-disciplinary-action'); ?>" class="btn btn-primary"> Add New</a>
                        <?php } ?>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <table class="table table-striped emp_discipline_table" id="emp_discipline_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Employee ID</th>                                       
                                        <th style="width: 20%">Employee Name</th>
                                        <th style="width: 20%">Action taken for</th>
                                        <th style="width: 10%">Action taken</th>
                                        <th style="width: 10%">Date</th>
                                        <th style="width: 10%">Approved by</th>
                                        <th style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
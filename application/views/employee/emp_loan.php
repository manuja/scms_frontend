<section class="content">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-money text-orange"></i>
                    <h3 class="box-title">Employee Loan and Dependency</h3>
                    <div class="box-tools">
                        <?php if ($this->userpermission->checkUserPermissions2('emp_loan_dependency_add')) { ?>
                            <a href="<?php echo site_url('employee/add-loan-dependency'); ?>" class="btn btn-primary"> Add New</a>
                        <?php } ?>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <table class="table table-striped emp_loan_table" id="emp_loan_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Employee ID</th>                                       
                                        <th style="width: 20%">Employee Name</th>
                                        <th style="width: 20%">Loan Type</th>
                                        <th style="width: 10%">Date</th>
                                        <th style="width: 10%">Amount</th>
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
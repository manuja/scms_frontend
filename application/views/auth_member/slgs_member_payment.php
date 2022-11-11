<html>

<head>
</head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Member Management</title>
</head>

<body>


    <section class="content">
        <div class="row">
            <?php
            $success = $this->session->userdata('success');
            if ($success != "") {
            ?>

                <div class="alert alert-success " role="alert">
                    <?php echo $success; ?>
                    <button type="button" id="alertbtt" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
            }
            ?>

            <?php
            $failure = $this->session->userdata('failure');
            if ($failure != "") {
            ?>
                <div class="alert alert-warning " role="alert">
                    <?php echo $failure; ?>
                    <button type="button" id="alertbtt" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
            }
            ?>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-newspaper-o text-blue"></i>
                        <h3 class="box-title">Payment History</h3>
                        <div class="box-tools">
                            <!-- <?php if ($this->ion_auth->is_admin() || $this->userpermission->checkUserPermissions2('publication_add')) { ?>
                                <a href="<?php echo site_url('publication/add-new-publication'); ?>" class="btn btn-primary">Add Publication</a>
                            <?php } ?> -->
                        </div>
                    </div>

                    <!-- 
                applybids
                  documents -->


                    <div class="box-body" style="overflow-x: scroll">


                        <div class="row">
                            <div class="col-xs-4" style="padding-bottom: 10px;">


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for=""> Payment Year</label>
                                        <input type="text" value="" name="payment_year" id="payment_year" class="form-control datepicker">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <!-- user_status -->

                              

                                <div class="col-sm-12">
                                    <p>Latest Payment Year - <?php echo $payment_data[0]['year'] ?> </p>
                                 
                                        <?php if ($user_status[0]['active'] == 1) { ?>
                                            Payment Status -  <p style="padding:0px; width: 65px; height: 20px;" class="btn btn-success">Paid</p>
                                <?php } else if ($user_status[0]['active'] == 4) { ?>
                                    Payment Status -  <p style="padding:0px;width: 130px;" class="btn btn-warning">Payment Pending</p>
                                <?php }else{?> 
                                    Payment Status -  <p style="padding:0px;width: 130px;" class="btn btn-warning">Payment Pending</p>
                                    <?php }?> 
                            </p>
                                </div>

                            </div>
                        </div>

                        <div style="display:none">
                            <input type="text" name="user_id" id="user_id" value="<?php echo $user_id; ?>" class="form-control" readonly>

                            <input type="text" name="base_path" id="base_path" value="<?php echo base_url(); ?>" class="form-control" readonly>

                        </div>


                        <table class="table" id="publication_table">
                            <thead style="font-size: 16px;">
                                <tr>
                                    <th>No</th>
                                    <th>Payment Year</th>
                                    <th>Payment Amount</th>
                                    <th>Paid Date</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                $i = 1;

                                ?>

                                <?php if (!empty($payment_data)) {
                                    foreach ($payment_data as $payment) {  ?>



                                        <tr>

                                            <td><?php echo $i; ?></td>



                                            <td><?php echo $payment['year']; ?> </td>


                                            <td><?php echo $payment['amount']; ?> </td>




                                            <td>


                                                <?php

                                                $paymentdate =  date('Y-m-d', strtotime($payment['payment_cratedat']));


                                                echo $paymentdate;


                                                ?>

                                            </td>




                                            <td>



                                                <?php if ($this->userpermission->checkUserPermissions2('payment_history_member_view')) { ?>

                                                    <a data-toggle="modal" data-toggle="tooltip" id="loadmodalview" data-year="<?php echo $payment['year']; ?>" data-amount="<?php echo $payment['amount']; ?>" data-paid_date="<?php echo $paymentdate; ?>" data-type="<?php echo $payment['payment_type']; ?>" data-slip="<?php echo $payment['payment_slip']; ?>" data-target="#ViewModal" href="" class="btn btn-success" title="Payment History"><i class="fa  fa-eye"></i></a>


                                                <?php } ?>

                                                <?php if ($this->userpermission->checkUserPermissions2('payment_history_member_attachment')) { ?>

                                                    <?php if ($payment['payment_slip'] != "") { ?>

                                                        <?php if (file_exists('uploads/Payment_slips/' . $user_id . '/' . $payment['payment_slip'])) { ?>
                                                            <a target="_blank" id="downloddoc" data-toggle="tooltip" href="<?php echo base_url('uploads/Payment_slips/' . $user_id . '/' . $payment['payment_slip']); ?>" class="btn btn-primary" title="Download Payment Slip"><i class="fa fa-download"></i></a>
                                                        <?php } else { ?>
                                                            <a target="_blank" disabled="disabled" id="downloddoc" data-toggle="tooltip" href="" class="btn btn-primary" title="Payment Slip is Missing or Deleted"><i class="fa fa-download"></i></a>

                                                        <?php } ?>

                                                    <?php } else { ?>
                                                        <a target="_blank" disabled="disabled" id="downloddoc" data-toggle="tooltip" href="" class="btn btn-primary" title=" There are no any Attachments with this Payment"><i class="fa fa-download"></i></a>
                                                    <?php } ?>
                                                <?php } ?>




                                            </td>



                                        </tr>
                                        <?php $i++; ?>

                                    <?php }
                                } else { ?>

                                    <tr>
                                        <td colspan="6">Records not found</td>
                                    </tr>


                                <?php } ?>

                                <?php ?>






                            </tbody>
                        </table>










                    </div>



                </div>
            </div>
        </div>


    </section>



</body>

</html>
</div>


</div>

<!-- Status modal -->
<div class="modal fade" id="ViewModal" tabindex="-1" role="dialog" aria-labelledby="status" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="statustitle">Payment History</h4>
                </button>
            </div>
            <div class="modal-body">
                <!-- <div class="box box-primary">


      <div class="box-body"> -->
                <div class="row">
                    <div class="col-sm-12">

                        <div class="panel panel-default">

                            <div class="panel-body">

                                <form id="payment_view" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="">



                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Payment Year</label>
                                                <input type="text" name="p_year" id="p_year" class="form-control" readonly>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Payment Amount</label>
                                                <input type="text" name="p_amount" id="p_amount" class="form-control" readonly>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Payment Type</label>
                                                <input type="text" name="p_type" id="p_type" class="form-control" readonly>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Paid Date</label>
                                                <input type="text" name="p_date" id="p_date" class="form-control" readonly>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>



                                    <div id="payment_slip_div">

                                    </div>



                                    <div>
                                        <div class="form-group  pull-right">
                                            <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <!-- </div>
      </div> -->
            <div class="modal-footer">

            </div>
            </form>
        </div>
    </div>
</div>


</div>
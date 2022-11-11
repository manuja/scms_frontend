
<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 5/1/2018
 * Time: 9:19 AM
 */

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Box Comment -->
                <div class="box box-widget">
                    <div class="box-header with-border text-center" style="background-color: #fff !important; color: #244b90;  border-radius: 6px;">
                        <h1 style="margin-bottom: 20px;">
                            <i class="fa fa-check-circle-o fa-lg" style="color: #00a65a;"></i> &nbsp; Member Payments
                        </h1>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="four-zero-three">
                                    <div class="inner">
                                        <p>&nbsp;</p>
                                        <p style="font-size: 1.2em;line-height: 2.1;font-weight: 700;">Once you submitted your application, test staff will review it and successful candidates will be notified about the application payment. Application payment will be different from class of membership that you are applying.</p>
                                        <p>&nbsp;</p>
                                        <p style="font-size: 1.2em;">Application payment rates are as follows by now.</p>
                                        <p>&nbsp;</p>
                                        <ul style="list-style: none;font-size: 1.2em;line-height: 2.1;padding-right: 40px;">
                                        <li><i class="fa fa-dot-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;Student : LKR <?php echo number_format(floatval($studentFee), 2); ?></li>
                                        <li><i class="fa fa-dot-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;Associate Member : LKR <?php echo number_format(floatval($amieFee), 2); ?></li>
                                        <li><i class="fa fa-dot-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;Affiliate Member : LKR <?php echo number_format(floatval($afimieFee), 2); ?></li>
                                        <li><i class="fa fa-dot-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;Companion : LKR <?php echo number_format(floatval($conpanionFee), 2); ?></li>
                                        <li><i class="fa fa-dot-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;Associate : LKR <?php echo number_format(floatval($associateFee), 2); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<html>
<head>
</head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Order</title>
      <script>var baseurl = "<?php echo site_url(); ?>";</script>
 
</head>
<body>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-industry text-orange"></i>
                    <h3 class="box-title"><?php echo $pagetitle; ?></h3>
                    <div class="box-tools">
                    </div>
                </div>



                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <fieldset disabled="disabled">
                                    <form  id="form_apply_bid" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url($formUrl) ?>">
                                        <div class="row">
                                        <input type="hidden" value="<?php if($edit_status != "" ){ echo $edit_status; } ?>" name="edit_status" id="edit_status" class="form-control"required>
                                        <input type="hidden" value="<?php if($one_event != "" ){ echo $one_event[0]['id']; } ?>" name="eid" id="eid" class="form-control"required>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                    <label for="">Order Id*</label>
                                                    <input type="text" value="<?php echo $one_order_id?>" name="orderid" id="orderid" class="form-control"required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            <div class="form-group">
                                                    <label for="">Order Name*</label>
                                                    <input type="text" value="<?php echo $name ?>" name="title" id="title" class="form-control"required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="">Contact No*</label>
                                                    <input type="text" value="<?php { echo $contactno; } ?>"  name="contactno" id="contactno" class="form-control"required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                             <div class="form-group ">
                                                    <label for="">Expected Completion Date*</label>
                                                    <input value="<?php { echo $order_need_date; } ?>" style="border-radius:2px" type="text" name="order_need_date" id="order_need_date" class="form-control datepicker" required>
                                                    <div class="help-block with-errors">
                                                    </div>
                                                    </div>
                                                    
                                                <div class="form-group">
                                                    <label for="">Order Description</label>
                                                    <!-- <input value="<?php { echo $orderinfo[0]->description; } ?>" type="text"  name="description" id="description" class="form-control" rows="3"> -->
                                                    <textarea value="" class="form-control" name="description" id="description" rows="5"><?php { echo $description; } ?></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                           
                                        </div>

   
  <div class="row">
      <div class="col-lg-12"><span id="success-msg"></div>
  </div>
    <div class="row">
        <div class="col-lg-12">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#add-staff" class="float-right btn btn-primary btn-sm" style="margin: 4px;"><i class="fa fa-plus"></i> Add</a>              
        </div>
    </div>
    <div class="row">   
    </div>
    <div class="">
        <table id="staffListing" class="table table-bordered table-hover small"> 
            <thead>
                <tr>
                    
                    <th>Order No</th>
                   <th>Oder Item Id</th>
                  <th>Item List Row ID</th>
                  <th>Qty</th>
                  <th>Order Item Name</th>
                 
                    <th scope="col">Action</th>
                </tr>
            </thead> 
            <tbody> 
            </tbody> 
           
        </table>
    </div>
</span>

</div>

                                       

                                        
                                      
                                        

                                        <div class="row">
                                            <div class="col-sm-11">
                                                <div class="form-group  pull-right">
                                               <a href="<?php echo base_url().'orders/'?>" class="btn btn-success">Ok</a>
                                                                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>



                </div>
        </div>
      </div>


</section>



</body>
</html>
</div>


<?php
$this->load->view('order/popup/display');
$this->load->view('order/popup/edit');
$this->load->view('order/popup/add');
$this->load->view('order/popup/delete');
//$this->load->view('templates/footer');
?>


<html>

<head>
</head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Management</title>
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
            <i class="fa fa-industry text-orange"></i>
            <h3 class="box-title">Order Management</h3>
            <div class="box-tools">
              <?php if ($this->ion_auth->is_admin() || $this->userpermission->checkUserPermissions2('add_event')) { ?>
                <a href="<?php echo site_url('order_management/add_orders'); ?>" class="btn btn-primary">Add Order</a>
              <?php } ?>
            </div>
          </div>

          <!--
                applybids
                  documents -->



          <div class="box-body" style="overflow-x: scroll">


            <div class="row">
              <div class="col-xs-4" style="padding-bottom: 10px;">



              </div>
            </div>



            <table class="table" id="bid_apply_table">
              <thead style="font-size: 16px;">
                <tr>
                  <th>Order No</th>
                  <th>Order Title</th>
                  <th>Contact No</th>
                  <th>Expacted Date</th>
                  <th>Actions</th>

                </tr>
              </thead>

              <tbody>
                <?php

                $i = 1;

                ?>

                <?php if (!empty($events)) {
                  foreach ($events as $event) {  ?>



                    <tr>

                      <td><?php echo $event['id']; ?></td>



                      <td><?php echo $event['name']; ?> </td>

                       <td><?php echo $event['contactno']; ?></td>
                      <td>
                        <?php echo $event['order_need_date']; ?>
                      </td>



                      <td>
                        <?php if ($this->userpermission->checkUserPermissions2('view_event')) { ?>
                          <a data-toggle="modal" data-toggle="tooltip" title="View" id="loadmodalview" href="<?php echo base_url('order_management/view_orders/' . $event['id']) ?>" class="btn btn-success"><i class="fa  fa-eye"></i></a>
                        <?php } ?>


                        <?php if ($this->userpermission->checkUserPermissions2('edit_event')) { ?>
                          <a data-toggle="tooltip" title="Edit" href="<?php echo base_url('OrderController/edit_orders/' . $event['id']) ?>" class="btn btn-warning"><i class="fa  fa-edit"></i></a>
                        <?php } ?>



                        <?php if ($this->userpermission->checkUserPermissions2('delete_event')) { ?>




                          <a data-toggle="modal" data-toggle="tooltip" id="loadmodaldelete" data-id="<?php echo $event['id']; ?>" data-title="<?php echo $event['title']; ?>" data-date="<?php echo $applydate; ?>" data-target="#deleteModal" href="" class="btn btn-danger" title="Delete"><i class="fa  fa-trash-o"></i></a>


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

<!-- delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title" id="statustitle">Delete Event</h4>
        </button>
      </div>
      <div class="modal-body">
        <!-- <div class="box box-primary">


      <div class="box-body"> -->
        <div class="row">
          <div class="col-sm-12">

            <div class="panel panel-default">

              <div class="panel-body">

                <form id="eventdelete" method="POST" enctype="multipart/form-data" data-toggle="validator" role="form" action="<?php echo base_url('order_management/delete_orders') ?>">



                  <div style="display:none" class="form-group">
                    <input type="hidden" value="" name="d_id" id="d_id" class="form-control" readonly>
                    <div class="help-block with-errors"></div>
                  </div>



                  <div>

                    <h4>Are you sure want to delete this Event! </h4>

                  </div>
                  <div>
                    <div class="form-group  pull-right">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                      <button type="submit" id="save_pr_delete_data" class="btn btn-danger">Yes</button>&nbsp;
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





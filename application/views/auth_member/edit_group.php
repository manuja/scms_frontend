<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Edit group</h3>

                    <div class="box-tools">
                        <a href="<?php echo site_url('auth/create_sub_group/' . $group_id); ?>" class="btn btn-primary">Add sub group</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="infoMessage"><?php echo $message; ?></div>
                    <div class="row"> 
                        <div class="col-md-3">
                            <?php echo form_open(current_url()); ?>
                            <div class="form-group">
                                <?php echo lang('edit_group_name_label', 'group_name'); ?>
                                <?php echo form_input($group_name); ?>
                            </div>

                            <div class="form-group">
                                <?php echo lang('edit_group_desc_label', 'description'); ?>
                                <?php echo form_input($group_description); ?>
                            </div>
                            <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-primary  btn-flat'), lang('edit_group_submit_btn')); ?>

                            <?php echo form_close(); ?>
                        </div>
                        <div class="col-md-9">
                            <h5>Sub groups</h5>
                            <table class="table table-bordered" id="sub_group">
                                <thead style="font-size: 12px;">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if (sizeof($sub_groups) > 0) {
                                        $i = 1;

                                        foreach ($sub_groups as $sub_group)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?php echo htmlspecialchars($sub_group->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($sub_group->description, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td>
                                                    <button type="button" id="<?php echo $sub_group->id; ?>" class="btn btn-danger delete_groups" ><i class="fa  fa-trash"></i></button>
                                                    <button type="button" value="<?php echo $sub_group->id; ?>" class="btn btn-primary edit_groups" data-toggle="modal" data-target="#myModal"><i class="fa  fa-pencil-square-o"></i></button>


                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4">This group has no sub groups</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sub Groups</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <fieldset>
                        <!-- Text input-->
                        <input id="hidden_sub_id" type="hidden">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">Sub Group</label>  
                            <div class="col-md-4">
                                <input id="subs_group" name="subs_group" type="text" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">Description</label>  
                            <div class="col-md-4">
                                <input id="description" name="sub_group" type="text" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton"></label>
                            <div class="col-md-4">
                                <button id="save_sub_groups" type="button" name="save_sub_groups" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </fieldset>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script src="<?php echo base_url() . 'assets/'; ?>bower_components/jquery/dist/jquery.min.js"></script>
<script>

    jQuery(document).on("click", ".edit_groups", function () {
        var gval = $(this).val();
        var ugroup = $(this).parent().siblings(":nth-child(2)").text();
        var desc = $(this).parent().siblings(":nth-child(3)").text();

        $('#description').val(desc);
        $('#subs_group').val(ugroup);
        $('#hidden_sub_id').val(gval);
//        alert(gval);
    });



    jQuery(document).on("click", "#save_sub_groups", function () {
        update_sub_form();
    });

    function update_sub_form() {
        var hidden_id = $('#hidden_sub_id').val();

        var description = $('#description').val();
        var subs_group = $('#subs_group').val();

        var param = {
            hidden_id: hidden_id,
            subs_group: subs_group,
            description: description
        };

        $.ajax({
            method: 'POST',
            url: site_url + 'Auth/sub_group_edit',
            dataType: 'json',
            data: param
        }).always(function (data) {
//                        console.log(data);
            if (data.status == '1') {
                $('#myModal').modal('hide');
                $('#description').val('');
                $('#subs_group').val('');
                $('#hidden_sub_id').val('');
                swal('Updated', 'Sub group updated', 'success');
                setTimeout(function () {
                    location.reload();
                }, 800);

            } else if (data.status == '2') {
               
                swal('Update failed', 'Sub group update failed', 'error');
            }

        });
//                });
    }
    
    $('.delete_groups').on('click', function() {
  			var sub_group_id = $(this).attr('id');
  			var post_data = {
  				sub_group_id: sub_group_id
  			};

  			swal({
  				title: 'Are you sure?',
  				type: 'warning',
  				showCancelButton: true,
  				confirmButtonColor: '#3085d6',
  				cancelButtonColor: '#d33',
  				confirmButtonText: 'Yes, Delete!'
  			}).then((result) => {
  				if (result.value) {
  					$.ajax({
  						type: 'POST',
  						url: '<?php echo base_url('Auth/delete_sub_group'); ?>',
                                                dataType: "json",
  						data: {
  							data: post_data
  						},
  						success: function(data) {
                                                    console.log(data.status);
                                                    if(data.status == '1'){
                                                        swal({
  								title: data.msg,
  								type: 'success'
  							}).then(function() {
  								window.location.reload();
  							});
                                                    }else{
                                                        swal({
  								title: data.msg,
  								type: 'error'
  							});
                                                    }
  							
  						},
  						error: function(jqXHR, textStatus, errorThrown) {
  							alert(textStatus);
  						}
  					});
  				}
  			});
  		});
</script>
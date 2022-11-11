<script>
    $(document).ready(function () {
        window.status = "";
        window.act_status = "";
        window.groupName = "";

        var group_name = $("#group_name").val();
        window.groupName = group_name;
        
        if(group_name=="User I"){
            window.status = "disabled";
            window.act_status = "disabled";
        }else if(group_name=="User II"){
            window.status = "";
            window.act_status = "disabled";
        }else if(group_name=="User III"){
            window.status = "";
            window.act_status = "";
        }else{//MIE//FIE//HLM//HLF
            window.status = "disabled";
            window.act_status = "disabled";
        }
     
        calling_directory_view();
        
        $('#form_active_status').on('submit',function(event){
        event.preventDefault();
        var directory_id = $('#directory_id').val();
        var dir_type = $('#dir_type').val();
        var active_status = $('#active_status').val();
        
        if($('#comment').val()){//save in db
            var data_form = document.getElementById('form_active_status');
            var formData = new FormData(data_form);
            $.ajax({
                url: site_url + "Add_calling_directory/saveComment",
                method: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // console.log(response.status);
                    if(response.status=="true"){
                        // $('.calling_directory_view').DataTable().clear().draw();
                        $('#myModal').modal('hide');
                        
                        // swal("Success!", "Status changed successfully!", "success");
                        active_status_for_application(directory_id, dir_type, active_status);
                    }else{
                        swal("Not Saved!", "Sorry!Comment not updated successfully!", "warning");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // console.log("gchdgshgchgsgchsgchsgchsgchsgchsgchsgchg ");
                    // console.log(jqXHR);
                //    console.log(textStatus, errorThrown);
                // swal("Cannot Save!", textStatus, "warning"); 
                }
            });
        }else{
            swal("Cannot Save!", "Please enter some data!", "warning"); 
        }
    });
    
    $('#form_verify').on('submit',function(event){
        event.preventDefault();
        var directory_id = $('#vdirectory_id').val();
        var dir_type = $('#vdir_type').val();
        var verify_status = $('#verify_status').val();
        
        if($('#vcomment').val()){//save in db
            var data_form = document.getElementById('form_verify');
            var formData = new FormData(data_form);
            $.ajax({
                url: site_url + "Add_calling_directory/saveVerifyComment",
                method: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // console.log(response.status);
                    if(response.status=="true"){
                        // $('.calling_directory_view').DataTable().clear().draw();
                        $('#verifyModal').modal('hide');
                        
                        // swal("Success!", "Status changed successfully!", "success");
                        Verify_application(directory_id, verify_status);
                    }else{
                        swal("Not Saved!", "Sorry!Comment not updated successfully!", "warning");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // console.log("gchdgshgchgsgchsgchsgchsgchsgchsgchsgchg ");
                    // console.log(jqXHR);
                //    console.log(textStatus, errorThrown);
                // swal("Cannot Save!", textStatus, "warning"); 
                }
            });
        }else{
            swal("Cannot Save!", "Please enter some data!", "warning"); 
        }
    });

    $('#dir_dropdown').on('click',function(){
        calling_directory_view(); 

    });
    $('#status_dropdown').on('click',function(){
        calling_directory_view();
    });


    });
    function getJtableBtnHtml(full) {
//    alert(full["approve_stat"] == 1);
        var appval = $('#approved_values').val();
        var html = '';
        var page_url = window.location.href;
        var enc_url = window.btoa(page_url); // encode a string
        html += '<div class="btn-group" role="group"  aria-label="" style="width: 90px;">';
        html += '<a class="btn btn-primary btn-edit" href="' + site_url + 'Add_calling_directory/edit_directories/' + full["directory_id"] + '/' + appval + '" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;';
        // html += '<button type="button" class="btn btn-primary btn-edit" data-toggle="tooltip" title="View" onclick="viewEditDir('+ full["directory_id"] +','+ appval +','+ full["directory_id"] +')"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                                                                                                                                        
//        html += '<a class="btn btn-danger btn-delete" href="' + site_url + 'membership_groups/add_members_to_group" data-toggle="tooltip" title="Add members to group"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;';
       
        <?php
            $user3 = $this->config_variables->getVariable('fin_dev_user_3_group_id');
            $user2 = $this->config_variables->getVariable('fin_dev_user_2_group_id');
            $user1 = $this->config_variables->getVariable('fin_dev_user_1_group_id');

            $user_see_id = $this->session->userdata('user_id');
            $group_id = $this->userpermission->get_user_group($user_see_id);

            if ($group_id == $user1 | $group_id == $user2 | $group_id == $user3) {
        ?>
                html += '</div>';
                return html;
        <?php
            }
        ?>
       if(window.groupName == "User I"){

            html += '</div>';
            return html;

       }else if(window.groupName == "User II"){

            if (full["approve_stat"] == 1) {
                // html += '<button type="button" class="btn btn-success btn_verifyed" value="' + full["directory_id"] + '" data-toggle="tooltip" title="Verify"><i class="fa fa-check" aria-hidden="true"></i></button>';
                html += '<button type="button" class="btn btn-success btn_verifyed" value="' + full["directory_id"] + '" data-vdir_type="' + full["direcory_type_id"] + '" data-toggle="tooltip" title="Verified" '+window.status+'><i class="fa fa-check" aria-hidden="true"></i></button>';
            } else {
                // html += '<button type="button" class="btn btn-warning btn_not_verify" value="' + full["directory_id"] + '" data-toggle="tooltip" title="Verify"><i class="fa fa-times" aria-hidden="true"></i></button>';
                html += '<button type="button" class="btn btn-warning btn_not_verify" value="' + full["directory_id"] + '" data-vdir_type="' + full["direcory_type_id"] + '" data-toggle="tooltip" title="Verify" '+window.status+'><i class="fa fa-spinner" aria-hidden="true"></i></button>';
            }
            html += '</div>';
            return html;

       }else if(window.groupName == "User III"){

        if (full["approve_stat"] == 1) {
                // html += '<button type="button" class="btn btn-success btn_verifyed" value="' + full["directory_id"] + '" data-toggle="tooltip" title="Verify"><i class="fa fa-check" aria-hidden="true"></i></button>';
                html += '<button type="button" class="btn btn-success btn_verifyed" value="' + full["directory_id"] + '" data-vdir_type="' + full["direcory_type_id"] + '" data-toggle="tooltip" title="Verified" '+window.status+'><i class="fa fa-check" aria-hidden="true"></i></button>';
            } else {
                // html += '<button type="button" class="btn btn-warning btn_not_verify" value="' + full["directory_id"] + '" data-toggle="tooltip" title="Verify"><i class="fa fa-times" aria-hidden="true"></i></button>';
                html += '<button type="button" class="btn btn-warning btn_not_verify" value="' + full["directory_id"] + '" data-vdir_type="' + full["direcory_type_id"] + '" data-toggle="tooltip" title="Verify" '+window.status+'><i class="fa fa-spinner" aria-hidden="true"></i></button>';
            }
        html += '</div>';
        return html;
        
       }else{
            html += '</div>';
            return html;
       }

       

    }

    // function viewEditDir(directory_id, appval, full_obj){

    //     // console.log(site_url + 'Add_calling_directory/edit_directories/' + directory_id + '/' + appval);
    //     window.location.href = site_url + 'Add_calling_directory/edit_directories/' + directory_id + '/' + appval;


    // }

    function active_stat(full) {
//    alert(full["approve_stat"] == 1);
        var appval = $('#approved_values').val();
        var html = '';
        var page_url = window.location.href;
        var enc_url = window.btoa(page_url); // encode a string
        html += '<div class="btn-group" role="group"  aria-label="" >';
<?php
$user3 = $this->config_variables->getVariable('fin_dev_user_3_group_id');
$user2 = $this->config_variables->getVariable('fin_dev_user_2_group_id');
$user1 = $this->config_variables->getVariable('fin_dev_user_1_group_id');

$user_see_id = $this->session->userdata('user_id');
$group_id = $this->userpermission->get_user_group($user_see_id);

if ($group_id != $user1 && $group_id != $user2 && $group_id != $user3) {
    ?>

            var active_status = full["active_status"];
            var finance_approve_stat = full["finance_approve_stat"];
            var approve_stat = full["approve_stat"];
            var html = '';

            if (approve_stat == 1 && finance_approve_stat == 1) {
                if (full["approve_stat"] == 1) {
                    if (full["active_status"] == 1 | full["active_status"] == 2) {
                        // if(window.status == "disabled"){
                            // html += '<button type="button" class="btn btn-success btn_act_stat" value="' + full["directory_id"] + '" data-toggle="tooltip" data-direcory_type_id="' + full["direcory_type_id"] + '" title="Application Status"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                            html += '<button type="button" class="btn btn-success btn_act_stat" value="' + full["directory_id"] + '" data-toggle="tooltip" data-direcory_type_id="' + full["direcory_type_id"] + '" title="Published" '+window.act_status+'><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                        // }else{
                            // html += '<button type="button" class="btn btn-success btn_act_stat" value="' + full["directory_id"] + '" data-toggle="tooltip" data-direcory_type_id="' + full["direcory_type_id"] + '" title="Application Status"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                            // html += '<button type="button" class="btn btn-success btn_act_stat" value="' + full["directory_id"] + '" data-toggle="tooltip" data-direcory_type_id="' + full["direcory_type_id"] + '" title="Application Status" onclick="changeStatus(' + full["directory_id"] + ',' + full["direcory_type_id"] +','+ full["active_status"] +')" '+window.status+'><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                        // }
                        
                    } else {
                        // if(window.status == "disabled"){
                            // html += '<button type="button" class="btn btn-warning btn_deact_stat" value="' + full["directory_id"] + '" data-toggle="tooltip" data-direcory_type_id="' + full["direcory_type_id"] + '" title="Verify"><i class="fa fa-times-circle" aria-hidden="true"></i></button>';
                            html += '<button type="button" class="btn btn-warning btn_deact_stat" value="' + full["directory_id"] + '" data-toggle="tooltip" data-direcory_type_id="' + full["direcory_type_id"] + '" title="Deactivated" '+window.act_status+'><i class="fa fa-times-circle" aria-hidden="true"></i></button>';
                        // }else{
                           // html += '<button type="button" class="btn btn-warning btn_deact_stat" value="' + full["directory_id"] + '" data-toggle="tooltip" data-direcory_type_id="' + full["direcory_type_id"] + '" title="Verify"><i class="fa fa-times-circle" aria-hidden="true"></i></button>';
                        //    html += '<button type="button" class="btn btn-warning btn_deact_stat" value="' + full["directory_id"] + '" data-toggle="tooltip" data-direcory_type_id="' + full["direcory_type_id"] + '" title="Verify" onclick="changeStatus(' + full["directory_id"] + ',' + full["direcory_type_id"] +','+ full["active_status"] +')" '+window.status+'><i class="fa fa-times-circle" aria-hidden="true"></i></button>';
                        // }    
                    }
                }
            }else{
            //   html += '<button type="button" class="btn btn" data-toggle="tooltip"  title="Finance Verification Needed"><i class="fa fa-times" aria-hidden="true"></i></button>';
              html += '<button type="button" class="btn btn" data-toggle="tooltip"  title="Finance Verification Needed" '+window.act_status+'><i class="fa fa-spinner" aria-hidden="true"></i></button>';
            }
<?php } else { ?>
            // html += '<button type="button" class="btn btn" value="" data-toggle="tooltip" data-direcory_type_id="" title="Not Authorized">Not Authorized</button>';
            // html += '<button type="button" class="btn btn" value="" data-toggle="tooltip" data-direcory_type_id="" title="Not Authorized" '+window.status+'>Not Authorized</button>';
<?php } ?>
        html += '</div>';
        return html;
    }


    function get_approve_stat(full) {
//    alert(full["approve_stat"] == 1);
        // console.log("View Test");
        // console.log(full);

        var active_status = full["active_status"];
        var finance_approve_stat = full["finance_approve_stat"];
        var approve_stat = full["approve_stat"];
        var html = '';
        var page_url = window.location.href;
        var enc_url = window.btoa(page_url); // encode a string

        // console.log("----URL-----");
        // console.log(page_url);
        // console.log(enc_url);
        if (active_status == 1 | active_status == 2) {
            html += '<button type="button" class="btn">Published</button>';
        }else if (approve_stat == 1 && finance_approve_stat == 1) {
            html += '<button type="button" class="btn">Finance Approved</button>';
        } else if (approve_stat == 1) {
            html += '<button type="button" class="btn">CEO Office Approved</button>';
        }else {
            html += '<button type="button" class="btn">Pending</button>';
        }
        html += '</div>';
        return html;
    }

    function getApplicationsList(full){
        var appval = $('#approved_values').val();
        var html = '';
        <?php if ($group_id == $user1 | $group_id == $user2 | $group_id == $user3) { ?>
            // var html = '';
        <?php }else{ ?>
            html += '<div class="btn-group" role="group" aria-label="" >';
            html += '<a class="btn btn-primary btn-list" href="' + site_url + 'Add_calling_directory/view_dir_applications/' + full["directory_id"] + '/' + full["direcory_type_id"] + '/' + appval +'" data-toggle="tooltip" title="View List"><i class="fa fa-list" aria-hidden="true"></i></a>&nbsp;';
            html += '</div>';
        <?php } ?>
        
        return html;
}

    function changeStatus(directory_id , dir_type, active_status) {
        
        $('#directory_id').val(directory_id);
        $('#dir_type').val(dir_type);
        $('#active_status').val(active_status);

        openModal();

    }
    
    function changeVerifyStatus(directory_id, dir_type, verify_status) {
        
        $('#vdirectory_id').val(directory_id);
        $('#vdir_type').val(dir_type);
        $('#verify_status').val(verify_status);

        // Verify_application(verify_id, '1');//verify_status

        openVerifyModal();
        //verifyModal//form_verify

    }

    function openModal(){
            
            // swal({
            //     title: "Are you sure?",
            //     text: "Do you want to change the status?",
            //     type: "info",
            //     showCancelButton: true,
            //     closeOnConfirm: true
            // }, function () {
            //     document.getElementById("form_active_status").reset();
            //     $('#comment').val(null);
            //     $('#myModal').modal('show');
            // });

            swal({
                title: "Are you sure?",
                text: "Do you want to change the active/publish status?",
                type: "info",
                showCancelButton: true,
            }).then(result => {
                
                if (result.value) {
                    document.getElementById("form_active_status").reset();
                    $('#comment').val(null);
                    $('#myModal').modal('show');
                } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
                ) {
                //none
                }
                swal.closeModal();
            });
     
        }
        function openVerifyModal(){
            
            swal({
                title: "Are you sure?",
                text: "Do you want to change the status?",
                type: "info",
                showCancelButton: true,
            }).then(result => {
                
                if (result.value) {
                    document.getElementById("form_verify").reset();
                    $('#vcomment').val(null);
                    $('#verifyModal').modal('show');
                } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
                ) {
                //none
                }
                swal.closeModal();
            });
     
        }

    $(document).on('click', '.btn_verifyed', function (event) {
//        var verify_id = $(this).val();
//        Verify_application(verify_id, '0');
    });
    $(document).on('click', '.btn_not_verify', function (event) {
        var verify_id = $(this).val();
        // Verify_application(verify_id, '1');//verify_status
        var directory_type_id = $(this).attr('data-vdir_type');
        changeVerifyStatus(verify_id, directory_type_id, 1);

    });
    function Verify_application(directory_id, varify_stat) {
//        alert(verify_id);
        var param = {};
        param.directory_id = directory_id;
        param.varify_stat = varify_stat;
        jQuery.post(site_url + 'Add_calling_directory/verify_the_application', param, function (response) {
            if (response !== null) {
                if (response.status == '1') {

                    var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    successmsg += response.msg;
                    successmsg += '</div>';
                    $("#message_notification").html(successmsg);
                    calling_directory_view();
                } else {
                    var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    errormsg += response.msg;
                    errormsg += '</div>';
                    $("#message_notification").html(errormsg);
                    calling_directory_view();
                }

            } else {
                swal("Failed!", "Record(s) could not be deleted!", "error");
            }
        }, 'json');
    }
// active status
    $(document).on('click', '.btn_deact_stat', function (event) {
        var act_id = $(this).val();
//        var directory_type_id = $(this).data('direcory_type_id');
        var directory_type_id = $(this).attr('data-direcory_type_id');
        // active_status_for_application(act_id, directory_type_id, '1');
       
        var param = {};
        param.directory_id = act_id;
        jQuery.post(site_url + 'Add_calling_directory/appExistsInDir', param, function (response) {
           
            console.log(response.status);
                //old//future//change//disabled
            
            if (response.status == 'old') {
                swal("No Permission!", "Sorry, You cannot publish an old directory!", "warning");
            } else if(response.status == 'future'){
                // swal("No Permission!", "Sorry, The opening date set, is in the future!", "warning");
                changeStatus(act_id , directory_type_id, 2); 
                
            }else if(response.status == 'disabled'){
                //none
            }else if(response.status == 'change'){
                swal("Notice!", "Please change the opening date before publishing!", "warning");
            }else {
            
                    if(window.groupName=="User II"){
                        swal("No Permission!", "Sorry, you do not have permission to publish!", "warning");
                    }else if(window.groupName=="User III"){
                        changeStatus(act_id , directory_type_id, 1); 
                    }else{
                     
                    }
                
            }

        }, 'json');
        
    });
    $(document).on('click', '.btn_act_stat', function (event) {
        var deact_id = $(this).val();
//        var directory_type_id = $(this).data('direcory_type_id');
        var directory_type_id = $(this).attr('data-direcory_type_id');
        // active_status_for_application(deact_id, directory_type_id, '0');

        changeStatus(deact_id , directory_type_id, 0);
    });
    function active_status_for_application(directory_id, directory_type_id, varify_stat) {
//        alert(directory_type_id);
        var param = {};
        param.directory_id = directory_id;
        param.varify_stat = varify_stat;
        param.directory_type_id = directory_type_id;
        jQuery.post(site_url + 'Add_calling_directory/activate_calling_directory', param, function (response) {
            if (response !== null) {
                if (response.status == '1') {

                    var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    successmsg += response.msg;
                    successmsg += '</div>';
                    $("#message_notification").html(successmsg);
                    calling_directory_view();
                } else {
                    var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    errormsg += response.msg;
                    errormsg += '</div>';
                    $("#message_notification").html(errormsg);
                    calling_directory_view();
                }

            } else {
                swal("Failed!", "Record(s) could not be deleted!", "error");
            }
        }, 'json');
    }

    function calling_directory_view() {
        $('#view_adjudication_application').DataTable({

            "responsive": true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollX": false,
            language: {
                searchPlaceholder: "Title, Created Date"
            },
            "ajax": {
                "url": site_url + "/Add_calling_directory/load_calling_directory_data",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {
                        "approved_val": $('#approved_values').val(),
                        "dir_type": $('#dir_dropdown').val(),
                        "status": $('#status_dropdown').val()
                    });
                }
            },
            "columns": [
                {"data": "directory_type"},
                {"data": "directory_title"},
                {"data": "reg_open_date"},
                {"data": "reg_closing_date"},
                {"data": "directory_id"},
                {"data": "directory_id"},
                {"data": "directory_id"},
                {"data": "directory_id"}
            ],
            "columnDefs": [
                {
                    "targets": -4,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return get_approve_stat(full);
                    }

                },
                {
                    "targets": -3,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getJtableBtnHtml(full);
                    }

                },
                {
                    "targets": -2,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return active_stat(full);
                    }

                },
                {
                    "targets": -1,
                    "data": "7",
                    "render": function (data, type, full, meta) {
                        return getApplicationsList(full);
                    } 
                }
//                {
//                    "targets": 4,
//                    "orderable": true,
//                    "render": function (data, type, full, meta) {
//                        var text = "";
//                        text += '<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn_inv_count" id="btn_inv_count" value="' + full["msg_id"] + '" data-invitetype="' + full["invitee_type"] + '" data-toggle="tooltip" title="Invites count"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
//                        return text;
//                    }
//                }
            ],
            "order": [[4, "desc"]],
            "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
            dom: 'fltip'
//                dom: 'lBfrtip',
//            buttons: [
//                {extend: 'excelHtml5', exportOptions: {
//                        columns: [0, 1, 3, 4]
//                    }, "text": '<i class="fa fa-file-excel-o" aria-hidden="true"></i>'}
//            ]

        });
    }

</script>




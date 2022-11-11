<script>
    $(document).ready(function() {
        $('#processdiv').attr('style', 'display: none');
        $('.datepicker').datetimepicker({
            format: 'YYYY'
        });
        $('.timepicker').datetimepicker({
            format: 'LT'
        });

    });
    $(document).ready(function() {
        var export_columns = [0, 1, 2, 3, 4, 5];
        var table = $('#mem_table').DataTable({
            dom: 'Bfrtlip', //'lBftipr',Bfrtlip
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            buttons: [,
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: export_columns
                    }

                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                },
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

        var export_columns = [0, 1, 2, 3, 4, 5];
        var table = $('#mem2_table').DataTable({
            dom: 'Bfrtlip', //'lBftipr',Bfrtlip
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            buttons: [,
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: export_columns
                    }

                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                },
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

        var export_columns = [0, 1, 2, 3, 4, 5];
        var table = $('#mem3_table').DataTable({
            dom: 'Bfrtlip', //'lBftipr',Bfrtlip
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            buttons: [,
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: export_columns
                    }

                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                },
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
        var export_columns = [0, 1, 2, 3, 4, 5];
        var table = $('#mem4_table').DataTable({
            dom: 'Bfrtlip', //'lBftipr',Bfrtlip
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            buttons: [,
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: export_columns
                    }

                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                },
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
        var export_columns = [0, 1, 2, 3, 4, 5];
        var table = $('#mem5_table').DataTable({
            dom: 'Bfrtlip', //'lBftipr',Bfrtlip
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            buttons: [,
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: export_columns
                    }

                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                },
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: export_columns
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
        //        $(".edit_user").click(function(){
        $(document).on('click', '.edit_user', function(event) {
            var user_id = $(this).attr("id");
            var group_status = $(this).attr("groupstatus");
            console.log(user_id);
            var param = {
                user_id: user_id,
                gr_sts: group_status
            };
            $.ajax({
                url: site_url + '/MemberManagementController/getUserDtails',
                method: "POST",
                dataType: "json",
                data: param,
                success: function(data) {
                    console.log(data);
                    if (data) {

                        console.log("--------");
                        console.log(data);
                        console.log("--------");

                        $("#employee_name").val(data.name_initials);
                        $("#employee_no").val(data.employee_no);
                        $('#user_group [value=' + data.group_id + ']').attr('selected', 'true');
                        $('#division [value=' + data.division + ']').attr('selected', 'true');

                        if (data.comment != "") {
                            var commentdate = new Date(data.comment_date);
                            commentdate = commentdate.toISOString().slice(0, 10)
                            var commenttime = new Date(data.comment_date).toLocaleTimeString();
                            var comment_string = " Comment - " + data.comment + "\n" + " Date - " + commentdate + " Time - " + commenttime;
                            $("#status_comment").val(comment_string);
                        } else {
                            $("#status_comment").val("");
                        }

                        //  $('#user_status [value='+data.active+']').attr('selected', 'true'); user_group group_id

                        $("#user_group").val(data.group_id);

                        console.log(data.active);


                        //         $user_details->payment_year = "";
                        // $user_details->payment_amount = "";
                        // $user_details->payment_comment = "";
                        // $user_details->payment_slip = "";
                        // $user_details->payment_date = "";


                        // $("#payment_year").val(data.payment_year);
                        // $("#payment_amount").val(data.payment_amount);
                        // $("#payment_comment").val(data.payment_comment);
                        // $("#payment_year").val(data.payment_slip);

    //             if (data.payment_slip != null){     
    //                 attachment_download = "";
    //                 //payment_slip_input
    //                // $('#payment_slip_input').attr('style', 'display: none');
    //     attachment_download += '<a target="_blank" href="uploads/Payment_slips/'+user_id+'/' + data.payment_slip + '">'
    //     attachment_download += '<i class="fa fa-certificate btn btn-primary"> View Attachment </i>'
    //     attachment_download += '</a>';

    //     $("#payment_slip_div").html(attachment_download);
    
    // } 


                        if (data.active == 0) {
                            $("#user_status").val(0);
                            $("#user_status option[value=1]").prop('disabled', true);
                        } else if (data.active == 1) {
                            $("#user_status").val(1);
                            $("#user_status option[value=1]").prop('disabled', true);
                        } else if (data.active == 2) {
                            $("#user_status").val(2);
                            $("#user_status option[value=1]").prop('disabled', true);
                        } else if (data.active == 3) {
                            $("#user_status").val(3);
                            $("#user_status option[value=1]").prop('disabled', true);
                        } else if (data.active == 4) {
                            $("#user_status").val(4);
                            $("#user_status option[value=1]").prop('disabled', false);
                        } else if (data.active == 5) {
                            $("#user_status").val(5);
                            $("#user_status option[value=1]").prop('disabled', true);
                        } else if (data.active == 7) {
                            $("#user_status").val(7);
                            $("#user_status option[value=1]").prop('disabled', true);
                            // $('#payment_div').attr('style', 'display: true');
                            // $('#payment_year').prop("disabled", true);
                            // $('#payment_amount').prop("disabled", true);
                            // $('#payment_comment').prop("disabled", true);
                            // $('#payment_slip').prop("disabled", true);
                            // $("#payment_status").val(0);
                        }

                        $("#user_id").val(data.id);
                        $('#user_edit_modal').modal('show');
                    } else {
                        Swal("Oops!", "You have not access permission", "warning");
                    }
                }
            });
        });



        //view staff member details view_staff <!-- user_status_modal -->

        $(document).on('click', '.view_staff', function(event) {
            var firstname = $(this).attr("fname");
            var lastname = $(this).attr("lname");
            var email = $(this).attr("email");
            var nic = $(this).attr("nic");
            var iname = $(this).attr("iname");



            $("#v_first_name").val(firstname);
            $("#v_last_name").val(lastname);
            $('#v_name_initials').val(iname);
            $('#v_nic').val(nic);
            $('#v_email').val(email);

            $('#view_stff_member_modal').modal('show');

        });






        $("#save_user_btn").click(function(event) {
            event.preventDefault();

            var elmForm = $("#edit_user_form");
            elmForm.validator('update');
            elmForm.validator('validate');
            var elmErr = elmForm.find('.has-error');

            if (elmErr && elmErr.length > 0) {
                return false;
            } else {
                $("#edit_user_form").submit();

            }
        });
        $('#edit_user_form').submit(function(event) {
            $('#processdiv').attr('style', 'display: true');
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: site_url + '/MemberManagementController/MemberActivation',
                data: formData,
                success: function(data) {
                    $('#processdiv').attr('style', 'display: none');

                    if (data.status = 1) {
                        //     console.log("----------------");
                        //    console.log(data.msg);
                        //    console.log("----------------");
                        Swal("Success", data.msg, "success").then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal("Oops!", data.msg, "warning");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });



    $(document).on('click', '.delete_user', function(event) {
        var user_id = $(this).data("value");
        var param = {
            user_id: user_id
        };

        $.ajax({
            url: site_url + '/Auth/remove_user',
            method: "POST",
            dataType: "json",
            data: param,
            success: function(data) {
                Swal('Updated', 'User has been deactivated', 'success');
                setTimeout(function() {
                    location.reload();
                }, 800);
            }
        });

        console.log();
    });



    $("#user_status").change(function() {
        console.log("in->change");
        statusval = $("#user_status").val();

        if (statusval == 6) {
            console.log("in->change->if");
            $('#user_group').prop("required", false);
            $('#payment_div').attr('style', 'display: none');
            $('#payment_year').prop("required", false);
            $('#payment_amount').prop("required", false);
            $('#payment_comment').prop("required", false);
            $('#payment_slip').prop("required", false);
            $("#payment_status").val(0);
        } else if (statusval == 7) {

            $('#payment_div').attr('style', 'display: true');
            $('#payment_year').prop("required", true);
            $('#payment_amount').prop("required", true);
            $('#payment_comment').prop("required", true);
            $('#payment_slip').prop("required", true);
            $("#payment_status").val(1);

        } else if (statusval == 1) {

            $('#payment_div').attr('style', 'display: true');
            $('#payment_year').prop("required", true);
            $('#payment_amount').prop("required", true);
            $('#payment_comment').prop("required", true);
            $('#payment_slip').prop("required", true);
            $("#payment_status").val(1);
        } else {
            console.log("in->change-else");
            $('#user_group').prop("required", true);
            $('#payment_div').attr('style', 'display: none');
            $('#payment_year').prop("required", false);
            $('#payment_amount').prop("required", false);
            $('#payment_comment').prop("required", false);
            $('#payment_slip').prop("required", false);
            $("#payment_status").val(0);
        }

    });


    //document_name
    $('#payment_slip').change(function() {

        fileName = document.querySelector('#payment_slip').value;
        extension = fileName.split('.').pop();
        const fi = document.getElementById('payment_slip');
        const fileSize = fi.files[0].size / 1024 / 1024

        if (extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'pdf') {



            if (fileSize >= 5) {

                // alert("File too Big, please select a file less than 4mb");
                swal('File Upload', 'File too Big, please select a file less than 4mb', 'error');
                $('#payment_slip').val("");
            }

            //  file_name_text =  fileName.split('\\').pop();


        } else {
            swal('File Upload', 'File Upload failed ! Please check file format', 'error');
            //alert('File Upload failed ! Please Select Image (JPG , JPEG , PNG)', 'error');
            $('#payment_slip').val("");

        }


    });

    $('#user_edit_modal').on('hidden.bs.modal', function() {
        //  console.log("in-->");
        window.location.href = "<?php base_url() . 'member-management' ?>";
    })


    // $('#A1_start_date').prop("required", true);
    //    $('#but2').attr('style','display: none');
    //$('#but3').attr('style','display: true');

    // $('#payment_div').attr('style','display: true');
    //                             $('#payment_year').prop("required", true);
    //                             $('#payment_amount').prop("required", true);
    //                             $('#payment_comment').prop("required", true);
    //                             $('#payment_slip').prop("required", true);
</script>
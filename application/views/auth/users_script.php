<script>
    $(document).ready(function() {
        var export_columns = [0, 1, 2, 3, 4, 5];
        var table = $('#user_table').DataTable({
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
 $('#search_By_user_group').on('change', function () {
        table
        .column(6)
        .search(this.value)
        .draw();
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
                url: site_url + '/Auth/getUserDtails',
                method: "POST",
                dataType: "json",
                data: param,
                success: function(data) {
                    if (data) {

                        console.log("--------");
                        console.log(data.active);
                        console.log("--------");

                        $("#employee_name").val(data.name_initials);
                        $("#employee_no").val(data.employee_no);
                        $('#user_group [value=' + data.group_id + ']').attr('selected', 'true');
                        $('#division [value=' + data.division + ']').attr('selected', 'true');
                        
                        if( data.comment != "" ){
                            var commentdate = new Date(data.comment_date);
                        commentdate = commentdate.toISOString().slice(0, 10)
                        var commenttime = new Date(data.comment_date).toLocaleTimeString();
                        var comment_string = " Comment - " + data.comment + "\n" + " Date - " + commentdate + " Time - " + commenttime;
                        $("#status_comment").val(comment_string);
                        }else{
                            $("#status_comment").val("");
                        }

                    
                        $('#user_status [value=' + data.active + ']').attr('selected', 'true');

                        if (data.active == 0) {
                            $("#user_status").val(0);
                        } else if (data.active == 1) {
                            $("#user_status").val(1);
                        } else if (data.active == 2) {
                            $("#user_status").val(0);
                        } else if (data.active == 3) {
                            $("#user_status").val(0);
                        } else if (data.active == 4) {
                            $("#user_status").val(1);
                        } else if (data.active == 5) {
                            $("#user_status").val(0);
                        }else if (data.active == 7) {
                            $("#user_status").val(0);
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
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: site_url + '/Auth/userActivation',
                data: formData,
                success: function(data) {

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
</script>
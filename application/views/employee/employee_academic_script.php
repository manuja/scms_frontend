<script>
    $(document).ready(function () {
        //Initiate date
        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $(".delete_btn").on('click',function () {
//            event.preventDefault();
            var academic_id = $(this).data('id');
            
            swal({
            title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('EmployeeController/deleteAcademicData'); ?>',
                        data: {
                            'academic_id':academic_id
                        },
                        success: function (data) {
                            var res = JSON.parse(data);
                            if (res.status == 1) {
                                swal({
                                    title: 'The record was removed!',
                                    type: 'success'
                                }).then(function () {
                                    window.location.reload();
                                });
                            } else {
                                swal({
                                    title: 'Error!',
                                    text: 'The record is not remove',
                                    type: 'error'
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(textStatus);
                        }
                    });
                }
            }); 
        });
    });
    
    $(document).on('click', '.btn_view', function () {
        var academic_id = $(this).data('id');
        var btn_id = $(this).attr('id');
        if (btn_id == 'btn_edit') {
            $('#old_degree_level').prop('disabled', false);
            $('#old_field').prop('readonly', false);
            $('#old_university').prop('readonly', false);
            $('#old_start_date').prop('readonly', false);
            $('#old_end_date').prop('readonly', false);
            $("#academic_doc").css('display', 'block');
            $("#update_btn").show();
        } else {
            $('#old_degree_level').prop('disabled', true);
            $('#old_field').prop('readonly', true);
            $('#old_university').prop('readonly', true);
            $('#old_start_date').prop('readonly', true);
            $('#old_end_date').prop('readonly', true);
            $("#academic_doc").css('display', 'none');
            $("#update_btn").hide();
        }

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('EmployeeController/getAcademicData') ?>",
            data: {
                'academic_id': academic_id
            },
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                var degree_level = data[0].degree_level;
                var html = '';
                console.log(degree_level);
                $('#old_degree_level').val(degree_level).attr("selected", "selected");
                $("#old_field").val(data[0].field);
                $("#old_university").val(data[0].university);
                $("#old_start_date").val(data[0].start_date);
                $("#old_academic_doc").val(data[0].attachment);
                $("#old_end_date").val(data[0].end_date);
                $("#emp_academic_id").val(data[0].emp_academic_id);
                if (data[0].attachment != "") {
                    html = "<br /><a class='btn btn-info btn-sm' href='<?php echo base_url('uploads/employee_academic_docs/'); ?>" + data[0].attachment + "' target='_blank'>View Attachment</a>";
                    $("#view_doc").html(html);
                } else {
                    $("#view_doc").html(html);
                }
            }
        });
        $('#academic_modal').modal('show');
    });

</script>

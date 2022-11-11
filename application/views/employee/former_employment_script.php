<script>
$(document).ready(function(){
    //Initiate date
    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    $(".delete_btn").on('click',function () {
//            event.preventDefault();
            var former_emp_id = $(this).data('id');
            
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
                        url: '<?php echo base_url('EmployeeController/deleteFormerEmploymentData'); ?>',
                        data: {
                            'former_emp_id':former_emp_id
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
                                    text: 'The record was not removed',
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
        var former_emp_id = $(this).data('id');
        var btn_id = $(this).attr('id');
        if (btn_id == 'btn_edit') {
            $('#job_title').prop('disabled', false);
            $('#organization').prop('readonly', false);
            $('#from').prop('readonly', false);
            $('#till').prop('readonly', false);
            $('#description').prop('readonly', false);
            $("#emp_doc").css('display', 'block');
            $("#update_btn").show();
        } else {
            $('#job_title').prop('disabled', true);
            $('#organization').prop('readonly', true);
            $('#from').prop('readonly', true);
            $('#till').prop('readonly', true);
            $('#description').prop('readonly', true);
            $("#emp_doc").css('display', 'none');
            $("#update_btn").hide();
        }

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('EmployeeController/getFormerEmploymentData') ?>",
            data: {
                'former_emp_id': former_emp_id
            },
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
               
                var html = '';
                $('#job_title').val(data[0].job_title);
                $("#organization").val(data[0].organization);
                $("#from").val(data[0].from_date);
                $("#till").val(data[0].to_date);
                $("#description").val(data[0].description);
                $("#old_emp_doc").val(data[0].attachment);
                $("#former_emp_id").val(data[0].emp_former_employment_id);
                if (data[0].attachment != "") {
                    html = "<br /><a class='btn btn-info btn-sm' href='<?php echo base_url('uploads/emp_employment_docs/'); ?>" + data[0].attachment + "' target='_blank'>View Attachment</a>";
                    $("#view_doc").html(html);
                } else {
                    $("#view_doc").html(html);
                }
            }
        });
        $('#femployment_modal').modal('show');
    });

</script>

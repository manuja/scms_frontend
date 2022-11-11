<script>
$(document).ready(function(){
       
    $(".delete_btn").on('click',function () {
//            event.preventDefault();
            var emp_doc_id = $(this).data('id');
            
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
                        url: '<?php echo base_url('EmployeeController/deleteOtherDocument'); ?>',
                        data: {
                            'emp_doc_id':emp_doc_id
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
        var attachment_id = $(this).data('id');
        var btn_id = $(this).attr('id');
        if (btn_id == 'btn_edit') {
            $('#doc_type').prop('disabled', false);
            $('#comment').prop('readonly', false);
            $("#other_doc").css('display', 'block');
            $("#update_btn").show();
        } else {
            $('#doc_type').prop('disabled', true);
            $('#comment').prop('readonly', true);
            $("#other_doc").css('display', 'none');
            $("#update_btn").hide();
        }

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('EmployeeController/getOtherDocumentData') ?>",
            data: {
                'attachment_id': attachment_id
            },
            success: function (data) {
                data = JSON.parse(data);
//                console.log(data);
                var doc_type = data[0].doc_type;
                var html = '';
                $('#doc_type').val(doc_type).attr("selected", "selected");
                $('#comment').val(data[0].comment);
                $("#old_other_doc").val(data[0].attachement);
                $("#other_doc_id").val(data[0].attachment_id);
                if (data[0].attachement != "") {
                    html = "<br /><a class='btn btn-info btn-sm' href='<?php echo base_url('uploads/emp_other_docs/'); ?>" + data[0].attachement + "' target='_blank'>View Attachment</a>";
                    $("#view_doc").html(html);
                } else {
                    $("#view_doc").html(html);
                }
            }
        });
        $('#other_doc_modal').modal('show');
    });

</script>

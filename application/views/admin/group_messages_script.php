<script>
    $(document).ready(function () {
        membership_group_messages_view();
    });

    function membership_group_messages_view() {

        mem_group_messages = $('#group_messages_view').DataTable({

            "responsive": true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollX": false,
            language: {
                searchPlaceholder: "Title, created Date"
            },
            "ajax": {
                "url": site_url + "/Membership_Groups/membership_group_messages_views",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {
                        "group_id": $('#group_id').val()
                    });
                }
            },

            "columns": [
                {"data": "msg_title"},
                {"data": "message"},
//                {"data": "meeting_date"},
                {"data": "msg_created_date"},
                {"data": "username"},
//                {"data": "invitee_type"},
                {"data": "msg_id"}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getJtableBtnHtml(full);
                    }

                },
                {
                    "targets": 4,
                    "orderable": true,
                    "render": function (data, type, full, meta) {
                        var text = "";
                        text += '<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn_inv_count" id="btn_inv_count" value="' + full["msg_id"] + '" data-invitetype="' + full["invitee_type"] + '" data-toggle="tooltip" title="Invites count"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                        return text;
                    }
                }
            ],
//            "order": [[5, "desc"]],
            "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
            dom: 'fltip',
//                dom: 'lBfrtip',
//            buttons: [
//                {extend: 'excelHtml5', exportOptions: {
//                        columns: [0, 1, 3, 4]
//                    }, "text": '<i class="fa fa-file-excel-o" aria-hidden="true"></i>'}
//            ]

        });
    }

    function getJtableBtnHtml(full) {
        var html = '';
        var page_url = window.location.href;
        var enc_url = window.btoa(page_url); // encode a string
        html += '<div class="btn-group" role="group"  aria-label="" >';
        html += '<a class="btn btn-primary btn-edit" href="' + site_url + 'Membership_Groups/edit_send_message/' + full["msg_id"] + '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';

//        html += '<a class="btn btn-danger btn-delete" href="' + site_url + 'membership_groups/add_members_to_group" data-toggle="tooltip" title="Add members to group"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;';
        html += '<button type="button" class="btn btn-danger btn_del" value="' + full["msg_id"] + '" data-toggle="tooltip" title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button>';

        html += '</div>';
        return html;
    }


    $(document).on('click', '.btn_del', function (event) {
        var del_met = $(this).val();
        deleteMsgRecord(del_met);
    });


    function deleteMsgRecord(del_msg) {
//        alert(del_met);
        var param = {};
        param.del_msg = del_msg;
        jQuery.post('<?php echo site_url("Membership_Groups/delete_meesages") ?>', param, function (response) {
            if (response !== null) {
                if (response.status == '1') {
                    var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    successmsg += 'Successfully deleted';
                    successmsg += '</div>';
                    $("#message_notification").html(successmsg);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);

                } else {
                    var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    errormsg += 'Failed to delete data';
                    errormsg += '</div>';
                    $("#message_notification").html(errormsg);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }

            } else {
                swal("Failed!", "Record(s) could not be deleted!", "error");
            }
        }, 'json');
    }
    function meeting_record_count(del_met, inv_type) {
        var param = {};
        param.del_met = del_met;
        param.inv_type = inv_type;
        
        jQuery.post('<?php echo site_url("Membership_Groups/get_invitee_count") ?>', param, function (response) {

            if (response !== null) {
                $('#tot_invites').html(response);

            }
        }, 'json');
    }

</script>




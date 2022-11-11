
<script>
    $(document).ready(function () {
        membership_group_meetings_view();
    });

    function membership_group_meetings_view() {
//            alert();
        mem_group_meeting = $('#group_meetings_view').DataTable({

            "responsive": true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollX": false,
            language: {
                searchPlaceholder: "Title, meeting Date"
            },
            "ajax": {
                "url": site_url + "/Membership_Groups/membership_group_meetings_view",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {
                        "group_id": $('#group_id').val()
                    });
                }
            },

            "columns": [
                {"data": "meeting_title"},
                {"data": "meeting_description"},
                {"data": "meeting_date"},
                {"data": "meeting_time_from"},
                {"data": "meeting_venue"},
                {"data": "meeting_created_date"},
                {"data": "username"},
                {"data": "meeting_id"},
                {"data": "meeting_id"}
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
                    "targets": 7,
                    "orderable": true,
                    "render": function (data, type, full, meta) {
                        var text = "";
                        text += '<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-warning btn_inv_count" id="btn_inv_count" value="' + full["meeting_id"] + '" data-invitetype="' + full["invite_type"] + '" data-toggle="tooltip" title="Invites count"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                        return text;
                    }
                }
            ],
//            "order": [[5, "desc"]],
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

    function getJtableBtnHtml(full) {
        var html = '';
        var page_url = window.location.href;
        var enc_url = window.btoa(page_url); // encode a string
        html += '<div class="btn-group" role="group"  aria-label="" >';
        html += '<a class="btn btn-primary btn-edit" href="' + site_url + 'Membership_Groups/edit_meeting_data/' + full["meeting_id"] + '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';

//        html += '<a class="btn btn-danger btn-delete" href="' + site_url + 'membership_groups/add_members_to_group" data-toggle="tooltip" title="Add members to group"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;';
        html += '<button type="button" class="btn btn-danger btn_del" value="' + full["meeting_id"] + '" data-toggle="tooltip" title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button>';

        html += '</div>';
        return html;
    }


    $(document).on('click', '.btn_del', function (event) {
        var del_met = $(this).val();
        deleteMeetingRecord(del_met);
    });
    $(document).on('click', '.btn_inv_count', function (event) {
        var inv_count = $(this).val();
//        var inv_count = $(this).val();
        var inv_type = this.getAttribute('data-invitetype');
//        alert(inv_count);
        meeting_record_count(inv_count, inv_type);
    });


    function deleteMeetingRecord(del_met) {
        var param = {};
        param.del_met = del_met;
        var url = site_url + 'Membership_Groups/delete_meetings';
        jQuery.post(url, param, function (response) {
            console.log(response);
            if (response !== null) {
                if (response.status == '1') {
                    var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    successmsg += 'Successfully deleted';
                    successmsg += '</div>';
                    $("#mem_group_view_div").html(successmsg);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);

                } else {
                    var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    errormsg += 'Failed to delete data';
                    errormsg += '</div>';
                    $("#mem_group_view_div").html(errormsg);
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
        var url = site_url + 'Membership_Groups/get_invitee_count';
        jQuery.post(url, param, function (response) {
//console.log(response);
            if (response !== null) {



                if (response[0].invites) {
                    $('#tot_invites').html(response[0].invites);

                } else {
                    $('#tot_invites').html('0');
                }
                if (response[0].confirmed) {
                    $('#tot_confirmed').html(response[0].confirmed);

                } else {
                    $('#tot_confirmed').html('0');
                }
                if (response[0].reject) {
                    $('#tot_reject').html(response[0].reject);

                } else {
                    $('#tot_reject').html('0');
                }



            }
        }, 'json');
    }


</script>
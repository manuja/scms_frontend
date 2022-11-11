<script>
    $(document).ready(function () {
        users_view();
    });

    function users_view() {

        mem_group_messages = $('#users_view').DataTable({

            "responsive": true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollX": false,
            language: {
                searchPlaceholder: "Name, Email"
            },
            "ajax": {
                "url": site_url + "/Users_new/users_view",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {
                        "group_id": $('#search_groups').val()
                    });
                }
            },

            "columns": [
                {"data": "first_name"},
                {"data": "last_name"},
                {"data": "email"},
                {"data": "group_name"},
                {"data": "active"},
                {"data": "id"}
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
                        if (full["active"] == 1) {

                            text += '<a style="padding:0px; width: 82px; height: 26px;" class="btn btn-success" href="' + site_url + 'auth/deactivate/' + full["id"] + '" data-toggle="tooltip" title="Active">Active &nbsp; <i class="	fa fa-check-square-o" aria-hidden="true"></i></a>&nbsp;';
                            return text;
                        } else if (full["active"] == 0) {
                            text = "";
                            text += '<a style="padding:0px; width: 82px; height: 26px;" class="btn btn-danger" href="' + site_url + 'auth/activate/' + full["id"] + '" data-toggle="tooltip" title="Inactive">Inactive &nbsp; <i class="fa fa-close" aria-hidden="true"></i></a>&nbsp;';
                            return text;
                        }
                    }
                }
            ],
//            "order": [[5, "desc"]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
//            dom: 'fltip',
            dom: 'lBfrtip',
            buttons: [
//                'copyHtml5',
                'excelHtml5',
//                'csvHtml5',
                'pdfHtml5'
            ]

        });
    }

    function getJtableBtnHtml(full) {
        var html = '';
        var page_url = window.location.href;
        var enc_url = window.btoa(page_url); // encode a string

        html += '<div class="btn-group" role="group"  aria-label="" >';
        html += '<a class="btn btn-primary btn-edit" href="' + site_url + 'auth/edit_user/' + full["id"] + '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';

//        html += '<a href="#" data-toggle="tooltip" class="btn btn-danger delete_user" data-value="' + full["id"] + '" title="Delete user"><i class="fa fa-times" aria-hidden="true"></i></a>';

        html += '</div>';
        return html;
    }


//    $(document).on('click', '.btn_del', function (event) {
//        var del_met = $(this).val();
//        deleteMsgRecord(del_met);
//    });


    $(document).on('click', '#search_groups', function (event) {
        users_view();
    });


</script>




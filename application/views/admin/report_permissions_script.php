<script>
    var ceo_user1_group_id = <?php echo $this->config_variables->getVariable('ceo_user1_group_id'); ?>;
    var ceo_user2_group_id = <?php echo $this->config_variables->getVariable('ceo_user2_group_id'); ?>;
    var ceo_user3_group_id = <?php echo $this->config_variables->getVariable('ceo_user3_group_id'); ?>;

    var pub_dev_user_1_group_id = <?php echo $this->config_variables->getVariable('pub_dev_user_1_group_id'); ?>;
    var pub_dev_user_2_group_id = <?php echo $this->config_variables->getVariable('pub_dev_user_2_group_id'); ?>;
    var pub_dev_user_3_group_id = <?php echo $this->config_variables->getVariable('pub_dev_user_3_group_id'); ?>;

    var fin_dev_user_1_group_id = <?php echo $this->config_variables->getVariable('fin_dev_user_1_group_id'); ?>;
    var fin_dev_user_2_group_id = <?php echo $this->config_variables->getVariable('fin_dev_user_2_group_id'); ?>;
    var fin_dev_user_3_group_id = <?php echo $this->config_variables->getVariable('fin_dev_user_3_group_id'); ?>;

    var edu_user_1_group = <?php echo $this->config_variables->getVariable('edu_user_1_group'); ?>;
    var edu_user_2_group = <?php echo $this->config_variables->getVariable('edu_user_2_group'); ?>;
    var edu_user_3_group = <?php echo $this->config_variables->getVariable('edu_user_3_group'); ?>;


    var managerialUserLevel = <?php echo $this->config_variables->getVariable('managerialUserLevel'); ?>;
    var topManagementUserLevel = <?php echo $this->config_variables->getVariable('topManagementUserLevel'); ?>;
    var pub_dev_parent_id = <?php echo $this->config_variables->getVariable('pub_dev_parent_id'); ?>;
    var operationalUserLevel = <?php echo $this->config_variables->getVariable('operationalUserLevel'); ?>;

//    var user_id = <?php // echo $this->session->userdata('user_id');              ?>;
    var group_id = <?php echo getGroupIdFromUserId($this->session->userdata('user_id')); ?>;

    $(document).ready(function () {
        var userid = '';
//        if ((group_id == ceo_user1_group_id) || (group_id == ceo_user2_group_id) || (group_id == ceo_user3_group_id) || (group_id == pub_dev_user_1_group_id) || (group_id == pub_dev_user_2_group_id) || (group_id == pub_dev_user_3_group_id) || (group_id == fin_dev_user_1_group_id) || (group_id == fin_dev_user_2_group_id) || (group_id == fin_dev_user_3_group_id) || (group_id == edu_user_1_group) || (group_id == edu_user_2_group) || (group_id == edu_user_2_group) || (group_id == managerialUserLevel) || (group_id == topManagementUserLevel) || (group_id == pub_dev_parent_id) || (group_id == operationalUserLevel)) {
            
            if ((group_id == ceo_user3_group_id) ||  (group_id == pub_dev_user_3_group_id) || (group_id == fin_dev_user_3_group_id)  || (group_id == edu_user_3_group) || (group_id == managerialUserLevel) || (group_id == topManagementUserLevel)) {
            
            
            userid = 0;
        } else {
            userid = $('#user_id').val();

        }
//        alert(userid);
        report_permissons_view(userid);
    });
    function report_permissons_view(userid) {

        report_permission_view = $('#report_permission_view').DataTable({
            "responsive": true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollX": false,
            language: {
                searchPlaceholder: "Title, created Date"
            },
            "ajax": {
                "url": site_url + "/Report_permissions/report_permissons_view",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {
                        "userid": userid
                    });
                }
            },

            "columns": [
//                {"data": "first_name"},
                {"data": "last_name"},
                {"data": "report_name"},
                {"data": "created_date"},
                {"data": "permission_status"},
                {"data": "report_save_id"}
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
                    "targets": 3,
                    "orderable": true,
                    "render": function (data, type, full, meta) {
                        var text = "";
                        if (full["permission_status"] == 1) {
                            text = 'Permission Granted';
                        } else {
                            text = 'Permission Pending';
                        }
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
        html += '<div class="btn-group" role="group"  aria-label="" >';

//        var page_url = window.location.href;
//        var enc_url = window.btoa(page_url); // encode a string
        if (full["permission_status"] == 1 || (group_id == ceo_user3_group_id) ||  (group_id == pub_dev_user_3_group_id) || (group_id == fin_dev_user_3_group_id)  || (group_id == edu_user_3_group) || (group_id == managerialUserLevel) || (group_id == topManagementUserLevel)) {
            html += '<button type="button"  class=" btn btn-primary view_report" data-module_id="' + full["module_id"] + '" value="' + full["report_save_id"] + '" data-toggle="tooltip" title=""><i class="fa fa-eye" aria-hidden="true"></i></button>';
        } else {
            html += '<button type="button"  class=" btn btn-primary" data-toggle="tooltip" title="">Permission Denied</button>';
        }

        if ((group_id == ceo_user3_group_id) ||  (group_id == pub_dev_user_3_group_id) || (group_id == fin_dev_user_3_group_id)  || (group_id == edu_user_3_group) || (group_id == managerialUserLevel) || (group_id == topManagementUserLevel)) {
            if (full["permission_status"] == 1) {

            } else {
                html += '<button type="button"  class=" btn btn-success confirmation" value="' + full["report_save_id"] + '" data-toggle="tooltip" title=""><i class="fa fa-check-square" aria-hidden="true"></i></button>';

            }
        }
        html += '</div>';
        return html;
    }



    $(document).on('click', '.view_report', function (event) {
        var more_info = $(this).val();
        var module_id = $(this).data("module_id");
        submitDataByPost('View_saved_dynamic_reports/redirect_to_filter_view', 'report_id', more_info, 'module', module_id);
    });

    function submitDataByPost(submitPage, submitDataName, submitDataValue, submitDataName1, submitDataValue1) {
        $('<form action="' + submitPage + '" method="POST"/>')
                .append(jQuery('<input type="hidden" name="' + submitDataName + '" value ="' + submitDataValue + '">'))
                .append(jQuery('<input type="hidden" name="' + submitDataName1 + '" value ="' + submitDataValue1 + '">'))
                .appendTo(jQuery(document.body))
                .submit();
    }


    $(document).on('click', '.confirmation', function (event) {
        var report_id = $(this).val();
        confirmation_report(report_id);
    });


    function confirmation_report(report_id) {

//        alert(verify_id);
        var param = {
            report_id: report_id
        };

        jQuery.post(site_url + 'Report_permissions/report_confirmation_update', param, function (response) {

            if (response !== null) {
                if (response == '1') {
                    swal('Success', 'Saved Success', 'success');
                    report_permissons_view();

                } else {
                    swal("Failed!", "Status update failed!", "error");
                }

            } else {
                swal("Failed!", "Status update failed!", "error");
            }

        }, 'json');
    }

</script>




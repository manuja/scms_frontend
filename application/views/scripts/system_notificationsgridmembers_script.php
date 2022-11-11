<script type="text/javascript">

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

    });


    function loadDataTable(){
        var export_columns = [0, 1, 2, 4];
        //Load data table
        list_table = jQuery('#member_application_list_table').DataTable({
            destroy: true,
            language: {
                searchPlaceholder: "Search by Message, Excerpt"
            },
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "scrollY": "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo site_url(); ?>SystemNotification/getMemberRecords/"+<?php echo $this->session->userdata('user_id'); ?>,
                "type": "POST",
                "data": {
                    notification_category: $('#search_filter_noti_category').val(),
                    notification_priority: $('#search_filter_noti_priority').val(),
                    search_filter_date_from: $('#search_filter_date_from').val(),
                    search_filter_date_to: $('#search_filter_date_to').val(),
                    search_text: $('#search_filter_search').val()
                }
            },
            "columns": [
                {"data": "notification_category_name"},
                {"data": "notification_priority_name"},
                {"data": "notification_text_short"},
                {"data": "notification_text_long"},
                {"data": "notification_hyperlink"},
                {"data": "created_datetime"}
            ],
            "columnDefs": [

                {
                    "targets": -6,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getCategory(full);
                    }
                },
                {
                    "targets": -5,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getPriority(full);
                    }
                },
                {
                    "targets": -2,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getHyperlink(full);
                    }
                },
                { "width": "10px", "targets": -6 },
                { "width": "10px", "targets": -5 },
                { "width": "10px", "targets": -4 },
                { "width": "10px", "targets": -3 },
                { "width": "70px", "targets": -2 },
                { "width": "70px", "targets": -1 }
            ],
            "order": [
                [0, "desc"]
            ],
            dom: 'Brtlip',
            buttons: [

//                {
//                    extend: 'pdfHtml5',
//                    exportOptions: {
//                        columns: export_columns
//                    }
//                },
                {
                    extend: 'csvHtml5',
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
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    }

    function getPriority(full) {
        if(full["notification_priority_name"]){
            return full["notification_priority_name"];
        }else{
            return "N/A";
        }
    }

    function getCategory(full) {
        if(full["notification_category_name"]){
            return full["notification_category_name"];
        }else{
            return "N/A";
        }
    }
    
    function getHyperlink(full) {
        if(full["notification_hyperlink"]){
//            if(full["notification_hyperlink"].length >= 30){
//                return '<a target="_blank" href="'+full["notification_hyperlink"]+'">'+full["notification_hyperlink"].substring(0, 29)+'[...]</a>';
//            }else{
                return '<a target="_blank" href="'+full["notification_hyperlink"]+'">'+full["notification_hyperlink"]+'</a>';
//            }
        }else{
            return "N/A";
        }
    }


    function initiateDatePickers(){
        $('#search_filter_date_to').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        var todayDate = new Date().getDate();
        // $('#search_filter_date_from').data("DateTimePicker").defaultDate(new Date(new Date().setDate(todayDate - 6570)));
        $('#search_filter_date_from').datetimepicker({
            format: 'YYYY-MM-DD',
            maxDate: new Date(new Date().setDate(todayDate - 7))

        });

    }


    $(document).ready(function () {
        loadDataTable();
        initiateDatePickers();


        $('#search_filter_date_from, #search_filter_date_to').focusout(function (event) {

            loadDataTable();
            event.stopPropagation();
        });

        $('#search_filter_clear').click(function (event) {
            event.preventDefault();

            $('#search_filter_date_from, #search_filter_date_to').val("");
            $('#search_filter_noti_priority').val('');
            $('#search_filter_noti_category').val('');
            $('#search_filter_search').val('');

            loadDataTable();
        });

    });



</script>
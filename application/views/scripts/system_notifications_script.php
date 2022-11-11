<script type="text/javascript">

    $(document).ready(function(){

        $("#select1change_status").on("change", function() {
            if( $(this).val() == "select1value4" ){
                // show div
                $("#hidediv_on_change_status").fadeIn();
            }else{
                // hide div
                $("#hidediv_on_change_status").fadeOut();
            }
        });

        var memberName = $('#memberName');
        var appNo = $('#appNo');
        var userImg = $('#userImg');
        var membershipClass = $('#membershipClass');
        var engineeringDiscipline = $('#engineeringDiscipline');
        var memberNIC = $('#memberNIC');
        var dateSubmitted = $('#dateSubmitted');
        var memberStatus = $('#memberStatus');

        $('#app1').click(function() {
            memberName.text($('#name1').text());
            appNo.text($('#app1').text());
            userImg.prop('src', '<?php echo base_url(); ?>assets/dist/img/user4-128x128.jpg');
            membershipClass.text($('#memClass1').text());
            engineeringDiscipline.text($('#engDisc1').text());
            memberNIC.text($('#nic1').text());
            dateSubmitted.text($('#date1').text());
            memberStatus.text($('#status1').text());
        });

        $('#app2').click(function() {
            memberName.text($('#name2').text());
            appNo.text($('#app2').text());
            userImg.prop('src', '<?php echo base_url(); ?>assets/dist/img/user1-128x128.jpg');
            membershipClass.text($('#memClass2').text());
            engineeringDiscipline.text($('#engDisc2').text());
            memberNIC.text($('#nic2').text());
            dateSubmitted.text($('#date2').text());
            memberStatus.text($('#status2').text());
        });

        $('#app3').click(function() {
            memberName.text($('#name3').text());
            appNo.text($('#app3').text());
            userImg.prop('src', '<?php echo base_url(); ?>assets/dist/img/user4-128x128.jpg');
            membershipClass.text($('#memClass3').text());
            engineeringDiscipline.text($('#engDisc3').text());
            memberNIC.text($('#nic3').text());
            dateSubmitted.text($('#date3').text());
            memberStatus.text($('#status3').text());
        });

        $('#app4').click(function() {
            memberName.text($('#name4').text());
            appNo.text($('#app4').text());
            userImg.prop('src', '<?php echo base_url(); ?>assets/dist/img/user1-128x128.jpg');
            membershipClass.text($('#memClass4').text());
            engineeringDiscipline.text($('#engDisc4').text());
            memberNIC.text($('#nic4').text());
            dateSubmitted.text($('#date4').text());
            memberStatus.text($('#status4').text());
        });

        $('#app5').click(function() {
            memberName.text($('#name5').text());
            appNo.text($('#app5').text());
            userImg.prop('src', '<?php echo base_url(); ?>assets/dist/img/user4-128x128.jpg');
            membershipClass.text($('#memClass5').text());
            engineeringDiscipline.text($('#engDisc5').text());
            memberNIC.text($('#nic5').text());
            dateSubmitted.text($('#date5').text());
            memberStatus.text($('#status5').text());
        });

        $('#app6').click(function() {
            memberName.text($('#name6').text());
            appNo.text($('#app6').text());
            userImg.prop('src', '<?php echo base_url(); ?>assets/dist/img/user1-128x128.jpg');
            membershipClass.text($('#memClass6').text());
            engineeringDiscipline.text($('#engDisc6').text());
            memberNIC.text($('#nic6').text());
            dateSubmitted.text($('#date6').text());
            memberStatus.text($('#status6').text());
        });

        $('#app7').click(function() {
            memberName.text($('#name7').text());
            appNo.text($('#app7').text());
            userImg.prop('src', '<?php echo base_url(); ?>assets/dist/img/user4-128x128.jpg');
            membershipClass.text($('#memClass7').text());
            engineeringDiscipline.text($('#engDisc7').text());
            memberNIC.text($('#nic7').text());
            dateSubmitted.text($('#date7').text());
            memberStatus.text($('#status7').text());
        });

        $('#app8').click(function() {
            memberName.text($('#name8').text());
            appNo.text($('#app8').text());
            userImg.prop('src', '<?php echo base_url(); ?>assets/dist/img/user1-128x128.jpg');
            membershipClass.text($('#memClass8').text());
            engineeringDiscipline.text($('#engDisc8').text());
            memberNIC.text($('#nic8').text());
            dateSubmitted.text($('#date8').text());
            memberStatus.text($('#status8').text());
        });

        $('[data-toggle="tooltip"]').tooltip();

    });


    function loadDataTable(){
        var export_columns = [0, 1, 2, 4, 6, 7, 8];
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
                "url": "<?php echo site_url(); ?>SystemNotification/getRecords",
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
                {"data": "notification_id"},
                {"data": "notification_category_name"},
                {"data": "notification_priority_name"},
                {"data": "notification_text_short"},
                {"data": "notification_text_long"},
                {"data": "notification_hyperlink"},
                {"data": "created_datetime"},
                {"data": "expire_datetime"},
                {"data": "initiated_by"}
            ],
            "columnDefs": [

                {
                    "targets": -8,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getCategory(full);
                    }
                },
                {
                    "targets": -7,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getPriority(full);
                    }
                },
                {
                    "targets": -4,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getHyperlink(full);
                    }
                },
                { "width": "10px", "targets": -9 },
                { "width": "10px", "targets": -8 },
                { "width": "10px", "targets": -7 },
                { "width": "10px", "targets": -6 },
                { "width": "10px", "targets": -5 },
                { "width": "10px", "targets": -4 },
                { "width": "70px", "targets": -3 },
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
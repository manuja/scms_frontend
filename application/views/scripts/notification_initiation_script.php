<script>
    $(document).ready(function() {


        $(function () {
            var todayDate = new Date().getDate();

            $('.notification_expire').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: new Date(new Date().setDate(todayDate + 1))
            });
            $('.notification_expire').val(""); // to remove auto selected value
            $('.notification_expire').siblings('.exp-duration').html(""); // to remove auto selected value
        });

        $("#notification_expire").on("dp.change", function (e) {
            var todayDate = moment().format('YYYY-MM-DD');
            var pickedDate = $("#notification_expire").val();

            var momentToday = moment(todayDate);
            var momentPicked = moment(pickedDate);
            var duration = momentPicked.diff(momentToday, 'days');

            if(!pickedDate){
                $(this).siblings('.exp-duration').html("");
            }else {
                $(this).siblings('.exp-duration').html(duration + " Days from today");
            }
        });

        // single/bulk expand/collapse handle  -- start
        $(function () {
            // to make sure default configuration is bulk email sending
            // $("#notification_bulk_switch").prop('checked', false);
            // $("#notification_mass_head").trigger('click');
            $("#notification_single_head").trigger('click');
        });
        // $("#notification_bulk_switch").on('change', function (event) {
        //     event.preventDefault();
        //
        //     $('#notification_single').toggle();
        //     $('#notification_mass').toggle();
        //
        //     if($(this).is(':checked')){
        //         $('#single_member_id').prop('required', true);
        //         $('#single_member_name').prop('required', true);
        //         $('#single_member_memnum').prop('required', true);
        //         $('.filter-header:checked').trigger('click');
        //     }else{
        //         $('#single_member_id').prop('required', false);
        //         $('#single_member_name').prop('required', false);
        //         $('#single_member_memnum').prop('required', false);
        //         $('#single_member_id').val('');
        //         $('#single_member_name').val('');
        //         $('#single_member_memnum').val('');
        //     }
        // });
        $(".notification-section-head").on('click', function (event) {
            event.preventDefault();

            // $('#notification_single').toggle();
            // $('#notification_mass').toggle();
            if($(this).attr('id') == "notification_mass_head"){
                $('#notification_bulk_switch').val('0');
                // enable this tab 'required'

                // disable other tabs 'required'
                $('#single_member_id').prop('required', false);
                $('#single_member_name').prop('required', false);
                $('#single_member_memnum').prop('required', false);
                $('#single_member_id').val('');
                $('#single_member_name').val('');
                $('#single_member_memnum').val('');
            }else if($(this).attr('id') == "notification_single_head"){
                $('#notification_bulk_switch').val('1');
                // enable this tab 'required'
                $('#single_member_id').prop('required', true);
                $('#single_member_name').prop('required', true);
                $('#single_member_memnum').prop('required', true);
                $('.filter-header:checked').trigger('click');

                // disable other tabs 'required'
            }else if($(this).attr('id') == "notification_staff_head"){
                $('#notification_bulk_switch').val('2');
                // enable this tab 'required'

                // disable other tabs 'required'
                $('#single_member_id').prop('required', false);
                $('#single_member_name').prop('required', false);
                $('#single_member_memnum').prop('required', false);
                $('#single_member_id').val('');
                $('#single_member_name').val('');
                $('#single_member_memnum').val('');
            }
        });
        // single/bulk expand/collapse handle  -- end
        // filter block expand/collapse handle  -- start
        $(".filter-header").on('change', function (event) {
            event.preventDefault();

            var filter_header = $(this);
            var header_id = filter_header.attr('id');

            if(filter_header.is(':checked')) {
                $('div.' + header_id).fadeIn();
            }else{
                $('div.' + header_id).fadeOut().find('input[type=checkbox]').prop('checked', false);
            }
        });
        // filter block expand/collapse handle  -- end
        // character limit warnings -- start
        $('.length_limit').on('keyup', function (event) {
            event.preventDefault();

            var this_input = $(this);
            var this_input_name = this_input.attr('name');
            if(this_input_name == 'notification_text_short'){
                var max_length = 40;
            }
            if(this_input_name == 'notification_text_long'){
                var max_length = 90;
            }
            var characters_remaining = max_length - this_input.val().length;
            if(characters_remaining == max_length) {
                this_input.siblings('.character-limit').html("");
            }else{
                this_input.siblings('.character-limit').html("Characters Remaining: " + characters_remaining);
            }
        });
        // character limit warnings -- end


        // $('.checkbox-group').on('click', function (event) {
        //     // event.preventDefault();
        //     var check_state = $(this).is(':checked');
        //     var req_state = $(this).prop('required');
        //
        //
        //
        //     if(check_state === true && req_state === true){// checked AND req
        //         // remove 'req' of other checkboxes
        //
        //     }else if(check_state === true && req_state === false){// checked AND !req
        //         // do nothing
        //
        //     }else if(check_state === false && req_state === true){// !checked AND req
        //         // if there are more 'req' checkboxes,  remove 'req' of this one
        //         // if there are no more 'req'
        //
        //     }else{// !checked AND !req
        //
        //     }
        //
        //
        //
        //
        // });


        var inputMemName = $("#single_member_picker_name");
        var inputMemMemnum = $("#single_member_picker_memnum");
        var single_notification_block = $("#notification_single");
        // search by name
        $.get('../SystemNotification/fetchMembersByName/', function(data){
            inputMemName.typeahead({
                source: data,
                minLength: 3,
                highlight: true
            });
        }, 'json'); // search by member num
        $.get('../SystemNotification/fetchMembersByMemnum/', function(data){
            inputMemMemnum.typeahead({
                source: data,
                minLength: 3,
                highlight: true
            });
        }, 'json');

        // Search by name handle
        inputMemName.change(function(){
            var current = inputMemName.typeahead("getActive");

            $('#single_member_id').val(current.id);
            $('#single_member_name').val(current.name);
            $('#single_member_memnum').val(current.memnum);
            inputMemName.val('');
            inputMemMemnum.val('');
            single_notification_block.validator('validate'); // to remove validation errors
        });
        // Search by memnum handle
        inputMemMemnum.change(function(){
            var current = inputMemMemnum.typeahead("getActive");

            $('#single_member_id').val(current.id);
            $('#single_member_name').val(current.name2);
            $('#single_member_memnum').val(current.memnum);
            inputMemName.val('');
            inputMemMemnum.val('');
            single_notification_block.validator('validate'); // to remove validation errors
        });

        // show file name when a file is selected -- start
        $("input[type=file]").on("change", function () {
            $(this).parent().siblings(".file_info").html($(this)[0].files[0].name);
            $("#thumb_clear_button").fadeIn();
        });
        // show file name when a file is selected -- end

        // clear image button
        $("#thumb_clear_button").click(function (event) {
            event.preventDefault();
            $('#notification_thumbnail').val('').prop("required", false);
            $('.file_info').html('');
            $(this).fadeOut(2000);
        });

        $("#clear_single_member").click(function (event) {
            event.preventDefault();

            $('#single_member_picker_name').val('');
            $('#single_member_picker_memnum').val('');
            $('#single_member_id').val('');
            $('#single_member_name').val('');
            $('#single_member_memnum').val('');
            single_notification_block.validator('validate');
        });

        $("#submit_notification").on('click', function (event) {
            event.preventDefault();

            var notificationForm = $("#send_notification_form");
            notificationForm.validator('update');
            notificationForm.validator('validate');

            var notificationFormErr = notificationForm.find('.has-error');

            if(notificationFormErr && notificationFormErr.length > 0){
                // Form validation failed
                return false;
            }else{
                notificationForm.trigger('submit');
            }

        });

        $("#send_notification_form").on('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo site_url('SystemNotification/sendNotification') ?>",
                data: formData,
                dataType : 'json',
                type: 'post',
                success: function (data) {
                    console.log(data);
                    if(data.state == true) {
                        swal('Success', 'Notification Sent!', 'success');
                        // swal("Success!", "Notification Sent!", "success");
                    }else if(data.files_validation == 0){
                        console.log('Image Upload Error');
                        swal('Oops...', 'Image Upload Error! '+data.notification_thumbnail, 'error');
                        // swal("Oops!", "Something went wrong!", "danger");
                    }else{
                        console.log('Error Fetching Data');
                        swal('Oops...', 'Notification Failed!', 'error');
                        // swal("Oops!", "Something went wrong!", "danger");
                    }
                },
                error: function () {
                    console.log('Error Fetching Data');
                    swal('Oops...', 'Something went wrong!', 'error');
                    // swal("Oops!", "Something went wrong!", "danger");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });


</script>
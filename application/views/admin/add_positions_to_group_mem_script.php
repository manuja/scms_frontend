<script>
    $(document).ready(function () {

    });


    $(document).on('click', '#save_positions', function (event) {
        event.preventDefault();
        var fullForm = $("#position_form");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            save_position();
        }


    });


    function save_position() {

        var save_positi = document.getElementById('position_form');
        var formData = new FormData(save_positi);
//                    formData.append('recommendations', JSON.stringify(get_RecommendationRecords()));

        $.ajax({
            method: 'POST',
            url: site_url + 'Add_positions_to_group_members/save_position',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        }).always(function (data) {
//                        console.log(data);
            if (data.status == '1') {
                var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                successmsg += data.msg;
                successmsg += '</div>';

                $("#msg_create_notifications_div").html(successmsg);
                $('#msg_create_form').trigger("reset");
//                location.reload();

            } else if (data.status == '3') {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += 'Cannot add duplicate entries, Please select another data';
                errormsg += '</div>';
                $("#msg_create_notifications_div").html(errormsg);
                $('#msg_create_form').trigger("reset");
//                location.reload();
            } else {

            }

        });
//                });
    }


    $(document).on('click', '#update_msg', function (event) {
        event.preventDefault();
        var fullForm = $("#msg_create_form");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            membership_group_msg_update();
        }
    });


    function membership_group_msg_update() {


        var msg_create = document.getElementById('msg_create_form');
        var formData = new FormData(msg_create);
//                    formData.append('recommendations', JSON.stringify(get_RecommendationRecords()));

        $.ajax({
            method: 'POST',
            url: site_url + 'Membership_Groups/update_membership_group_messages',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        }).always(function (data) {
//                        console.log(data);
            if (data.status == '1') {
                var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                successmsg += data.msg;
                successmsg += '</div>';

                $("#msg_create_notifications_div").html(successmsg);
//                location.reload();

            } else if (data.status == '3') {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += 'Cannot add duplicate entries, Please select another data';
                errormsg += '</div>';
                $("#msg_create_notifications_div").html(errormsg);
//                location.reload();
            } else {

            }

        });
//                });
    }



    $(document).on('change', '#hidden_group_id', function (event) {
        var group_id = $(this).val();
        load_group_members(group_id);
    });

    function load_group_members(group_id) {
//        alert(verify_id);
        var param = {};
        param.group_id = group_id;
        jQuery.post(site_url + 'Add_positions_to_group_members/load_group_members', param, function (response) {
            if (response !== null) {
                if (response.status == '1') {


                } else {

                }

            } else {
                swal("Failed!", "Record(s) could not be deleted!", "error");
            }
        }, 'json');
    }

</script>
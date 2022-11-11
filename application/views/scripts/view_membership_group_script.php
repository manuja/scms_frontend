<script>
    
    $(document).ready(function () {
        $("#core_ing_disp").select2({
            placeholder: 'Please select...'
        });
        $("#sub_engineering_id").select2({
            placeholder: 'Please select...'
        });


        var selected_group = $('input[name="group_type"]:checked').val();
//        console.log(selected_group);
        $('#group_admins').select2({
            placeholder: 'Please select...'
        });

//        $('#create_membership_group_form').on('submit', function (event) {
//            event.preventDefault();
//
//            swal({
//                title: 'Success!',
//                text: 'A new membership group has been created successfully',
//                icon: 'success'
//            }).then(function () {
//                window.location.replace('<?php // echo site_url('membership_groups/index');         ?>');
//            });
//        });
    });


    $(document).on('click', '#mem_group_create', function (event) {
        event.preventDefault();
        var fullForm = $("#create_membership_group_form");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            membership_group_save();
        }


    });


    function membership_group_save() {
//        swal({
//            title: "Save this details?",
//            text: " information will be saved",
//            type: "info",
//            showCancelButton: true,
//            closeOnConfirm: false
//        },
//                function () {

        var menu_create = document.getElementById('create_membership_group_form');
        
        var formData = new FormData(menu_create);
//                    formData.append('description', tinymce.get('description').getContent());

        $.ajax({
            method: 'POST',
            url: site_url + 'membership_groups/membership_group_save',
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

                $("#create_mem_group").html(successmsg);
                location.reload();

            } else if (data.status == '3') {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += 'Cannot add duplicate entries, Please select another data';
                errormsg += '</div>';
                $("#create_mem_group").html(errormsg);
                location.reload();
            } else {

            }

        });
//                });
    }



    $(document).on('change.select2', '#core_ing_disp', function (event) {
        var obj = $("#core_ing_disp").val();
        load_sub_eng_discipline(obj);
    });



    function load_sub_eng_discipline(obj, selected) {
        var url = site_url + 'membership_groups/sub_eng';
        $.post(url, {subeng: obj}, function (response) {
            var select_data = '- Select grand child menu -';
            var select_data_divi = 'Select Child Menu';
            console.log(response);
            if (response.status == "1" && response.data != null) {
//                console.log(response.data);
                $.each(response.data, function (index, row) {

                    if (!isNaN(parseInt(selected)) && selected == row.engineering_discipline_sub_field_id) {
                        select_data += '<option value="' + row.engineering_diengineering_discipline_sub_field_idscipline_sub_field_id + '" selected>' + row.engineering_discipline_sub_field_name + '</option>';
                    } else {
                        select_data += '<option value="' + row.engineering_discipline_sub_field_id + '">' + row.engineering_discipline_sub_field_name + '</option>';
                    }
                });
            } else {
                select_data += '<option value="" selected>' + select_data_divi + '</option>';
            }
            $('#sub_engineering_id').html(select_data);
            if (selected) {
                $("#sub_engineering_id").val(selected);
            }
        }, 'json');

    }


    jQuery("input:radio[name=group_type]").click(function () {
        var checked_radio = $(this).val();
        if (checked_radio == 1) {
            $('#commitee_div').addClass('hidden');
            $('#chapter_div').addClass('hidden');
        } else if (checked_radio == 2) {
            $('#commitee_div').addClass('hidden');
            $('#chapter_div').removeClass('hidden');
        } else if (checked_radio == 3) {
            $('#commitee_div').removeClass('hidden');
            $('#chapter_div').addClass('hidden');
        }
    });

</script>
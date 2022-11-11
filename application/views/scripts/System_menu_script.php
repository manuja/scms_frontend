<script>
    $(document).ready(function ($) {
        load_child_dropdown();
        drop_down_validations();
//        load_grand_child_dropdown($('#child_menu').val());
    });




    $(document).on('click', '#save_button', function (event) {
        event.preventDefault();
        var fullForm = $("#menu_create_form");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            system_menu_save();
        }


    });
    $(document).on('click', '#add_sub_menu', function (event) {

        add_sub_menu($(this).val());
    });
    $(document).on('click', '#grand_child_edit', function (event) {
        edit_grand_child($(this).val());
    });
    $(document).on('click', '#update_button', function (event) {
        update_grand_child($(this).val());
    });
    $(document).on('click', '#grand_child_delete', function (event) {
        delete_grand_child($(this).val());
    });
    $(document).on('click', '#child_edit', function (event) {
        edit_grand_child($(this).val());
    });
    $(document).on('click', '#child_delete', function (event) {
        delete_grand_child($(this).val());
    });

    $(document).on('click', '#title_edit', function (event) {
        edit_grand_child($(this).val());
    });
    $(document).on('click', '#title_delete', function (event) {
        delete_grand_child($(this).val());
    });
    $(document).on('change', '#parent_menu', function (event) {
//        drop_down_validations();
//        $('#grand_child').html('<option>Select Grand Child</option>');
        load_child_dropdown($(this).val(), false);

    });
    $(document).on('click', '#menu_level', function (event) {
        drop_down_validations();

    });

    $(document).on('click', '#cancel_button', function (event) {
        location.reload();

    });


//    $(document).on('change', '#child_menu', function (event) {
//        load_grand_child_dropdown($(this).val(), false);
//
//    });




    function load_child_dropdown(id, selected) {
//        alert(id);
//        alert(selected);
        var param = {};
        param.parent = id;
        var url = site_url + 'System_menu/get_child_menu';
//        alert(url);
        $.post(url, param, function (response) {
            var select_data = '- Select Process -';
            var select_data_divi = 'Select Process';
//            console.log(response);
            if (response.status == "1" && response.data != null) {
//                console.log(response.data);
                $.each(response.data, function (index, row) {

                    if (!isNaN(parseInt(selected)) && selected == row.id) {
                        select_data += '<option value="' + row.id + '" selected>' + row.name + '</option>';
                    } else {
                        select_data += '<option value="' + row.id + '">' + row.name + '</option>';
                    }
                });
            } else {

                select_data += '<option value="" selected>' + select_data_divi + '</option>';
            }
            $('#child_menu').html(select_data);
            if (selected) {
                $("#child_menu").val(selected);
            }
            $("#child_menu").trigger("chosen:updated");
        }, 'json');
    }


//    function load_grand_child_dropdown(id, selected) {
////        alert(id);
//
//        var param = {};
//        param.child = id;
//        var url = site_url + 'System_menu/get_grand_child_menu';
////        alert(url);
//        $.post(url, param, function (response) {
//            var select_data = '- Select Sub Process -';
//            var select_data_divi = 'Select Sub Process';
////            console.log(response);
//            if (response.status == "1" && response.data != null) {
////                console.log(response.data);
//                $.each(response.data, function (index, row) {
//
//                    if (!isNaN(parseInt(selected)) && selected == row.id) {
//                        select_data += '<option value="' + row.id + '" selected>' + row.name + '</option>';
//                    } else {
//                        select_data += '<option value="' + row.id + '">' + row.name + '</option>';
//                    }
//                });
//            } else {
//                select_data += '<option value="" selected>' + select_data_divi + '</option>';
//            }
//            $('#grand_child').html(select_data);
//            if (selected) {
//                $("#grand_child").val(selected);
//            }
//            $("#grand_child").trigger("chosen:updated");
//            if (id) {
//                frm_rnd_project_create.element("#grand_child");
//            }
//        }, 'json');
//    }

    function system_menu_save() {


        var menu_create = document.getElementById('menu_create_form');
        var formData = new FormData(menu_create);
//                    formData.append('recommendations', JSON.stringify(get_RecommendationRecords()));

        $.ajax({
            method: 'POST',
            url: site_url + 'System_menu/system_menu_save',
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

                $("#messages_noti").html(successmsg);
                location.reload();

            } else if (data.status == '3') {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += 'Cannot add duplicate entries, Please select another data';
                errormsg += '</div>';
                $("#messages_noti").html(errormsg);
//                location.reload();
            }

        });
//                });
    }

    function edit_grand_child(grand_child_val) {
        $('#save_button').addClass('hidden');
        $('#update_button').removeClass('hidden');
        var param = {};
        param.grand_child_val = grand_child_val;
        $.post(site_url + '/System_menu/edit_grand_child', param, function (response) {
            if (response !== null) {
//                console.log(response);
                $('#menu_icon').iconpicker('setIcon', response.menu_icon);
//                $('#menu_icon').iconpicker('icon',response.menu_icon);

                if (response.menu_level == 1) {
                    $('#main_process').addClass('hidden');

                } else {
                    $('#main_process').removeClass('hidden');

                }
                $('#menu_icon').iconpicker('setIcon', response.menu_icon);
                $('#menu_id').val(response.menu_id);
                $('#menu_title').val(response.menu_title);
//                $('#menu_icon').val(response.menu_icon);
                $('#menu_level').val(response.menu_level);
                $('#menu_url').val(response.menu_path);
                $('#menu_order').val(response.row_order);
                $('#menu_parent_hdn').val(response.menu_parent);
//                alert(response.menu_parent);
                $('#parent_menu').val(response.permission_parent_id);
                load_child_dropdown(response.permission_parent_id, response.permission_child_id);
//                load_grand_child_dropdown(response.permission_child_id, response.permission_grand_child_id);
            } else {
//                swal("Failed!", "Status could not be updated!", "error");
            }
        }, 'json');
    }


    function update_grand_child() {
//            swal({
//                title: "Update this details?",
//                text: "Project information will be updated",
//                type: "info",
//                showCancelButton: true,
//                closeOnConfirm: false
//            },
//                    function () {
        var client_project = document.getElementById('menu_create_form');
        var formData = new FormData(client_project);
//                    formData.append('recommendations', JSON.stringify(get_RecommendationRecords()));

        $.ajax({
            method: 'POST',
            url: site_url + '/System_menu/system_menu_update',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        }).always(function (data) {

            if (data.status == '1') {


                var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                successmsg += data.msg;
                successmsg += '</div>';

                $("#messages_noti").html(successmsg);
                location.reload();

            } else {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += 'you cannot update data';
                errormsg += '</div>';

                $("#messages_noti").html(errormsg);
                location.reload();
            }

        });
//                    });
    }
//
    function delete_grand_child(delete_grand_child) {
        var param = {};
        param.dchild_delete = delete_grand_child;
        $.post(site_url + '/System_menu/system_menu_delete', param, function (response) {
            if (response !== null) {
                if (response.status == '1') {


                    var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    successmsg += response.msg;
                    successmsg += '</div>';

                    $("#messages_noti").html(successmsg);
                    location.reload();

                } else {
                    var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    errormsg += 'You cannot delete this data';
                    errormsg += '</div>';

                    $("#messages_noti").html(errormsg);
                    location.reload();
                }

            } else {
                swal("Failed!", "Record(s) could not be deleted!", "error");
            }
        }, 'json');
    }

    function drop_down_validations() {
        var menu_level = $("input:radio[name=menu_level]:checked").val()
//        var menu_level = $('#menu_level').val();
//        var fullForm = $("#menu_create_form");
        if (menu_level == 1) {
            $('#main_process').addClass('hidden');
//            $('#child_menu').prop('required', true);
//            $('#grand_child').prop('required', false);
//            fullForm.validator('update');
//            fullForm.validator('validate');
//        } else if (menu_level == 3) {
//            $('#child_menu').prop('required', true);
//            $('#grand_child').prop('required', true);
//            fullForm.validator('update');
//            fullForm.validator('validate');
//        } 
        } else {
            $('#main_process').removeClass('hidden');
//            $('#child_menu').prop('required', false);
//            $('#grand_child').prop('required', false);
//            fullForm.validator('update');
//            fullForm.validator('validate');
        }
    }


    function  add_sub_menu(main_menu_id) {

//        $('#save_button').addClass('hidden');

        var param = {};
        param.grand_child_val = main_menu_id;
        $.post(site_url + '/System_menu/edit_grand_child', param, function (response) {
            if (response !== null) {
                console.log(response);
                $('#menu_level2').removeClass('hidden');
                $('#menu_level1').addClass('hidden');
                $('#main_process').removeClass('hidden');

                $('#menu_level').prop('disabled', true);
                $('#menu_id').val(response.menu_id);
//                $('#menu_level').val('2');
                $("input[name=menu_level]").val([2]);
//                $('#menu_url').val(response.menu_path);
//                $('#menu_order').val(response.row_order);
//                $('#parent_menu').prop('disabled', true);
                $('#parent_menu').val(response.permission_parent_id);
//                $('#group_id').val(response.permission_parent_id);
                load_child_dropdown(response.permission_parent_id, response.permission_child_id);
//                load_child_dropdown(response.permission_parent_id, response.permission_child_id);
//                load_grand_child_dropdown(response.permission_child_id, response.permission_grand_child_id);
            } else {
//                swal("Failed!", "Status could not be updated!", "error");
            }
        }, 'json');
    }
</script>

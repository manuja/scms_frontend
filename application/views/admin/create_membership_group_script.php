
<script>

    $(document).ready(function () {

        load_group_admins();
        assoc_check();
        assoc_combo();

        var checked_radio = $('input[name=group_type]:checked').val();
        change_check_boxes(checked_radio);
        var eng = $('#core_ing_disp').val();
        var subeng = $('.hidden_sub_eng_id').val();
        var subeng = [];
        $('.hidden_sub_eng_id').each(function (i) {
            subeng[i] = $(this).val();
        });
        load_sub_eng_discipline(eng, subeng);
        $("#core_ing_disp").select2({
            placeholder: 'Please select...'
        });
        $("#sub_engineering_id").select2({
            placeholder: 'Please select...'
        });
        $("#group_admins").select2({
//            placeholder: 'Please select...',
            multiple: true
        });
        var selected_group = $('input[name="group_type"]:checked').val();
//        console.log(selected_group);
//        $('#group_admins').select2({
//            placeholder: 'Please select...'
//        });
//        $('#create_membership_group_form').on('submit', function (event) {
//            event.preventDefault();
//
//            swal({
//                title: 'Success!',
//                text: 'A new membership group has been created successfully',
//                icon: 'success'
//            }).then(function () {
//                window.location.replace('<?php // echo site_url('Membership_Groups/index');                                                                              ?>');
//            });
//        });

        tinymce.init({
            selector: '#description',
            height: 250,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help imagetools wordcount'
            ],
            toolbar: 'insert | undo redo | fontsizeselect | bold italic forecolor backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image | code',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'],
            automatic_uploads: true,
            relative_urls : false,
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {title: file.name});
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            },
            setup: function (ed) {
                ed.on('init', function (e) {
                    ed.execCommand('fontName', false, 'Arial');
                });
            },
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '<?php echo base_url(); ?>Membership_Groups/uploadContentImage');
                var token = '{{ csrf_token() }}';
                xhr.setRequestHeader("X-CSRF-Token", token);
                xhr.onload = function () {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }
        });
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
//            title: "Save this details?",  function membership_group_save() {
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
        formData.append('description', tinymce.get('description').getContent());
        $.ajax({
            method: 'POST',
            url: site_url + 'Membership_Groups/membership_group_save',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        }).always(function (data) {
//            console.log(data);
            if (data.status == '1') {

                var successmsg = '<div  class="response-block alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                successmsg += data.msg;
                successmsg += '</div>';
                $("#create_mem_group").html(successmsg);
                $("body, html").animate({
                    scrollTop: $(".box-title").offset().top
                }, 300);
                setTimeout(function () {
                    location.reload();
                }, 3000);
            } else if (data.status == '3') {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += data.msg;
                errormsg += '</div>';
                $("#create_mem_group").html(errormsg);
//                setTimeout(function () {
//                    location.reload();
//                }, 5000);
            } else {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += data.msg;
                errormsg += '</div>';
                $("#create_mem_group").html(errormsg);
            }

        });
//                });
    }



    $(document).on('change.select2', '#core_ing_disp', function (event) {
        var obj = $("#core_ing_disp").val();
        load_sub_eng_discipline(obj);
    });
    function load_sub_eng_discipline(obj, selected) {
//        console.log(selected);
        var url = site_url + 'Membership_Groups/sub_eng';
        $.post(url, {subeng: obj}, function (response) {
            var select_data = '- Select sub engineering data -';
            var select_data_divi = 'Select sub engineering data';
//            console.log(response);
            if (response.status == "1" && response.data != null) {
//                console.log(response.data);
                $.each(response.data, function (index, row) {

                    if (!isNaN(parseInt(selected)) && selected == row.engineering_discipline_sub_field_id) {
                        select_data += '<option value="' + row.engineering_discipline_sub_field_id + '" selected>' + row.engineering_discipline_sub_field_name + '</option>';
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
        change_check_boxes(checked_radio);
    });
    function change_check_boxes(checked_radio) {
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
    }

    $(document).on('click', '#mem_group_update', function (event) {
        event.preventDefault();
        var fullForm = $("#create_membership_group_form");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            membership_group_update();
        }


    });
    function membership_group_update() {
//        swal({
//            title: "Save this details?",  function membership_group_save() {
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
        formData.append('description', tinymce.get('description').getContent());
        $.ajax({
            method: 'POST',
            url: site_url + 'Membership_Groups/membership_group_update',
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
                setTimeout(function () {
                    location.reload();
                }, 2500);
//                location.reload();

            } else if (data.status == '3') {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += data.msg;
                errormsg += '</div>';
                $("#create_mem_group").html(errormsg);
                setTimeout(function () {
                    location.reload();
                }, 2500);
//                location.reload();
            } else {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += data.msg;
                errormsg += '</div>';
                $("#create_mem_group").html(errormsg);
                setTimeout(function () {
                    location.reload();
                }, 2500);
            }

        });
//                });
    }

    $('#core_eng_select_all').click(function () {
        if ($(this).is(':checked')) {
            var values = [];
            $('#core_ing_disp').find('option').each(function () {
                var opt = $(this);
                var opvalue = opt.attr('value');
                values.push(opvalue);
            });
            $('#core_ing_disp').val(values).trigger('change');
        } else {
            $("select").val('').change();
        }
    });
    $('#sub_eng_select_all').click(function () {
        if ($(this).is(':checked')) {
            var values = [];
            $('#sub_engineering_id').find('option').each(function () {
                var opt = $(this);
                var opvalue = opt.attr('value');
                values.push(opvalue);
            });
            $('#sub_engineering_id').val(values).trigger('change');
        } else {
            $("select").val('').change();
        }
    });
    $(document).on('change', '#chapter', function (event) {
        assoc_check();
    });
    $('#assoc_prov_check').click(function () {
        assoc_combo();
    });
    function assoc_combo() {
        if ($('#assoc_prov_check').is(':checked')) {
            $('#asc_provincial_chapter_div').removeClass('hidden');
        } else {
            $('#asc_provincial_chapter_div').addClass('hidden');
        }
    }

    function assoc_check() {
        var chapter_val = $('#chapter').val();
        if (chapter_val == 3) {
            $('#provincial_chapter_div').removeClass('hidden');
        } else {
            $('#assoc_prov_check').prop('checked', false);
            $('#provincial_chapter_div').addClass('hidden');
        }
    }


//    function load_group_admins(obj, selected) {
//
//        var url = site_url + 'Membership_Groups/load_group_admins';
//        $.post(url, {admin_name: obj}, function (response) {
//            var select_data = '- Select sub engineering data -';
//            var select_data_divi = 'Select sub engineering data';
//            console.log(response);
//            if (response.status == "1" && response.data != null) {
////                console.log(response.data);
//                $.each(response.data, function (index, row) {
//
//                    if (!isNaN(parseInt(selected)) && selected == row.id) {
//                        select_data += '<option value="' + row.id + '" selected>' + row.text + '</option>';
//                    } else {
//                        select_data += '<option value="' + row.id + '">' + row.text + '</option>';
//                    }
//                });
//            } else {
//                select_data += '<option value="" selected>' + select_data_divi + '</option>';
//            }
//            $('#group_admins').html(select_data);
//            if (selected) {
//                $("#group_admins").val(selected);
//            }
//        }, 'json');
//
//    }


//    $(document).on('keyup', '#group_admin_search', function (event) {
//        var admin_val = $(this).val();
//        alert(admin_val.length);
//        if (admin_val.length > 2) {
//            load_group_admins();
//        }
//    });




    function load_group_admins() {
//        var admins_array = [];
        $('#group_admin_search').typeahead({
            source: function (query, process) {
                var objects = [];
                map = {};
                $.post(site_url + 'Membership_Groups/load_group_admins', function (data) {
                    $.each(data, function (i, object) {
                        map[object.membership_number] = object;
                        objects.push(object.membership_number);
                    });
                    process(objects);
                }, 'json');
            },
            updater: function (item) {
//                admins_array.push(map[item].user_id);
                $('#group_admin_search').val('');
//                $('#group_admin_ids').val(admins_array);
//var new_recipient = $("#group_admin_search").val();
//
                if ($("#group_admins").find("option[value='" + map[item].user_id + "']").length) {
                    $("#group_admins").val(map[item].user_id).trigger("change");
                } else {
                    var new_selected_recipient = new Option(map[item].user_name_w_initials, map[item].user_id, true, true);
                    $("#group_admins").append(new_selected_recipient).trigger('change');
                }

//                return item;

            }
        });
    }


//    $("#append_group_id").on("click", function (event) {
//
//        event.preventDefault();
//
//        var new_recipient = $("#group_admin_search").val();
//
//        if ($("#group_admins").find("option[value='" + new_recipient + "']").length) {
//            $("#group_admins").val(new_recipient).trigger("change");
//        } else {
//            var new_selected_recipient = new Option(new_recipient, new_recipient, true, true);
//            $("#group_admins").append(new_selected_recipient).trigger('change');
//        }
//        $('#group_admin_search').val('');
//    });



</script>
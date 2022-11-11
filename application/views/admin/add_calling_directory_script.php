<script>


    $(document).ready(function () {

        var directory_type = $('#directory_type').val();
        if(directory_type == 1){
            show_hidden_adjudicator_div(directory_type);
        }
        
        var today = new Date();
        var date_sts = $("#date_status").val();
        
        if(date_sts == "save"){//save page

            $('#reg_open_date,#reg_closing_date').datetimepicker({
                useCurrent: false,
                format: 'YYYY-MM-DD',
                minDate: new Date().setHours(0,0,0,0)
            });

        }else if(date_sts == "edit"){//edit page
          
            $('#reg_open_date,#reg_closing_date').datetimepicker({
                useCurrent: false,
                format: 'YYYY-MM-DD'
            });

        }else{
          
        }
        // dp.change
        //$('#reg_open_date').datetimepicker('update', incrementDay);
        // dp.update

            $('#reg_open_date').datetimepicker().on('dp.change', function (e) {
                var incrementDay = moment(new Date(e.date));
                incrementDay.add(1, 'days');

                $('#reg_closing_date').data('DateTimePicker').minDate(incrementDay);
                $(this).data("DateTimePicker").hide();
            });

            $('#reg_closing_date').datetimepicker().on('dp.change', function (e) {
                var decrementDay = moment(new Date(e.date));
                decrementDay.subtract(1, 'days');
                $('#reg_open_date').data('DateTimePicker').maxDate(decrementDay);
                 $(this).data("DateTimePicker").hide();
            });










//        $('.datetimepicker').datetimepicker({
//            format: 'YYYY-MM-DD'
//        });
        load_sub_cat_drop_down($('#main_payment').val());
        setTimeout(function () {
            var selected_sub_cat = $('#subcat_hidden_id').val();

//        $("#sub_payment").val(selected_sub_cat).change();
            $('#sub_payment  option[value="' + selected_sub_cat + '"]').prop("selected", true);
        }, 150);

        // $('#sub_payment option[value=' + selected_sub_cat + ']').attr('selected', 'selected');


//        $('.direct_date_picker').datetimepicker({
//            format: 'YYYY-MM-DD'
//        });
        show_hide_related_divs($('#directory_type').val());


        tinymce.init({
            selector: '#rich_text_editor',
            height: 250,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help imagetools wordcount'
            ],
            toolbar: 'insert | undo redo | fontsizeselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'],
            automatic_uploads: true,
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
            }
        });


    });

    $(document).on('change', '#directory_type', function () {
        var directory_type = $(this).val();

        show_hide_related_divs(directory_type);
    });

    function  show_hide_related_divs(directory_type) {

        if (directory_type == 3) {
            $(".app_fee").addClass('hidden');
            $(".building_div").removeClass('hidden');
            $(".req_field").prop('required', true);
            $(".req_field_app").prop('required', false);

        } else {
            $(".app_fee").removeClass('hidden');
            $(".building_div").addClass('hidden');
            $(".req_field_app").prop('required', true);
            $(".req_field").prop('required', false);
        }

    }
    //adjudicator//req_field_both

    $(document).on('change', '#directory_type', function () {
        var directory_type = $(this).val();

        show_hidden_adjudicator_div(directory_type);
    });

    function show_hidden_adjudicator_div(directory_type) {

        if (directory_type == 1) {
            $(".adjudicator_arbitrator_div").removeClass('hidden');
            $(".req_field_both").prop('required', true);
        } else {
            $(".adjudicator_arbitrator_div").addClass('hidden');
            $(".req_field_both").prop('required', false);
        }

    }

    $(document).on('click', '#calling_directory_save', function (event) {
        event.preventDefault();
        var fullForm = $("#calling_directory");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            var directory_type = $('#directory_type').val();
            if(directory_type == '1'){
                checkArbitratorDirStatus();
            }else{
                save_calling_directory();
            }
        }
    });


    function save_calling_directory() {
        
        var directory_create = document.getElementById('calling_directory');
        var formData = new FormData(directory_create);
//                    formData.append('recommendations', JSON.stringify(get_RecommendationRecords()));

        $.ajax({
            method: 'POST',
            url: site_url + 'Add_calling_directory/calling_directory_save',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        }).always(function (data) {

            if (data.status == '1') {
                // var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                // successmsg += data.msg;
                // successmsg += '</div>';
//                report_module_table();
                // $("#messages_div").html(successmsg);

                //R
                swal("Success!", data.msg, "success");
                //R
                $('#calling_directory').trigger("reset");
                
                setTimeout(function () {
                    window.location.replace(site_url + 'Add_calling_directory/view_calling_directory');
                }, 2500);


            } else if (data.status == '3') {
                report_module_table();
                // var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                // errormsg += 'Cannot add duplicate entries, Please select another data';
                // errormsg += '</div>';
                // $("#messages_div").html(errormsg);
                //R
                swal("Error!", "Cannot add duplicate entries, Please select another data!", "warning");
                //R
                $('#calling_directory').trigger("reset");
            }

        });
//                });
    }
    function checkArbitratorDirStatus(){
        $.ajax({
            method: 'POST',
            url: site_url + 'Add_calling_directory/check_arbitrator_dir_status',
            dataType: 'json',
            data: 'check_dir_type=2',
            processData: false,
            contentType: false,
        }).always(function (response) {
            console.log("Value- ");
            console.log(response.data);
            if(response.data == "1" | response.data == "2"){//active=1
                save_calling_directory();
            }else if(response.data == "0"){//not active=0
                swal("Notice!", "Please create and publish an Arbitrator Directory before you create an Adjudicator & Arbitrator Directory", "warning");
            }else{
                //none
            }
        });

    }


    //When main payment category changes load relevant sub payment categories
    $('#main_payment').on('change', function () {
        var main_paymentID = $(this).val();
        load_sub_cat_drop_down(main_paymentID);
    });

    function load_sub_cat_drop_down(main_paymentID) {

        if (main_paymentID) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() . 'index.php/B_paper/getSubPaymentCategoriesForGivenMainPayment'; ?>",
                data: 'main_payment_id=' + main_paymentID,
                success: function (html) {
                    $('#sub_payment').html(html);
                }
            });
        } else {
            //$('#sub_payment').html('<option value="">Select main payment first</option>');
        }

    }


    $('#add_new_sub_payment_cat_btn').on('click', function () {
        $('#create_new_sub_payment_cat_form').validator('validate');

        if ($('.has-error').length > 0) {
            return false;
        } else {

            var directory_create = document.getElementById('create_new_sub_payment_cat_form');
            var formData = new FormData(directory_create);
//                    formData.append('recommendations', JSON.stringify(get_RecommendationRecords()));

            $.ajax({
                method: 'POST',
                url: site_url + 'Add_calling_directory/add_sub_payment_category',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
            }).always(function (data) {
//                        console.log(data);
                if (data.status == '1') {
                    swal({
                        title: 'Success!',
                        type: 'success'
                    }).then(function () {
                        $('#modal-add').modal('hide');
                        $('#create_new_sub_payment_cat_form').trigger("reset");
                    });
                }

            });
        }
    });

    $('#is_tax_enable_new_reg').on('click', function () {
        if ($(this).prop('checked') == true) {
            if ($(".new_app_check").is('checked').length > 0) {
                $(".new_app_check").prop('required', false);

            } else {
                $(".new_app_check").prop('required', true);
            }
            $('#loadmembervat_new_reg').show();

        } else {
            
            $('#loadmembervat_new_reg').hide();
            $('.checkclassmem').prop('checked', false);

            $('.new_app_check1').prop('required', false);
            $('.new_app_check2').prop('required', false);
        }
    });
    $('#is_tax_enable_cont_reg').on('click', function () {
        if ($(this).prop('checked') == true) {
            if ($(".cont_reg_check").is('checked').length > 0) {
                $(".cont_reg_check").prop('required', false);

            } else {
                $(".cont_reg_check").prop('required', true);
            }
            $('#loadmembervat_cont_reg').show();

        } else {

            $('#loadmembervat_cont_reg').hide();
            $('.checkclassmem').prop('checked', false);

        }
    });

    $('#is_tax_enable_new_pub').on('click', function () {
        if ($(this).prop('checked') == true) {
            if ($(".ne_pub_check").is('checked').length > 0) {
                $(".ne_pub_check").prop('required', false);

            } else {
                $(".ne_pub_check").prop('required', true);
            }
            $('#loadmembervat_new_pub').show();

        } else {

            $('#loadmembervat_new_pub').hide();
            $('.checkclassmem').prop('checked', false);

            $(".ne_pub_check1").prop('required', false);
            $(".ne_pub_check2").prop('required', false);

        }
    });

    $('#is_tax_enable_cont_pub').on('click', function () {
        if ($(this).prop('checked') == true) {
            if ($(".cont_pub_check").is('checked').length > 0) {
                $(".cont_pub_check").prop('required', false);

            } else {
                $(".cont_pub_check").prop('required', true);
            }
            $('#loadmembervat_cont_pub').show();

        } else {
            $('#loadmembervat_cont_pub').hide();
            $('.checkclassmem').prop('checked', false);

            $(".cont_pub_check1").prop('required', false);
            $(".cont_pub_check2").prop('required', false);
        }
    });
//

        $('#adj_arbi_is_tax_enable_new_reg').on('click', function () {
                if ($(this).prop('checked') == true) {
                    if ($(".adj_arbi_new_app_check").is('checked').length > 0) {
                        $(".adj_arbi_new_app_check").prop('required', false);

                    } else {
                        $(".adj_arbi_new_app_check").prop('required', true);
                    }
                    $('#adj_arbi_loadmembervat_new_reg').show();

                } else {
                    $('#adj_arbi_loadmembervat_new_reg').hide();
                    $('.adj_arbi_checkclassmem').prop('checked', false);

                    $(".adj_arbi_new_app_check1").prop('required', false);
                    $(".adj_arbi_new_app_check2").prop('required', false);

                }
            });
            $('#adj_arbi_is_tax_enable_cont_reg').on('click', function () {
                if ($(this).prop('checked') == true) {
                    if ($(".adj_arbi_cont_reg_check").is('checked').length > 0) {
                        $(".adj_arbi_cont_reg_check").prop('required', false);

                    } else {
                        $(".adj_arbi_cont_reg_check").prop('required', true);
                    }
                    $('#adj_arbi_loadmembervat_cont_reg').show();

                } else {

                    $('#adj_arbi_loadmembervat_cont_reg').hide();
                    $('.adj_arbi_checkclassmem').prop('checked', false);

                }
            });

            $('#adj_arbi_is_tax_enable_new_pub').on('click', function () {
                if ($(this).prop('checked') == true) {
                    if ($(".adj_arbi_ne_pub_check").is('checked').length > 0) {
                        $(".adj_arbi_ne_pub_check").prop('required', false);

                    } else {
                        $(".adj_arbi_ne_pub_check").prop('required', true);
                    }
                    $('#adj_arbi_loadmembervat_new_pub').show();

                } else {
                    $('#adj_arbi_loadmembervat_new_pub').hide();
                    $('.adj_arbi_checkclassmem').prop('checked', false);

                    $(".adj_arbi_ne_pub_check1").prop('required', false);
                    $(".adj_arbi_ne_pub_check2").prop('required', false);

                }
            });

            $('#adj_arbi_is_tax_enable_cont_pub').on('click', function () {
                if ($(this).prop('checked') == true) {
                    if ($(".adj_arbi_cont_pub_check").is('checked').length > 0) {
                        $(".adj_arbi_cont_pub_check").prop('required', false);

                    } else {
                        $(".adj_arbi_cont_pub_check").prop('required', true);
                    }
                    $('#adj_arbi_loadmembervat_cont_pub').show();

                } else {
                    $('#adj_arbi_loadmembervat_cont_pub').hide();
                    $('.adj_arbi_checkclassmem').prop('checked', false);

                    $(".adj_arbi_cont_pub_check1").prop('required', false);
                    $(".adj_arbi_cont_pub_check2").prop('required', false);

                }
            });


    $(document).on('click', '#save_ceo_approval', function (event) {

        event.preventDefault();
        var fullForm = $("#adjudicator_payment_form");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            approve_from_finance_division();
        }
    });






    function approve_from_finance_division() {


        var adjudicator = document.getElementById('adjudicator_payment_form');
        var formData = new FormData(adjudicator);
//                    formData.append('recommendations', JSON.stringify(get_RecommendationRecords()));

        $.ajax({
            method: 'POST',
            url: site_url + 'Add_calling_directory/approve_from_finance',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        }).always(function (data) {
//                        console.log(data);
            if (data.status == '1') {
//                 var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
//                 successmsg += data.msg;
//                 successmsg += '</div>';
// //                report_module_table();
//                 $("#messages_div").html(successmsg);
                //R
                swal("Success!", data.msg, "success");
                //R
                $("body, html").animate({
                    scrollTop: $(".box-title").offset().top
                }, 300);
                setTimeout(function () {
                    window.location.replace(site_url + 'Add_calling_directory/view_calling_directory/1');
//                    location.reload();
                }, 800);
            } else if (data.status == '3') {
                report_module_table();
                // var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                // errormsg += 'Cannot add duplicate entries, Please select another data';
                // errormsg += '</div>';
                // $("#messages_div").html(errormsg);
                //R
                swal("Error!", "Cannot add duplicate entries, Please select another data!", "warning");
                //R

                $("body, html").animate({
                    scrollTop: $(".box-title").offset().top
                }, 300);
                setTimeout(function () {
                    location.reload();
                }, 800);
            }

        });
        $('#create_announcement_form').on('submit', function () {
            var content = tinymce.get('rich_text_editor').getContent();
            if (content.length == 0) {
                $('#content_err').text('Please fill out this field.');
                return false;
            }
        });

    }

    $(document).on('click', '.ne_pub_check1', function (event) {
        if ($(this).prop('checked') == true) {
            $(".ne_pub_check2").prop('required', false);

        } else {
            $(".ne_pub_check2").prop('required', true);
        }
    });


    $(document).on('click', '.ne_pub_check2', function (event) {
        if ($(this).prop('checked') == true) {
            $(".ne_pub_check1").prop('required', false);

        } else {
            $(".ne_pub_check1").prop('required', true);

        }
    });



    $(document).on('click', '.cont_pub_check1', function (event) {

        if ($(this).prop('checked') == true) {
            $(".cont_pub_check2").prop('required', false);

        } else {
            $(".cont_pub_check2").prop('required', true);

        }

    });


    $(document).on('click', '.cont_pub_check2', function (event) {
        if ($(this).prop('checked') == true) {
            $(".cont_pub_check1").prop('required', false);

        } else {
            $(".cont_pub_check2").prop('required', true);

        }
    });



    $(document).on('click', '.new_app_check1', function (event) {
        if ($(this).prop('checked') == true) {
            $(".new_app_check2").prop('required', false);

        } else {
            $(".new_app_check1").prop('required', true);

        }
    });




    $(document).on('click', '.new_app_check2', function (event) {
        if ($(this).prop('checked') == true) {
            $(".new_app_check1").prop('required', false);

        } else {
            $(".new_app_check2").prop('required', true);

        }
    });




    $(document).on('click', '.cont_reg_check1', function (event) {
        if ($(this).prop('checked') == true) {
            $(".cont_reg_check2").prop('required', false);

        }
    });


    $(document).on('click', '.cont_reg_check2', function (event) {
        if ($(this).prop('checked') == true) {
            $(".cont_reg_check1").prop('required', false);

        }
    });
    //

    $(document).on('click', '.adj_arbi_ne_pub_check1', function (event) {
        if ($(this).prop('checked') == true) {
            $(".adj_arbi_ne_pub_check2").prop('required', false);

        } else {
            $(".adj_arbi_ne_pub_check2").prop('required', true);
        }
    });


    $(document).on('click', '.adj_arbi_ne_pub_check2', function (event) {
        if ($(this).prop('checked') == true) {
            $(".adj_arbi_ne_pub_check1").prop('required', false);

        } else {
            $(".adj_arbi_ne_pub_check1").prop('required', true);

        }
    });



    $(document).on('click', '.adj_arbi_cont_pub_check1', function (event) {

        if ($(this).prop('checked') == true) {
            $(".adj_arbi_cont_pub_check2").prop('required', false);

        } else {
            $(".adj_arbi_cont_pub_check2").prop('required', true);

        }

    });


    $(document).on('click', '.adj_arbi_cont_pub_check2', function (event) {
        if ($(this).prop('checked') == true) {
            $(".adj_arbi_cont_pub_check1").prop('required', false);

        } else {
            $(".adj_arbi_cont_pub_check2").prop('required', true);

        }
    });



    $(document).on('click', '.adj_arbi_new_app_check1', function (event) {
        if ($(this).prop('checked') == true) {
            $(".adj_arbi_new_app_check2").prop('required', false);

        } else {
            $(".adj_arbi_new_app_check1").prop('required', true);

        }
    });




    $(document).on('click', '.adj_arbi_new_app_check2', function (event) {
        if ($(this).prop('checked') == true) {
            $(".adj_arbi_new_app_check1").prop('required', false);

        } else {
            $(".adj_arbi_new_app_check2").prop('required', true);

        }
    });




    $(document).on('click', '.adj_arbi_cont_reg_check1', function (event) {
        if ($(this).prop('checked') == true) {
            $(".adj_arbi_cont_reg_check2").prop('required', false);

        }
    });


    $(document).on('click', '.adj_arbi_cont_reg_check2', function (event) {
        if ($(this).prop('checked') == true) {
            $(".adj_arbi_cont_reg_check1").prop('required', false);

        }
    });

</script>
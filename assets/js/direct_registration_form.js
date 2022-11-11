/**
 * Created by test on 4/27/2018.
 */

var formSubmitting = false;
$(document).ready(function(){

    // $.lockNav({
    //     DisableF5: true,
    //     WarnBeforeUnload: true,
    //     WarningMessage: 'You may lose information.'
    // });

    // window.onbeforeunload = function() {
    //     return "";
    // };

    // page leave warning - start
    var setFormSubmitting = function() { formSubmitting = true; };


    window.onload = function() {
        window.addEventListener("beforeunload", function (e) {
            if (formSubmitting) {
                return undefined;
            }

            var confirmationMessage = 'If you leave this page changes you made will be lost.';

            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
            return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
        });
    };
    // page leave warning - end


    // Initialize datepickers
    $(function () {
        var todayDate = new Date().getDate();

        var dob_edit = $('#user_dob').attr('value');
        if(dob_edit.length > 0){ // edit mode
            $('#user_dob').datetimepicker({
                format: 'YYYY-MM-DD',
                viewMode: 'years',
                maxDate: new Date(new Date().setDate(todayDate - 6570)),// 6570days = 18years // can reduce(-) no_of_days to match minimum applicant age (21 yrs)
                defaultDate: dob_edit,
                useCurrent:false
            });
        }else{ // not-edit mode
            $('#user_dob').datetimepicker({
                format: 'YYYY-MM-DD',
                viewMode: 'years',
                maxDate: new Date(new Date().setDate(todayDate - 6570))// 6570days = 18years // can reduce(-) no_of_days to match minimum applicant age (21 yrs)
            });
            $('#user_dob').val(""); // necessary to remove auto selected date by MaxSDate option
        }
        $(".date-field-start").datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years'
        });
        $(".date-field-end").datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD',
            viewMode: 'years',
            maxDate: new Date(new Date().setDate(todayDate + 1))
        });
        $(".date-field-year").datetimepicker({
            viewMode: 'years',
            format: 'YYYY'
        });
        $(".date-field-year-pastonly").datetimepicker({
            viewMode: 'years',
            format: 'YYYY',
            maxDate: new Date(new Date().setDate(todayDate + 1))
        });
        //$('#user_dob').val(""); // necessary to remove auto selected date by MaxSDate option

        if($('#form_edit_mode').val() == '1'){
            // in edit mode, email and nic are defualt shown as duplicates. to fix this
            $('#user_email').trigger('focus');
            $('#user_nic').trigger('focus');
            $('#user_email').trigger('focus');
            // in edit mode, email and nic are defualt shown as duplicates. to fix this -- end
        }
        // $('#search_filter_date_from').data("DateTimePicker").defaultDate(new Date(new Date().setDate(todayDate - 6570)));
        $(".select-dropdown-tags").select2({
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                  return null;
                }

                return {
                  id: term.substr(0,1).toUpperCase()+term.substr(1),
                  text: term.substr(0,1).toUpperCase()+term.substr(1),
                  newTag: true // add additional parameters
                }
            }
        });
        $(".select-dropdown").select2();
    });

    $(function () {
        // initialize telephone fields
        $(".telephone-number").intlTelInput({
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.3.0/js/utils.js",
            initialCountry: "LK",
            nationalMode: true
            // separateDialCode: true
        });
        // $.fn.intlTelInput.loadUtils("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.3.0/js/utils.js");

        // $('#reg_form').validator({
        //     custom: {
        //         intltelephone: function ($el) {
        //             return validateTelephone($el);
        //         },
        //         telephone: function ($el) {
        //             return 'wwwwww';
        //         },
        //
        //     }
        // });
    });
    // set maxdate, mindate restrictions to related date fields
    $(".date-field-start").on("dp.change", function (e) {
        var parentRow = $(this).closest(".date-field-group");
        parentRow.find(".date-field-end").data("DateTimePicker").minDate(e.date);
    });
    $(".date-field-end").on("dp.change", function (e) {
        var parentRow = $(this).closest(".date-field-group");
        parentRow.find(".date-field-start").data("DateTimePicker").maxDate(e.date);
    });
    // set maxdate, mindate restrictions to related date fields(clones)
    $(".date-field-clone-start").on("dp.change", function (e) {
        var parentRow = $(this).closest(".template-row");
        parentRow.find(".date-field-clone-end").data("DateTimePicker").minDate(e.date);
    });
    $(".date-field-clone-end").on("dp.change", function (e) {
        var parentRow = $(this).closest(".template-row");
        parentRow.find(".date-field-clone-start").data("DateTimePicker").maxDate(e.date);
    });

    // disable form date for ongoing events
    $(".from-date-disable").click(function () {
        var parentRow = $(this).closest(".date-field-group");
        var parentRowParent = $(this).closest(".academic-panel");
        if($(this).prop( "checked" )){
            parentRow.find(".date-field-end").prop('required',false).fadeOut();
            parentRow.find(".date-field-clone-end").prop('required',false).fadeOut();
            parentRow.find(".date-field-end-error").fadeOut();
            parentRow.find(".from-date-disable-value").val("1");
            parentRowParent.find(".year_of_award").prop('required',false);
            parentRowParent.find(".year_of_award").parent().validator('validate');
        }else{
            parentRow.find(".date-field-end").prop('required',true).fadeIn().validator('validate');
            parentRow.find(".date-field-clone-end").prop('required',true).fadeIn().validator('validate');
            parentRow.find(".date-field-end-error").fadeIn();
            parentRow.find(".from-date-disable-value").val("0");
            parentRowParent.find(".year_of_award").prop('required',true);
            parentRowParent.find(".year_of_award").parent().validator('validate');
        }
    });
    $(".from-date-disable-clone").click(function () {
        var parentRow = $(this).closest(".template-row");
        var parentRowParent = $(this).closest(".academic-panel");
        if($(this).prop( "checked" )){
            parentRow.find(".date-field-clone-end").prop('required',false).fadeOut();
            parentRow.find(".date-field-end-error").fadeOut();
            parentRow.find(".from-date-disable-value").val("1");
            parentRowParent.find(".year_of_award").prop('required',false);
            parentRowParent.find(".year_of_award").parent().validator('validate');
        }else{
            parentRow.find(".date-field-clone-end").prop('required',true).fadeIn();
            parentRow.find(".date-field-end-error").fadeIn();
            parentRow.find(".from-date-disable-value").val("0");
            parentRowParent.find(".year_of_award").prop('required',true);
            parentRowParent.find(".year_of_award").parent().validator('validate');
        }
    });

    // mark primary academic qualification -- start
    $(".primary_qualification").click(function () {
        var parentRow = $(this).closest(".form-group");
        var thisCheckbox = $(this);
        var thisCheckboxVal = thisCheckbox.parent().siblings('.primary_qualification_value');
        if(thisCheckbox.prop( "checked" )){
            thisCheckboxVal.val("1");
        }else{
            thisCheckboxVal.val("0");
        }
        // make other rows not primary
        var academicBlock = $("#form-step-1");
        var otherCheckboxes = academicBlock.find('.primary_qualification').not(thisCheckbox);
        var otherCheckboxesVal = academicBlock.find('.primary_qualification_value').not(thisCheckboxVal);

        otherCheckboxes.prop('checked', false);
        otherCheckboxesVal.val('0')

    });
    // mark primary academic qualification -- end


    // validate using 1000Hz bootstrap validator -- start
    // validation on form wizard steps
    $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
        var elmForm = $("#form-step-" + stepNumber);

        // stepDirection === 'forward' :- this condition allows to do the form validation
        // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
        if(stepDirection === 'forward' && elmForm){

            // elmForm.validator({
            //     custom: {
            //         'intltelephone2': function ($el) {
            //             return validateTelephone($el);
            //         }
            //     }
            // });


            elmForm.validator('update');
            elmForm.validator('validate');
            // validateTelephone($('.telephone-number'));
//                var elmErr = elmForm.children().children('.has-error');
            var elmErr = elmForm.find('.has-error');

            if(elmErr && elmErr.length > 0){
                // Form validation failed
                return false;
            }
        }
        return true;
    });
    $("#normalRegistrationSubmit").click(function (event) {
        event.preventDefault();
        $(this).prop('disabled', true);
        $("#reg_form").validator('update');
        $("#reg_form").validator('validate');
        $(".telephone-number").trigger('focusout');

        $("#reg_form").submit();

    });

    $('#reg_form').submit(function (event) {
        event.preventDefault();
        
        $('.error-block, .error-block2').css('display', 'none').html('');

        var formData = new FormData(this);
        if ($('#form_edit_mode').val() == '1'){
            var submitPath = '../direct-route/resubmit';
        }else{
            var submitPath = '../direct-route/submit';
        }
        $.ajax({
            type: 'POST',
            url: submitPath,
            data: formData,
            beforeSend: function() {
                $('#normalRegistrationSubmit').removeClass('btn-success').addClass('btn-warning').html('Submitting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
            },
            success: function (data) {
                // console.log('Submission was successful.');
                // console.log(JSON.parse(data));
                data = JSON.parse(data);
                if(data['file_user_profile_picture']){
                    $("#user_profile_picture").parent().siblings('.error-block').append(data['file_user_profile_picture']).css('display', 'block');
                }
                if(data['user_birth_certificate']){
                    $("#user_birth_certificate").parent().siblings('.error-block').append(data['user_birth_certificate']).css('display', 'block');
                }
                if(data['user_experience_report']){
                    $("#user_experience_report").parent().siblings('.error-block').append(data['user_experience_report']).css('display', 'block');
                }
                if(data['design_report']){
                    $("#design_report").parent().siblings('.error-block').append(data['design_report']).css('display', 'block');
                }
                if(data['file_user_al_certificate']){
                    $("#form-step-1 .error-block2").append(data['file_user_al_certificate']).css('display', 'block');
                }
                if(data['file_certificate_upload']){
                    $("#form-step-1 .error-block").append(data['file_certificate_upload']).css('display', 'block');
                }
                if(data['file_proposer_signed_doc']){
                    $("#form-step-2 .error-block").append(data['file_proposer_signed_doc']).css('display', 'block');
                }
                if(data['file_exp_upload_certificate']){
                    $("#form-step-3 .error-block").append(data['file_exp_upload_certificate']).css('display', 'block');
                }
                if(data['file_mem_upload_certificate']){
                    $("#form-step-4 .error-block").append(data['file_mem_upload_certificate']).css('display', 'block');
                }
                if(data['files_validation'] == 0){
                    swal('Oops...', 'File upload error!', 'error');
                }
                
                if(data['status'] == 0 && data['validation'] == 1){
                    swal('Oops...', 'Something went wrong!', 'error');
                }
                if(data['status'] == 0 && data['validation'] == 0){
                    swal('Oops...', 'Some of the required information has not been given!', 'error');
                }
                if(data['create_user'] == 0){
                    swal('Oops...', 'Temporary user account creation failed!', 'error');
                }

                if(data['db_insert'] == 1){
                    // redirect to success page
                    if(data['newTempUserEmail']) {
                        // new entry
                        location.replace('../direct-route/success?em=' + data['newTempUserEmail'] + '&ps=' + data['newTempUserAccInfo']['password'] + '&id=' + data['newTempUserAccInfo']['id']);
                    }else{
                        // update
                        location.replace('../direct-route/success');
                    }
                }

            },
            error: function (data) {
                console.log('An error occurred.');
                // console.log(data);
            },
            complete: function (){
                $('#normalRegistrationSubmit').prop('disabled', false).removeClass('btn-warning').addClass('btn-success').html('Submit');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $("#user_email").on('keyup blur', function () {
        var user_email = $(this).val();
        var user_id = $("#mem_user_id").val();
        $("#user_email_match").val(user_email);
        $.ajax({
            url: "../MemberDirectRouteRegistration/unique_email/",
            data: {
                email: user_email,
                user_id: user_id
            },
            dataType: "json",
            type: 'post',
            success: function (data) {
                // console.log(data);

                if(data.status == false){
                    // $("#user_email").parent().addClass("has-error").addClass("has-danger");
                    $("#user_email_match").val("");
                    $("#user_email").trigger("focusout");

                }
                else{
                    $("#user_email_match").val(user_email);
                    $("#user_email").trigger("focusout");
                }

            },
            error: function () {
            }
        });
    });

    $("#user_nic").on('keyup blur', function () {
        var user_nic = $(this).val();
        var user_id = $("#mem_user_id").val();
        $("#user_nic_match").val(user_nic);
        $.ajax({
            url: "../MemberDirectRouteRegistration/unique_nic/",
            data: {
                nic: user_nic,
                user_id: user_id
            },
            dataType: "json",
            type: 'post',
            success: function (data) {
                // console.log(data);

                if(data.status == false){
                    $("#user_nic_match").val("");
                    $("#user_nic").trigger("focusout");

                }
                else{
                    $("#user_nic_match").val(user_nic);
                    $("#user_nic").trigger("focusout");
                }

            },
            error: function () {
            }
        });
    });


    // Telephpne fields validation - start
    function validateTelephone(element) {

        var errs = "";
        if(!element.intlTelInput("isValidNumber")){

            var telephone_num_err = element.intlTelInput("getValidationError");
            if (telephone_num_err == intlTelInputUtils.validationError.NOT_A_NUMBER) {
                errs += "Not a valid number";
            }
            if (telephone_num_err == intlTelInputUtils.validationError.IS_POSSIBLE) {
                errs += "This is number is invalid";
            }
            if (telephone_num_err == intlTelInputUtils.validationError.INVALID_COUNTRY_CODE) {
                errs += "Invalid country code";
            }
            if (telephone_num_err == intlTelInputUtils.validationError.TOO_SHORT) {
                errs += "Number too short";
            }
            if (telephone_num_err == intlTelInputUtils.validationError.TOO_LONG) {
                errs += "Number too long";
            }
            return errs;
        }

    }
    $(".telephone-number").focusout(function (event) {
        event.preventDefault();

        var field = $(this);
        var error_block = field.parent().siblings('.help-block.with-errors');
        var form_group = field.closest('.form-group');

        if(field.attr('required') || field.val().length > 0){
            field.removeAttr('novalidate');
            error_block.html('');
            form_group.removeClass('has-error has-danger');

            var intltele = field.intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
            field.val(intltele);

            var err = validateTelephone(field);
            if(err && err.length > 0){
                var errors = "<ul class='list-unstyled'><li>"+err+"</li></ul>";
                field.attr('novalidate', true);
                error_block.append(errors);
                form_group.addClass('has-error has-danger');
            }
        }
        event.stopPropagation();
    });
    $(".telephone-number").keyup(function (event) {
        event.preventDefault();

        var field = $(this);
        var error_block = field.parent().siblings('.help-block.with-errors');
        var form_group = field.closest('.form-group');

        field.removeAttr('novalidate');
        error_block.html('');
        form_group.removeClass('has-error has-danger');

        event.stopPropagation();
    });

    // also call this on general validation function $(".telephone-number").trigger('focusout');
    // Telephone fields valication - End


    // validate using 1000Hz bootstrap validator -- end

    function submitNormalRegForm() {
        var uname = document.getElementById('user_email').value;
        var pwd = document.getElementById('user_nic').value;
        var msg = "You have registered on our system successfully.\n\n In a few moments you will be redirected to the login page.\n\n Your username and password have already been sent to your email. ";

        swal({
            title: "Success!",
            text: msg,
            icon: "success"
        });

        setTimeout(function () {
            window.location.replace('<?php echo site_url(""); ?>');
        }, 10000);

//            event.preventDefault();
    }

    $('.academic_qualifications_clone_button').click(function (event) {
        event.preventDefault();
        $(this).fadeOut(100);
        $(this).siblings(".data_row_clear_button_academic").fadeOut(100);
        $(this).siblings(".academic_qualifications_clone_remove_button").fadeIn(1000);

        var parentPanel = $(this).closest('.academic-panel');
        var todayDate = new Date().getDate();
        var academic_row_clone_template = $('#academic_qualifications_clone');
        // academic_row_clone_template.find(".study_period_from_required, .study_period_to_required, .institute_name_required, .institute_type_required, .qualification_awarded_required, .year_of_award_required").prop('required',true);
        var academic_row_clone = academic_row_clone_template.clone(true);
        academic_row_clone.css('display', 'block').removeAttr("id");
        academic_row_clone.find(".date-field-clone-start").datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years'
        });
        academic_row_clone.find(".date-field-clone-end").datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD',
            viewMode: 'years',
            maxDate: new Date(new Date().setDate(todayDate + 1))
        });
        academic_row_clone.find(".date-field-year-clone").datetimepicker({
            viewMode: 'years',
            format: 'YYYY',
            maxDate: new Date(new Date().setDate(todayDate + 1))
        });
        
        academic_row_clone.find(".select-dropdown-tags-clone").select2({
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                  return null;
                }

                return {
                  id: term.substr(0,1).toUpperCase()+term.substr(1),
                  text: term.substr(0,1).toUpperCase()+term.substr(1),
                  newTag: true // add additional parameters
                }
            }
        });

        // academic_row_clone_template.find(".study_period_from_required, .study_period_to_required, .institute_name_required, .institute_type_required, .qualification_awarded_required, .year_of_award_required").prop('required',false);

        // $('#form-step-1 .tab-cont').append(academic_row_clone);
        // $(academic_row_clone).insertAfter('#form-step-1 .tab-cont .academic-clone-div');
        $(academic_row_clone).insertAfter(parentPanel);
        //$(academic_row_clone).appendTo($('#academic_qualifications_clone_container'));
    });

    $(".academic_qualifications_clone_remove_button").click(function (event) {
        event.preventDefault();
        // $(this).closest(".academic_qualifications_clone").remove();
        $(this).closest(".academic-panel").remove();
    });

    $('#proposers_clone_button').click(function (event) {
        event.preventDefault();
        var proposers_row_clone_template = $('#proposers_clone');
        proposers_row_clone_template.find(".proposer_name_w_initials_required, .proposer_membership_class_required, .proposer_membership_no_required").prop('required',true);
        var proposers_row_clone = proposers_row_clone_template.clone(true);
        proposers_row_clone.css('display', 'block').removeAttr("id");
        proposers_row_clone_template.find(".proposer_name_w_initials_required, .proposer_membership_class_required, .proposer_membership_no_required").prop('required',false);

        // $('#form-step-2 .tab-cont').append(proposers_row_clone);
        $(proposers_row_clone).insertAfter('#form-step-2 .tab-cont .title-row');
    });

    $(".proposers_clone_remove_button").click(function (event) {
        event.preventDefault();
        $(this).closest(".proposers_clone").remove();
    });

    $('.past_exp_clone_button').click(function (event) {
        event.preventDefault();
        $(this).siblings(".data_row_clear_button").fadeOut(100);
        $(this).fadeOut(100);
        $(this).siblings(".past_exp_clone_remove_button").fadeIn(1000);

        var past_exp_row_clone_template = $('#past_exp_clone');
        // past_exp_row_clone_template.find(".exp_work_period_from_required, .exp_work_period_to_required, .exp_place_of_work_required, .exp_position_held_required, .exp_description_required").prop('required',true);
        var past_exp_row_clone = past_exp_row_clone_template.clone(true);
        past_exp_row_clone.css('display', 'block').removeAttr("id");
        past_exp_row_clone.find(".date-field-clone-start").datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years'
        });
        past_exp_row_clone.find(".date-field-clone-end").datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD',
            viewMode: 'years'
        });
        
         past_exp_row_clone.find(".select-dropdown-tags-clone").select2({
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                  return null;
                }

                return {
                  id: term.substr(0,1).toUpperCase()+term.substr(1),
                  text: term.substr(0,1).toUpperCase()+term.substr(1),
                  newTag: true // add additional parameters
                }
            }
        });
        // past_exp_row_clone_template.find(".exp_work_period_from_required, .exp_work_period_to_required, .exp_place_of_work_required, .exp_position_held_required, .exp_description_required").prop('required',false);

        // $('#form-step-3 .tab-cont').append(past_exp_row_clone);
        $(past_exp_row_clone).insertAfter('#form-step-3 .tab-cont .exp-clone-div');
    });

    $(".past_exp_clone_remove_button").click(function (event) {
        event.preventDefault();
        $(this).closest(".exp-panel").remove();
    });

    $('.prof_mem_clone_button').click(function (event) {
        event.preventDefault();
        $(this).siblings(".data_row_clear_button_academic").fadeOut(100);
        $(this).fadeOut(100);
        $(this).siblings(".prof_mem_clone_remove_button").fadeIn(1000);

        var prof_mem_row_clone_template = $('#prof_mem_clone');
        // prof_mem_row_clone_template.find(".mem_institute_required, .mem_membership_no_required, .mem_joined_year_required").prop('required',true);
        var prof_mem_row_clone = prof_mem_row_clone_template.clone(true);
        prof_mem_row_clone.css('display', 'block').removeAttr("id");
//        prof_mem_row_clone.find(".date-field-year-clone").datetimepicker({
//            viewMode: 'years',
//            format: 'YYYY'
//        });

        var todayDate = new Date().getDate();
        prof_mem_row_clone.find(".date-field-year-clone").datetimepicker({
            viewMode: 'years',
            format: 'YYYY',
            maxDate: new Date(new Date().setDate(todayDate + 1))
        });

        // prof_mem_row_clone_template.find(".mem_institute_required, .mem_membership_no_required, .mem_joined_year_required").prop('required',false);

        // $('#form-step-4-sub').append(prof_mem_row_clone);
        $(prof_mem_row_clone).insertAfter('#form-step-4-sub .title-row');
    });

    $(".prof_mem_clone_remove_button").click(function (event) {
        event.preventDefault();
        $(this).closest(".profmem-row").remove();
    });

    // this is for past_exp and professionl_membership sections to clear partially entered data rows
    $(".data_row_clear_button").click(function (event) {
        event.preventDefault();
        var this_data_row = $(this).closest(".data-row");
        this_data_row.find(".required-toggle").val('').prop("required", false);
        this_data_row.find(".form-dropdown").prop("selectedIndex", 0);
        this_data_row.find(".file_info, .help-block.with-errors").html('');
        this_data_row.find(".has-error.has-danger").removeClass('has-error has-danger');
    });

    // academic qualification form clear button
    $(".data_row_clear_button_academic").click(function (event) {
        event.preventDefault();
        var this_data_row = $(this).closest(".data-row");
        this_data_row.find(".required-toggle").val('');
        this_data_row.find(".file_info, .help-block.with-errors").html('');
        this_data_row.find(".has-error.has-danger").removeClass('has-error has-danger');
    });

    // load CIE and MIE users for proposers -- Start
    var inputCorpoMem = $("input.corporate-members-name");
    var inputCorpoMemNum = $("input.corporate-members-memnum");


    // search by name
    $.get('../MemberDirectRouteRegistration/fetchCorporateMembers/', function(data){
        inputCorpoMem.typeahead({
            source: data,
            minLength: 3,
            highlight: true
        });
    }, 'json');
    // search by membership number
    $.get('../MemberDirectRouteRegistration/fetchCorporateMembersMemNum/', function(data){
        inputCorpoMemNum.typeahead({
            source: data,
            minLength: 3,
            highlight: true
        });
    }, 'json');

    // Search by name handle
    inputCorpoMem.change(function(){
        var current = inputCorpoMem.typeahead("getActive");
        var corpo_row_1 = $(this).parent().parent().parent().parent().find('.corpo-row-1');
        var corpo_row_2 = $(this).parent().parent().parent().parent().find('.corpo-row-2');
        var corpo_row_3 = $(this).parent().parent().parent().parent().find('.corpo-row-3');
        var corpo_row_4 = $(this).parent().parent().parent().parent().find('.corpo-row-4');
        var other_proposer = [];
            other_proposer.push(corpo_row_1.find('.corporate-member-mem-name').val());
            other_proposer.push(corpo_row_2.find('.corporate-member-mem-name').val());
            other_proposer.push(corpo_row_3.find('.corporate-member-mem-name').val());
            other_proposer.push(corpo_row_4.find('.corporate-member-mem-name').val());
            
        if( corpo_row_1.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMem.val() == current.name) {
                corpo_row_1.find('.corporate-member-mem-name').val(current.name);
                corpo_row_1.find('.corporate-member-mem-num').val(current.memnum);
                corpo_row_1.find('.corporate-member-mem-class').val(current.memclass);
                corpo_row_1.find('.corporate-member-mem-class-id').val(current.memclassid);
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
                corpo_row_1.validator('validate'); // to remove validation errors
                // to prevent same user being picked
                if(other_proposer.indexOf(current.name) >= 0){
                    $("#proposer_name_w_initials_match_row1").val('');
                }else {
                    $("#proposer_name_w_initials_match_row1").val(current.name);
                }
            }
        }else if( corpo_row_2.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMem.val() == current.name) {
                corpo_row_2.find('.corporate-member-mem-name').val(current.name);
                corpo_row_2.find('.corporate-member-mem-num').val(current.memnum);
                corpo_row_2.find('.corporate-member-mem-class').val(current.memclass);
                corpo_row_2.find('.corporate-member-mem-class-id').val(current.memclassid);
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
                corpo_row_2.validator('validate'); // to remove validation errors
                // to prevent same user being picked
                
                if(other_proposer.indexOf(current.name) >= 0){
                    $("#proposer_name_w_initials_match_row2").val('');
                }else {
                    $("#proposer_name_w_initials_match_row2").val(current.name);
                }
            }
        }else if( corpo_row_3.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMem.val() == current.name) {
                console.log(current.name);
                corpo_row_3.find('.corporate-member-mem-name').val(current.name);
                corpo_row_3.find('.corporate-member-mem-num').val(current.memnum);
                corpo_row_3.find('.corporate-member-mem-class').val(current.memclass);
                corpo_row_3.find('.corporate-member-mem-class-id').val(current.memclassid);
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
                corpo_row_3.validator('validate'); // to remove validation errors
                // to prevent same user being picked
                if(other_proposer.indexOf(current.name) >= 0){
                    $("#proposer_name_w_initials_match_row3").val('');
                }else {
                    $("#proposer_name_w_initials_match_row3").val(current.name);
                }
            }
        }else if( corpo_row_4.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMem.val() == current.name) {
                corpo_row_4.find('.corporate-member-mem-name').val(current.name);
                corpo_row_4.find('.corporate-member-mem-num').val(current.memnum);
                corpo_row_4.find('.corporate-member-mem-class').val(current.memclass);
                corpo_row_4.find('.corporate-member-mem-class-id').val(current.memclassid);
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
                corpo_row_4.validator('validate'); // to remove validation errors
                // to prevent same user being picked
                if(other_proposer.indexOf(current.name) >= 0){
                    $("#proposer_name_w_initials_match_row4").val('');
                }else {
                    $("#proposer_name_w_initials_match_row4").val(current.name);
                }
            }
        }else{
            if(inputCorpoMem.val() == current.name) {
                // console.log(corpo_row_1.find('.corporate-member-mem-name').val());
                // console.log(corpo_row_2.find('.corporate-member-mem-name').val());
                swal("Oops!", "You have selected sufficient proposers", "warning");
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
            }
        }

    });

    // Search by membership number handle
    inputCorpoMemNum.change(function(){
        var current = inputCorpoMemNum.typeahead("getActive");
        var corpo_row_1 = $(this).parent().parent().parent().parent().find('.corpo-row-1');
        var corpo_row_2 = $(this).parent().parent().parent().parent().find('.corpo-row-2');
        var corpo_row_3 = $(this).parent().parent().parent().parent().find('.corpo-row-3');
        var corpo_row_4 = $(this).parent().parent().parent().parent().find('.corpo-row-4');
        
        var other_proposer = [];
            other_proposer.push(corpo_row_1.find('.corporate-member-mem-name').val());
            other_proposer.push(corpo_row_2.find('.corporate-member-mem-name').val());
            other_proposer.push(corpo_row_3.find('.corporate-member-mem-name').val());
            other_proposer.push(corpo_row_4.find('.corporate-member-mem-name').val());

        if( corpo_row_1.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMemNum.val() == current.name) {
                corpo_row_1.find('.corporate-member-mem-name').val(current.name2);
                corpo_row_1.find('.corporate-member-mem-num').val(current.memnum);
                corpo_row_1.find('.corporate-member-mem-class').val(current.memclass);
                corpo_row_1.find('.corporate-member-mem-class-id').val(current.memclassid);
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
                corpo_row_1.validator('validate'); // to remove validation errors
                // to prevent same user being picked
                
                if(other_proposer.indexOf(current.name2) >= 0){
                    $("#proposer_name_w_initials_match_row1").val('');
                }else {
                    $("#proposer_name_w_initials_match_row1").val(current.name2);
                }
            }
        }else if( corpo_row_2.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMemNum.val() == current.name) {
                corpo_row_2.find('.corporate-member-mem-name').val(current.name2);
                corpo_row_2.find('.corporate-member-mem-num').val(current.memnum);
                corpo_row_2.find('.corporate-member-mem-class').val(current.memclass);
                corpo_row_2.find('.corporate-member-mem-class-id').val(current.memclassid);
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
                corpo_row_2.validator('validate'); // to remove validation errors
                // to prevent same user being picked
                if(other_proposer.indexOf(current.name2) >= 0){ // same propser is in other row
                    $("#proposer_name_w_initials_match_row2").val('');
                }else {
                    $("#proposer_name_w_initials_match_row2").val(current.name2);
                }
            }
        }else if( corpo_row_3.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMemNum.val() == current.name) {
                corpo_row_3.find('.corporate-member-mem-name').val(current.name2);
                corpo_row_3.find('.corporate-member-mem-num').val(current.memnum);
                corpo_row_3.find('.corporate-member-mem-class').val(current.memclass);
                corpo_row_3.find('.corporate-member-mem-class-id').val(current.memclassid);
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
                corpo_row_3.validator('validate'); // to remove validation errors
                // to prevent same user being picked
                if(other_proposer.indexOf(current.name2) >= 0){ // same propser is in other row
                    $("#proposer_name_w_initials_match_row3").val('');
                }else {
                    $("#proposer_name_w_initials_match_row3").val(current.name2);
                }
            }
        }else if( corpo_row_4.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMemNum.val() == current.name) {
                corpo_row_4.find('.corporate-member-mem-name').val(current.name2);
                corpo_row_4.find('.corporate-member-mem-num').val(current.memnum);
                corpo_row_4.find('.corporate-member-mem-class').val(current.memclass);
                corpo_row_4.find('.corporate-member-mem-class-id').val(current.memclassid);
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
                corpo_row_4.validator('validate'); // to remove validation errors
                // to prevent same user being picked
                if(other_proposer.indexOf(current.name2) >= 0){ // same propser is in other row
                    $("#proposer_name_w_initials_match_row4").val('');
                }else {
                    $("#proposer_name_w_initials_match_row4").val(current.name2);
                }
            }
        }else{
            if(inputCorpoMemNum.val() == current.name) {
                swal("Oops!", "You have selected sufficient proposers", "warning");
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
            }
        }

    });

    // proposer clear button handle
    $(".proposers_clear_button").click(function (event) {
        event.preventDefault();
        //clear this row
        var row = $(this).parent().parent().parent().parent().parent();
        row.find('.corporate-member-mem-name').val('');
        row.find('.corporate-member-mem-num').val('');
        row.find('.corporate-member-mem-class').val('');
        row.find('.corporate-member-mem-class-id').val('');
        row.find('.proposer-file').prop('required', true);
        if(row.hasClass('corpo-row-1')){
            // if this is row-1
            var other_row = $(this).parent().parent().parent().parent().parent().parent().find('.corpo-row-2');
            $("#proposer_name_w_initials_match_row2").val(other_row.find('.corporate-member-mem-name').val()); // in case same proposer validation is triggered in other row
            $("#proposer_name_w_initials_match_row1").val(''); // clear same proposer validation in this row
        }else if(row.hasClass('corpo-row-2')){
            // if this is row-2
            var other_row = $(this).parent().parent().parent().parent().parent().parent().find('.corpo-row-1');
            $("#proposer_name_w_initials_match_row1").val(other_row.find('.corporate-member-mem-name').val()); // in case same proposer validation is triggered in other row
            $("#proposer_name_w_initials_match_row2").val(''); // clear same proposer validation in this row
        }

        inputCorpoMem.val('');
        inputCorpoMemNum.val('');

    });

    // load CIE and MIE users for proposers -- End


    // new file upload for old academic record handle -- Start
    $(".upload-new-file-button").click(function (event) {
        event.preventDefault();

        var r = confirm("Are you sure? This action cannot be reversed.\nPreviously uploaded file will be discarded.");
        if (r == true) {

            $(this).siblings(".old-attachment-preview").remove();
            $(this).siblings(".prev-uploaded-file").val("0");

            var academic_new_file_upload_clone_template = $('#new_file_upload_clone_academic');
            academic_new_file_upload_clone_template.find(".new_file_upload_clone_academic_required").prop('required',true);
            var academic_new_file_upload_clone = academic_new_file_upload_clone_template.clone(true);
            academic_new_file_upload_clone.css('display', 'block').removeAttr("id");
            academic_new_file_upload_clone_template.find(".new_file_upload_clone_academic_required").prop('required',false);
            $(this).after(academic_new_file_upload_clone);
            $(this).remove();

        } else {
            return false;
        }

    });
    // new file upload for old academic record handle -- End

    // new file upload for old proposer record handle -- Start
    $(".upload-new-file-button-proposer").click(function (event) {
        event.preventDefault();

        var r = confirm("Are you sure? This action cannot be reversed.\nPreviously uploaded file will be discarded.");
        if (r == true) {

            $(this).siblings(".old-attachment-preview").remove();
            $(this).siblings(".prev-uploaded-file").val("0");

            var proposer_new_file_upload_clone_template = $('#new_file_upload_clone_proposer1');
            var proposer_new_file_upload_clone_template2 = $('#new_file_upload_clone_proposer2');
            proposer_new_file_upload_clone_template.find(".new_file_upload_clone_porposer_required").prop('required',true);
            var proposer_new_file_upload_clone = proposer_new_file_upload_clone_template.clone(true);
            var proposer_new_file_upload_clone2 = proposer_new_file_upload_clone_template2.clone(true);
            proposer_new_file_upload_clone.css('display', 'block').removeAttr("id");
            proposer_new_file_upload_clone2.css('display', 'block').removeAttr("id");
            proposer_new_file_upload_clone_template.find(".new_file_upload_clone_exp_required").prop('required',false);
            $(this).after(proposer_new_file_upload_clone);
            $(this).parent().append(proposer_new_file_upload_clone2);
            $(this).remove();

        } else {
            return false;
        }

    });
    // new file upload for old proposer record handle -- End
    // new file upload for old exp record handle -- Start
    $(".upload-new-file-button-exp").click(function (event) {
        event.preventDefault();

        var r = confirm("Are you sure? This action cannot be reversed.\nPreviously uploaded file will be discarded.");
        if (r == true) {

            $(this).siblings(".old-attachment-preview, .prev-uploaded-file").remove();

            var exp_new_file_upload_clone_template = $('#new_file_upload_clone_exp');
            exp_new_file_upload_clone_template.find(".new_file_upload_clone_exp_required").prop('required',true);
            var exp_new_file_upload_clone = exp_new_file_upload_clone_template.clone(true);
            exp_new_file_upload_clone.css('display', 'block').removeAttr("id");
            exp_new_file_upload_clone_template.find(".new_file_upload_clone_exp_required").prop('required',false);
            $(this).after(exp_new_file_upload_clone);
            $(this).remove();

        } else {
            return false;
        }

    });
    // new file upload for old exp record handle -- End
    // new file upload for old profmem record handle -- Start
    $(".upload-new-file-button-profmem").click(function (event) {
        event.preventDefault();

        var r = confirm("Are you sure? This action cannot be reversed.\nPreviously uploaded file will be discarded.");
        if (r == true) {

            $(this).siblings(".old-attachment-preview, .prev-uploaded-file").remove();

            var profmem_new_file_upload_clone_template = $('#new_file_upload_clone_profmem');
            profmem_new_file_upload_clone_template.find(".new_file_upload_clone_profmem_required").prop('required',true);
            var profmem_new_file_upload_clone = profmem_new_file_upload_clone_template.clone(true);
            profmem_new_file_upload_clone.css('display', 'block').removeAttr("id");
            profmem_new_file_upload_clone_template.find(".new_file_upload_clone_exp_required").prop('required',false);
            $(this).after(profmem_new_file_upload_clone);
            $(this).remove();

        } else {
            return false;
        }

    });
    // new file upload for old profmem record handle -- End
    // show file name when a file is selected -- start
    $("input[type=file]").on("change", function () {
        $(this).parent().siblings(".file_info").html($(this)[0].files[0].name);
    });
    // show file name when a file is selected -- end

    // form wizard navigation -- start
    $(".form-button-next-step").click(function (event) {
        event.preventDefault();
        var this_step = parseInt($(this).data('step'));
        var next_step = this_step + 1; 
        // $("#form-button-step-"+next_step).trigger('click');

        var formSection = $("#form-step-"+this_step); 

        // formSection.validator({
        //     custom: {
        //         intltelephone: function ($el) {
        //             return validateTelephone($el);
        //         }
        //     }
        // });


        formSection.validator('update');
        formSection.validator('validate');
        $(".telephone-number").trigger('focusout');

        var elmErr = formSection.find('.has-error');

        if(elmErr && elmErr.length > 0){
            // Form validation failed
            return false;
        }else{
            $("#form-button-step-"+next_step).trigger('click');
            $('html, body').animate({
                scrollTop: $("#form-button-step-"+next_step).offset().top
            }, 500);
        }


    });
    $(".form-button-prev-step").click(function (event) {
        event.preventDefault();
        var next_step = parseInt($(this).data('step')) - 1;
        $("#form-button-step-"+next_step).trigger('click');
    });

    // form wizard navigation -- end

    // required-toggle handlers -- start
    $(".required-toggle").change(function (event) {
        event.preventDefault();

        var this_input_element = $(this);
        var this_data_row = this_input_element.closest(".data-row");
        if(!!this_input_element.val()){
            this_data_row.find(".required-toggle").prop('required', true);
            if(this_data_row.find("input.from-date-disable").length>0){
                if(this_data_row.find("input.from-date-disable").prop( "checked" )){
//                    alert('1');
                    var parentRow = this_data_row.find("input.from-date-disable").closest(".date-field-group");
                    var parentRowParent = this_data_row.find("input.from-date-disable").closest(".academic-panel");
                    parentRow.find(".date-field-end").prop('required',false).fadeOut();
                    parentRow.find(".date-field-clone-end").prop('required',false).fadeOut();
                    parentRow.find(".date-field-end-error").fadeOut();
                    parentRow.find(".from-date-disable-value").val("1");
                    parentRowParent.find(".year_of_award").prop('required',false);
                    parentRowParent.find(".year_of_award").parent().validator('validate');
                }else{
                    var parentRow = this_data_row.find("input.from-date-disable").closest(".date-field-group");
                    var parentRowParent = this_data_row.find("input.from-date-disable").closest(".academic-panel");
//                    alert('2');
                    parentRow.find(".date-field-end").prop('required',true).fadeIn();
                    parentRow.find(".date-field-clone-end").prop('required',true).fadeIn();
                    parentRow.find(".date-field-end-error").fadeIn();
                    parentRow.find(".from-date-disable-value").val("0");
                    parentRowParent.find(".year_of_award").prop('required',true);
        }
            }
            if(this_data_row.find("input.from-date-disable-clone").length>0){
                if(this_data_row.find("input.from-date-disable-clone").prop( "checked" )){
                    var parentRow = this_data_row.find("input.from-date-disable-clone").closest(".template-row");
                    var parentRowParent = this_data_row.find("input.from-date-disable-clone").closest(".academic-panel");
//                    alert('3');
                    parentRow.find(".date-field-end").prop('required',false).fadeOut();
                    parentRow.find(".date-field-clone-end").prop('required',false).fadeOut();
                    parentRow.find(".date-field-end-error").fadeOut();
                    parentRow.find(".from-date-disable-value").val("1");
                    parentRowParent.find(".year_of_award").prop('required',false);
                    parentRowParent.find(".year_of_award").parent().validator('validate');
                }else{
                    var parentRow = this_data_row.find("input.from-date-disable-clone").closest(".template-row");
                    var parentRowParent = this_data_row.find("input.from-date-disable-clone").closest(".academic-panel");
//                    alert('4');
                    parentRow.find(".date-field-end").prop('required',true).fadeIn();
                    parentRow.find(".date-field-clone-end").prop('required',true).fadeIn();
                    parentRow.find(".date-field-end-error").fadeIn();
                    parentRow.find(".from-date-disable-value").val("0");
                    parentRowParent.find(".year_of_award").prop('required',true);
                }
            }
        }
    });
    // need to trigger 'change' to add required attribute to this data-row
    $('.calendar-field').on("dp.change", function (e) {
        $(this).trigger('change');
    });

    // required-toggle handlers -- End


    // AL results section -- start
    $("select.al-subject").on('change', function (event) {
        event.preventDefault();
        var this_drop = $(this);
        var this_row = this_drop.closest('.al-subject-row');
        var this_drop_value = this_drop.val();
        // console.log(this_drop_value);
        var other_rows = this_row.siblings('.al-subject-row');

        var other_row_values = new Array();
        other_rows.each(function (index) {
            if($(this).find('select.al-subject').val()) {
                var each_drop_value = $(this).find('select.al-subject').val();
                other_row_values.push(each_drop_value);
            }
        });
        other_rows.each(function (index) {
            var now_row = $(this);
            var now_row_value = now_row.find('select.al-subject').val();
            now_row.find('select.al-subject option.drop-option').attr('disabled', false);
            now_row.find('select.al-subject option[value="'+this_drop_value+'"]').attr('disabled',true);
            other_row_values.forEach(function (index, item) {
                if(now_row_value != index) {
                    now_row.find('select.al-subject option[value="' + index + '"]').attr('disabled', true);
                }
            });
        });
    });
    $("select.type-of-exam").on('change', function (event) {
        event.preventDefault();
        var this_drop_value = $(this).val();

        // get subjects
        $.ajax({
            type: 'POST',
            url: '../MemberDirectRouteRegistration/getAlSubjects',
            data: {
                exam_type: this_drop_value
            },
            success: function (data) {
                data = JSON.parse(data);
                $("select.al-subject").html(data.subjects);
                $("select.al-result").html(data.results);
            },
            error: function (data) {
                console.log('An error occurred.');
            },
            cache: false
        });
    });
    // AL results section -- end

    function readURL(input) {

        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            $('#prof_pic_preview_image').attr('src', e.target.result).fadeIn();
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

    $("#user_profile_picture").change(function() {
        readURL(this);
    });
});
function setFormSubmitting() {
    formSubmitting = true;
}
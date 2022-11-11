 /**
 * Created by test on 4/27/2018.
 */



$(document).ready(function($){

    // Initalize form wizard
    $('#smartwizard').smartWizard({
        keyNavigation: false,
        autoAdjustHeight: true,
        showStepURLhash: false,
        transitionEffect: 'fade',
        transitionSpeed: '1000',
        theme: 'arrows',
        toolbarSettings: {
            toolbarPosition: 'both', // none, top, bottom, both
            toolbarButtonPosition: 'right', // left, right
            showNextButton: true, // show/hide a Next button
            showPreviousButton: true // show/hide a Previous button
        }
    });

    // Initialize datepickers
    $(function () {
        var todayDate = new Date().getDate();
        $('#user_dob').datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years',
            maxDate: new Date(new Date().setDate(todayDate - 6570))// 6570days = 18years // can reduce(-) no_of_days to match minimum applicant age (21 yrs)
        });
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
        $('#user_dob').val(""); // necessary to remove auto selected date by MaxSDate option
    });

    $(function () {
        // initialize telephone fields
        $(".telephone-number").intlTelInput({
            utilsScript: "../application/vendor/jackocnr/intl-tel-input/build/js/utils.js",
            initialCountry: "LK",
            nationalMode: true
            // separateDialCode: true
        });

        $('#reg_form').validator({
            custom: {
                equals: function($el) {
                    var matchValue = $el.data("equals"); // foo
                    if ($el.val() !== matchValue) {
                        return "Hey, that's not valid! It's gotta be " + matchValue
                    }
                },
                intltelephone: function ($el) {
                    return validateTelephone($el);
                }
            }
        });
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
        if($(this).prop( "checked" )){ console.log("hide");
            parentRow.find(".date-field-end").prop('required',false).fadeOut();
            parentRow.find(".date-field-end-error").fadeOut();
            parentRow.find(".from-date-disable-value").val("1");
        }else{console.log("show");
            parentRow.find(".date-field-end").prop('required',true).fadeIn();
            parentRow.find(".date-field-end-error").fadeIn();
            parentRow.find(".from-date-disable-value").val("0");
        }
    });
    $(".from-date-disable-clone").click(function () {
        var parentRow = $(this).closest(".template-row");
        if($(this).prop( "checked" )){ console.log("hide");
            parentRow.find(".date-field-clone-end").prop('required',false).fadeOut();
            parentRow.find(".date-field-end-error").fadeOut();
            parentRow.find(".from-date-disable-value").val("1");
        }else{console.log("show");
            parentRow.find(".date-field-clone-end").prop('required',true).fadeIn();
            parentRow.find(".date-field-end-error").fadeIn();
            parentRow.find(".from-date-disable-value").val("0");
        }
    });


    // validate using 1000Hz bootstrap validator -- start
    // validation on form wizard steps
    $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
        var elmForm = $("#form-step-" + stepNumber);

        // stepDirection === 'forward' :- this condition allows to do the form validation
        // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
        if(stepDirection === 'forward' && elmForm){console.log(elmForm);

            elmForm.validator({
                custom: {
                    equals: function($el) {
                        var matchValue = $el.data("equals"); // foo
                        if ($el.val() !== matchValue) {
                            return "Hey, that's not valid! It's gotta be " + matchValue
                        }
                    },
                    intltelephone: function ($el) {
                        return validateTelephone($el);
                    }
                }
            });


            elmForm.validator('update');
            elmForm.validator('validate');
            // validateTelephone($('.telephone-number'));
//                var elmErr = elmForm.children().children('.has-error');
            var elmErr = elmForm.find('.has-error');
            console.log(elmErr.length);
            if(elmErr && elmErr.length > 0){
                // Form validation failed
                return false;
            }
        }
        return true;
    });
    $("#normalRegistrationSubmit").click(function (event) {
        event.preventDefault();
       
//        var user_class = $("#user_member_class").val();
//        var training_count = $("#count_training_ex").val();
//        
//        if(user_class >= 8 && training_count == 0){
//            swal("Opps!",'Please update your experience reports in your profile, before applying to account recovery.',"error");
//           // swal('Opps.','Please update your training experience details in your profile before apply to recovery.','Error');
//        }else{
           
        $(this).prop('disabled', true).prop('disabled', true).removeClass('btn-success').addClass('btn-warning').html('Submitting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');

        var elmForm = $("#form-step-4");
        var fullForm = $("#reg_form");

        elmForm.validator('update');
        elmForm.validator('validate');
        fullForm.validator('update');
        fullForm.validator('validate');
        var elmErr = elmForm.find('.has-error');
        var fullErr = fullForm.find('.has-error');

        if(elmErr && elmErr.length <= 0 && fullErr.length <= 0){
            // Form validation success
//                submitNormalRegForm();
            fullForm.trigger('submit');
        }
        $(this).prop('disabled', false).removeClass('btn-warning').addClass('btn-success').html('<i class="fa fa-paper-plane-o"></i> &nbsp; Submit');
//    }
    });

    $("#user_email").keyup(function () {
        var user_email = $(this).val();
        $("#user_email_match").val(user_email);
        $.ajax({
            url: "./MemberRegistration/unique_email/",
            data: {
                email: user_email
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

    $("#user_nic").keyup(function () {
        var user_nic = $(this).val();
        $("#user_nic_match").val(user_nic);
        $.ajax({
            url: "./MemberRegistration/unique_nic/",
            data: {
                nic: user_nic
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
        var intltele = $(this).intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
        $(this).val(intltele);
        event.stopPropagation();
    });


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

    $('#academic_qualifications_clone_button').click(function (event) {
        event.preventDefault();
        var todayDate = new Date().getDate();
        var academic_row_clone_template = $('#academic_qualifications_clone');
        academic_row_clone_template.find(".study_period_from_required, .study_period_to_required, .institute_name_required, .institute_type_required, .qualification_awarded_required, .year_of_award_required").prop('required',true);
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
            format: 'YYYY'
        });

        academic_row_clone_template.find(".study_period_from_required, .study_period_to_required, .institute_name_required, .institute_type_required, .qualification_awarded_required, .year_of_award_required").prop('required',false);

        $('#form-step-1').append(academic_row_clone);
    });

    $(".academic_qualifications_clone_remove_button").click(function (event) {
        event.preventDefault();
        $(this).closest(".academic_qualifications_clone").remove();
    });

    $('#proposers_clone_button').click(function (event) {
        event.preventDefault();
        var proposers_row_clone_template = $('#proposers_clone');
        proposers_row_clone_template.find(".proposer_name_w_initials_required, .proposer_membership_class_required, .proposer_membership_no_required").prop('required',true);
        var proposers_row_clone = proposers_row_clone_template.clone(true);
        proposers_row_clone.css('display', 'block').removeAttr("id");
        proposers_row_clone_template.find(".proposer_name_w_initials_required, .proposer_membership_class_required, .proposer_membership_no_required").prop('required',false);

        $('#form-step-2').append(proposers_row_clone);
    });

    $(".proposers_clone_remove_button").click(function (event) {
        event.preventDefault();
        $(this).closest(".proposers_clone").remove();
    });

    $('#past_exp_clone_button').click(function (event) {
        event.preventDefault();
        var past_exp_row_clone_template = $('#past_exp_clone');
        past_exp_row_clone_template.find(".exp_work_period_from_required, .exp_work_period_to_required, .exp_place_of_work_required, .exp_position_held_required, .exp_description_required").prop('required',true);
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

        past_exp_row_clone_template.find(".exp_work_period_from_required, .exp_work_period_to_required, .exp_place_of_work_required, .exp_position_held_required, .exp_description_required").prop('required',false);

        $('#form-step-3').append(past_exp_row_clone);
    });

    $(".past_exp_clone_remove_button").click(function (event) {
        event.preventDefault();
        $(this).closest(".past_exp_clone").remove();
    });

    $('#prof_mem_clone_button').click(function (event) {
        event.preventDefault();
        var prof_mem_row_clone_template = $('#prof_mem_clone');
        prof_mem_row_clone_template.find(".mem_institute_required, .mem_membership_no_required, .mem_joined_year_required").prop('required',true);
        var prof_mem_row_clone = prof_mem_row_clone_template.clone(true);
        prof_mem_row_clone.css('display', 'block').removeAttr("id");
        prof_mem_row_clone.find(".date-field-year-clone").datetimepicker({
            viewMode: 'years',
            format: 'YYYY'
        });

        prof_mem_row_clone_template.find(".mem_institute_required, .mem_membership_no_required, .mem_joined_year_required").prop('required',false);

        $('#form-step-4-sub').append(prof_mem_row_clone);
    });

    $(".prof_mem_clone_remove_button").click(function (event) {
        event.preventDefault();
        $(this).closest(".prof_mem_clone").remove();
    });

    $(".form-button-next-step").click(function (event) {
        event.preventDefault();
        var next_step = parseInt($(this).data('step')) + 1;
        $("#form-button-step-"+next_step).trigger('click');
    });
    $(".form-button-prev-step").click(function (event) {
        event.preventDefault();
        var next_step = parseInt($(this).data('step')) - 1;
        $("#form-button-step-"+next_step).trigger('click');
    });

 $("input[type=file]").on("change", function () {
       $(this).parent().siblings(".file_info").html($(this)[0].files[0].name);
    });
        
});
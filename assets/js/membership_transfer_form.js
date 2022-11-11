 /**
 * Created by test on 4/27/2018.
 */



$(document).ready(function($){



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
        $("#normalRegistrationSubmit").prop('disabled', true).removeClass('btn-success').addClass('btn-warning').html('Submitting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
        var error_count = 0;
        var user_name_w_initials = $('#user_name_w_initials').val();
        var user_nic = $('#user_nic').val();
        var user_email = $('#user_email').val();
        if(user_name_w_initials == "" || user_nic == "" || user_email == ""){
            error_count++;            
        }
        if(error_count > 0){
            swal('Opps..','You must update your basic information in your profile before apply the membership upgrade','error');
        }else{
        
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
        }
            $("#normalRegistrationSubmit").prop('disabled', false).removeClass('btn-warning').addClass('btn-success').html('<i class="fa fa-paper-plane-o"></i> &nbsp; Submit');
      
        
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



// load CIE and MIE users for proposers -- Start
    var inputCorpoMem = $("input.corporate-members-name");
    var inputCorpoMemNum = $("input.corporate-members-memnum");
    

    // search by name
    $.get('../MembershipTransfer/fetchCorporateMembers/', function(data){
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
        var mem_class = $("#member_current_class_id").val();
       
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
            
         //check two purposers of F or HLF member class selected in puposers list. 
                var memcls_count = 0;
                var row_1_memclass = corpo_row_1.find('.corporate-member-mem-class-id').val();
                var row_2_memclass = corpo_row_2.find('.corporate-member-mem-class-id').val();
                var row_3_memclass = corpo_row_3.find('.corporate-member-mem-class-id').val();
                var row_4_memclass = corpo_row_4.find('.corporate-member-mem-class-id').val();
                
                if(row_1_memclass != '' && (row_1_memclass == 9 || row_1_memclass == 12 || row_1_memclass == 13 )){
                    memcls_count++;
                }
                if(row_2_memclass != '' && (row_2_memclass == 9 || row_2_memclass == 12 || row_2_memclass == 13)){
                    memcls_count++;
                }
                if(row_3_memclass != '' && (row_3_memclass == 9 || row_3_memclass == 12 || row_3_memclass == 13)){
                    memcls_count++;
                }
                if(row_4_memclass != '' && (row_4_memclass == 9 || row_4_memclass == 12 || row_4_memclass == 13)){
                    memcls_count++;
                }
               
        if( corpo_row_1.find('.corporate-member-mem-name').val() == ''){
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
                if(memcls_count == 0 && mem_class == 8 && (current.memclassid != 9 && current.memclassid != 12 && current.memclassid != 13)){
                    swal("Oops!", "You must selct atleast two proposers from 'Fellow' or 'Honorary Life Fellow' class", "warning");
                    inputCorpoMem.val('');
                    inputCorpoMemNum.val('');
               }else{
             
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
            }
        }else if( corpo_row_4.find('.corporate-member-mem-name').val() == ''){
            if(inputCorpoMem.val() == current.name) {
                if(memcls_count == 1 && mem_class == 8 && (current.memclassid != 9 && current.memclassid != 12 && current.memclassid != 13)){
                   swal("Oops!", "You must selct atleast two proposers from 'Fellow' or 'Honorary Life Fellow' class", "warning");
                    inputCorpoMem.val('');
                    inputCorpoMemNum.val('');
               }else{
                   
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
        var mem_class = $("#member_current_class_id").val();
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
            
            //check two purposers of F or HLF member class selected in puposers list. 
                var memcls_count = 0;
                var row_1_memclass = corpo_row_1.find('.corporate-member-mem-class-id').val();
                var row_2_memclass = corpo_row_2.find('.corporate-member-mem-class-id').val();
                var row_3_memclass = corpo_row_3.find('.corporate-member-mem-class-id').val();
                var row_4_memclass = corpo_row_4.find('.corporate-member-mem-class-id').val();
                
                if(row_1_memclass != '' && (row_1_memclass == 9 || row_1_memclass == 12 || row_1_memclass == 13 )){
                    memcls_count++;
                }
                if(row_2_memclass != '' && (row_2_memclass == 9 || row_2_memclass == 12 || row_2_memclass == 13)){
                    memcls_count++;
                }
                if(row_3_memclass != '' && (row_3_memclass == 9 || row_3_memclass == 12 || row_3_memclass == 13)){
                    memcls_count++;
                }
                if(row_4_memclass != '' && (row_4_memclass == 9 || row_4_memclass == 12 || row_4_memclass == 13)){
                    memcls_count++;
                }
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
                if(memcls_count == 0 && mem_class == 8 && (current.memclassid != 9 && current.memclassid != 12 && current.memclassid != 13)){
                   swal("Oops!", "You must selct atleast two proposers from 'Fellow' or 'Honorary Life Fellow' class", "warning");
                    inputCorpoMem.val('');
                    inputCorpoMemNum.val('');
               }else{
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
            }
        }else if( corpo_row_4.find('.corporate-member-mem-name').val() == '' ){
            if(inputCorpoMemNum.val() == current.name) {
                if(memcls_count == 1 && mem_class == 8 && (current.memclassid != 9 && current.memclassid != 12 && current.memclassid != 13)){
                   swal("Oops!", "You must selct atleast two proposers from 'Fellow' or 'Honorary Life Fellow' class", "warning");
                    inputCorpoMem.val('');
                    inputCorpoMemNum.val('');
               }else{
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
            }
        }else{
            if(inputCorpoMemNum.val() == current.name) {
                swal("Oops!", "You have selected sufficient proposers", "warning");
                inputCorpoMem.val('');
                inputCorpoMemNum.val('');
            }
        }

    });
     // show file name when a file is selected -- start
    $("input[type=file]").on("change", function () {
        $(this).parent().siblings(".file_info").html($(this)[0].files[0].name);
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

});
$(document).ready(function(){
    
    tinymce.init({
      selector: '.text_editor',
      height: 250,
      menubar: false,
      relative_urls : false,
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
      file_browser_callback_types: 'image',
      file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function() {
          var file = this.files[0];
          
          var reader = new FileReader();
          reader.onload = function () {
            var id = 'blobid' + (new Date()).getTime();
            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);

            cb(blobInfo.blobUri(), { title: file.name });
          };
          reader.readAsDataURL(file);
        };
        
        input.click();
      },
      setup: function(ed) {
        ed.on('init', function(e) {
          ed.execCommand('fontName', false, 'Arial');
        });
      },
      images_upload_handler: function(blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '<?php echo base_url(); ?>Event_initiation/uploadContentImage');
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
          var json;
          if(xhr.status != 200) {
            failure('HTTP Error: ' + xhr.status);
            return;
          }
          json = JSON.parse(xhr.responseText);

          if(!json || typeof json.location != 'string') {
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
    
    if($("input[name='existing_training_program']:checked").val() == '1'){
       $("#existing_training_program_details").css('display','block');
    }else{
       $("#existing_training_program_details").css('display','none');
    }
    
    if($("input[name='person_incharge_training']:checked").val() == '1'){
       $("#person_incharge_training_details").css('display','block');
       $("#person_incharge_training_details").attr("required",true);
    }else{
       $("#person_incharge_training_details").css('display','none');
       $("#person_incharge_training_details").attr("required", false);
    }
    
    $("input[name='existing_training_program']").click(function(){
        if($(this).val() == '1'){
            $("#existing_training_program_details").css('display','block');
            $("#existing_training_program_details").attr("required", true);
        }else{
            $("#existing_training_program_details").css('display','none');
             $("#existing_training_program_details").attr("required", false);
        }
    });
    $("input[name='person_incharge_training']").click(function(){
        if($(this).val() == '1'){
            $("#person_incharge_training_details").css('display','block');
        }else{
            $("#person_incharge_training_details").css('display','none');
        }
    });
   
    $(function () {
        // initialize telephone fields
        $(".telephone-number").intlTelInput({
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.3.0/js/utils.js",
            initialCountry: "LK",
            nationalMode: true
            // separateDialCode: true
        });
        
        if($('#form_edit_mode').val() == '1'){
            // in edit mode, email and nic are defualt shown as duplicates. to fix this
            $('#user_email').trigger('focus');
            $('#user_nic').trigger('focus');
//            $('#user_email').trigger('focus');
            // in edit mode, email and nic are defualt shown as duplicates. to fix this -- end
            
            // edit mode checkbox groups
            $('.checkbox-group-org_discipline .checkbox-option').trigger('change');

        }
    });
    
    $('.checkbox-group-org_discipline .checkbox-option').on('change', function (e) {
        var checkbox = $(this);
        var group = checkbox.closest('.checkbox-group');
        if(checkbox.is(':checked')){
            checkbox.prop('required', true);
        }else{
            checkbox.prop('required', false);
        }
        var checked_checkboxes = group.find('.checkbox-option:checked').not(checkbox);
        if(checked_checkboxes.length === 0){
            group.find('.checkbox-option').not(checkbox).prop('required', !checkbox.prop('required'));
            group.validator('update');
        }
    });
    
    // form wizard navigation -- start
    $(".form-button-next-step").click(function (event) {
        event.preventDefault();
        var this_step = parseInt($(this).data('step'));
        var next_step = this_step + 1;
        // $("#form-button-step-"+next_step).trigger('click');

        var formSection = $("#form-step-"+this_step);

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


    // clonning handle -- start
    $(".btn_clone_add_chartered").click(function(event) {
        event.preventDefault();
        var parent_row = $(this).closest('.engineer-block');
        var pivot = parent_row.find('.insert-after');
        var clone_template = $('#chartered_clone');
        var row_clone = clone_template.clone(true);

        $(this).fadeOut(100);
        $(this).siblings(".btn_clone_clear").fadeOut(100);
        $(this).siblings(".btn_clone_remove").fadeIn(1000);

        row_clone.css('display', 'block').removeAttr("id");
        $(row_clone).insertAfter(pivot);
    });
    $(".btn_clone_add_non_chartered").click(function(event) {
        event.preventDefault();
        var parent_row = $(this).closest('.engineer-block');
        var pivot = parent_row.find('.insert-after');
        var clone_template = $('#non_chartered_clone');
        var row_clone = clone_template.clone(true);

        $(this).fadeOut(100);
        $(this).siblings(".btn_clone_clear").fadeOut(100);
        $(this).siblings(".btn_clone_remove").fadeIn(1000);

        row_clone.css('display', 'block').removeAttr("id");
        $(row_clone).insertAfter(pivot);
    });
    $(".btn_clone_add_non_qualified").click(function(event) {
        event.preventDefault();
        var parent_row = $(this).closest('.engineer-block');
        var pivot = parent_row.find('.insert-after');
        var clone_template = $('#non_qualified_clone');
        var row_clone = clone_template.clone(true);

        $(this).fadeOut(100);
        $(this).siblings(".btn_clone_clear").fadeOut(100);
        $(this).siblings(".btn_clone_remove").fadeIn(1000);

        row_clone.css('display', 'block').removeAttr("id");
        $(row_clone).insertAfter(pivot);
    });

    $(".btn_clone_remove").click(function(event){
        event.preventDefault();
        $(this).closest('.engineer-row').remove();
    });

    $(".btn_clone_clear").click(function(event){
        event.preventDefault();
        var engineer_row = $(this).closest('.engineer-row');
        engineer_row.find('input').val('');
        engineer_row.find('select').prop('selectedIndex',0);
    });
    // clonning handle -- end

    // engineer clock display handle -- start
    $("#has_chartered_engineer").click(function(event){
        var engineer_block = $("#engineer_chartered");
        if($(this).is(':checked')){
            // display block
            // make required
            engineer_block.fadeIn();
            var pivot = $('#engineer_chartered .insert-after');
            var clone_template = $('#chartered_clone');
            var row_clone = clone_template.clone(true);
            row_clone.css('display', 'block').removeAttr("id");
            $(row_clone).insertAfter(pivot);
            engineer_block.find('.required-toggle').prop('required', true);
        }else{
            // hide block
            // make not required
            engineer_block.fadeOut();
            engineer_block.find('.required-toggle').prop('required', false);
//            engineer_block.find('.engineer-row:not(:first)').remove();
//            engineer_block.find('.engineer-row:first .btn_clone_clear').trigger('click');
            engineer_block.find('.engineer-row').remove();
            engineer_block.validator('update');
            engineer_block.validator('validate');
        }
    });
    $("#has_non_chartered_engineer").click(function(event){
        var engineer_block = $("#engineer_non_chartered");
        if($(this).is(':checked')){
            // display block
            // make required
            engineer_block.fadeIn();
            var pivot = $('#engineer_non_chartered .insert-after');
            var clone_template = $('#non_chartered_clone');
            var row_clone = clone_template.clone(true);
            row_clone.css('display', 'block').removeAttr("id");
            $(row_clone).insertAfter(pivot);
            engineer_block.find('.required-toggle').prop('required', true);
        }else{
            // hide block
            // make not required
            engineer_block.fadeOut();
            engineer_block.find('.required-toggle').prop('required', false);
//            engineer_block.find('.engineer-row:not(:first)').remove();
//            engineer_block.find('.engineer-row:first .btn_clone_clear').trigger('click');
            engineer_block.find('.engineer-row').remove();
            engineer_block.validator('update');
            engineer_block.validator('validate');
        }
    });
    $("#has_non_qualified_engineer").click(function(event){
        var engineer_block = $("#engineer_non_qualified");
        if($(this).is(':checked')){
            // display block
            // make required
            engineer_block.fadeIn();
            var pivot = $('#engineer_non_qualified .insert-after');
            var clone_template = $('#non_qualified_clone');
            var row_clone = clone_template.clone(true);
            row_clone.css('display', 'block').removeAttr("id");
            $(row_clone).insertAfter(pivot);
            engineer_block.find('.required-toggle').prop('required', true);
        }else{
            // hide block
            // make not required
            engineer_block.fadeOut();
            engineer_block.find('.required-toggle').prop('required', false);
//            engineer_block.find('.engineer-row:not(:first)').remove();
//            engineer_block.find('.engineer-row:first .btn_clone_clear').trigger('click');
            engineer_block.find('.engineer-row').remove();
            engineer_block.validator('update');
            engineer_block.validator('validate');
        }
    });
    // engineer clock display handle -- end
    
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
//            var intltele = field.intlTelInput("getNumber");
            
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
    // Telephpne fields validation - end
    
    
    $('#training_org_submit').click(function(event){
        event.preventDefault();
        var elmForm = $('#reg_form');
        elmForm.validator('update').validator('validate');
        $(".telephone-number").trigger('focusout');
        $(".error-block").html('').fadeOut();
        
        var elmErr = elmForm.find('.has-error');
        if(elmErr && elmErr.length > 0){
            // Form validation failed
            return false;
        }else{
            $("#reg_form").submit();
        }
    });
    
    $('#reg_form').submit(function (event) {
        event.preventDefault();
        //$('.error-block, .error-block2').css('display', 'none').html('');
        main_business=tinyMCE.get('main_business').getContent();
        business_description=tinyMCE.get('business_description').getContent();
        library_description=tinyMCE.get('library_description').getContent();
        var formData = new FormData(this);
        formData.append('main_business', main_business);
        formData.append('business_description', business_description);
        formData.append('library_description', library_description);
        
        if ($('#form_edit_mode').val() == '1'){
            var submitPath = '../training-organization/resubmit';
        }else{
            var submitPath = '../training-organization/submit';
        }
        $.ajax({
            type: 'POST',
            url: submitPath,
            data: formData,
            success: function (data) {
                // console.log('Submission was successful.');
                // console.log(JSON.parse(data));
                data = JSON.parse(data);
                if(data['file_cv_attachment']){
                    $("#reg_form .error-block.error-file-cv-attachment").append(data['file_cv_attachment']).css('display', 'block');
                }
                if(data['file_info_attachment']){
                    $("#reg_form .error-block.error-file-info-attachment").append(data['file_info_attachment']).css('display', 'block');
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
                        location.replace('../training-organization/success?em=' + data['newTempUserEmail'] + '&ps=' + data['newTempUserAccInfo']['password'] + '&id=' + data['newTempUserAccInfo']['id']);
                    }else{
                        // update
                        location.replace('../training-organization/success');
                    }
                }

            },
            error: function (data) {
                console.log('An error occurred.');
                // console.log(data);
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
            url: "../TrainingOrganizationEval/unique_email/",
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
    
});
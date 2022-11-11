/**
 * Created by test on 5/11/2018.
 */
$(document).ready(function () {
    var todayDate = new Date().getDate();

    $(".date-input").datetimepicker({
        format: 'YYYY-MM-DD',
        viewMode: 'years',
//        maxDate: new Date(new Date().setDate(todayDate + 1))
    });
    $(".datetime-input").datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        viewMode: 'years'
    });
//    $(".date-input-future").datetimepicker({
//        format: 'YYYY-MM-DD',
//        viewMode: 'years',
//        minDate: new Date(new Date().setDate(todayDate + 1))
//    });
    
    var dob_edit = $('#date-input-future').attr('value');
    if(dob_edit && dob_edit.length > 0){ // edit mode
        $('#date-input-future').datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years',
            minDate: new Date(new Date().setDate(todayDate + 1)),
            defaultDate: dob_edit,
            useCurrent:false
        });
    }else{ // not-edit mode
        $("#date-input-future").datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years',
            minDate: new Date(new Date().setDate(todayDate + 1))
        });
    }
    
    var dob_edit2 = $('#date-input-future2').attr('value');
    if(dob_edit2 && dob_edit2.length > 0){ // edit mode
        $('#date-input-future2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            viewMode: 'years',
            minDate: new Date(new Date().setDate(todayDate + 1)),
            defaultDate: dob_edit2,
            useCurrent:false
        });
    }else{ // not-edit mode
        $("#date-input-future2").datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            viewMode: 'years',
            minDate: new Date(new Date().setDate(todayDate + 1))
        });
    }

    $("#manual_payment_made").click(function (event) {
        event.preventDefault();
        var user_id = $(this).data('user');
        $.ajax({
            url: "../../../TrainingOrganizationEval/manualPaymentMade/",
            data: {
                org_tbl_id: user_id
            },
            dataType: "json",
            type: 'post',
            success: function (data) {
                console.log(data);
                console.log(JSON.parse(data));
                if(data>0){
                    swal("Success", "Payment Status Changed Successfully", "warning");
                    location.reload();
                }else{
                    swal("Oops!", "Payment Status Change Failed!", "warning");
                }

            },
            error: function () {
            }
        });
    });
    
    $('#printWindow').on('click', function(event){
        event.preventDefault();
        
        var submitPath = $(this).data('path');
        var recordId = $(this).data('tblid');
        
        $.ajax({
            url: submitPath,
            data: {
                user_tbl_id: recordId
            },
            dataType: "json",
            type: 'post',
            beforeSend: function() {
                $('#printWindow').prop('disabled', true).removeClass('btn-default').addClass('btn-warning').html('Please Wait... <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>').prop('title', 'Gathering Necessities');
            },
            success: function (data) {
//                console.log(data);
                if(data['state'] == true){
                    window.open('../../../'+data['path']);
                }else{
                    swal("Oops!", "We couldn't gather all the information of the application. Please try again later.", "warning");
                }

            },
            complete: function (){
                $('#printWindow').prop('disabled', false).removeClass('btn-warning').addClass('btn-default').html('<i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download').prop('title', 'Download as ZIP');
            },
            error: function () {
            }
        });
    });
    
    $(".scheduleVivaButton").click(function(){
        event.preventDefault();
        var btnId = $(this).attr('id');
        var id = btnId.substring(7);
        var applicant_id = $('#descipline_id_'+id).val();
        console.log(applicant_id);
        var application_id = $('#application_id').val();
        var redirect_url = $('#redirect_url').val();
        $.ajax({
            url: "../../../ResourcePersonBooking/loadBookingView/5",
            data: {
                applicant_id: applicant_id,
                application_id: application_id,
                redirect_url: redirect_url
            },
            dataType: "html",
            type: 'post',
            success: function (data) {
                $('#scheduleViva .panel-body').html(data);
                $('#vs_'+id).html(data);
            },
            error: function (data) {
                console.log('Error Occured');
            }
        });
   
    });
    
    $(".visit_results_form_submit").click(function(event){
       
        event.preventDefault();
        var btn_id = $(this).attr('id');
        var id = btn_id.substring(4);
        $("#form_"+id).submit();
     
    });
    
    $(".btn_visit_publish").click(function(event){
        event.preventDefault();
        var btn_id = $(this).attr("id");
        var dicipline_id = btn_id.substring(4);
        var application_id = $("#application_id").val();
        $.ajax({
            url: "../../../TrainingOrganizationEval/publishOrganizationVisit",
            data: {
                dicipline_id: dicipline_id,
                application_id: application_id
            },
            dataType: "json",
            type: 'post',
            success: function (data) {
                if(data == 1){
                    swal("Success", "Visit Complted", "success");
                    location.reload();
                }else{
                    swal("Oops!", "We couldn't update application. Please try again later.", "warning");
                    console.log(data);
                }
               
            },
            error: function (data) {
                 swal("Oops!", "We couldn't update application. Please try again later.", "warning");
            }
        });
    });
    
    
    tinymce.init({
      selector: '.text_editor',
      height: 250,
      menubar: false,
      relative_urls : false,
       readonly : 1,
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
    
});
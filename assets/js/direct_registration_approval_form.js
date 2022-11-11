/**
 * Created by test on 5/11/2018.
 */
$(document).ready(function () {
    var todayDate = new Date().getDate();

    $(".date-input").datetimepicker({
        format: 'YYYY-MM-DD',
        viewMode: 'years',
        maxDate: new Date(new Date().setDate(todayDate + 1))
    });

    $("#manual_payment_made").click(function (event) {
        event.preventDefault();
        var user_id = $(this).data('user');
        $.ajax({
            url: "../../../MemberDirectRouteRegistration/manualPaymentMade/",
            data: {
                user_tbl_id: user_id
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
    
    
    
    
    $("#origial_data_submit").click(function (event) {

        event.preventDefault();
        var fullForm = $("#registry_form_2");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        console.log(fullErr);
        if (fullErr.length <= 0) {
//            fullForm.trigger('submit');
            var url = '../../../Payment_Overide/SaveOriginalData';
            submitform(url);
        }
    });

    $("#form2Submit").click(function (event) {
        event.preventDefault();
        var fullForm = $("#registry_form_2");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
//            fullForm.trigger('submit');
            var sub_amount = parseFloat($('#app_final_amount').val()) + parseFloat($('#subscrip_amount_for_registration').val());
            $('#sub_total').val(sub_amount);
            var url = '../../../Payment_Overide/OverrideOriginalData';
            
            
                       
            swal({
                title: "Are you sure?",
                text: "Once saved, Application will approved and payment can not be able to change this application!",
                icon: "warning",
                buttons: [
                   'NO',
                   'YES'
                 ],
                dangerMode: true,
              }).then((willDelete) => {
                if (willDelete) {
                     submitform(url);
                     applicationApprove();
                        swal("Success !", {
                          icon: "success",
                        }).then((value)=>{
                            location.reload();
                        });
                } else {
                  swal("Your imaginary file is safe!");
                }
              });
            
            
        }
    });



    function submitform(url) {

//    jQuery( "#registry_form_2" ).submit(function( event ) {


        $('#actionform').modal({backdrop: 'static', keyboard: false});
        $('#actionformvvv').modal('show');


        var frm_details = document.getElementById('registry_form_2');
        var formData = new FormData(frm_details);

        jQuery.ajax({
            type: "POST",
            dataType: 'text',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (done) {

                response = JSON.parse(done);



                if (response.status === false) {

                    errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <img src="<?php echo base_url(); ?>assets/images/dribbble_2x.gif"/>';
                    errormsg += response.msg;
                    errormsg += '</div>';

                    jQuery("#form2msg").html(errormsg);
                    
                   
                }

            }});


    }

    function applicationApprove() {
          
        var application_id = $('#master_table_record_id').val();
        var remark = $('#update_remarks').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '../../../MemberDirectRouteRegistration/afterEditPaymentApplicationApproval',
            data: {
                'admin_remarks':remark,
                'application_id':application_id
            },
            success: function (done) {

                response = JSON.parse(done);

               window.location.href='../../../applications/direct-route/get/'+application_id;
               /* if (response.status === false) {

                    errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <img src="<?php echo base_url(); ?>assets/images/dribbble_2x.gif"/>';
                    errormsg += response.msg;
                    errormsg += '</div>';

                    jQuery("#form2msg").html(errormsg);

                }*/

            }
        });


    }
});
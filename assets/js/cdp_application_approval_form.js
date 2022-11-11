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
    
    $('.select-dropdown').select2();

    $("#manual_payment_made").click(function (event) {
        event.preventDefault();
        var user_id = $(this).data('user');
        $.ajax({
            url: "../../../CdpRegistration/manualPaymentMade/",
            data: {
                user_tbl_id: user_id
            },
            dataType: "json",
            type: 'post',
            success: function (data) {
                console.log(data);
                console.log(JSON.parse(data));
                if(data>0){
                    swal("Success!", "Payment Status Changed Successfully", "success");
                    location.reload();
                }else{
                    swal("Oops!", "Payment Status Change Failed!", "error");
                }

            },
            error: function () {
            }
        });
    });
    
    $('#scheduleVivaButton').on('click', function(event){
        event.preventDefault();
        var applicant_id = $('#applicant_id').val();
        var application_id = $('#application_id').val();
        var redirect_url = $('#redirect_url').val();
        $.ajax({
            url: "../../../ResourcePersonBooking/loadBookingView/4",
            data: {
                applicant_id: applicant_id,
                application_id: application_id,
                redirect_url: redirect_url
            },
            dataType: "html",
            type: 'post',
            success: function (data) {
                $('#scheduleViva .panel-body').html(data);
            },
            error: function (data) {
                console.log('Error Occured');
            }
        });
    });
    
    $('input[name="applicant_attendance"]').on('click', function(){
        var result_1 = $('input[name="result"][value="1"]');
        var result_2 = $('input[name="result"][value="2"]');
        if($(this).val() == '1'){
        }else{
            result_1.prop('checked', false);
            result_2.prop('checked', true);
        }
    });
    
    $('input[name="result"]').on('click', function(){
        var att_0 = $('input[name="applicant_attendance"][value="0"]');
        var att_1 = $('input[name="applicant_attendance"][value="1"]');
        if($(this).val() == '1'){
            att_0.prop('checked', false);
            att_1.prop('checked', true);
        }
    });
    
});
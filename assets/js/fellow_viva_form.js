 /**
 * Created by test on 4/27/2018.
 */



$(document).ready(function($){



    // Initialize datepickers
    $(function () {
        var todayDate = new Date().getDate();
        
        $(".date-field-start").datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });
        $('.select-dropdown').select2();
        $('form').validator();
    });

    $('#scheduleVivaButton').on('click', function(event){
        event.preventDefault();
        elmForm = $('#reg_form');
        elmForm.validator('validate');
        var elmErr = elmForm.find('.has-error');

        if(elmErr && elmErr.length > 0){
            // Form validation failed
            return false;
        }else{
        
            var applicant_id = $('#mie_member_id').val();
            var application_id = $('#mie_member_id').val();
            var redirect_url = $('#redirect_url').val();
            $.ajax({
                url: "../ResourcePersonBooking/loadBookingView/3",
                data: {
                    applicant_id: applicant_id,
                    application_id: application_id,
                    redirect_url: redirect_url
                },
                dataType: "html",
                type: 'post',
                success: function (data) {
                    $('#viva_schedule').html(data);
                },
                error: function (data) {
                    console.log('Error Occured');
                }
            });
        }
    });
});
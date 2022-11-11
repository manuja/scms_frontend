 /**
 * Created by test on 4/27/2018.
 */



$(document).ready(function($){



    // Initialize datepickers
    $(function () {
        var todayDate = new Date().getDate();
        
        $(".date-field-start").datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('.select-dropdown').select2();
        $('form').validator();
    });

    $('#viva_batch_id').on('change', function(event){
        event.preventDefault();
        var dropdown = $(this);
        var batch_id = dropdown.val();
        
        var a_paper_datetime = $('#a_paper_datetime');
        var examiner = $('#examiner');
        var score = $('#score');
        var results = $('#results');
        var remarks = $('#remarks');
        
        $.ajax({
            url: 'PrAPaper/getAPaperResult/',
            data: {
                batch_id: batch_id
            },
            dataType : 'html',
            type: 'post',
            success: function (data) {
                if(data) {
                    data = JSON.parse(data);
                    if(data.length > 0){
                        a_paper_datetime.val(data[0]['a_paper_datetime']);
                        examiner.val(data[0]['examiners_list']);
                        score.val(data[0]['score']);
                        if(data[0]['results'] == "2"){
                            results.html('<p style="font-size: 16px;"><i class="fa fa-times" style="color: #ef0f3f;"></i> &nbsp; Fail</p>');
                        }else if(data[0]['results'] == "1"){
                            results.html('<p style="font-size: 16px;"><i class="fa fa-check" style="color: #00a65a;"></i> &nbsp; Pass</p>');
                        }else {
                            results.html('<p style="font-size: 16px;"><i class="fa fa-circle-o-notch" style="color: #00a65a;"></i> &nbsp; Pending</p>');
                        }
                        
                        remarks.val(data[0]['remarks']);
                    }else{
                        a_paper_datetime.val('');
                        examiner.val('');
                        score.val('');
                        results.html('');
                        remarks.html('');
                        swal('Your results has not been updated yet');
                    }
                }else{
                    a_paper_datetime.val('');
                    examiner.val('');
                    score.val('');
                    results.html('');
                    remarks.html('');
                    console.log('Error Fetching Data');
                    swal('Error fetching data. Please try again later.');
                }
            },
            error: function () {
                console.log('Error Fetching Data');
            }
        });
    });
});
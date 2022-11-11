 /**
 * Created by test on 4/27/2018.
 */



$(document).ready(function($){



    // Initialize datepickers
    $(function () {
        var todayDate = new Date().getDate();
        
//        $(".date-field-start").datetimepicker({
//            format: 'YYYY-MM-DD HH:mm:ss',
//            maxDate: new Date(new Date().setDate(todayDate))
//        });
        
        
        var dob_edit = $('#a_paper_datetime').attr('value');
        if(dob_edit && dob_edit.length > 0){ // edit mode
            $('.date-field-start').datetimepicker({
                format: 'YYYY-MM-DD',
                maxDate: new Date(new Date().setDate(todayDate)),
                defaultDate: dob_edit,
                useCurrent:false
            });
        }else{ // not-edit mode
            $(".date-field-start").datetimepicker({
                format: 'YYYY-MM-DD',
                maxDate: new Date(new Date().setDate(todayDate))
            });
            $('#a_paper_datetime').val(""); // necessary to remove auto selected date by MaxSDate option
        }
        
        
        
        $('.select-dropdown').select2();
        $('form').validator();
    });

    $('#viva_batch_id').on('change', function(event){
        event.preventDefault();
        var dropdown = $(this);
        var application_dropdown = $('#viva_application_id');
        var batch_id = dropdown.val();
        var options  ='<option value="" selected disabled>Please select...</option>';
        $.ajax({
            url: 'PrAPaper/getApprovedApplicationsOfVivaBatch',
            data: {
                batch_id: batch_id
            },
            dataType : 'html',
            type: 'post',
            success: function (data) {
                if(data) {
                    data = JSON.parse(data);
                    for (i = 0; i < data.length; i++) {
                        options += '<option value="'+data[i]["pr_viva_app_id"]+'">'+data[i]["reference_no"]+' | '+data[i]["member_name_w_initials"]+' | '+data[i]["membership_no"]+'</option>';
                    }
                    application_dropdown.html(options);
                }else{
                    console.log('Error Fetching Data');
                }
            },
            error: function () {
                console.log('Error Fetching Data');
            }
        });
    });
    
    $('#viva_application_id').on('change', function(event){
        event.preventDefault();
        var user_id = $(this).val();
        
        var a_paper_datetime = $('#a_paper_datetime');
//        var examiner = $('#examiner');
        var examiner = $('#pr_apaper_examiners');
        var score = $('#score');
        var results = $('#results');
        var remarks = $('#remarks');
        
        
        examiner.val('');
        $.ajax({
            url: 'PrAPaper/getAPaperResultByUser/',
            data: {
                user_id: user_id
            },
            dataType : 'html',
            type: 'post',
            success: function (data) {
                if(data) {
                    data = JSON.parse(data);
                    if(data.length > 0){
                        a_paper_datetime.val(data[0]['a_paper_datetime']);
                        
//                        examiner.val(data[0]['examiner']);
//                        examiner.select2('destroy').select2();
//                        examiner.val('');
                        console.log(data[0]['examiner_mem_num']);
                        var examiners_list = '';
                        if(data[0]['examiner_mem_num'] != null){
                            $.each(data, function(index, value){
                                examiners_list += value['examiner_mem_num']+' | '+value['examiner_name']+'\n';
                            });
                            examiner.val(examiners_list);
                        }else{
                            examiner.val('This aplicant has not faced for PR VIVA yet. Or Results has not been updated yet');
                        }
                        
                        score.val(data[0]['score']);
                        remarks.val(data[0]['remarks']);
                        if(data[0]['results'] == "2"){
                            $("#results-0").prop('checked', true);
                            $("#results-1").prop('checked', false);
                        }else if(data[0]['results'] == "1"){
                            $("#results-0").prop('checked', false);
                            $("#results-1").prop('checked', true);
                        }else{
                            $("#results-0").prop('checked', false);
                            $("#results-1").prop('checked', false);
                        }
                        
                    }else{
                        swal('Oops!', 'This aplicant has not faced for PR VIVA yet. Or Results has not been updated yet', 'warning');
                        a_paper_datetime.val('');
                        examiner.val('');
                        score.val('');
                        remarks.val('');
                        results.html('');
                    }
                }else{
                    a_paper_datetime.val('');
                    examiner.val('');
                    score.val('');
                    remarks.val('');
                    results.html('');
                    console.log('Error Fetching Data');
                }
            },
            error: function () {
                console.log('Error Fetching Data');
            }
        });
    });
    
    $('button[type="reset"]').on('click', function(e){
        e.preventDefault();
        var form = $(this).closest('form');
        form.find('input, textarea').val('');
        form.find('input[type="radio"]').prop('checked', false);
        form.find('select').prop("selectedIndex", 0).trigger('change.select2');

    });
    
    $("input[type=file]").on("change", function () {
            $(this).parent().siblings(".file_info").html($(this)[0].files[0].name);
        });
});
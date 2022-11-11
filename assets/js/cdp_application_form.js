

$(document).ready(function () {

    // Logical validations of the form -- start
    $("input[type=radio][name=per_employer_design_office], input[type=radio][name=per_employer_design_office_test]").on("change", function (event) {
        event.preventDefault();

        if($("#design_office_y").prop('checked') && $("#design_office_test_y").prop('checked')){
            $("#design_office_certificate").prop('required', true);
            $("#design-office-reco").fadeIn();
        }else{
            $("#design_office_certificate").prop('required', false);
            $("#design-office-reco").fadeOut();
        }
    });
    $("input[type=radio][name=per_employer_design_office]").on("change", function (event) {
        event.preventDefault();

        if($("#design_office_y").prop('checked')){
            $("#design_office_test_y").prop('required', true);
            $("#design-office-yes").fadeIn();
        }else{
            $("#design_office_test_y").prop('required', false);
            $("#design-office-yes").fadeOut();
        }
    });
    $("input[type=radio][name=sup_is_designer]").on("change", function (event) {
        event.preventDefault();

        if($("#seperv_is_designer_y").prop('checked')){
            $("#seperv_is_designer_years").prop('required', true).prop('readonly', false);
        }else{
            $("#seperv_is_designer_years").prop('required', false).prop('readonly', true).val("");
        }
    });
    $("#seperv_is_designer_years").on('focusout', function(event){
        event.preventDefault();
        if($(this).val().length > 0){
            $("#seperv_is_designer_y").prop('checked', true);
            $("input[type=radio][name=sup_is_designer]").trigger('change');
        }
    });
    // Logical validations of the form -- end

    $("input[type=file]").on("change", function () {
        $(this).parent().siblings(".file_info").html($(this)[0].files[0].name);
    });



    // load CIE and MIE users for supervisors -- Start
    var inputCorpoMemCivil = $("input.superv-by-name-civil");
    var inputCorpoMemElectrical = $("input.superv-by-name-electrical");


    // search by name (Civil)
    $.get('../CdpRegistration/getSupervisorsCivil/', function(data){
        inputCorpoMemCivil.typeahead({
            source: data,
            minLength: 3,
            highlight: true
        });
    }, 'json');
    // search by name (Electrical)
    $.get('../CdpRegistration/getSupervisorsElectrical/', function(data){
        inputCorpoMemElectrical.typeahead({
            source: data,
            minLength: 3,
            highlight: true
        });
    }, 'json');

    // Search by name handle (Civil)
    inputCorpoMemCivil.change(function(){
        var current = inputCorpoMemCivil.typeahead("getActive");
        var superv_block = $(this).parent().parent().parent();

        superv_block.find('.superv-name').val(current.name);
        superv_block.find('.superv-memnum').val(current.memnum);
        superv_block.find('.superv-userid').val(current.userid);
        superv_block.find('.sup_tele_mobile').val(current.mobile);
        superv_block.find('.sup_tele_office').val(current.officetel);
        superv_block.find('.sup_email').val(current.email);
        inputCorpoMemCivil.val('');

    });
    // Search by name handle (Electrical)
    inputCorpoMemElectrical.change(function(){
        var current = inputCorpoMemElectrical.typeahead("getActive");
        var superv_block = $(this).parent().parent().parent();

        superv_block.find('.superv-name').val(current.name);
        superv_block.find('.superv-memnum').val(current.memnum);
        superv_block.find('.superv-userid').val(current.userid);
        superv_block.find('.sup_tele_mobile').val(current.mobile);
        superv_block.find('.sup_tele_office').val(current.officetel);
        superv_block.find('.sup_email').val(current.email);
        inputCorpoMemElectrical.val('');

    });

    // proposer clear button handle
    $(".proposers_clear_button").click(function (event) {
        event.preventDefault();
        var row = $(this).parent().parent().parent().parent().parent(); console.log(row);
        row.find('.corporate-member-mem-name').val('');
        row.find('.corporate-member-mem-num').val('');
        row.find('.corporate-member-mem-class').val('');
        row.find('.corporate-member-mem-class-id').val('');
        row.find('.proposer-file').prop('required', true);

        inputCorpoMem.val('');
        inputCorpoMemNum.val('');

    });

    // load CIE and MIE users for proposers -- End
    $("#cdp_reject_button").click(function (event) {
        event.preventDefault();


    });
    
    $("#cdp_design_field_id").on('change', function(event){
        event.preventDefault();
        
        var application_dropdown = $('#cdp_sub_design_field_id');
        var discipline_id = $("#cdp_design_field_id").val();
        var options  ='<option value="" selected disabled>Please select...</option>';
        $.ajax({
            url: '../CdpRegistration/fetchMasterSubEngineeringDiscipline/'+discipline_id,
            data: {
                discipline_id: discipline_id
            },
            dataType : 'html',
            type: 'post',
            success: function (data) {
                if(data) {
                    data = JSON.parse(data);
                    for (i = 0; i < data.length; i++) {
                        options += '<option value="'+data[i]["engineering_discipline_sub_field_id"]+'">'+data[i]["engineering_discipline_sub_field_name"]+'</option>';
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

});
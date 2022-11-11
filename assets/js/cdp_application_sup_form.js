

$(document).ready(function () {

    // Logical validations of the form -- start
    $("input[type=radio][name=per_employer_design_office], input[type=radio][name=per_employer_design_office_test]").on("change", function (event) {
        event.preventDefault();

        if($("#design_office_y").prop('checked') && $("#design_office_test_y").prop('checked')){
            $("#design_office_certificate").prop('required', true);
        }else{
            $("#design_office_certificate").prop('required', false);
        }
    });
    $("input[type=radio][name=per_employer_design_office]").on("change", function (event) {
        event.preventDefault();

        if($("#design_office_y").prop('checked')){
            $("#design_office_test_y").prop('required', true);
        }else{
            $("#design_office_test_y").prop('required', false);
        }
    });
    $("input[type=radio][name=sup_is_designer]").on("change", function (event) {
        event.preventDefault();

        if($("#seperv_is_designer_y").prop('checked')){
            $("#seperv_is_designer_years").prop('required', true);
        }else{
            $("#seperv_is_designer_years").prop('required', false);
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
    $.get('../../CdpRegistration/getSupervisorsCivil/', function(data){
        inputCorpoMemCivil.typeahead({
            source: data,
            minLength: 3,
            highlight: true
        });
    }, 'json');
    // search by name (Electrical)
    $.get('../../CdpRegistration/getSupervisorsElectrical/', function(data){
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
        inputCorpoMemCivil.val('');

    });
    // Search by name handle (Electrical)
    inputCorpoMemElectrical.change(function(){
        var current = inputCorpoMemElectrical.typeahead("getActive");
        var superv_block = $(this).parent().parent().parent();

        superv_block.find('.superv-name').val(current.name);
        superv_block.find('.superv-memnum').val(current.memnum);
        superv_block.find('.superv-userid').val(current.userid);
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






});
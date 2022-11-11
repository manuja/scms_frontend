/**
 * Created by test on 5/1/2018.
 */
var degree_institute_id = $("#degree_institute_id");
var degree_qualification_id = $("#degree_qualification_id");
var degree_programme_id = $("#recognized_degree_id");
var accredition_year = $("#accredition_year");

$(document).ready(function () {
    $('#modal-default').modal('toggle');

    $(".fetch-degree").change(function () {
        var degree_institute = degree_institute_id.val();
        var degree_qualification = degree_qualification_id.val();

        if(degree_institute != null) {
            $.ajax({
                url: "../get/degrees/",
                data: {
                    degree_institute: degree_institute,
                    degree_qualification: degree_qualification
                },
                dataType: "json",
                type: 'post',
                success: function (data) {
                    var new_options = "<option val='' >Please Select...</option>";
                    if(data) {
                        $.each(data, function (index, value) {
                            new_options += "<option value='" + value.recognized_degree_id + "'>" + value.degree_name + "</option>"
                        });
                        $("#recognized_degree_id").html(new_options).prop('disabled', false);
                    }else{
                        $("#recognized_degree_id").html(new_options).prop('disabled', true);
                    }


                },
                error: function () {
                    var new_options = "";
                    $("#recognized_degree_id").html(new_options).prop('disabled', true);
                }
            });
        }
    });

    $("#verify_degree").click(function (event) {
        event.preventDefault();

        var degree_programme = degree_programme_id.val();
        var accredition_year_val = accredition_year.val();

        $.ajax({
            url: "../test/degrees/",
            data: {
                degree_programme: degree_programme,
                accredition_year_val: accredition_year_val
            },
            dataType: "json",
            type: 'post',
            success: function (data) {
                if(data) {
                    console.log(data);
                    if(data > 0){
                        // go to next step
                        // $('#modal-degree-check').fadeOut();
                        window.location.href = 'addflash';
                    }else{
                        swal("Oops!", "Selected degree is not attested for the selected year!", "error");
                        // no go. show error
                    }
                }else{
                    swal("Oops!", "Selected degree is not attested for the selected year!", "error");
                    // no go. show error
                }

            },
            error: function () {
                swal("Oops!", "Error encountered", "error");
            }
        });
    });

    $(".date-field-year").datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });
});
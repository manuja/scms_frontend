/**
 * Created by test on 5/1/2018.
 */
var degree_institute_id = $("#degree_institute_id");
var degree_qualification_id = $("#degree_qualification_id");
var degree_programme_id = $("#recognized_degree_id");
var accredition_year = $("#accredition_year");

$(document).ready(function () {

    var todayDate = new Date().getDate();

    $(".date-field").datetimepicker({
        format: 'YYYY-MM-DD',
        viewMode: 'years',
        maxDate: new Date(new Date().setDate(todayDate - 1825)),// 1825days = 5years
        useCurrent:false
    });

});


$(document).ready(function () {

    // Initialize datepickers
    $(function () {
        var todayDate = new Date().getDate();
        
        $(".date-field-start").datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years'
        });
        $(".date-field-end").datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD',
            viewMode: 'years'
            
        });
        $('.select-dropdown').select2();
        $('form').validator();
    });

    // set maxdate, mindate restrictions to related date fields
    $(".date-field-start").on("dp.change", function (e) {
        var parentRow = $(this).closest(".date-field-group");
        parentRow.find(".date-field-end").data("DateTimePicker").minDate(e.date);
    });
    $(".date-field-end").on("dp.change", function (e) {
        var parentRow = $(this).closest(".date-field-group");
        parentRow.find(".date-field-start").data("DateTimePicker").maxDate(e.date);
    });

});
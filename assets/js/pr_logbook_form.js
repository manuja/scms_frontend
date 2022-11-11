/**
 * Created by test on 4/27/2018.
 */



$(document).ready(function ($) {



    // Initialize datepickers
    $(function () {
        var todayDate = new Date().getDate();

        $(".date-field-start").datetimepicker({
            format: 'YYYY-MM-DD',
            viewMode: 'years',
            maxDate: new Date(new Date().setDate(todayDate + 1))
        });
        $(".date-field-end").datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD',
            viewMode: 'years',
            maxDate: new Date(new Date().setDate(todayDate + 1))

        });
         $(".select-dropdown-tags").select2({
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                  return null;
                }

                return {
                  id: term.substr(0,1).toUpperCase()+term.substr(1),
                  text: term.substr(0,1).toUpperCase()+term.substr(1),
                  newTag: true // add additional parameters
                }
            }
        });
        $('.select-dropdown').select2();
        $('form').validator();
    });


    // set maxdate, mindate restrictions to related date fields
    $(".date-field-start").on("dp.change", function (e) {

         var myDate = new Date(e.date);
      myDate.setDate(myDate.getDate()+28);
        
        var parentRow = $(this).closest(".date-field-group");
        parentRow.find(".date-field-end").data("DateTimePicker").minDate(e.date);
        parentRow.find(".date-field-end").data("DateTimePicker").maxDate(myDate);
       
    });
    $(".date-field-end").on("dp.change", function (e) {
        var myDate = new Date(e.date);
        myDate.setDate(myDate.getDate()-28);
        var parentRow = $(this).closest(".date-field-group");
        parentRow.find(".date-field-start").data("DateTimePicker").maxDate(e.date);
       parentRow.find(".date-field-start").data("DateTimePicker").minDate(myDate);
    });


    $(".date-field-start, .date-field-end").on("dp.change", function (e) {
        var startDate = $(".date-field-start").val();
        var endDate = $(".date-field-end").val();
        if (startDate.length > 0 && endDate.length > 0) {

            var momentStart = moment(startDate);
            var momentEnd = moment(endDate);
            var duration = momentEnd.diff(momentStart, 'weeks');
            $('#period-weeks').val(duration + " Week(s)");
        } else {
            $('#period-weeks').val("");
        }
        $('#period-weeks').trigger('focusout');
    });

    $('button[type="reset"]').on('click', function () {
        var form = $(this).closest('form');
        form.find('select').prop("selectedIndex", 0).trigger('change.select2');

    });

    $('#print_button').on('click', function () {
        var divHeight = $('#print-area').height();
        var divWidth = $('#print-area').width();
        var ratio = divHeight / divWidth;
       
        html2canvas(document.querySelector('#print-area')).then(canvas => {
            var img = canvas.toDataURL('image/png', 1.0);
            var doc = new jsPDF("l", "mm", "a4");
            
            var width = doc.internal.pageSize.width;
            var height = doc.internal.pageSize.height;
            var options = {
                 pagesplit: true
            };
            doc.addImage(img, 'PNG', 0, 0, width, height);
//            doc.save('logbook');
        });
        
        html2canvas(document.getElementById("print-area"), {
            height: divHeight,
            width: divWidth,
            onrendered: function(canvas) {
                var image = canvas.toDataURL("image/png");
                var doc = new jsPDF(); // using defaults: orientation=portrait, unit=mm, size=A4
                var width = doc.internal.pageSize.width;    
                var height = doc.internal.pageSize.height;
                height = ratio * width;
                doc.addImage(image, 'PNG', 0, 0, width, height);
                doc.save('myPage.pdf'); //Download the rendered PDF.
            }
       });
    });
    
    $("input[type=file]").on("change", function () {
        $(this).parent().siblings(".file_info").html($(this)[0].files[0].name);
    });

//    $('#print_button').click(function () {
//        var pdf = new jsPDF('p', 'pt', 'letter');
//        pdf.addHTML($('#print-area')[0], function () {
//            alert('as');
//            pdf.save('Test.pdf');
//        });
//    });

});

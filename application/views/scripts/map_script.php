<script>
$(document).ready(function($){
    $(document).on('click', '#submit_map_upload_form', function (event) {
        event.preventDefault();
        var fullForm = $("#map_upload_form");
        fullForm.validator('update');
        fullForm.validator('validate');
        var fullErr = fullForm.find('.has-error');
        if (fullErr.length <= 0) {
            save_map_upload_form();
        }
    });
});
function save_map_upload_form() {
        var menu_create = document.getElementById('map_upload_form');
        var formData = new FormData(menu_create);

        $.ajax({
            method: 'POST',
            url: site_url + 'save_map_upload',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        }).always(function (data) {
            console.log(data);
            if (data.status == '1') {

                var successmsg = '<div  class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                successmsg += data.msg;
                successmsg += '</div>';

                $('#map_upload_form').trigger("reset");
                $("#messages_noti").html(successmsg);

                jQuery(window).scrollTop(0);

                // setTimeout(function () {
                //     window.location.reload();
                // }, 2500);
              
            }else {
                var errormsg = '<div  class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                errormsg += data.msg;
                errormsg += '</div>';
                $("#messages_noti").html(errormsg);
            }

        });

    }
</script>
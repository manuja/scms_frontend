/**
 * Created by test on 5/9/2018.
 */
$(document).ready(function(){
    $("#application_admin_submit").click(function (event) {
        event.preventDefault();
        $("#application_admin_action").validator('validate');
    });
});
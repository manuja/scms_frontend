/**
 * Created by test on 5/8/2018.
 */
$(document).ready(function () {
    $("#temp_member_make_payment_online").click(function () {

        // var user_reg_id = $("#user_reg_id").val();
        // $.ajax({
        //     url: "../payment/make",
        //     data: {
        //         user_tbl_id: user_reg_id
        //     },
        //     dataType: "json",
        //     type: 'post'
        // });

        $("#asdasdasd").submit();
    });


});

function goIPGBOC() {
  
    $('.onlineipghidden').val(1);
    $('#payonline').val('BOC');

    $("#paymentForm").submit();
    //CheckUserCanRegisterOnline();

}

function goIPGtest() {

    $('.onlineipghidden').val(0);
    $('#payonline').val('test');
    $("#paymentForm").submit();

    // CheckUserCanRegisterOnline();

}

function SelectIPG() {
   
    $('#onlineipg').modal('show');
}
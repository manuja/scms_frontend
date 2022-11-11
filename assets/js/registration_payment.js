/**
 * Created by test on 5/8/2018.
 */
$(document).ready(function () {
 
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
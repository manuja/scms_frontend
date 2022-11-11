<script>

$(document).ready(function () {

  

var issri =  $('#issri').val();




if( issri == 1 ){
          $('#f1').attr('style','display: none');
          $('#f2').attr('style','display: none');
          $('#f3').attr('style','display: none');
          $('#f4').attr('style','display: none');
}else{
          $('#f1').attr('style','display: true');
          $('#f2').attr('style','display: true');
          $('#f3').attr('style','display: true');
          $('#f4').attr('style','display: true');
}



var user_type =  $('#user_type').val();


console.log(user_type);



if(  user_type == 1 ){

          $('#f1').attr('style','display: none');
          $('#f2').attr('style','display: none');
          $('#f3').attr('style','display: none');
          $('#f4').attr('style','display: none');
          $('#issri').attr('style','display: none');
          $('#confix').attr('style','display: none');
          $('#conmobile').attr('style','display: none');
          $('#address1').attr('style','display: none');
          $('#address2').attr('style','display: none');
          $('#zipcode').attr('style','display: none');

}





});


</script>
<script>

$(document).ready(function () {

  

var issri =  $('#issri').val();
var editstus =  $('#editstatus').val();

console.log(issri);


if( issri == 1 ){
  $('#f1').prop("required", false);
          $('#f2').prop("required", false);
          $('#f3').prop("required", false);
          $('#f4').prop("required", false);
          $('#panel2').attr('style','display: none');
}else{
  $('#panel2').attr('style','display: true');
          $('#f1').prop("required", true);
          $('#f2').prop("required", true);
          $('#f3').prop("required", true);
          $('#f4').prop("required", true);

}


// firstname
// lastname
// nic
// address1
// address2
// pcode
// F_country
// F_province
// F_city
// F_pasport_country
// conmobile
// confix
// Email
//issri



if( editstus == true ){

          $('#f1').prop("readonly", false);
          $('#f2').prop("readonly", false);
          $('#f3').prop("readonly", false);
          $('#f4').prop("readonly", false);
          $('#firstname').prop("readonly", false);
          $('#lastname').prop("readonly", false);
          $('#nic').prop("readonly", false);
          $('#address1').prop("readonly", false);
          $('#address2').prop("readonly", false);
          $('#pcode').prop("readonly", false);
          $('#conmobile').prop("readonly", false);
          $('#confix').prop("readonly", false);
          $('#email').prop("readonly", false);
          $('#title').prop("readonly", false);
          $('#iname').prop("readonly", false);
          $('#uploadin').attr('style','display: true');
          $('#upload_fie').prop("readonly", false);
          $('#but01').attr('style','display: true');
          
          $('#emailinfo').attr('style','display: true');
        
}else{
  
          $('#f1').prop("readonly", true);
          $('#f2').prop("readonly", true);
          $('#f3').prop("readonly", true);
          $('#f4').prop("readonly", true);
          $('#firstname').prop("readonly", true);
          $('#lastname').prop("readonly", true);
          $('#nic').prop("readonly", true);
          $('#address1').prop("readonly", true);
          $('#address2').prop("readonly", true);
          $('#pcode').prop("readonly", true);
          $('#conmobile').prop("readonly", true);
          $('#confix').prop("readonly", true);
          $('#email').prop("readonly", true);
          $('#title').prop("readonly", true);
          $('#iname').prop("readonly", true);
          $('#but01').attr('style','display: none');
          $('#uploadin').attr('style','display: none');
          $('#emailinfo').attr('style','display: none');

}













});

    //document_name
    $('#upload_file').change(function() {

fileName = document.querySelector('#upload_file').value;
extension = fileName.split('.').pop();
const fi = document.getElementById('upload_file');
const fileSize = fi.files[0].size / 1024 / 1024

if (extension == 'jpg' || extension == 'jpeg' || extension == 'png') {



  if (fileSize >= 5) {

   // alert("File too Big, please select a file less than 4mb");
    swal('File Upload', 'File too Big, please select a file less than 4mb', 'error');
    $('#upload_file').val("");
  }

  //  file_name_text =  fileName.split('\\').pop();


} else {
  swal('File Upload', 'File Upload failed ! Please Select Image', 'error');
  //alert('File Upload failed ! Please Select Image (JPG , JPEG , PNG)', 'error');
  $('#upload_file').val("");

}


});
</script>
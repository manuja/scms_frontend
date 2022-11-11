<script>
     $(document).ready(function () {
     
     $('#processdiv').attr('style', 'display: none');
    });
     
   $(document).ready(function () {
     


       
        $("#form_submit").click(function (event) {
  
        
            event.preventDefault();

             var elmForm = $("#reg_form");
                elmForm.validator('update');
                elmForm.validator('validate');    
                var elmErr = elmForm.find('.has-error');

                if(elmErr && elmErr.length > 0){
                    return false;
                }else{    
                    $("#form_member_registration").submit();
                  
                   
                }

        });
   });

   $('#register_member').click(function() {
    $('#processdiv').attr('style', 'display: true');

})

$('#title,#firstname,#lastname,#intialname').on('keypress', function(event) {
    // console.log("in->");
    var regex = new RegExp("^[a-zA-Z' ']+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });
  $('#address1,#address2').on('keypress', function(event) {
    var regex = new RegExp("^[a-zA-Z0-9' ','/'.-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });

  $('#nic').on('keypress', function(event) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });


  $('#pcode,#conmobile,#confix').on('keypress', function(event) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });

  $('#f1,#f2,#f3,#f4').on('keypress', function(event) {
    var regex = new RegExp("^[a-zA-Z' ']+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });
  $('#email').on('keypress', function(event) {

    if( $('#emailerror').text() == "Already Created Account ! Please Check Your Email" ){
      $('#emailerror').text("");
    }

    var regex = new RegExp("^[a-zA-Z0-9.@_-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });

$('#checkbox1').change(function() {
  console.log("in-check")
if (this.checked) {
  $('#f1').prop("required", false);
  $('#f2').prop("required", false);
  $('#f3').prop("required", false);
  $('#f4').prop("required", false);
  $('#panel2').attr('style', 'display: none');
} else {
  $('#panel2').attr('style', 'display: true');
  $('#f1').prop("required", true);
  $('#f2').prop("required", true);
  $('#f3').prop("required", true);
  $('#f4').prop("required", true);
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


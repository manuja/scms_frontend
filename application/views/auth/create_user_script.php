<script>
   $(document).ready(function () {
       $("#emp_number").keyup(function(){           
           $("#identity").val('PF'+$(this).val());
       });
       
       
        $("#form_submit").click(function (event) {
        
            event.preventDefault();

             var elmForm = $("#reg_form");
                elmForm.validator('update');
                elmForm.validator('validate');    
                var elmErr = elmForm.find('.has-error');

                if(elmErr && elmErr.length > 0){
                    return false;
                }else{    
                    $("#reg_form").submit();
                   
                }

        });
   });
</script>


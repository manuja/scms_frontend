<script>
     $(document).ready(function () {
         
         $('.datepicker').datetimepicker({
	    	format: 'YYYY-MM-DD'
        });
     });
     
      $("#employee_id").focusout(function(){
          var emp_number = $(this).val();
          
          $.ajax({
                  type: 'POST',
                  url: "<?php echo base_url('EmployeeController/getEmpNameByNumber')?>",
                  data: {
                      'emp_number':emp_number
                  },
                  success: function (data) {
                     data = JSON.parse(data);
                     console.log(data);
                     if(data){
                         if(data.name_w_initials){
                             $("#emp_name").val(data.name_w_initials);
                         }else{
                            $("#emp_name").val(data.name);
                         }
                         $("#profile_id").val(data.user_profile_id);
                     }else{
                         $("#emp_name").val("This employee number is not exist");
                         $("#profile_id").val('');
                     }                  
                     
                  }
              });
          
          
          
        
      });
     
</script>
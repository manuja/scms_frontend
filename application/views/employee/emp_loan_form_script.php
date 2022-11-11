<script>
     $(document).ready(function () {
         
         $('.datepicker').datetimepicker({
	    	format: 'YYYY-MM-DD'
        });
        
        
        var myinput = document.getElementById('amount');

        myinput.addEventListener('keyup', function() {
          var val = this.value;
          val = val.replace(/[^0-9\.]/g,'');

          if(val != "") {
            valArr = val.split('.');
            valArr[0] = (parseInt(valArr[0],10)).toLocaleString();
            val = valArr.join('.');
          }

          this.value = val;
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
      
      function addCommas(nStr)
        {
            console.log('here');
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
     
</script>
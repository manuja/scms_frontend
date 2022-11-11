<script>
$(document).ready(function(){
    //Initiate date
    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('.js-multiple').select2();

    $(".select-dropdown-tags").select2({
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                  return null;
                }

                return {
                  id: term.substr(0,1).toUpperCase()+term.substr(1),
                  text: term.substr(0,1).toUpperCase()+term.substr(1),
                  newTag: true // add additional parameters
                }
            }
        });
        
        $('#add_contract_details').click(function() {
            $(".contact_details").toggle(this.checked);
        });
        
         $("#division").change(function(){
               var division_id = $(this).val();
                $.ajax({
                  type: 'POST',
                  url: "<?php echo base_url('EmployeeController/getSubDivisionList')?>",
                  data: {
                      'division_id':division_id
                  },
                  success: function (data) {
                      data = JSON.parse(data);
                      
                      $("#sub_division").empty();
                      $("#sub_division").append('<option value="" >Select...</option>');
                      if(data.length >0){
                        $.each(data,function(index,item)
                          {
                              $("#sub_division").append('<option value=' + item.sub_division_id + '>' + item.sub_division_name + '</option>');
                          });
                      }
                     
                  }
              });
              
             });
             
         $("#division").change(function(){
               var division_id = $(this).val();
                $.ajax({
                  type: 'POST',
                  url: "<?php echo base_url('EmployeeController/getSupervisorList')?>",
                  data: {
                      'division_id':division_id
                  },
                  success: function (data) {
                      data = JSON.parse(data);
                      
                      $("#supervisor").empty();
//                      $("#supervisor").append('<option value="" >Select...</option>');
                      if(data.length >0){
                        $.each(data,function(index,item)
                          {
                              $("#supervisor").append('<option value=' + item.user_profile_id + '>' + item.employee_no + ' | ' + item.name_w_initials + '</option>');
                          });
                      }
                     
                  }
              });
              
             });
             
            
             
});
</script>

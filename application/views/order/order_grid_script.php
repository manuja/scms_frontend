<script>
$(document).ready(function () {
  // var export_columns = [0, 1, 2, 4,];
   var table = $('#bid_apply_table').DataTable({
 



      "pagingType": "simple_numbers", // "simple_number" option for 'Previous' and 'Next' buttons and number
      "order": [[0, 'desc']],
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": true,
      "bPaginate": true,

    });
    $('.dataTables_length').addClass('bs-select');
    $("#alertbtt").on('click',function(){

      $(".alert").alert('close')

    })

    
  });


$(document).on("click", "#loadmodaldelete", function () {


  event_id = $(this).data('id');
  
  event_date = $(this).data('date');
  
  event_title = $(this).data('title');



     $(".modal-body #d_id ").val( event_id );
     $(".modal-body #d_title ").val( event_title );
     $(".modal-body #d_date ").val( event_date );

 

});











$('#deleteModal').on('hidden.bs.modal', function () {
  //  console.log("in-->");
    window.location.href = "<?php base_url().'event_management' ?>";
})




  </script>
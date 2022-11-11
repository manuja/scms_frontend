<script>
$(document).ready(function(){
   
    
    $(".delete_promo").on('click',function () {
//            event.preventDefault();
            var promo_id = $(this).attr('id');
            
            swal({
            title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('EmployeeController/deletePromotionData'); ?>',
                        data: {
                            'promo_id':promo_id
                        },
                        success: function (data) {
                            var res = JSON.parse(data);
                            if (res.status == 1) {
                                swal({
                                    title: 'The record was removed!,Please update Employemt details accordingly',
                                    type: 'success'
                                }).then(function () {
                                    window.location.reload();
                                });
                            } else {
                                swal({
                                    title: 'Error!',
                                    text: 'The record was not removed',
                                    type: 'error'
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(textStatus);
                        }
                    });
                }
            }); 
        });
    $(".delete_leave").on('click',function () {
//            event.preventDefault();
            var leave_id = $(this).attr('id');
            
            swal({
            title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('EmployeeController/deleteLeave'); ?>',
                        data: {
                            'leave_id':leave_id
                        },
                        success: function (data) {
                            var res = JSON.parse(data);
                            if (res.status == 1) {
                                swal({
                                    title: 'The record was removed !',
                                    type: 'success'
                                }).then(function () {
                                    window.location.reload();
                                });
                            } else {
                                swal({
                                    title: 'Error!',
                                    text: 'The record was not removed',
                                    type: 'error'
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(textStatus);
                        }
                    });
                }
            }); 
        });
});

</script>

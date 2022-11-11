/* 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $('#mem_letter_request').on('click', function(){
        var link = $(this).data('link');
        swal({
            title: 'Are you sure?',
            text: "This will open a request for membership card!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm!'
        }).then((result) => {
            if (result.value) {
                window.location.replace(link);
            }
        });


        
    });
});


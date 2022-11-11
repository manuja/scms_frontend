<script>
    $(document).ready(function() {

        // var export_columns = [0, 1, 2, 4,];
        var table = $('#publication_table').DataTable({




            "pagingType": "simple_numbers", // "simple_number" option for 'Previous' and 'Next' buttons and number
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": true,
            "bPaginate": true,

        });
        $('.dataTables_length').addClass('bs-select');
        $("#alertbtt").on('click', function() {

            $(".alert").alert('close')

        })

     

    });


    $(document).on("click", "#loadmodalview", function() {
        //id title status publication_status

        year = $(this).data('year');

        amount = $(this).data('amount');

        paid_date = $(this).data('paid_date');

        comment = $(this).data('comment');

        slip = $(this).data('slip');



        $(".modal-body #p_year ").val(year);
        $(".modal-body #p_amount ").val(amount);
        $(".modal-body #p_date ").val(paid_date);
        $(".modal-body #p_comment ").val(comment);

        user_id = $("#user_id").val();

        base_path = $("#base_path").val();


        console.log(base_path);

        attachment_download = "";

        function doesFileExist(urlToFile) {
                            var xhr = new XMLHttpRequest();
                            xhr.open('HEAD', urlToFile, false);
                            xhr.send();

                            if (xhr.status == "404") {
                                return false;
                            } else {
                                return true;
                            }
                        }

        var docstatus = doesFileExist(base_path+'uploads/Payment_slips/'+ user_id + '/' + slip);

        // attachment_download += '<a target="_blank" href="uploads/Payment_slips/' + user_id + '/' + slip + '">' base_path

        if( docstatus == true && slip != "" ){

            attachment_download += '<a target="_blank" href="'+base_path+'uploads/Payment_slips/'+ user_id + '/' + slip + '">'
        attachment_download += '<i class="fa fa-certificate btn btn-primary"> View Attachment </i>'
        attachment_download += '</a>';

        $(".modal-body #payment_slip_div").html(attachment_download);

        }else{

        attachment_download += '<a target="_blank" href="">'
        attachment_download += '<i class="fa fa-certificate btn btn-primary"> View Attachment </i>'
        attachment_download += '</a>';

        $(".modal-body #payment_slip_div").html(attachment_download);



        }

       



    });


    //user_id
</script>
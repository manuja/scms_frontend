<script>

    $(document).ready(function () {
//more_info
    });

    $(".more_info").click(function () {
        var more_info = $(this).val();
        var cat_type = $('#cat_type').val();
//        alert(more_info);
        submitDataByPost(site_url + 'Membership_Groups/index_member/'+cat_type, 'more_info', more_info);
    });

    function submitDataByPost(submitPage, submitDataName, submitDataValue) {
        $('<form action="' + submitPage + '" method="POST"/>')
                .append(jQuery('<input type="hidden" name="' + submitDataName + '" value ="' + submitDataValue + '">'))
                .appendTo(jQuery(document.body))
                .submit();
    }

    function submitmutipleData(submitPage, submitData) {
        $('<form action="' + submitPage + '" method="POST"/>')
                .append(jQuery(submitData))
                .appendTo(jQuery(document.body))
                .submit();
    }

</script>
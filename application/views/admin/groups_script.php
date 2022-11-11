<script>
    $(document).ready(function () {
        $('#groups_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    });


    $(document).on('click', '.group_delete', function (event) {
        var group_id = $(this).data("value");
        var param = {
            group_id: group_id
        };

        $.ajax({
            url: site_url + '/Auth/delete_parent_group',
            method: "POST",
            dataType: "json",
            data: param,
            success: function (data) {
                Swal('Updated', 'Group has been deleted', 'success');
                setTimeout(function () {
                    location.reload();
                }, 800);
            }
        });

        console.log();
    });
</script>
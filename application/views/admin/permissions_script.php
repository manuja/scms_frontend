<?php $CI = & get_instance(); ?>
<script>

    $(document).ready(function () {


        if ($('#parent_permission2').val() == 0) {
            $('#child_permissions_div').hide();
            $('#new_child_permission_div').hide();
            $('#grandchild_permission_div').hide();
            $('#submit_div').hide();
        }


        $('#parent_permission2').on('change', function () {
            var parent_id = this.value;
            $.ajax({
                url: "<?php echo base_url() . 'index.php/Permissions/get_child_permissions' ?>",
                method: "POST",
                dataType: "json",
                success: function (data) {

                    var child_permissions = $('#child_permission');
                    var select_data = '<option value=\"0\">Please select...</option>';
                    $.each(data, function (index, value) {
                        if (value.parent_id == parent_id) {
                            select_data += '<option value="' + value.id + '">' + value.name + '</option>';
                            child_permissions.html('').append(select_data);
                        }
                    });
                    $('#perm_type').change(function () {
                        if (this.value === '') {
                            $('#child_permissions_div').hide();
                            $('#new_child_permission_div').hide();
                            $('#grandchild_permission_div').hide();
                            $('#submit_div').hide();
                        }

                        if (this.value === 'Child') {
                            $('#new_child_permission_div').show();
                            $('#submit_div').show();
                            $('#child_permissions_div').hide();
                            $('#grandchild_permission_div').hide();
                        }

                        if (this.value === 'Grandchild') {
                            $('#child_permissions_div').show();
                            $('#grandchild_permission_div').show();
                            $('#submit_div').show();
                            $('#new_child_permission_div').hide();
                        }
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                    console.log(XMLHttpRequest);
                }
            });
        });
        $("#data_div").load("<?php echo site_url('permissions/permissions1'); ?>", function (response, status, xhr) {

        });
        $("#save_parent_permission").on("click", function () {

            var permission = $("#parent_permission").val();
            if (permission == '') {

                $("#errParentPerm").text("Please enter permission!");
            } else {
                $("#errParentPerm").text("");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'index.php/Permissions/createParentPermission'; ?>",
                    cache: false,
                    data: $('#parent_permission_data').serialize(),
                    success: function (json) {
                        try {
                            var obj = jQuery.parseJSON(json);
                            if (obj['STATUS'] == 1) {

                                window.location.replace("<?php echo site_url('permissions'); ?>");
                            } else {
                                alert("Something went wrong!");
                            }


                        } catch (e) {
                            alert('Exception while request..' + json);
                        }
                    },
                    error: function () {
                        alert('Error while request..');
                    }
                });
            }
        });
        $("#save_child_permission").on("click", function () {

            var parent_permission = $("#parent_permission2").val();
            var new_child_permission = $("#new_child_permission").val();
            var new_grandchild_permission = $("#new_grandchild_permission").val();
            var perm_type = $("#perm_type").val();
            var child_permission = $("#child_permission").val();
            //alert(parent_permission +" --->"+new_child_permission);
            if (parent_permission != 0 && perm_type != 0) {


                if (perm_type == 'Child' && new_child_permission == '') {

                    $("#errChildPerm").text("Please enter child permission!");
                } else if (perm_type == 'Grandchild' && child_permission == 0) {

                    $("#errChildPermDropDown").text("Please select child permission!");
                } else if (perm_type == 'Grandchild' && new_grandchild_permission == '') {

                    $("#errGrandChildPerm").text("Please enter grand child permission!");
                } else {
                    $("#errChildPerm").text("");
                    $("#errGrandChildPerm").text("");
                    $("#errChildPermDropDown").text("");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'index.php/Permissions/createPermission'; ?>",
                        data: $('#child_permission_data').serialize(),
                        success: function (json) {
                            try {
                                var obj = jQuery.parseJSON(json);
                                if (obj['STATUS'] == 1) {

                                    window.location.replace("<?php echo site_url('permissions'); ?>");
                                    //alert(obj['PAR'] + ' '+obj['CHI']);

                                } else {
                                    alert("Something went wrong!");
                                }


                            } catch (e) {
                                alert('Exception while request..' + json);
                            }
                        },
                        error: function () {
                            alert('Error while request..' + json);
                        }
                    });
                }
            } else {
                swal('Error', 'Permissions cannot be empty!');
            }
        });


    });
    function load_data(val) {

        $("#data_div").load("<?php echo site_url('permissions/'); ?>" + val, function (response, status, xhr) {

        });
    }


    $('#modal-add-parent').on('hidden.bs.modal', function (e) {
        $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
    });


    $(document).on('click', '#child_perm_edit', function (event) {
        var per_id = $(this).val();
        var child_perm = $('#child_perm_' + per_id).val();
        var hidden_child = $('#hidden_child_' + per_id).val();

        var param = {
            hidden_child: hidden_child,
            child_perm: child_perm
        };

        $.ajax({
            method: 'POST',
            url: site_url + 'Permissions/edit_child_perm',
            dataType: 'json',
            data: param
        }).always(function (data) {
//                        console.log(data);
            if (data.status == '1') {
                $('#myModal').modal('hide');
                $('#description').val('');
                $('#subs_group').val('');
                $('#hidden_sub_id').val('');
                swal('Updated', 'Sub group updated', 'success');
                setTimeout(function () {
                    location.reload();
                }, 800);

            } else if (data.status == '2') {

                swal('Update failed', 'Sub group update failed', 'error');
            }

        });

    });




    $(document).on('click', '#grand_perm_edit', function (event) {
        var per_id = $(this).val();
        var grand_perm = $('#grand_perm_' + per_id).val();
        var hidden_grand = $('#hidden_grand_' + per_id).val();

        var param = {
            hidden_grand: hidden_grand,
            grand_perm: grand_perm
        };

        $.ajax({
            method: 'POST',
            url: site_url + 'Permissions/edit_grand_perm',
            dataType: 'json',
            data: param
        }).always(function (data) {
//                        console.log(data);
            if (data.status == '1') {
                $('#myModal').modal('hide');
                $('#description').val('');
                $('#subs_group').val('');
                $('#hidden_sub_id').val('');
                swal('Updated', 'Sub group updated', 'success');
                setTimeout(function () {
                    location.reload();
                }, 800);

            } else if (data.status == '2') {

                swal('Update failed', 'Sub group update failed', 'error');
            }

        });

    });

</script>
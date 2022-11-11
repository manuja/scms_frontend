<script>

    $(document).ready(function () {

        jQuery(document).ajaxStart(function () {
            jQuery(".loading_animation_content").show();
        }).ajaxStop(function () {
            jQuery(".loading_animation_content").hide();
        });
        
         $('#user_id').select2({
            placeholder: 'Please select...'
        });


    });


    $(document).on('change', '#user_id', function (event) {
        $('#jstree').jstree("destroy").empty();
        var user_id = $(this).val();
        create_js_tree(user_id);
    });

    function create_js_tree(user_id) {
        var param = {
            user_id: user_id
        };

        $.ajax({
            url: site_url + '/User_permissions_new/get_js_tree',
            method: "POST",
            dataType: "json",
            data: param,
            success: function (data) {
//                $('#tree').treeview({data: data, showCheckbox: true});
                $('#jstree').jstree({
                    'core': {
                        'data': data
                    },

                    "checkbox": {
                        "keep_selected_style": false
                    },
                    "plugins": ["checkbox"]
                });
            }
        });

    }


    $(document).on('click', '#users_perm_reset', function (event) {
        location.reload();
    });


    $(document).on('click', '#users_perm_save', function (event) {
        var user_id = $('#user_id').val();
        var result = $('#jstree').jstree('get_selected', true);
        var checkedNodes = result.filter((node) => {
            return node.state.disabled == false
        }).map((checked) => {
            return checked.id
        });
        var param = {
            checkedNodes: checkedNodes,
            user_id: user_id
        };

        $.ajax({
            url: site_url + '/User_permissions_new/save_user_permissions',
            method: "POST",
            dataType: "json",
            data: param,
            success: function (data) {
                swal('Updated', 'User Permissions Updated', 'success');
            }
        });

        console.log();
    });

//    function submitMe() {
//        var checked_ids = [];
//        $("#jstree").jstree("get_checked", null, true).each
//                (function () {
//                    checked_ids.push(this.id);
//                });
//        console.log(checked_ids);
//    }

</script>




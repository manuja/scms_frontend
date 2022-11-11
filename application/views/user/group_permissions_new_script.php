<script>

    $(document).ready(function () {

        jQuery(document).ajaxStart(function () {
            jQuery(".loading_animation_content").show();
        }).ajaxStop(function () {
            jQuery(".loading_animation_content").hide();
        });

        var group_id = $(this).val();
        create_js_tree(group_id);

    });


    $(document).on('change', '#group_id', function (event) {
        $('#jstree').jstree("destroy").empty();
        var group_id = $(this).val();
        create_js_tree(group_id);
    });

    function create_js_tree(group_id) {
        var param = {
            group_id: group_id
        };

        $.ajax({
            url: site_url + '/Group_permissions_new/get_js_tree',
            method: "POST",
            dataType: "json",
            data: param,
            success: function (data) {
//                $('#tree').treeview({data: data, showCheckbox: true});


                $('#jstree').on('select_node.jstree', function (e, data) {
                    if (data.event) {
                        data.instance.select_node(data.node.children_d);
                    }
                }).on('deselect_node.jstree', function (e, data) {
                    if (data.event) {
                        data.instance.deselect_node(data.node.children_d);
                    }
                }).jstree({
                    'core': {
                        'data': data
                    },

                    "checkbox": {
                        "keep_selected_style": false,
                        "three_state": false,
                        "cascade": ""
                    },
                    "plugins": ["checkbox"]
                });
            }
        });

    }


    $(document).on('click', '#group_perm_clear', function (event) {
        location.reload();
    });


    $(document).on('click', '#group_perm_save', function (event) {
        var group_id = $('#group_id').val();


        var selected = $('#jstree').jstree().get_selected(), i, j;
        for (i = 0, j = selected.length; i < j; i++) {
            selected = selected.concat($('#jstree').jstree().get_node(selected[i]).parents);
        }
        var checkedNodes = $.vakata.array_unique(selected);

//        console.log(selected);

//        var result = $('#jstree').jstree('get_selected', true);
//        var checkedNodes = result.filter((node) => {
//            return node.state.disabled == false
//        }).map((checked) => {
//            return checked.id
//        });



        var param = {
            checkedNodes: checkedNodes,
            group_id: group_id
        };

        $.ajax({
            url: site_url + '/Group_permissions_new/save_group_permissions',
            method: "POST",
            dataType: "json",
            data: param,
            success: function (data) {
                Swal('Updated', 'Group Permissions Updated', 'success');
            }
        });
//
//        console.log();
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




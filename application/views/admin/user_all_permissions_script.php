<script>
	
	$(document).ready(function (){

		//Get permission tree
		$.ajax({ 
	        url: "<?php echo base_url() . 'index.php/Group_permissions/getTree' ?>",
	        method:"POST",
	        dataType: "json",            
	        success: function(data) {
	            $('#tree').treeview({ data: data,showCheckbox: true });
	        }    
		});

		get_permissions_for_user();
	});


	//Get all permissions for given user
	function get_permissions_for_user(){

		var userid="<?php echo $user_id;?>";
        if (userid > 0) {
            var param = {};
            param.user_id = userid;
            $.post("<?php echo base_url() . 'index.php/User_permisions/get_permissions_to_user' ?>", param, function (response) {

                if (response !== null) {
                    if (response.status == "1") {

                        unchecked_nodes = $('#tree').treeview('getUnchecked', false);
                        $.each(unchecked_nodes, function (index, nodeobj) {
                            node_perm_id = nodeobj.id;
                            a = $.inArray(node_perm_id, response.data);
                            if (a > -1) {
                                $('#tree').treeview('expandNode', [nodeobj.nodeId, {levels: 2, silent: true}]);
                                $('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                            }
                        });

                    } else {
                        alert("No permissions assigned.");
                    }

                } else {
                    alert("Could not load data.");
                }
            }, 'json').fail(function () {
                alert("Could not load data.");
            });
        }

    }
</script>
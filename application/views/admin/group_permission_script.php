<script>


	$(document).ready(function(){

        //Get permission tree
		$.ajax({ 
	        url: "<?php echo base_url() . 'index.php/Group_permissions/getTree' ?>",
	        method:"POST",
	        dataType: "json",            
	        success: function(data) {
	            $('#tree').treeview({ data: data,showCheckbox: true });
	        }    
    	});

        //When group change load relevant permissions
        $(document).on('change', '#group_id', function (event) {
            $('#tree').treeview(true).uncheckAll();
            var group_id=$("#group_id").val();
            if(group_id != 0){
                $.ajax({ 
                    url: "<?php echo base_url() . 'index.php/Group_permissions/getUserGroupPermissions' ?>",
                    method:"POST",
                    data:{'group_id':group_id},           
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);

                        if (obj['status'] == "1") {

                            unchecked_nodes = $('#tree').treeview('getUnchecked', false);
                            $.each(unchecked_nodes, function (index, nodeobj) {
                                node_perm_id = nodeobj.id;
                                a = $.inArray(node_perm_id, obj['data']);
                                if (a > -1) {
                                    $('#tree').treeview('expandNode', [nodeobj.nodeId, {levels: 2, silent: true}]);
                                    $('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                                }
                            });
                        }else{
                            $.ajax({ 
                                url: "<?php echo base_url() . 'index.php/Group_permissions/getTree' ?>",
                                method:"POST",
                                dataType: "json",            
                                success: function(data) {
                                    $('#tree').treeview({ data: data,showCheckbox: true });
                                }    
                            });
                        }
                    }    
                });
            }
        });

        
        //Save group permissions
        $(document).on('click', '#save_perms', function (event) {
            var group_id=$("#group_id").val();

            checked_nodes = $('#tree').treeview('getChecked', false);
            //console.log(checked_nodes);
            var checked_perm_arr = [];
            if (checked_nodes) {
                $.each(checked_nodes, function (index, perm_node) {
                    checked_perm_arr.push(perm_node.id);
                });
            }
            
            if (group_id > 0 && checked_perm_arr.length > 0){
                $.ajax({ 
                    url: "<?php echo base_url() . 'index.php/Group_permissions/saveGroupPermissions' ?>",
                    method:"POST", 
                    data :{'group_id':group_id,'perms' : checked_perm_arr},          
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj['status'] == "1") {
                            alert(obj['msg']);
                        }
                    }    
                });
            }
        }); 

	});


</script>
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

	loadPermissionTree();


	});

	//Load group permission tree for given group
	function loadPermissionTree(){

		var group_id="<?php echo $group_id;?>";
		if(group_id != 0){
			$.ajax({ 
	            url: "<?php echo base_url() . 'index.php/Group_permissions/getUserGroupPermissions' ?>",
	            method:"POST",
	            data:{'group_id':group_id},           
	            success: function(data) {
	                var obj = jQuery.parseJSON(data);

	                if (obj['status'] == 1) {
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
	            },error: function(XMLHttpRequest, textStatus, errorThrown) { 
        			alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    			}    
	        });
		}else{
			alert("Group id is invalid");
		}
	}


</script>
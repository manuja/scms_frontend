<script>
	
	$(document).ready(function (){

		//Save parent permission
        $(document).on('click', '#add_perm', function (event) {

        	var parent_permission=$("#parent_permission").val();
        	if(parent_permission != ''){
        		$.ajax({ 
	                url: "<?php echo base_url() . 'index.php/Permissions/create_parent_permission' ?>",
	                method:"POST",
	                data:{'permission':parent_permission},           
	                success: function(data) {
	                    var obj = jQuery.parseJSON(data);

	                    if (obj['status'] == "1") {
	                    	location.reload();
	                    }else{
	                    	alert(obj['msg']);
	                    }
	                }    
            	});
        	}else{
        		alert("Please enter the permission name!");
        	}
        });
	});
</script>
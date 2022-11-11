<script>
	$(document).ready(function() {

		if($('#parent_permission').val() == '') {
			$('#child_permissions_div').hide();
			$('#new_child_permission_div').hide();
			$('#grandchild_permission_div').hide();
			$('#submit_div').hide();
		}

		$('#parent_permission').on('change', function() {
			var parent_id = this.value;
			$.ajax({ 
				url: "<?php echo base_url().'index.php/Permissions/get_child_permissions' ?>",
				method:"POST",
				dataType: "json",            
				success: function(data) {

					var child_permissions = $('#child_permission');
					var select_data = '<option value=\"\">Please select...</option>';
					$.each(data, function(index, value) {
						if(value.parent_id == parent_id) {
							select_data += '<option value="' + value.id + '">' + value.name + '</option>';
							child_permissions.html('').append(select_data);
						}
					});

					$('#perm_type').change(function() {
						if(this.value === '') {
							$('#child_permissions_div').hide();
							$('#new_child_permission_div').hide();
							$('#grandchild_permission_div').hide();
							$('#submit_div').hide();
						}

						if(this.value === 'Child') {
							$('#new_child_permission_div').show();
							$('#submit_div').show();
							$('#child_permissions_div').hide();
							$('#grandchild_permission_div').hide();
						}

						if(this.value === 'Grandchild') {
							$('#child_permissions_div').show();
							$('#grandchild_permission_div').show();
							$('#submit_div').show();
							$('#new_child_permission_div').hide();
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
        			alert("Status: " + textStatus); alert("Error: " + errorThrown);
        			console.log(XMLHttpRequest); 
    			} 
			});
		});
  });
</script>
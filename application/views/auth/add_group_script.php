<script>
	$(document).ready( function(){

		$("#errNameMsg").html('');
	});

	function validateForm() {
	    var checked = $("#addGroup input:checked").length > 0;
	    if (!checked) {
	        $("#msg").html('Please select atleast one group!');
	        return false;
	    }
	}
</script>
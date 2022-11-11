<script>
	$(document).ready( function(){

		$("#errNameMsg").html('');
	});

	function validateForm() {
	    var x = document.forms["addSubGroup"]["name"].value;
	    if (x == "") {
	        $("#errNameMsg").html('Name must be filled out');
	        return false;
	    }
	}
</script>
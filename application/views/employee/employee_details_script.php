<script>
$(document).ready(function(){
    //Initiate date
    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    $(".select-dropdown-tags").select2({
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                  return null;
                }

                return {
                  id: term.substr(0,1).toUpperCase()+term.substr(1),
                  text: term.substr(0,1).toUpperCase()+term.substr(1),
                  newTag: true // add additional parameters
                }
            }
        });
});
</script>

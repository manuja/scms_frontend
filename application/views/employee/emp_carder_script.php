<script>
$(document).ready(function () {
       
    loadDataTable();
    
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

function loadDataTable(){

        var export_columns = [0, 1, 2, 3];
        //Load data table
        $('#emp_carder_table').DataTable({
            destroy: true,
            language: {
                searchPlaceholder: "Search by Designation"
            },
            "responsive": true,
            "autoWidth": true,
            "processing": true,
            "serverSide": true,
            "scrollY": "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo site_url(); ?>EmployeeController/getEmployeeCarder",
                "type": "POST",
                "data": {                    
                }
            },
            "columns": [
                {"data": ""},
                {"data": "designation"},
                {"data": "no_of_allowed"},
                {"data": "no_of_fill"}
            ],
           "columnDefs": [
                {
                    "targets": -4,
                    "data": "0",
                    "render": (data, type, full, meta) => meta.row+1,
                    
                },
               
                { "width": "5%", "targets": -4 },
                { "width": "30%", "targets": -3 },
                { "width": "30%", "targets": -2 },
                { "width": "25%", "targets": -1 }
            ],
            dom: 'Bfrtlip',
            buttons: [
//                 'copy', 'excel', 'pdf'
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    className: 'btn btn-default',
                    exportOptions: { 
                        columns: export_columns
                    }

                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    className: 'btn btn-default',
                    exportOptions: { 
                        columns: export_columns
                    }

                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    className: 'btn btn-default',
                    exportOptions: { 
                        columns: export_columns
                    },
                    customize: function (doc) {
//                        doc.content[1].table.widths =
//                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                        doc.content[1].table.body[0].forEach(function (h) {
                            h.fillColor = '#EA7500';
                            alignment: 'center'
                        });

                        doc.styles.title = {
                            color: '#2D1D10',
                            fontSize: '16',
                            alignment: 'center'
                        }
                    }

                },
            ], 
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    }
    
     function getButton(full) {
        var html = "";
           
            $.ajax({
            type: 'POST',
            url: "<?php echo base_url('EmployeeController/getEmployeeCountForDesignation') ?>",
            data: {
                'designation_id': full['designation_id']
            },
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
               html = data.no_of_employee;
                
            }
        });
           
           
        return html;
    }
    

   
    
</script>
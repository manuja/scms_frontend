<script>
$(document).ready(function () {
   
    loadDataTable();
    
    
    
});

function loadDataTable(){

        var export_columns = [0, 1, 2, 3,4];
        //Load data table
        $('#emp_loan_table').DataTable({
            destroy: true,
            language: {
                searchPlaceholder: "Search by Emp No/Name"
            },
            "responsive": true,
            "autoWidth": true,
            "processing": true,
            "serverSide": true,
            "scrollY": "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo site_url(); ?>EmployeeController/getEmployeeLoanList",
                "type": "POST",
                "data": {                    
                }
            },
            "columns": [
                {"data": "employee_no"},
                {"data": "name_w_initials"},
                {"data": "loan_type"},
                {"data": "date"},
                {"data": "amount"},
                {"data": ""}
            ],
           "columnDefs": [
                
                {
                    "targets": -1,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getButton(full);
                    },
                },
                {
                    "targets": -2,
                    "data": "0",
                    "render": function (data, type, full, meta) {
                        return getNumberformat(full);
                    },
                },
                
//            "order": [
//                [0, "asc"]
               
                { "width": "15%", "targets": -6 },
                { "width": "20%", "targets": -5 },
                { "width": "20%", "targets": -4 },
                { "width": "10%", "targets": -3 },
                { "width": "10%", "targets": -2 },
                { "width": "20%", "targets": -1 }
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
            html = '<a href="<?php echo site_url('employee/view-loan-dependency/'); ?>'+full["emp_loan_id"]+'" class="btn btn-success" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a> ';
            
           <?php if($this->userpermission->checkUserPermissions2('emp_loan_dependency_update')){ ?>        
                html += '<a href="<?php echo site_url('employee/update-loan-dependency/'); ?>'+full["emp_loan_id"]+'" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> ';
            <?php } ?>
            <?php if($this->userpermission->checkUserPermissions2('emp_loan_dependency_delete')){ ?>       
                html += '<button id="'+full["emp_loan_id"]+'" class="btn btn-danger delete_btn" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>';
            <?php } ?>
        return html;
    }
    
    function getNumberformat(full){
        

       
          var val = full['amount'];
          val = val.replace(/[^0-9\.]/g,'');

          if(val != "") {
            valArr = val.split('.');
            valArr[0] = (parseInt(valArr[0],10)).toLocaleString();
            val = valArr.join('.');
          }

          return val;
       
    }
    
    
   $(document).on("click",".delete_btn",function () {
//   $(".delete_btn").on('click',function () {
            event.preventDefault();
            var loan_id = $(this).attr('id');
            
            swal({
            title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('EmployeeController/deleteEmployeeLoan'); ?>',
                        data: {
                            'loan_id':loan_id
                        },
                        success: function (data) {
                            var res = JSON.parse(data);
                            if (res.status == 1) {
                                swal({
                                    title: 'The record was removed!',
                                    type: 'success'
                                }).then(function () {
                                    window.location.reload();
                                });
                            } else {
                                swal({
                                    title: 'Error!',
                                    text: 'The record is not remove',
                                    type: 'error'
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(textStatus);
                        }
                    });
                }
            }); 
        });

   
    
</script>
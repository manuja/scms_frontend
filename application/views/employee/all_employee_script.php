<script>
$(document).ready(function () {
    $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD'
    });
    $('.select2').select2();
    
    loadDataTable();
    
    
     $(document).on('click','.btn_promotion',function(){
//         $(".btn_promotion").click(function(){
        
        $("#pomo_emp_name").val($(this).attr('data-empName'));
        $("#promo_emp_id").val($(this).attr('data-empid'));
        $("#promo_emp_profile_id").val($(this).attr('id'));
        $('#emp_promotion').modal('show');
    });
    
     $(document).on('click','.btn_leave',function(){
//         $(".btn_promotion").click(function(){
        
        $("#leave_emp_name").val($(this).attr('data-empName'));
        $("#leave_emp_id").val($(this).attr('data-empid'));
        $("#leave_emp_profile_id").val($(this).attr('id'));
        $('#emp_leave').modal('show');
    });
});

function loadDataTable(){

        var export_columns = [0, 1, 2, 3,4];
        //Load data table
        $('#emp_list_table').DataTable({
            destroy: true,
            language: {
                searchPlaceholder: "Search by Emp No"
            },
            "responsive": true,
            "autoWidth": true,
            "processing": true,
            "serverSide": true,
            "scrollY": "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo site_url(); ?>EmployeeController/getRecordList",
                "type": "POST",
                "data": {                    
                }
            },
            "columns": [
                {"data": "employee_no"},
                {"data": "name_w_initials"},
                {"data": "division_name"},
                {"data": "job_title"},
                {"data": "employment_status"},
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
                        return getStatus(full);
                    },
                },
//            "order": [
//                [0, "asc"]
               
                { "width": "10%", "targets": -6 },
                { "width": "20%", "targets": -5 },
                { "width": "10%", "targets": -4 },
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
            <?php if($this->userpermission->checkUserPermissions2('emp_view')){ ?>        
                html = '<a href="<?php echo site_url('employees/view_profile/'); ?>'+full["user_profile_id"]+'" class="btn btn-success" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a> ';
            <?php } ?>
           <?php if($this->userpermission->checkUserPermissions2('emp_edit')){ ?>        
                html += '<a href="<?php echo site_url('employee/employee-details/'); ?>'+full["user_profile_id"]+'" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> ';
            <?php } ?>
            <?php if($this->userpermission->checkUserPermissions2('emp_promo_add')){ ?>       
                html += '<botton id="'+full["user_profile_id"]+'" data-empId="'+full['employee_no']+'" data-empName = "'+full['name_w_initials']+'" class="btn btn-info btn_promotion" data-toggle="tooltip" title="Promitions"><i class="fa fa-trophy"></i></botton> ';
            <?php } ?>
            <?php if($this->userpermission->checkUserPermissions2('emp_leave_add')){ ?>       
                html += '<botton id="'+full["user_profile_id"]+'" data-empId="'+full['employee_no']+'" data-empName = "'+full['name_w_initials']+'" class="btn btn-default btn_leave" data-toggle="tooltip" title="Leave"><i class="fa fa-sign-out"></i></botton> ';
            <?php } ?>
        return html;
    }
    function getStatus(full){
        var html ="";
        if(full['employment_status']==1){
            html =  "Temporary";
        }else if(full['employment_status']==2){
            html = "Full time";
        }else if(full['employment_status']==3){
            html = "Contract";
        }else if(full['employment_status']==4){
            html = "Permanent";
        
        }else if(full['employment_status']==5){
            html = "Probation";
        }else{
            html = "-";
        }
        return html;
    }

   
    
</script>
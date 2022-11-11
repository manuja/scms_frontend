<?php
   header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#order_need_date').attr('style', 'display: all');
        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('.timepicker').datetimepicker({
            format: 'LT'
        });

    });
</script>

<script type="text/javascript">
 jQuery(document).ready(function () {


    var hosturl="http://localhost/";

    jQuery.ajax({
        type:'GET',
        url: hosturl+"scms_backend/API/getOriginOrderItem",
        headers: {"token": 'Ab&5$rgyh123oakyhgfdA'},
                        
        success: function (json) {
          //  console.log(json);
           //alert(json);    
           var options = json;
            var selectOption = $('#droporderitem');
            $.each(options, function (val, text) {
                selectOption.append(
                    $('<option></option>').val(val).html(text)
                );
            });  

          
            var selectOption = $('#droporderitemedit');
            $.each(options, function (val, text) {
                selectOption.append(
                    $('<option></option>').val(val).html(text)
                );
            }); 




        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });


       });
</script>


<script type="text/javascript">
   

        var orderid=jQuery('#orderid').val();
        var hosturl="http://localhost/";
        //alert(orderid);
        jQuery('#staffListing').dataTable({
            "lengthChange": false,
            "paging": true,
            "processing": false,
            "serverSide": false,
            "bFilter": false,
            "order": [],            
            "ajax": {
                //"url": "http://localhost/scms/staff/getStaffListing",
                "url": hosturl+"scms_backend/API/getOrderItem?orderid="+orderid,
                "headers": {'token': 'Ab&5$rgyh123oakyhgfdA'},
                "type": "GET",
                "data": function ( data ) {

                    //console.log(data);

                    data.name = $('#name_filter').val();
                    data.email = $('#email_filter').val();
                    data.mobile = $('#contact_filter').val();
                    data.address = $('#address_filter').val();
                }
            },
            
            "columns": [
                {
                    "bVisible": false, "aTargets": [0]
                },
                null,
                {
                    "bVisible": false, "aTargets": [0]
                },
                null,
                null,
               
                {
                    mRender: function (data, type, row) {

                        var bindHtml = '';

                         if(row[2]!=null){

                        bindHtml += '<a id="updateid" data-toggle="modal" data-target="#update-staff"  title="Edit Staff" class="update-staff-details ml-1 btn-ext-small btn btn-sm btn-primary" onclick="updateItemByItem('+ row[2] +')"  data-staffid="' + row[2] + '"><i class="fa fa-edit"></i></a>';
                        bindHtml +='&nbsp;&nbsp;';
                        bindHtml += '<a data-toggle="modal" data-target="#delete-staff" onclick="deleteItemByItem('+ row[2] +')" title="Delete Stff" class="delete-staff-details ml-1 btn-ext-small btn btn-sm btn-danger" data-staffid="' + row[2] + '"><i class="fa fa-times"></i></a>';

                      }

                        return bindHtml;
                    }
                },
                
            ],
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', aData[0]);
            }
        });        
        function filterGlobal(v) {
            jQuery('#staffListing').DataTable().search(
                    v,
                    false,
                    false
                    ).draw();
        }
        jQuery('input.global_filter').on('keyup click', function () {
            var v = jQuery(this).val();    
            filterGlobal(v);
        });
        jQuery('input.column_filter').on('keyup click', function () {
            jQuery('#staffListing').DataTable().ajax.reload();
        });
      //});
</script>

<script type="text/javascript">

    function updateItemByItem(id)
{

     var hosturl="http://localhost/";

     jQuery('#ListItemId').val(id); 

    jQuery.ajax({
        type:'GET',
        url: hosturl+"scms_backend/API/getOrderedItemSingle?itemid="+id,
        headers: {"token": 'Ab&5$rgyh123oakyhgfdA'},
                  
        success: function (json) {

           jQuery('#qtyedit').val(json[0]['qty']); 
           jQuery('#qtyedithide').val(json[0]['qty']);
           jQuery("#droporderitemedit").val(json[0]['order_item_id']);

                          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
}

function deleteItemByItem(id)
{
     var hosturl="http://localhost/";

     //jQuery('#ListItemId').val(id); 

    jQuery.ajax({
        type:'GET',
        url: hosturl+"scms_backend/API/deleteOrderedItemSingle?itemid="+id,
        headers: {"token": 'Ab&5$rgyh123oakyhgfdA'},
       // data:jQuery("form#update-staff-form").serialize(),
        //dataType:'json',                   
        success: function (json) {

          jQuery('span#success-msg').html('<div class="alert alert-success">Record delete successfully.</div>');
          jQuery('#staffListing').DataTable().ajax.reload();

                          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
}

</script>


<script>
jQuery(document).on('click', 'button#add-staff', function(){


//alert("cool");

    var orderid=jQuery('#orderid').val();

   // alert("vaaa"+orderid);
    jQuery('#orderidval').val(orderid);

    
    jQuery.ajax({
        type:'POST',
       // url:'http://localhost/scms/staff/save',
        url:'http://localhost/scms_backend/API/addItem/',
        headers: {"token": 'Ab&5$rgyh123oakyhgfdA'},
        data:jQuery("form#add-staff-form").serialize(),
        dataType:'json',    
        beforeSend: function () {
            jQuery('button#add-staff').button('loading');
        },
        complete: function () {
            jQuery('button#add-staff').button('reset');
            setTimeout(function () {
                jQuery('span#success-msg').html('');
            }, 5000);
            
        },                
        success: function (json) {
            $('.text-danger').remove();
            if (json['error']) {             
                for (i in json['error']) {
                    var element = $('.input-staff-' + i.replace('_', '-'));
                    if ($(element).parent().hasClass('input-group')) {                       
                        $(element).parent().after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                    }
                }
            } else {
                jQuery('span#success-msg').html('<div class="alert alert-success">Record added successfully.</div>');
                jQuery('#staffListing').DataTable().ajax.reload();
                jQuery('form#add-staff-form').find('textarea, input').each(function () {
                    jQuery(this).val('');
                });
                jQuery('#add-staff').modal('hide');
                
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
});
jQuery(document).on('click', 'button#update-staff', function(){
    
    jQuery.ajax({
        type:'POST',
        url:'http://localhost/scms_backend/API/updateItem/',
        headers: {"token": 'Ab&5$rgyh123oakyhgfdA'},
        data:jQuery("form#update-staff-form").serialize(),
        dataType:'json',    
        beforeSend: function () {
            jQuery('button#update-staff').button('loading');
        },
        complete: function () {
            jQuery('button#update-staff').button('reset');
            setTimeout(function () {
                jQuery('span#success-msg').html('');
            }, 5000);
            
        },                
        success: function (json) {
           // alert("okkkk"+json);
            $('.text-danger').remove();
            if (json['error']) {             
                for (i in json['error']) {
                  var element = $('.input-staff-' + i.replace('_', '-'));
                  if ($(element).parent().hasClass('input-group')) {                       
                    $(element).parent().after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                  } else {
                    $(element).after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                  }
                }
            } else {
                jQuery('span#success-msg').html('<div class="alert alert-success">Record updated successfully.</div>');
                jQuery('#staffListing').DataTable().ajax.reload();
                jQuery('form#update-staff-form').find('textarea, input').each(function () {
                    jQuery(this).val('');
                });
                jQuery('#update-staff').modal('hide');
            }                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
});
jQuery(document).on('click', 'button#delete-staff', function(){
    var staff_id = jQuery('#staff_id').val();
    jQuery.ajax({
        type:'POST',
        url:'http://localhost/scms/staff/delete',
        data:{staff_id: staff_id},
        dataType:'html',  
        success: function (html) {
         jQuery('span#success-msg').html('');
            jQuery('span#success-msg').html('<div class="alert alert-success">Deleted staff successfully.</div>');  
         jQuery('#staffListing').DataTable().ajax.reload();    
         jQuery('#delete-staff').modal('hide');       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
})



   $(document).ready(function() {


      //Initiate date
      $('#event_date').datetimepicker({
         format: 'YYYY-MM-DD',
         minDate: new Date,
      });
      $('.timepicker').datetimepicker({
         format: 'LT',
      });


      $('#event_time').datetimepicker({
         format: 'hh:mm A'
      });


      var editstaus = $('#edit_status').val();

      if( editstaus == true ){

         //uploaddiv save_pr_viva_data

$('#title').prop("readonly", false);
$('#event_date').prop("readonly", false);
$('#event_time').prop("readonly", false);
$('#event_venue').prop("readonly", false);
$('#event_description').prop("readonly", false);
$('#save_pr_viva_data').attr('style','display: true');
$('#uploaddiv').attr('style','display: true');


}else{

   $('#title').prop("readonly", true);
$('#event_date').prop("readonly", true);
$('#event_time').prop("readonly", true);
$('#event_venue').prop("readonly", true);
$('#event_description').prop("readonly", true);
$('#save_pr_viva_data').attr('style','display: none');
$('#uploaddiv').attr('style','display: none');


}



   });


   $('#upload').change(function(){

fileName = document.querySelector('#upload').value;
extension = fileName.split('.').pop();



// console.log(extension);
console.log(fileName);
if( extension == 'jpg' || extension == 'jpeg'){

   file_name_text =  fileName.split('\\').pop();
   uploadstatus = true;


}else{

   swal('File Upload', 'File Upload failed ! Plese check you file format ', 'error');
   $('#upload').val("");

}




  
});




</script>
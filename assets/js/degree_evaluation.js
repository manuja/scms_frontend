$(document).ready(function(){
    $("input[name='class_for_apply']").change(function(){
    var class_selected = $(this).val();
        switch(class_selected){
            case "1": 
                 window.location.replace("register/new");
                break;
            case "2": 
                 window.location.replace("register/new");
                break;
            case "3": 
                 window.location.replace("register/new");
                break;
            case "6": 
                $("#accredited_degree").show();
                $("#apply_class").hide();
                break;
            case "7": 
                $("#accredited_degree").show();
                $("#apply_class").hide();
                break; 
            case "8": 
                  window.location.replace("uploads/general/System_Instructions_Guideline(MIE).pdf");
                break; 
            case "9": 
                  window.location.replace("uploads/general/System_Instructions_Guideline(FIE).pdf");
                break; 
            default:
                console.log('else');
              
        }
        
    });
    
    
   $("#valid_yes").click(function(){
       window.location.replace("register/new");
   });
   $("#valid_no").click(function(){
     $("#accredited_degree").hide();
     
     $('#recognized_degree').show();
   });
   
   $("#recognized_yes").click(function(){
       window.location.replace("register/new");
   });
   
   $("#recognized_no").click(function(){
     $("#recognized_degree").hide();
     var apply_class = $("input[name='class_for_apply']:checked").val();
     
     if(apply_class == '6'){
         $("#wa_or_sa").text('Is your degree program accredited by the Washington Accord ?');
     }else{
         $("#wa_or_sa").text('Is your degree program accredited by the Sidney Accord ?');
     }
     $('#approved_washnton').show();
   });
   
   $("#washington_yes").click(function(){
       var apply_class = $("input[name='class_for_apply']:checked").val();
       if(apply_class=='6'){
           $("#am_entry").show();
           $("#af_entry").hide();
       }else{
           $("#am_entry").hide();
           $("#af_entry").show();
       }
       if(apply_class == '6'){
            window.location.replace("degree_evaluation/"+apply_class+"/WA");
        }else{
            window.location.replace("degree_evaluation/"+apply_class+"/SA");
        }
       
   });
   $("#washington_no").click(function(){
      $("#approved_washnton").hide();
      var apply_class = $("input[name='class_for_apply']:checked").val();
       if(apply_class=='6'){
           $("#am_entry").show();
           $("#af_entry").hide();
       }else{
           $("#am_entry").hide();
           $("#af_entry").show();
       }
     $('#entry_req').show();
   });
   
   $("#req_yes").click(function(){
       var apply_class = $("input[name='class_for_apply']:checked").val();
//       console.log(apply_class);
         window.location.replace("degree_evaluation/"+apply_class+"/NR");
   });
   $("#req_no").click(function(){
      
      $("#msg_div").show();
   });
   
  
   
  
});


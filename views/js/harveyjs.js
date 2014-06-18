/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    function getRadioChecked(radioName,radiovalue){
             var obj=document.getElementsByName(radioName);
             for(i=0;i<obj.length;i++){
                 if(obj[i].value==radiovalue){
                         obj[i].checked=true;
                 }
             }
             return true;
         }

    function del_sure(str){
            var gnl = confirm("do you confirm?");
            if(gnl == true){
                window.location="http://localhost/more/controllers/edit_templates/remove_template.php?id="+str;
                return true;
            }
            else{
                return false;
            }
        }
        
        
    function del_group_sure(str){
        var gnl = confirm("do you confirm?");
        if(gnl==true){
            //window.location="http://localhost/megsys/controller/listcontroller/remove_group.php?id="+str;
            return true;
        }else{
            return false;
        }
    }    
    
    function del_groupmember_sure(str,str2){
        var gnl = confirm("do you confirm?");
        if(gnl==true){
            window.location="http://localhost/more/controllers/listcontroller/remove_group_member.php?group="+str+"&member="+str2;
            return true;
        }else{
            return false;
        }
    }    

    function doSubmit() {
            var objForm=emailform;
            objForm.action="http://localhost/more/controllers/previewemail/email_preview.php";
            objForm.target="preview_page";
            window.open('http://localhost/more/controllers/previewemail/email_preview.php', 'preview_page', 'scrollbars=yes,width=600,height=600');
            objForm.submit();

           }
    function emailSubmit(sig){
            if(sig.value.length==0){
            sig.focus();
            alert("please input your filename");
            return false;
            }
            
            var objForm=emailform;
            //objForm.action="http://localhost/megsys/controller/send_email_controller.php";
            objForm.action="previewemail/confirm_email_page.php";
            objForm.target="preview_page";
            window.open('previewemail/confirm_email_page.php', 'preview_page', 'scrollbars=yes,width=600,height=600');
            objForm.submit();
    }
    
    
    
        $(document).ready(function() { 
        $("input[name=select_method]").each(function()
        {
            //alert($(this).attr("id") + ",  " + $(this).attr("checked"));
            if($(this).attr("id") === "email" && ($(this).attr("checked") === true || $(this).attr("checked") === "checked"))
            {
                //alert($(this).attr("value"));
                $("#etemplate").show(); 
                $("#stemplate").hide(); 
            }
            else if($(this).attr("id") == "sms" && ($(this).attr("checked") === true || $(this).attr("checked") === "checked"))
            {
                //alert($(this).attr("value"));
                $("#etemplate").hide(); 
                $("#stemplate").show(); 
            }
            //return false;
        });
        
        $(":radio").click(function(){  
        //if($(this).attr("id") === "email" && ($(this).attr("checked") === true || $(this).attr("checked") === "checked")) { 
        if($(this).attr("id") === "email" && ($(this).attr("checked") === true || $(this).attr("checked") === "checked")) { 
          $("#etemplate").show(); 
          $("#stemplate").hide();
        }else //if($(this).attr("id") === "sms" && ($(this).attr("checked") === true || $(this).attr("checked") === "checked")) 
        {
            if(($(this).attr("id"))==="sms")
            {
              $("#etemplate").hide(); 
              $("#stemplate").show();
            }
        } 
      })      
    }); 
    
    function selectAllCheckBox(obj){
        var allInput = document.getElementsByTagName("input");
        //alert(allInput.length);
        var loopTime = allInput.length;
        for(i = 0;i < loopTime;i++)
        {
            //alert(allInput[i].type);
            if(allInput[i].type == "checkbox")
            {
                allInput[i].checked = obj.checked;
            }
        }
    }

    function checkdata(sig){
       // alert(sig.value.length);
        
//        if(sig.value.indexOf(" ")!=-1){
//            alert("there is a space in your filename!");
//            return false; 
//        }
        if(sig.value.length==0){
            sig.focus();
            alert("please input your filename");
            return false;
        }
    }
    
    function checkdata_content(sig){
        if(sig.value.length==0){
           var gnl = confirm("no centent, are you sure?");
           if(gnl==true){
               return true;
           }
           else{
               return false;
           }
        }
    }
    
    function checkdata_campaign(sig){
        if(sig.value.length==0){
            sig.focus();
            alert("please input campaign name");
            return false;
        }
    }
    
    function selectfunction(str){
        alert('ddd');
        document.getElementByName(str).execCommand('Underline');
    }
    
    function changeStyle(str){
        document.getElementById(str).style.fontWeight='bold';
    }
    
    function closepage(){
        window.close();
    }
    
    
    $(document).ready(function(){
        $("#hide").click(function(){
            $("#t1").hide();
        });
        $("#show").click(function(){
            $("#t1").show();
        });
    });
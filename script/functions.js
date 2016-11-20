
function submitNote(finishFunction) {   
 
    var Type = document.getElementById("noteType").value ; 
    var Str = document.getElementById("noteString").value ;     
    var Vlue = document.getElementById("noteValue").value ;     
    
    
    $.post("script/php/notes.php" , "type="+Type+"&str="+Str+"&vlue="+Vlue , finishFunction) ; 
}
function deleteNote(note, ftDeRetour){
    
    $.post("script/php/notes.php" , "remove="+note, ftDeRetour) ; 
    
}
function workSubmitForm(elm){
    
    
    if(document.getElementById('WorkSubmitRadioB').style.display!="none"){
        
        var hours = document.getElementById("hoursToken").value ; 
        var impression = document.getElementById("impr").value ; 
        var improve = (document.getElementsByName("wimp")[0].checked)?"Y":"N" ; 
        var org   = (document.getElementsByName("org")[0].checked)?"Y":"N" ; 
        
        hours = hours==""?"1":hours ; 
        
        $.post("script/php/submitForm.php" , "hours="+hours+"&imprs="+impression+"&improve="+improve+"&org="+org,function(){
            
           
            document.getElementsByClassName('modal-backdrop')[0].remove() ; 
            
            buttonClick(document.getElementById('agendaButton')) ;
        }) ; 
        
        return ; 
    }
    
    Chked = (elm.children[1].children[0].checked)?1:((elm.children[2].children[0].checked)?2:(elm.children[3].children[0].checked)?3:0) ; 
    if(Chked == 0){
    alert("Select a Radio Button") ; 
    return  ;
    }
    
   $.post("script/php/submitForm.php" , "Work="+Chked+"&For="+submitWorkId, function(rep){
   if(rep == 1022){
 
       document.getElementById("cancelButtonModul").disabled="disabled" ; 
       showOtherModul() ; 
   }
   if(rep == 1023){
       alert("Work is already expired! ") ; 
       
   }
   if(rep == 1024){
       alert("Must finish the work today !") ;
        
   }  
   if(rep == 1025){
       alert("You are allowed to bypass the work to tomorrow") ; 
        
   }  
       
       
   }) ; 

    
}
function showOtherModul(){
    
    $("#WorkSubmitRadioA").fadeOut(600 , function(){
        $("#WorkSubmitRadioB").fadeIn(400) ; 
        
    }) ; 
    
    
}
function addWork(){
    
    var workTitle = document.getElementById("workTitle").value; 
    var workType  = document.getElementById("workType").value ;  
    var limitDay  = document.getElementById("limit").value; 
    var difficulity = document.getElementById("diff").value; 
    var description = document.getElementById("desc").value; 
    
    
    if(workTitle == "" || workType == "" || limitDay == "" || description == "" || difficulity == ""){
        alert("complete all fields input"); 
        return ; 
    }
    if(difficulity*1 != difficulity || difficulity>10 || difficulity < 0 ){
        alert("difficulity is a number between 0 and 10") ; 
        return ; 
    }
    $("#newAgenda").modal("toggle") ; 
    
    ShowLoading() ; 
    
    var data = "workTitle="+workTitle+"&workType="+workType+"&limitDay="+limitDay+"&difficulity="+difficulity+"&description="+description ; 
    
    $.post("script/php/createWork.php" ,data , function(){
        
       HideLoading(function(){
           
           buttonClick(document.getElementById('agendaButton')) ;
           
       }) 
        
       
    } ) ;     

    
}









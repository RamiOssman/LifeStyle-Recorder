function successAlert(innerMessage , status){
    
   
    var Alert = document.getElementById("successalert") ; 
    
     if(!status){
     $(Alert).fadeOut(600); 
     return ;      
    }
    
    Alert.innerHTML = innerMessage ; 
    $(Alert).fadeIn(600); 
    
        
    
    
}
function infoAlert(innerMessage , status){
    
   
    var Alert = document.getElementById("infoalert") ; 
    
     if(!status){
     $(Alert).fadeOut(600); 
     return ;      
    }
    
    Alert.innerHTML = innerMessage ; 
    $(Alert).fadeIn(600); 
    
        
    
    
}
function warningAlert(innerMessage , status){
    
   
    var Alert = document.getElementById("warningalert") ; 
    
     if(!status){
     $(Alert).fadeOut(600); 
     return ;      
    }
    
    Alert.innerHTML = innerMessage ; 
    $(Alert).fadeIn(600); 
    
        
    
    
}
function dangerAlert(innerMessage , status){
    
   
    var Alert = document.getElementById("dangeralert") ; 
    
     if(!status){
     $(Alert).fadeOut(600); 
     return ;      
    }
    
    Alert.innerHTML = innerMessage ; 
    $(Alert).fadeIn(600); 
    
   
}



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
    
    if($("#WorkSubmitRadioK")[0].style.display=="none"){
        
         ShowLoading() ; 
        
         $("#newAgenda").modal("toggle") ; 
        
     minWork = window.minWork ; 
     initalData = window.datK ;    
     responseData = window.datF ;  
     workSelected = "" ;     
    
        var tableBody = document.getElementById("SelectWorkDateTable");  
        
        for(tdn = 0 ; tdn < tableBody.childElementCount ; tdn++){
            
            child = tableBody.children[tdn] ;  
            
            if(child.children[2].children[0].checked){
                 
                workof  = "workOf="+child.children[0].innerText ;
                
                chapter = child.children[3].children[0].value ; 
                
                finalInfo = initalData+"&"+workof+"&chapter="+chapter;
                
                $.post("script/php/createWork.php" , finalInfo , function(){
                    
                })
            }
         
            
            
        }
    
        
      HideLoading(function(){
           buttonClick(document.getElementById('agendaButton')) ; successAlert("Agenda Updated !" , true)}) ;  
        
        
     return ; 
    }
    
    var workTitle = document.getElementById("workTitle").value; 
    var workType  = document.getElementById("workType").value ;  
    var limitDay  = document.getElementById("limit").value; 
    var difficulity = document.getElementById("diff").value; 
    var description = document.getElementById("desc").value; 
    
    var chaptersDiv = document.getElementById("chapters") ; 
    
    var chapters = "" ; 
    
    for(x = 0 ; x < chaptersDiv.childElementCount ; x++){
        
        var Chapter = chaptersDiv.children[x].children[0] ;
        
        if(Chapter.checked)
            chapters+=Chapter.value+"||" ; 
    
        
        
    }
    
    
    if(workTitle == "" || workType == "" || limitDay == "" || description == "" || difficulity == ""){
        alert("complete all fields input"); 
        return ; 
    }
    if(difficulity*1 != difficulity || difficulity>10 || difficulity < 0 ){
        alert("difficulity is a number between 0 and 10") ; 
        return ; 
    }
   // $("#newAgenda").modal("toggle") ; 
    
   // ShowLoading() ; 
    
    var data = "workTitle="+workTitle+"&workType="+workType+"&limitDay="+limitDay+"&difficulity="+difficulity+"&description="+description+"&chapters="+chapters ; 
    

    $("#WorkSubmitRadioK").fadeOut(400) ; 
    window.datK = data ; 
    
   $.ajax({
    url: "script/php/createWork.php",
    type: 'POST',
    data: data,
    dataType:"json",
    success: function(d) {
        
        window.datF = d ;
        
        $("#SelectWorkDate").fadeIn(800) ;
        
        table = document.getElementById("SelectWorkDateTable") ; 
        
        console.log(d) ; 
        
        select = "<option selected value='' >Select Work</option>" ; 
        select+= "<option value='Total' >General Work</option>" ; 
        
        window.minWork = d[d.length-1].length ; 
        
        for(x = 0 ; x < d[d.length-1].length ; x++){
            
            m = d[d.length-1] ; 
            n = d[d.length-2] ; 
            
            select+="<option value="+n[x]+" >"+m[x]+"</option>" ; 
            
        } 
        
        for(x = d.length-3 ; x >= 0 ; x--){
            
        var row = table.insertRow(0);
            
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1); 
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);    
        var cell5 = row.insertCell(4);
            
             
            cell1.innerHTML = d[x]["day"]+"-"+d[x]["month"]+"-"+d[x]["year"] ; 
            cell2.innerHTML = d[x]["Charge"]+"/"+d[x]["maxWork"] ;
            cell3.innerHTML = "<input onclick='checkButton(this)' type='checkbox' name='cpp' value='"+x+"' />"  ; 
            cell4.innerHTML = "<select disabled id='X"+x+"'>"+select+"</select>"  ; 
            cell5.innerHTML = "  <button type='button' onclick='addMoreWork(this.parentElement.parentElement)' class='btn btn-default'>add More</button>"  ;  
        
        }
        
       
    } });  
    

 
}

function addlate(){
    
        
       HideLoading(function(){
           
           buttonClick(document.getElementById('agendaButton')) ;
           
       }) 
        
}

function loadChaptersofMaterial(x){

    form_data = "getMat="+x.value ; 
    
$.ajax({
    url: "script/php/createWork.php",
    type: 'POST',
    data: form_data,
    dataType:"json",
    success: function(data) {
        
                    
        parent = document.getElementById("chapters") ; 
        
        parent.innerHTML = "" ; 
        
        for(x = 0 ; x < data[0].length ; x++){

        //<label><input type="radio" name="workdone" value="A" /> All the work is done</label>
        label =  document.createElement("label") ; 
        
        label.className = "checkbox-inline" ; 
            
        parent.appendChild(label) ;   
        
        inp = document.createElement("input") ; 
            
            
        label.appendChild(inp) ;   
          
            
        inp.type = "checkbox" ; 
        
        inp.name = "X"+x ; 
            
        inp.value= data[0][x] ;     
        
        para = document.createElement("p") ;
            
        label.appendChild(para) ;       
            
        para.innerText = data[1][x] ;     

            
        }
   }
    
})

}

function checkButton(x){

      value = x.value ; 
    
if(!x.checked){
    document.getElementById("X"+value).disabled = true ; 
    document.getElementById("X"+value).children[0].selected = true ; 
}
else
    document.getElementById("X"+value).disabled = false ; 



}

function addMoreWork(to){
    
    
     table = document.getElementById("SelectWorkDateTable") ;     
    
     var newElement = document.createElement('tr');

     newElement = table.insertBefore(newElement, to.nextSibling);
    
        var cell1 = newElement.insertCell(0);
        var cell2 = newElement.insertCell(1); 
        var cell3 = newElement.insertCell(2);
        var cell4 = newElement.insertCell(3);    
        var cell5 = newElement.insertCell(4);
            
             
            cell1.innerHTML = to.children[0].innerText ; 
            cell2.innerHTML = to.children[1].innerText ; 
            cell3.innerHTML = to.children[2].innerHTML ; 
            cell4.innerHTML = to.children[3].innerHTML ; 
            cell5.innerHTML = to.children[4].innerHTML ; 
    

    
}

function changeWorkDate(x){
    
      var d = new Date(x) ; 
      year = d.getYear()-100 ;
      month = d.getMonth()+1 ; 
      date = "d="+d.getDate()+"&m="+month+"&y="+year ;                         
                        
      $.post("script/php/Agenda.php" , date , function(response , state , xc){ 
      $(".Agenda-div").html(response) ; 
                      
      HideLoading( function(){ $(".Agenda-div").fadeIn(800) ; }) ;}) ;
    
    
    
    
    
}
createNoteOf  = 0 ;

function boxSelected(x){
    createNoteOf  = x ; 
    var connecall = $("#optionConnection")[0] ; 
    var material  = $("#optionWorkMaterial")[0] ; 
    
    if(x == 1){
        $(material).fadeOut(600) ; 
        setInterval(600) ; 
        $(connecall).fadeIn(600) ; 
        
    }
    else if(x == 2){
        $(connecall).fadeOut(600) ; 
        setInterval(600) ; 
        $(material).fadeIn(600) ; 
        
    }
    
    
}
function createNote(){    
    
    if(createNoteOf ==0){
        
        alert("Select a note to create!") ; 
        
        return ;
        
    }
    
     $("#myModal").modal("toggle") ; 
     ShowLoading() ; 
      
    if(createNoteOf == 1){
        
        var name = $("#strDN")[0]; 
        var ip   = $("#strVL")[0];
        
        if(name.value == "" || ip.value == ""){
            
            alert("no value given!") ; 
        }
        
        $.post("script/php/createNote.php" , "create=1&"+"name="+name.value+"&ip="+ip , function(returnData){
             HideLoading( function(){buttonClick(document.getElementById('notesButton')) }) ; 
             successAlert("Note "+returnData+" added!" , true) ; 
                               
        }) ; 
        
        
    }  
    
    if(createNoteOf == 2){
        
        var mat = $("#materialSelect")[0]; 
        var vlue  = $("#MCS")[0];
        
        if(mat.value == "" || vlue.value == ""){
            
            alert("no value given!") ; 
        }
        
        $.post("script/php/createNote.php" , "create=2&"+"name="+mat.value+"&value="+vlue.value , function(returnData){
             HideLoading( function(){ buttonClick(document.getElementById('notesButton')) }) ; 
             successAlert("Note "+returnData+" added!" , true) ; 
        }) ; 
        
        
    }
    
    
}







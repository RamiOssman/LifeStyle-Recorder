function submitNote(finishFunction) 
{   
    var Type = document.getElementById("noteType").value ; 
    var Str = document.getElementById("noteString").value ;     
    var Vlue = document.getElementById("noteValue").value ;     
    
    
    $.post("script/php/notes.php" , "type="+Type+"&str="+Str+"&vlue="+Vlue , finishFunction) ; 
}
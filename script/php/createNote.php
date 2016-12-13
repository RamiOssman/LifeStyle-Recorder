<?php
require_once('import.php') ; 
if(!isset($_POST['create']))
exit() ; 

$create = $_POST['create'];

$notes = new NoteRef ;

if($create == 1){
    
  $name = $_POST['name'] ; 
  $ip   = $_POST['ip'] ; 
    
    echo $notes->createNote("CONNECTION_TYPE_ALLOWED" , $name , $ip) ;
    
}
if($create == 2){
    
  $name = $_POST['name'] ; 
  $value   = $_POST['value'] ; 
    
    
    
    echo $notes->createNote("MATERIAL_".$name , clean($value) , $value) ;
    
}

function clean($string) {
    

   $string =  strtoupper(preg_replace('/[^A-Za-z0-9\-]/', '', $string)); // Removes special chars.
   return str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
}


?>
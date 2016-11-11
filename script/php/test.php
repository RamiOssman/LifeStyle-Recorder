<?php

    require_once('AgendaRef.php') ; 
    require_once('NRef.php') ; 

    $agenda= new Agenda ; 

    $rep = array() ; 

$rep['day']   =  10 ; 
$rep['month'] = 11 ; 
$rep['year']  = 16 ;

$rep['TitleRefNotesId'] = 12 ; 
$rep['TypeRefNotesId']  = 15 ; 
$rep['Difficulity']     =  6 ;
$rep['Description']     =  "DM n*3 tous le texte et les exercice qui suit" ; 

$rep['CreatedByNoteRefId'] = 16 ; 


 //   echo $agenda->Create($rep) ; 
$noteRef = new NoteRef ; 

$agendaWork = $agenda->toDo(array(10 , 11 , 16))[0] ; 

$STR = $noteRef->getStringFromNoteId($agendaWork["TitleRefNotesId"]) ; 
    
    print_r($noteRef->getValuesFromString($STR)); 



?>
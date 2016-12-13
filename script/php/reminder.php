<?php
date_default_timezone_set('Europe/Paris');
require_once('httpdocs/connection/privateconnect.php') ; 
require_once('httpdocs/script/php/AgendaRef.php') ; 
require_once('httpdocs/script/php/NRef.php') ; 
require_once('httpdocs/script/php/HSS.php') ;

$agenda = new Agenda ; 
$noteRef = new NoteRef ; 

  $to      = 'rossmane17@gmail.com';

    
    $dateJs = new DateTime() ;  
    $date = array($dateJs->format('d') , $dateJs->format('m') , $dateJs->format('y')) ;
    
    $mailBody = "" ; 
    
    
    $mailBody.= "<center><h2 style='font-family: sans-serif;'>Good morning Rami !</br> 
Today is: ".date('l jS \of F Y h:i A')."</h2></center></br></br></br>" ; 

    $list = $agenda->toDo($date) ;  
    $workAt = 0 ; 
    
    foreach($list as $element){
        if($workAt == 0 )
           $mailBody.="<h3>What you should do today: </h3><ul>" ; 
        
          $chapters = $agenda->getChaptersOfWorkId($element['AgendaLogId']) ;
          $cpp = "" ; 
    
          foreach($chapters as $chap){
                $cpp.=$noteRef->getValueFromNoteId($chap) ; 
        
          if($chapters[sizeof($chapters)-1] != $chap)
                    $cpp.=" , " ;  
            
            }
        
        
        
       $title = $noteRef->getValueFromNoteId($element['TitleRefNotesId']) ; 
       $type  = $noteRef->getValueFromNoteId($element['TypeRefNotesId']) ;   
       $desc = $element['Description'] ; 
        
        $mailBody.="<li>
    <strong>Title:</strong> $title</br>
    <strong>Type :</strong> $type</br>
    <strong>Chapter:</strong> $cpp</br>
    <strong>Description:</strong> $desc
    </li></br>" ; 
        
        
     
        $workAt++ ; 
    }
    
    if($workAt == 0)
        $mailBody.="<h2 style='color:green;' >you are FREE!! \nYou don't work today!</h2>" ; 
    else
        $mailBody.="</ul>" ; 
    
    
    
    
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     $headers .= 'From: LSR reminder <reminder@lsr.nhvvs.fr>' . "\r\n";
   
     $subject = 'LSR work of the day';

     mail($to, $subject, $mailBody, $headers);
    
    return "received" ; 
    
    


?>

<?php

    require_once('import.php') ; 
    date_default_timezone_set('Europe/Paris');
  if(!isset($_POST['workTitle']))
      exit() ; 

$workTitle = $_POST['workTitle'] ; 
$workType  = $_POST['workType'] ; 
$limitDay  = $_POST['limitDay'] ;
$difficulity = $_POST['difficulity'] ; 
$description = $_POST['description'] ;  


    $agenda = new Agenda ; 
    $notes = new NoteRef ; 

$date1=date_create(date("Y-m-d"));
$date2=date_create($limitDay);
$diff=date_diff($date1,$date2);

    $importanceIndex = $agenda->importanceCalculator($workType , $workTitle  , $diff->format("%R%a days")) ; 

$dateToFinish = new DateTime("20-11-2017") ; 

$dayTF = $date->format('d') ; 
$monthTF = $date->$date->format('m') ; 
$yearTF = $date->$date->format('y') ; 

$TotalWorkAdded = 0 ; 

if($importanceIndex == 10){
    
    // Very Important must add it for the next day
    //toDo
    if($difficulity > 7){
        
        for($x = 1  ; $x < $diff->format("%R%a days") ; $x++){
            
            $TotalWorkDifficulity = $agenda->ChargeWorkOfTheDay(array(date("d")+$x , date("m") ,date("y") )) ; 
            
            if($TotalWorkDifficulity < 20){
                //ADD A WORK TO THIS DAY TODO 
                $TotalWorkAdded++ ; 
            }
        }
        if($TotalWorkAdded < 3){
            
            for($x = 1  ; $x < $diff->format("%R%a days") ; $x++){
            
            $TotalWorkDifficulity = $agenda->ChargeWorkOfTheDay(array(date("d")+$x , date("m") ,date("y") )) ; 
            
            if($TotalWorkDifficulity < 35){
                //ADD A WORK TO THIS DAY TODO 
                $REPORT = array(
                
                "day" =>$dayTF , 
                "month" =>$monthTF,
                "year" =>   $yearTF,
                "TitleRefNotesId" => $notes->getNoteIdFromNoteString($workTitle),
                "TypeRefNotesId" =>$notes->getNoteIdFromNoteString($workType),
                "Difficulity" =>$difficulity,
                "CreatedByNoteRefId" => "16",
                "Description" =>$description,
                "dayEnd" => date("d")+$x , 
                "monthEnd" =>date("m") , 
                "yearEnd" =>  date("y")   
                
                )
                $TotalWorkAdded++ ; 
            }
        }
            
        }
       
    }
        elseif($difficulity > 5){
        
        for($x = 1  ; $x < $diff->format("%R%a days") ; $x++){
            
            $TotalWorkDifficulity = $agenda->ChargeWorkOfTheDay(array(date("d")+$x , date("m") ,date("y") )) ; 
            
            if($TotalWorkDifficulity < 20){
                //ADD A WORK TO THIS DAY TODO 
                $TotalWorkAdded++ ; 
            }
        }
        if($TotalWorkAdded < 2){
            
            for($x = 1  ; $x < $diff->format("%R%a days") ; $x++){    
                
            $TotalWorkDifficulity = $agenda->ChargeWorkOfTheDay(array(date("d")+$x , date("m") ,date("y") )) ; 
            
            if($TotalWorkDifficulity < 28){
                //ADD A WORK TO THIS DAY TODO 
                $TotalWorkAdded++ ; 
            }
        }
            
        }
       
    }
    else{
        
             for($x = 1  ; $x < $diff->format("%R%a days") ; $x++){
            
            $TotalWorkDifficulity = $agenda->ChargeWorkOfTheDay(array(date("d")+$x , date("m") ,date("y") )) ; 
            
            if($TotalWorkDifficulity < 20){
                //ADD A WORK TO THIS DAY TODO 
                $TotalWorkAdded++ ; 
            }
        }
        
        
        
        
        
        
    }
    
    
    
    
    
}
 


?>
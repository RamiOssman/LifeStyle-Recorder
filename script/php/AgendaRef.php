 <?php
 date_default_timezone_set('Europe/Paris');

class Agenda{
    
    function toDo($date){ //[0] =>day, [1] => month, [2] => year
        
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
        
//$date = array(date("d") , date("m") , date("y")) ; 

$dateRequest = new timeRef ; 

$timeRef =  $dateRequest->getTimeRefId($date[0] , $date[1] , $date[2]) ; 
        
$query = "SELECT * FROM `AgendaLog` WHERE `TRefId` = $timeRef AND `Status` = 'Not Completed'" ; 

$result = $conn->query($query) ;
if($result===false)
    return array() ; 
        
        $returnArray = array() ; 
        

        while($row = $result->fetch_assoc())
            $returnArray[sizeof($returnArray)] = $row ;
        
        return $returnArray ; 
        
    }
    
    function ChargeWorkOfTheDay($date){ //[0] =>day, [1] => month, [2] => year
        
        $Work = $this->toDo($date) ;
            
        $ChargeIndex = 0 ; 
        
        foreach($Work as $tWork)
            $ChargeIndex+=$tWork['Difficulity'] ;  
   
          return $ChargeIndex ; 
    }
    
        function toDoById($id){ //[0] =>day, [1] => month, [2] => year
        
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
    

$query = "SELECT * FROM `AgendaLog` WHERE `AgendaLogId` = $id" ; 

$result = $conn->query($query) ;
if($result===false)
    return null ; 

        
$row = $result->fetch_assoc() ; 
       return $row ; 
        
    }
    
    function addChaptersByStringName($chaptersArray , $WorkRefId){
        
         $conx =   new callSql ; 
         $notes = new NoteRef ;
         $conn = $conx->startConnection("") ;      
        
        foreach($chaptersArray as $chapter){
            
            $NoteId = $notes->getNoteIdFromNoteString($chapter) ;
            
            $query = "INSERT INTO `Chapters` (`WorkRefId` , `ChapRefId`) VALUES ('$WorkRefId' , '$NoteId')" ; 
        
            $conn->query($query) ;
            
            
        }
        
    }
    
    function getChaptersOfWorkId($workId){
        
         $conx =   new callSql ; 
         $notes = new NoteRef ;
         $conn = $conx->startConnection("") ;  
        
         $result = array() ; 
        
         $query = "SELECT * FROM `Chapters` WHERE `WorkRefId` = '$workId'" ; 
        
         $resultA = $conn->query($query) ; 
         
         while($row = $resultA->fetch_assoc()){
             
             
         $result[sizeof($result)] = $row['ChapRefId'] ; 
         }
        
        
         return $result;
          
        
    }
    
    function Create($REPORT){
        
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ;        
        
        $dateCreate = new timeRef ; 
        $dateRefId = $dateCreate->setDate($REPORT["day"] , $REPORT["month"], $REPORT["year"]) ; 
        $endDateRefId = $dateCreate->setDate($REPORT["dayEnd"] , $REPORT["monthEnd"], $REPORT["yearEnd"]) ; 
        
        $TitleRefNotesId = $REPORT['TitleRefNotesId'] ; 
        $TypeRefNotesId  = $REPORT['TypeRefNotesId']  ; 
        $Difficulity     = $REPORT['Difficulity']     ;
        $Description     = $REPORT['Description']     ;
        
        $CreatedByNoteRefId=$REPORT['CreatedByNoteRefId'] ; 
        
        $query = "INSERT INTO `AgendaLog` (`TRefId` , `LimiteDayRefId` , `TitleRefNotesId` , `TypeRefNotesId` , `Difficulity` , `Description` , `CreatedByNoteRefId`) VALUES ('$dateRefId' , ' $endDateRefId' , '$TitleRefNotesId' , '$TypeRefNotesId' , '$Difficulity' , '$Description' , '$CreatedByNoteRefId') " ; 
        
        $conn->query($query) ;
        
        $idRef = $conn->insert_id  ; 
        
        $addChapters = $this->addChaptersByStringName($REPORT['ChapRef'] , $idRef) ; 
        
        return $idRef; 
        
        
        
        
    }
    function WorkSubmitFinished($WorkId){
        
                
        
            $work = $this->toDoById($WorkId) ;  
            if($work == null) return "404 Work" ; 
            if($work['Status'] == "Completed") return "Work already submitted" ; 
        
        
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ;     
        
         $query = "UPDATE `AgendaLog` SET `Status`='Completed' WHERE `AgendaLogId` = '$WorkId'" ; 
         $result = $conn->query($query) ; 
         if($result===false)return "ERROR" ; 
         return "1022" ; 
        
        
        
    }
    function WorkSubmitParcielFinished($workId){
        
         $work = $this->toDoById($workId) ; 
         if($work == null) return "404 Work" ; 
        
        $dateRequest = new timeRef ; 
        
        //importance verification
        $workLimit = $dateRequest->getDate($work['LimiteDayRefId']) ;
        $workTrRef = $dateRequest->getDate($work['TRefId']) ; 
        
        $isExpired = false ; 
        
              $dateTr = new DateTime("20".$workLimit[2]."-".$workLimit[1]."-".$workLimit[0]) ; 
              $dateLm = new DateTime("20".$workTrRef[2]."-".$workTrRef[1]."-".$workTrRef[0]) ; 
              $interval = date_diff($dateLm,$dateTr) ; 
              $intr = $interval->format('%R%a days');
              if($intr < 0)
                  return "1023" ; 
              if($intr < 2)
                  return "1024" ; 
        
               //WORK IS NOT IMPORTANT; 
               $difficulity = $work['Difficulity']; 
               if($difficulity < 5)
                   return "1024" ; 
                    
                 //Check CreatedBy   
                 $NoteR = new NoteRef ; 
                    $doneBy = $NoteR->getStringFromNoteId($work['CreatedByNoteRefId']) ; 
        
                if($doneBy == "SYSTEM_RECOVERY_WORK")
                    return "1024" ; 
                

           $date = new DateTime('2000-01-01');
           $date->add(new DateInterval('P1D'));
    
           $this->changeWorkDate($_POST['For'] , array($date('d') , $date('m') , $date('y'))) ; 
              
             return "1025" ; 
                
        
        
        
        
    }
    function changeWorkDate($workId , $date){
        
            $dateRequest = new timeRef ; 

            $timeRef =  $dateRequest->getTimeRefId($date[0] , $date[1] , $date[2]) ;        
        
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ;     
        
         $query = "UPDATE `AgendaLog` SET `TRefId`=$timeRef WHERE `AgendaLogId` = $workId" ; 
         return $conn->query($query) ; 
        
        
    }
    function importanceCalculator($workType , $workTitle , $limitDay){
        
        /*
        Exemple: 
        
        workTitle:SCIENCES_PHYSIQUE_CHIMIE
        workType:REVISION_DST
        limitDay:4

        */
        
        $importanceIndex = 0  ;
        
        $notes = new NoteRef ;
        
        ////////CONDITION A
        
        /////   PRIORITY A
        $typesPA = $notes->getStringsFromType("WORK_TYPE_PRIORITY_A") ; 
        foreach($typesPA as $typeA)
        if(trim($notes->getValueFromString($typeA)) == trim($notes->getValueFromString($workType)))
            $importanceIndex+=3 ; 
      
        /////   PRIORITY B
        $typesPA = $notes->getStringsFromType("WORK_TYPE_PRIORITY_B") ; 
        foreach($typesPA as $typeA)
        if(trim($notes->getValueFromString($typeA)) == trim($notes->getValueFromString($workType)))
            $importanceIndex+=2 ; 
        
        /////   PRIORITY C
        $typesPA = $notes->getStringsFromType("WORK_TYPE_PRIORITY_C") ; 
        foreach($typesPA as $typeA)
        if(trim($notes->getValueFromString($typeA)) == trim($notes->getValueFromString($workType)))
            $importanceIndex+=1 ; 
      
            
        ////////CONDITION B
        
        /////   PRIORITY A
        $typesPA = $notes->getStringsFromType("WORK_MATERIAL_PRIORITY_A") ; 
        foreach($typesPA as $typeA)
         if(trim($notes->getValueFromString($typeA)) == trim($notes->getValueFromString($workTitle)))
            $importanceIndex+=3 ; 
      
        /////   PRIORITY B
        $typesPA = $notes->getStringsFromType("WORK_MATERIAL_PRIORITY_B") ; 
        foreach($typesPA as $typeA)
         if(trim($notes->getValueFromString($typeA)) == trim($notes->getValueFromString($workTitle)))
            $importanceIndex+=2 ; 
        
        /////   PRIORITY C
        $typesPA = $notes->getStringsFromType("WORK_MATERIAL_PRIORITY_C") ; 
        foreach($typesPA as $typeA)
         if(trim($notes->getValueFromString($typeA)) == trim($notes->getValueFromString($workTitle)))
            $importanceIndex+=1 ;         
        
        ////////CONDITION C
        
        if($limitDay < 3)
            $importanceIndex+=4 ; 
        elseif($limitDay < 5)
            $importanceIndex+=4 ; 
        elseif($limitDay < 8)
            $importanceIndex+=4 ;  
        
        $TypeR =  $notes->getValueFromString($workType) ; 
         $typesPA = $notes->getStringsFromType("WORK_TYPE_PRIORITY_A") ; 
        foreach($typesPA as $typeA)
        {
            $TEST = $notes->getValueFromString($typeA) ; 
            if($TEST == $TypeR)
             echo "TEST"."\n" ; 
        }

        
        return $importanceIndex ; 
        
        
    }


       
    
}

?>
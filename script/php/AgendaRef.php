 <?php
 require_once('../../connection/privateconnect.php') ; 
 require_once('NRef.php') ;
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
        
        return $conn->insert_id ; 
        
        
        
        
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

       
    
}

?>
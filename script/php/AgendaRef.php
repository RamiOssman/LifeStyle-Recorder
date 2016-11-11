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

$query = "SELECT * FROM `AgendaLog` WHERE `TRefId` = $timeRef" ; 

$result = $conn->query($query) ;
if($result===false)
    return array() ; 
        
$returnArray = array() ; 
        

while($row = $result->fetch_assoc())
       $returnArray[sizeof($returnArray)] = $row ;
       return $returnArray ; 
        
    }
    
    function Create($REPORT)
    {
        
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ;        
        
        $dateCreate = new timeRef ; 
        $dateRefId = $dateCreate->setDate($REPORT["day"] , $REPORT["month"], $REPORT["year"]) ; 
        
        $TitleRefNotesId = $REPORT['TitleRefNotesId'] ; 
        $TypeRefNotesId  = $REPORT['TypeRefNotesId']  ; 
        $Difficulity     = $REPORT['Difficulity']     ;
        $Description     = $REPORT['Description']     ;
        
        $CreatedByNoteRefId=$REPORT['CreatedByNoteRefId'] ; 
        
        $query = "INSERT INTO `AgendaLog` (`TRefId` , `TitleRefNotesId` , `TypeRefNotesId` , `Difficulity` , `Description` , `CreatedByNoteRefId`) VALUES ('$dateRefId' , '$TitleRefNotesId' , '$TypeRefNotesId' , '$Difficulity' , '$Description' , '$CreatedByNoteRefId') " ; 
        
        $conn->query($query) ;
        
        return $conn->insert_id ; 
        
        
        
        
    }
       
    
}

?>
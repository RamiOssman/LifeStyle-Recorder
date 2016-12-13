<?php


class NoteRef
{

    function getValueFromString($STR_REF)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
        
        $res   = array() ;
 
        $query = "SELECT * FROM `Notes` WHERE `NoteString` = '$STR_REF'" ; 

        $result = $conn->query($query) ; 

        $row = $result->fetch_assoc() ; 

        return $row['NoteValue'] ; 
      
        
        
    }
        function getStringsFromTypeId($STR_REF)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
        
        $res   = array() ;
 
        $query = "SELECT * FROM `Notes` WHERE `NoteTypeId` = '$STR_REF'" ; 

        $result = $conn->query($query) ; 
        
        $at = 0 ;
             
        while($row = $result->fetch_assoc()){
            
            $res[$at] = $row['NoteString'] ; 
            $at++ ; 
        }
        
        return $res ; 
        
        
    }
    
    function getStringFromNoteId($STR_REF)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
        

 
        $query = "SELECT * FROM `Notes` WHERE `NoteId` = '$STR_REF'" ; 

        $result = $conn->query($query) ; 
                
        $row = $result->fetch_assoc() ; 
         
        return $row['NoteString'] ; 
        

        
    }
                
    function getValueFromNoteId($STR_REF)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
        

 
        $query = "SELECT * FROM `Notes` WHERE `NoteId` = '$STR_REF'" ; 

        $result = $conn->query($query) ; 
                    
        $row = $result->fetch_assoc() ; 
         
        return $row['NoteValue'] ; 
        

        
    }
        function getNoteTypeIdFromNoteType($STR_REF)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
        

 
        $query = "SELECT * FROM `NoteType` WHERE `NoteTypeString` = '$STR_REF'" ; 

        $result = $conn->query($query) ; 
                    
        $row = $result->fetch_assoc() ; 
         
        return $row['NoteTypeId'] ; 
        

        
    }
            function getNoteIdFromNoteString($STR_REF)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
        

 
        $query = "SELECT * FROM `Notes` WHERE `NoteString` = '$STR_REF'" ; 

        $result = $conn->query($query) ; 
                    
        $row = $result->fetch_assoc() ; 
         
        return $row['NoteId'] ; 
        

        
    }
            
    
    function getStringsFromType($TYPE_REF)
    {
        
       $conx =   new callSql ; 
       $conn = $conx->startConnection("librarydb") ; 
        
        $res   = array() ;
 
        $query = "SELECT * FROM `NoteType` WHERE `NoteTypeString` = '$TYPE_REF'" ; 

        $result = $conn->query($query) ;
        
        $row = $result->fetch_assoc() ; 
        
        $TYPEID = $row['NoteTypeId'] ; 
        
          $query = "SELECT * FROM `Notes` WHERE `NoteTypeId` = '$TYPEID'" ; 

        $result = $conn->query($query) ;
        
        $at = 0 ;
             
        while($row = $result->fetch_assoc() ){
            
            $res[$at] = $row['NoteString'] ; 
            $at++ ; 
        }
        
        return $res ; 
        
    } 
    function createNote($Type , $Str , $Vlue){
        
    $conx =   new callSql ; 
        
    $conn = $conx->startConnection("librarydb") ; 
        
    $query = "SELECT * FROM `NoteType` WHERE `NoteTypeString` = '$Type'";  

    $result = $conn->query($query) ; 
    
    if($result->num_rows == 0 ){
        $query = "INSERT INTO `NoteType` (`NoteTypeString`) VALUES ('$Type')" ; 
        $conn->query($query) ; 
        $IDTYPE = $conn->insert_id ; 

    }
    else{
        
        $row = $result->fetch_assoc() ; 
        $IDTYPE = $row['NoteTypeId']  ;
    }
    
    $query = "INSERT INTO `Notes` (`NoteTypeId`,`NoteString` , `NoteValue`) VALUES('$IDTYPE' , '$Str' , '$Vlue')" ; 
    
    $result = $conn->query($query) ; 
        
        
    return $conn->insert_id ;

    
}
    
    

}
 class timeRef
{

 

 

    
    function getTimeRefId($D , $M , $Y)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
    
 
        $query = "SELECT * FROM `TimeReferencal` WHERE `TRYEAR` = '$Y' AND `TRMONTH` = '$M' AND `TRDAY` = '$D'" ; 

        $result = $conn->query($query) ; 
        
        if($result===false)
            return 1 ; 
        
        $row = $result->fetch_assoc() ; 
        
        return $row['TRID'] ;
        
        
    }
     
    function getDate($refId)
    {
        
        
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
        
    
 
        $query = "SELECT * FROM `TimeReferencal` WHERE `TRID` = '$refId' " ; 

        $result = $conn->query($query) ; 
        
        $row = $result->fetch_assoc() ; 
        
        return array($row['TRDAY'] , $row['TRMONTH'] , $row['TRYEAR']) ;
        
        
        
    }
     
     function setDate($D , $M , $Y) {
         
            $conx =   new callSql ; 
            $conn = $conx->startConnection("") ; 
         
         
         $query = "SELECT * FROM `TimeReferencal` WHERE `TRDAY` = '$D' AND `TRMONTH` = '$M' AND `TRYEAR` = '$Y' " ;
         
         $result = $conn->query($query) ; 
         
         while($row=$result->fetch_assoc())
             return $row['TRID'] ; 
         
         $query = "INSERT INTO `TimeReferencal` (`TRDAY` , `TRMONTH` , `TRYEAR`) VALUES ('$D' , '$M' , '$Y')" ; 
         
            $result = $conn->query($query) ;
         
            return $conn->insert_id ;  
         
         
     }
 }
        

?>
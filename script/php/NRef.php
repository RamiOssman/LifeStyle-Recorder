<?php

 require_once('../../connection/privateconnect.php') ; 

class NoteRef
{

 

 

    
    function getValuesFromString($STR_REF)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("librarydb") ; 
        
        
        $res   = array() ;
 
        $query = "SELECT * FROM `Notes` WHERE `NoteString` = '$STR_REF'" ; 

        $result = $conn->query($query) ; 
        
        $at = 0 ;
             
        while($row = $result->fetch_assoc()){
            
            $res[$at] = $row['NoteValue'] ; 
            $at++ ; 
        }
        
        return $res ; 
        
        
    }
        function getStringsFromTypeId($STR_REF)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("librarydb") ; 
        
        
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


    
    
    
    
}
 class timeRef
{

 

 

    
    function getTimeRefId($D , $M , $Y)
    {
        
           
            $conx =   new callSql ; 
            $conn = $conx->startConnection("librarydb") ; 
        
    
 
        $query = "SELECT * FROM `TimeReferencal` WHERE `TRYEAR` = '$Y' AND `TRMONTH` = '$M' AND `TRDAY` = '$D'" ; 

        $result = $conn->query($query) ; 
        
        $row = $result->fetch_assoc() ; 
        
        return $row['TRID'] ;
        
        
    }
 }
        

?>
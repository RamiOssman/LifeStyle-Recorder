<?php

class connectAt
{
public $connectId = Array
(

"type" => "PCTS"
,
"speed" => "100#"
,
"read" =>"####"

);
public $connectDetail = Array
(
"userServerName" => "localhost"
,
"userAgentName" => "root"
,
"PpassId" => ""
,
"DBName" => "LSR"
,
"ServerDetail" => "Apache 8.1"
,
"ServerMySqliType" =>"databases/users/connectionprivate/#A privateCC"

);
public $s = "a" ; 

    
}

class callSql extends connectAt
{
    
 

    
    function startConnection($DBname)
    {
        
       

// Create connection
$conn = new mysqli($this->connectDetail['userServerName'] , $this->connectDetail['userAgentName'] ,$this->connectDetail['PpassId'] ,"LSR" );

// Check connection
if ($conn->connect_error) {
    
 return $this->OnConnectionError($conn) ; 
  
  
} 
else
{
	$q1 = "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'" ; 
$conn->query($q1) ; 
    
    return $conn ;
    
}

        
        
    }
    
    function AbortConnection($connName)
    {
        
        $connName->close();
        
    }
    
    function OnConnectionError($errorLog)
    {
        
        
        
    }
    function databaseError($DBName)
    {
        
        
        
    }
    
    
    
    
    
}
 

?>
<?php

require_once('../../connection/privateconnect.php') ; 
require_once('NRef.php') ; 

date_default_timezone_set('Europe/Paris');

$conx = new callSql ; 

$conn = $conx->startConnection("librarydb") ; 

$date = array(date("d") , date("m") , date("y")) ; 

$dateRequest = new timeRef ; 


$timeRef =  $dateRequest->getTimeRefId($date[0] , $date[1] , $date[2]) ; 

$query = "SELECT * FROM `AgendaLog` WHERE `TRefId` = $timeRef" ; 

$result = $conn->query($query) ;

while($row = $result->fetch_assoc())
{
    
    ?>
<div class="container">
  <table class="table">
    <thead>
      <tr>
        <th style="font-family: 'Quicksand', sans-serif;">Agenda Nb</th>
        <th style="font-family: 'Quicksand', sans-serif;">Type</th>
        <th style="font-family: 'Quicksand', sans-serif;">Matière</th>
        <th style="font-family: 'Quicksand', sans-serif;">Description</th>
      </tr>
    </thead>
    <tbody>

<?php
    
    
    
}



?>
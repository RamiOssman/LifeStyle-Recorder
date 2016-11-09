<?php

require_once('../../connection/privateconnect.php') ; 
$conx = new callSql ; 

$conn = $conx->startConnection("librarydb") ; 


if(isset($_POST['remove'])){
    
    $removeId = $_POST['remove'] ; 
    $query = "DELETE FROM `Notes` WHERE `NoteId` = $removeId" ; 
    $result = $conn->query($query) ; 
    if($result===false)
        echo "error" ; 
    
    exit() ; 
}



if(isset($_POST['type'])){
    
    $Type = $_POST['type'] ;
    $Str  = $_POST['str'] ;
    $Vlue = $_POST['vlue'] ; 
    
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
    if($result===false)
        echo "error" ; 
    exit() ; 
}

$query = "SELECT * FROM `NoteType` ";  

$result = $conn->query($query) ; 
?>
<div class="container">
  <table class="table">
    <thead>
      <tr>
        <th style="font-family: 'Quicksand', sans-serif;">Note Type</th>
        <th style="font-family: 'Quicksand', sans-serif;">Note String</th>
        <th style="font-family: 'Quicksand', sans-serif;">Note Value</th>
        <th style="font-family: 'Quicksand', sans-serif;">Action</th>
      </tr>
    </thead>
    <tbody>
        <?php
        while($row = $result->fetch_assoc())
{
   $NoteType  = $row['NoteTypeString'] ; 
   $query = "SELECT * FROM `Notes` WHERE `NoteTypeId` = ".$row['NoteTypeId'] ;
   $result_new = $conn->query($query) ; 
   while($row_new = $result_new->fetch_assoc())
   {
       
    
    ?>
              <tr class="success">
        <td style="background-color:#6f5499; color:white; font-family: 'Quicksand', sans-serif;"> <?php  echo $NoteType ;  ?></td>
        <td style="background-color:#6f5499; color:white; font-family: 'Quicksand', sans-serif;">  <?php echo $row_new['NoteString'] ;  ?></td>
        <td style="background-color:#6f5499 ; color:white; font-family: 'Quicksand', sans-serif;"> <?php echo $row_new['NoteValue'] ;  ?></td>
        <td style="background-color:#6f5499 ; color:white; font-family: 'Quicksand', sans-serif;"> <button type="button" class="btn btn-danger" style="font-family: 'Quicksand', sans-serif;" onclick="deleteNote(<?php echo  $row_new['NoteId']; ?>, function(){buttonClick(document.getElementById('notesButton'))})">Delete Field</button> </td>          
      </tr>
        
        <?php 
    
    }
    
    }
    
    ?>
        
      <tr class="success">
        <td style="background-color:#6f5499">  <input class="form-control" id="noteType" type="text" name="NOTETYPE"></td>
        <td style="background-color:#6f5499">  <input class="form-control" id="noteString" type="text" name="NOTESTRING"></td>
        <td style="background-color:#6f5499">  <input class="form-control" id="noteValue" type="text" name="NOTEVALUE"></td>
         <td style="background-color:#6f5499">    <button type="button" class="btn btn-success" style="font-family: 'Quicksand', sans-serif;" onclick="submitNote(function(a , b, c){buttonClick(document.getElementById('notesButton'))})">Submit</button></td>
      </tr>
          <tr class="success">
        <td style="background-color:#6f5499">    
<button type="button" class="btn btn-primary" onclick="buttonClick(this)">Go Back</button>
            </td>
      
      </tr>
    
    
    </tbody>
  </table>
</div>

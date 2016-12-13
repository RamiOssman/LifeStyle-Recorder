<?php


require_once('import.php') ; 
$conx = new callSql ; 
$notes = new NoteRef ;
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
    
 
    $newNoteId = $notes->createNote($Type , $Str , $Vlue) ; 
    
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
        <td style="background-color:#6f5499">   <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal">Add Note</button></td>
       <td style="background-color:#6f5499">    
<button type="button" class="btn btn-primary" onclick="buttonClick(this)">Go Back</button>
            </td>
      
      </tr>
    
    
    </tbody>
  </table>
</div>
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create new Note</h4>
        </div>
        <div class="modal-body">
            <div id="addType">
          <p>Select the option to add:</p>
            <div class="radio">
  <label><input type="radio" onclick="boxSelected(1)" name="optradio">Connection allowed</label>
</div>
<div class="radio">
  <label><input type="radio" onclick="boxSelected(2)"  name="optradio" >Material Chapter</label>
</div>
                </div>
            <div style="display:none" id="optionConnection">
            
            <label for="strDN">Administrator device name and type:</label>
                <input type="text" class="form-control" id="strDN" /> 
            <label for="strVL">Connection Ip:</label>
                <input type="text" class="form-control" id="strDN" /> 
                
            </div>
            
            <div style="display:none" id="optionWorkMaterial">
                
            <label for="strDN">Chapter For: </label>
                <select id="materialSelect">
                <?php
                  
                    $materials = $notes->getStringsFromTypeId(5) ; 
                    
                    foreach($materials as $mat){
                        
                        $vlue = $notes->getvalueFromString($mat) ;
                        
                        echo "<option value='$mat'>$vlue</option>" ; 
                        
                    }
                    
                    ?>
                
                </select></br>
            <label for="MCV">Material Chapter Value:</label>
                <input type="text" class="form-control" id="MCS" /> 

                
                
            </div>
            
        </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-success" style="font-family: 'Quicksand', sans-serif;" onclick="createNote()">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
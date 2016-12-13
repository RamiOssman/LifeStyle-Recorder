<?php

date_default_timezone_set('Europe/Paris');

require_once('import.php'); 

$agenda = new Agenda ; 
$noteRef = new NoteRef ; 
$dateJs = new DateTime($_POST['y']."-".$_POST['m'] ."-". $_POST['d']) ;
$date = array($dateJs->format('d') , $dateJs->format('m') , $dateJs->format('y')) ;
$list = $agenda->toDo($date) ;  
$workTypes  = $noteRef->getStringsFromTypeId("8") ; 
$workTitles = $noteRef->getStringsFromTypeId("5") ; 
    ?>
<div class="container">
  <table class="table">
    <thead>
      <tr>
        <th style="font-family: 'Quicksand', sans-serif;">Title</th>
        <th style="font-family: 'Quicksand', sans-serif;">Type</th>
        <th style="font-family: 'Quicksand', sans-serif;">Chapter</th>
        <th style="font-family: 'Quicksand', sans-serif;">Description</th>
        <th style="font-family: 'Quicksand', sans-serif;">Action</th>
      </tr>
    </thead>
    <tbody>

<?php
    
foreach($list as $element)
{

  $chapters = $agenda->getChaptersOfWorkId($element['AgendaLogId']) ;
    $cpp = "" ; 
    
    foreach($chapters as $chap){
        $cpp.=$noteRef->getValueFromNoteId($chap) ; 
        
        if($chapters[sizeof($chapters)-1] != $chap)
            $cpp.=" , " ;  
            
            }
    

?>
      <tr class="success">
        <td style="background-color:#6f5499; color:white; font-family: 'Quicksand', sans-serif;"> <?php  echo $noteRef->getValueFromNoteId($element['TitleRefNotesId']) ;  ?></td>
        <td style="background-color:#6f5499; color:white; font-family: 'Quicksand', sans-serif;"><?php  echo $noteRef->getValueFromNoteId($element['TypeRefNotesId']) ;  ?></td>
        <td style="background-color:#6f5499; color:white; font-family: 'Quicksand', sans-serif;"><?php  echo  $cpp;   ?></td>          
        <td style="background-color:#6f5499 ; color:white; font-family: 'Quicksand', sans-serif;"> <?php  echo $element['Description'];  ?></td>
        <td style="background-color:#6f5499 ; color:white; font-family: 'Quicksand', sans-serif;"> <button type="button" class="btn btn-danger" style="font-family: 'Quicksand', sans-serif;"  onclick="submitWorkId = <?php echo $element['AgendaLogId']; ?>" data-toggle="modal" data-target="#submitModul">End work</button> </td>          
      </tr>
        
        <?php 
        
}
        ?>
         <tr class="success">
                   <td style="background-color:#6f5499">    
<button type="button" class="btn btn-success" onclick="$('#newAgenda').modal('toggle')">Add manual Agenda Work</button>
            </td>
        <td style="background-color:#6f5499">    
<button type="button" class="btn btn-primary" onclick="buttonClick(this)">Go Back</button>
            </td>

             <td style="background-color:#6f5499">    </td>
             <td style="background-color:#6f5499">    </td>
      </tr>
      </tbody></table></div>

<center>
  <div class="container">
        <h5>Change Work Date:</h5>
     <input style="width:180px;" value="<?php echo $dateJs->format("Y")."-".$dateJs->format("m")."-".$dateJs->format("d"); ?>" oninput="changeWorkDate(this.value)" class="form-control" type="date" id="newWorkDate"></input>
    </div>

</center>



   <div class="modal fade" id="submitModul" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Work submit</h4>
        </div>
        <div class="modal-body">
            
            <div class="checkbox" id="WorkSubmitRadioA">
          <p>Have you done the work ?</p>
        <label><input type="radio" name="workdone" value="A" /> All the work is done</label>
        <label><input type="radio" name="workdone" value="B" /> Half of the work is done</label>
        <label><input type="radio" name="workdone" value="C" /> Nothing is done</label>
            </div>
            
            
            <div class="checkbox" style="display:none;"  id="WorkSubmitRadioB">
          <label for="hoursToken">Hours token to finish the work:</label>
                <input type="number" class="form-control" id="hoursToken"></br>
          <label for="impr">Your impression about the work:</label>
          <select class="form-control" id="impr">  
              <option value="hp" >Very happy</option>
              <option value="h" selected>Happy</option>
              <option value="n" >Not happy</option>
              <option value="np" >Not happy at all</option>
          </select></br>
           <p>Work improved ?</p>
        <label><input checked type="radio" name="wimp" value="1"> Yes</label>
        <label><input type="radio" name="wimp" value="0"> No</label></br>
          <p>Work organistation ?</p>
        <label><input checked type="radio" name="org" value="1"> Organised</label>
        <label><input type="radio" name="org" value="0"> Not organised</label></br>   

                     
            </div>

           
            
          </div>
            
        <div class="modal-footer">
            <button type="button" onclick="workSubmitForm(document.getElementById('WorkSubmitRadioA'))"   class="btn btn-success" style="font-family: 'Quicksand', sans-serif;">Submit</button>
          <button type="button" id="cancelButtonModul" class="btn btn-default" data-dismiss="modal"  data-toggle="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
        




   <div class="modal fade" id="newAgenda" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="newAgenda">&times;</button>
          <h4 class="modal-title">Add work</h4>
        </div>
        <div class="modal-body">
            
            <div id="WorkSubmitRadioK" style="display='';">
                       <div>
          <p>Work Type: </p>
               <select type="radio" class="form-control" id="workType"> 
                   <option value="" >Select Type</option>
         <?php 
                foreach($workTypes as $workType)
                {
                    $workValue = $noteRef->getValueFromString($workType) ; 
                    ?>
              
               
                    <option <?php echo "value='$workType'>$workValue"?></option>
                    
                    
                 
            <?php
                    
                 }
            ?>
                      </select>
                   </br>
                <p>Work Title:</p>
                
                <select type="radio" class="form-control"  onchange="loadChaptersofMaterial(this);" id="workTitle" > 
                   <option value="" >Select material</option>
         <?php 
                foreach($workTitles as $workType)
                {
                    $workValue = $noteRef->getValueFromString($workType) ; 
                    ?>
              
               
                    <option onclick="loadChaptersofMaterial(this.value)" <?php echo "value='$workType'>$workValue"?></option>
                    
                    
                 
            <?php
                    
                 }
            ?>
                      </select>
            </br>
            
            
          <div class="checkbox" id="chapters">
          
        
            </div>
           
            
            

              </br>
           <p>Work limit day: </p>   

    <input data-format="yyyy-MM-dd" class="form-control" type="date" id="limit"></input>
        
 </br>
           <p>Difficulity: </p>   

    <input class="form-control" type="number" id="diff"></input>

          </br>
           <p>Description: </p>   

    <input class="form-control" type="text" id="desc"></input>

          
            </div>
          </div>



<div id="SelectWorkDate" style="display:none; ">
    
  <table class="table">
    <thead>
      <tr>
        <th style="font-family: 'Quicksand', sans-serif;">Date</th>
        <th style="font-family: 'Quicksand', sans-serif;">Charge</th>
        <th style="font-family: 'Quicksand', sans-serif;">Add Work</th>
        <th style="font-family: 'Quicksand', sans-serif;">Select Chapter</th>
        <th style="font-family: 'Quicksand', sans-serif;">Add more</th>  
      </tr>
 
    </thead>
    <tbody id="SelectWorkDateTable" >
        
        
        
</tbody></table></div>

  <div class="modal-footer">
            <button type="button" onclick="addWork()" class="btn btn-success" style="font-family: 'Quicksand', sans-serif;">Submit</button>
          <button type="button" id="cancelButtonModul" class="btn btn-default" data-dismiss="modal"  data-toggle="modal">Close</button>
        </div>
    
</div>


           
            
          </div>
            
      
      </div>
      
    </div>

        
        
        
        
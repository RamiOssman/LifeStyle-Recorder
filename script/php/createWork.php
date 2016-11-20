       
       <script src="../../script/jquery.js" >
    
    </script>
        <link href="../../style/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../../style/css.css" rel="stylesheet" type="text/css" />
 
    <script src="../../script/bootstrap.js">
    
    </script>
    <script src="../../script/functions.js">
    
    
    </script>  
 <div class="modal fade" id="submitModul" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#submitModul">Open Modal</button>
<?php
exit() ; 
    require_once('AgendaRef.php') ; 
    require_once('NRef.php') ; 

    $agenda= new Agenda ; 

    $rep = array() ; 

$rep['day']   =  10 ; 
$rep['month'] = 11 ; 
$rep['year']  = 16 ;

$rep['TitleRefNotesId'] = 12 ; 
$rep['TypeRefNotesId']  = 15 ; 
$rep['Difficulity']     =  6 ;
$rep['Description']     =  "DM n*3 tous le texte et les exercice qui suit" ; 

$rep['CreatedByNoteRefId'] = 16 ; 


 //   echo $agenda->Create($rep) ; 
$noteRef = new NoteRef ; 

$agendaWork = $agenda->toDo(array(10 , 11 , 16))[0] ; 

$STR = $noteRef->getStringFromNoteId($agendaWork["TitleRefNotesId"]) ; 
    
    print_r($noteRef->getValuesFromString($STR)); 



?>
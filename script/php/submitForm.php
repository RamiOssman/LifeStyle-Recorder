  <?php

    require_once('import.php'); 

    $agenda= new Agenda ; 

if(isset($_POST['hours'])){
    
    $hours = $_POST['hours'] ; 
    $imprs = $_POST['imprs'] ; 
    $imorv = $_POST['improve'] ; 
    $organ = $_POST['org'] ;
    
    
    
}

    if(!isset($_POST['Work']) || !isset($_POST['For']))
        exit() ; 
   
     

$worknewStatus = "No response" ; 


    if($_POST['Work'] == "1")
    $worknewStatus = $agenda->WorkSubmitFinished($_POST['For']) ; 
    if($_POST['Work'] == "2")
    $worknewStatus = $agenda->WorkSubmitParcielFinished($_POST['For']) ; 
    if($_POST['Work'] == "3")
    $worknewStatus = $agenda->WorkSubmitParcielFinished($_POST['For']) ; 

if($worknewStatus == 1022 || $worknewStatus == 1023 || $worknewStatus == 1025){
    
 //   $HSS = new HSS ;
 //   $report = $HSS->submitWork($_POST['For'] , $worknewStatus) ; 
    
}

echo $worknewStatus ; 
exit() ; 
?>
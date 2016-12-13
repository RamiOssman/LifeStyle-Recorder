
<?php

    require_once('import.php') ; 
    date_default_timezone_set('Europe/Paris');



if(isset($_POST['chapter']) && isset($_POST['workOf'])){
    
    
    $chapter = $_POST['chapter'] ; 
    $dateToFinish = new DateTime($_POST['workOf']); 
    $limitDay = new DateTime($_POST['limitDay']) ; 
    $workTitleString = $_POST['workTitle'] ; 
    $workTypeString  = $_POST['workType'] ; 
    $diffi           = $_POST['difficulity'] ;
    $desc            = $_POST['description'] ; 
    
    
    $chapters = explode("||" , $_POST['chapters']) ;
    unset($chapters[sizeof($chapters) - 1]) ; 
    
    if($chapter != "Total")
        $chapters = array($chapter) ; 
 

    
    $notes = new NoteRef ;
    $agenda = new Agenda ;
    
    
        $dateCreate = new timeRef ; 
        echo $dateCreate->setDate(11 ,12, 16) ; 
    
    
                    $REPORT = array( 
                "day" =>$dateToFinish->format('d') , 
                "month" =>$dateToFinish->format('m'),
                "year" =>   $dateToFinish->format('y'),
                "TitleRefNotesId" => $notes->getNoteIdFromNoteString($workTitleString),
                "TypeRefNotesId" =>$notes->getNoteIdFromNoteString($workTypeString),
                "Difficulity" =>$diffi,
                "CreatedByNoteRefId" => "16",
                "Description" =>$desc,
                "dayEnd" => $limitDay->format('d') , 
                "monthEnd" =>$limitDay->format('m') , 
                "yearEnd" =>$limitDay->format('y'),
                "ChapRef" =>$chapters
                    );
    
        $work = $agenda->Create($REPORT) ; 
    
    sleep(0.1) ; 
    exit() ; 
    
    
}

if(isset($_POST['getMat'])){
    
    $mat = $_POST['getMat'] ; 
    
    $notes = new NoteRef ;
    
    $R1 = $notes->getStringsFromType("MATERIAL_".$mat) ; 
    
    $R2 = array() ; 
    
    foreach($R1 as $r1)
        $R2[sizeof($R2)] = $notes->getValueFromString($r1) ; 

    
   print json_encode(array($R1 , $R2)) ; 
    
    
}


  if(!isset($_POST['workTitle']))
      exit() ; 

$workTitle = $_POST['workTitle'] ; 
$workType  = $_POST['workType'] ; 
$limitDay  = $_POST['limitDay'] ;
$difficulity = $_POST['difficulity'] ; 
$description = $_POST['description'] ;  


    $agenda = new Agenda ; 
    $notes = new NoteRef ; 

$chapters = explode("||" , $_POST['chapters']) ;
unset($chapters[sizeof($chapters) - 1]) ; 


$date1=date_create(date("Y-m-d"));
$date2=date_create($limitDay);
$diff=date_diff($date1,$date2);

  //  $importanceIndex = $agenda->importanceCalculator($workType , $workTitle  , $diff->days-1) ; 
$importanceIndex = 10 ; 

$dateToFinish = new DateTime($limitDay) ; 

$dayTF = $dateToFinish->format('d') ; 
$monthTF = $dateToFinish->format('m') ; 
$yearTF = $dateToFinish->format('y') ; 

$TotalWorkAdded = 0 ; 


if($importanceIndex >= 10){

$numOfChapters = sizeof($chapters) ; 



    $title = $notes->getNoteIdFromNoteString($workTitle) ; 
    $type  = $notes->getNoteIdFromNoteString($workType)  ;
    
  print json_encode((addForTheCloserDays($chapters , $title , $type , $limitDay , $difficulity , $description ))) ;     
    
     
}

function addForTheCloserDays($chapters ,$wt , $wy , $ld , $df , $ds){
    
    $atChapter = 0 ; 

    
    $agenda = new Agenda ;
    $notes = new NoteRef ;
    
    $date1=date_create(date("Y-m-d"));
    $date2=date_create($ld);
    $diff=date_diff($date1,$date2); 
    
    $date =  array($date2->format('d') ,$date2->format('m') ,$date2->format('y') ) ; 
        
    $maxWorkHandle  = $notes->getValueFromString("WORK_DIFF_MAX_PER_DAY") ;    
    
    
    $totalReports = array() ; 
    
    for($x = 0 ; $x <= $diff->days-1 ; $x++){
    
       $workDay = date_create(date("Y-m-d"));
       date_add($workDay,date_interval_create_from_date_string("$x days"));
        
       $chargeWorkOfTheDay = $agenda->ChargeWorkOfTheDay(array(date_format($workDay,"d"),date_format($workDay,"m"),date_format($workDay,"y"))) ; 
       
        if($chargeWorkOfTheDay < $maxWorkHandle){

        
                $REPORT = array( 
                "day" => date_format($workDay,"d"), 
                "month" =>date_format($workDay,"M"), 
                "year" =>date_format($workDay,"Y"),
                "Charge" => $chargeWorkOfTheDay,
                "maxWork" =>  $maxWorkHandle
                );
            
            $totalReports[sizeof($totalReports)] = $REPORT ; 
        
        
        }
    
    }
    
    $chaptersValues = array() ; 
    
    for($x = 0 ; $x < sizeof($chapters) ; $x++)
         $chaptersValues[$x] =  $notes->getValueFromString($chapters[$x]) ; 
    
    $totalReports[sizeof($totalReports)] = $chapters ; 
    $totalReports[sizeof($totalReports)] = $chaptersValues ; 
    
    return $totalReports ; 
    
    
    
    
    
    
}





















exit() ; 
if($importanceIndex == 10){
    
    // Very Important must add it for the next day
    //toDo
    if($difficulity > 7){
        
        $diffr = $diff->days-1  ; 
        
        for($x = 1  ; $x <= $diffr ; $x++){
            
            $dateTime = new DateTime(date("Y").'-'.date("m").'-'.date("d"));
            
            $dateTime->add(new DateInterval('P'.$x.'D'));    
                
            $TotalWorkDifficulity = $agenda->ChargeWorkOfTheDay(array( $dateTime->format('d') ,  $dateTime->format('m') ,  $dateTime->format('y'))) ; 
            
            
            echo "Day: $x TWD: ".$TotalWorkDifficulity."\n" ; 
            
            if($TotalWorkDifficulity < 17){
                //ADD A WORK TO THIS DAY TODO 
                $REPORT = array( 
                "day" =>$dayTF , 
                "month" =>$monthTF,
                "year" =>   $yearTF,
                "TitleRefNotesId" => $notes->getNoteIdFromNoteString($workTitle),
                "TypeRefNotesId" =>$notes->getNoteIdFromNoteString($workType),
                "Difficulity" =>$difficulity,
                "CreatedByNoteRefId" => "16",
                "Description" =>$description,
                "dayEnd" => $dateTime->format('d') , 
                "monthEnd" =>$dateTime->format('m') , 
                "yearEnd" =>$dateTime->format('y')) ;
                
                $REPORT_STATUS = $agenda->Create($REPORT) ;     
                
                print_r($REPORT) ; 

                $TotalWorkAdded++ ; 
            }
            
          //  if($x == $diffr && $TotalWorkAdded < 3)
            //     $x = 1 ; 
      
            
            
        }
       
    }
        elseif($difficulity > 5){
        
        for($x = 1  ; $x < $diff->format("%a") || $TotalWorkAdded < 2 ; $x++){
            
            $dateTime = new DateTime(date("Y").'-'.date("m").'-'.date("d"));
            
            $dateTime->add(new DateInterval('P'.$x.'D'));    
                
            $TotalWorkDifficulity = $agenda->ChargeWorkOfTheDay(array( $dateTime->format('d') ,  $dateTime->format('m') ,  $dateTime->format('y'))) ; 
            
            if($TotalWorkDifficulity < 20){
                //ADD A WORK TO THIS DAY TODO 
                $REPORT = array( 
                "day" =>$dayTF , 
                "month" =>$monthTF,
                "year" =>   $yearTF,
                "TitleRefNotesId" => $notes->getNoteIdFromNoteString($workTitle),
                "TypeRefNotesId" =>$notes->getNoteIdFromNoteString($workType),
                "Difficulity" =>$difficulity,
                "CreatedByNoteRefId" => "16",
                "Description" =>$description,
                "dayEnd" => $dateTime->format('d') , 
                "monthEnd" =>$dateTime->format('m') , 
                "yearEnd" =>$dateTime->format('y')) ;
                
                print_r($REPORT) ; 
                $TotalWorkAdded++ ; 
            }
        }
  
            
            
       
    }
    else{
        
             for($x = 1  ; $x < $diff->format("%a")  || $TotalWorkAdded < 1 ; $x++){
                 
           $dateTime = new DateTime(date("Y").'-'.date("m").'-'.date("d"));
            
           $dateTime->add(new DateInterval('P'.$x.'D'));   
            
           $TotalWorkDifficulity = $agenda->ChargeWorkOfTheDay(array( $dateTime->format('d') ,  $dateTime->format('m') ,  $dateTime->format('y'))) ; 
           
            if($TotalWorkDifficulity < 20){
                //ADD A WORK TO THIS DAY TODO 
                $REPORT = array( 
                "day" =>$dayTF , 
                "month" =>$monthTF,
                "year" =>   $yearTF,
                "TitleRefNotesId" => $notes->getNoteIdFromNoteString($workTitle),
                "TypeRefNotesId" =>$notes->getNoteIdFromNoteString($workType),
                "Difficulity" =>$difficulity,
                "CreatedByNoteRefId" => "16",
                "Description" =>$description,
                "dayEnd" => $dateTime->format('d') , 
                "monthEnd" =>$dateTime->format('m') , 
                "yearEnd" =>$dateTime->format('y')) ;
                
                print_r($REPORT) ; 
                
                $TotalWorkAdded++ ; 
            }
        }
        
        
        
        
        
        
    }
    
    
    
    
    
}



    


?>
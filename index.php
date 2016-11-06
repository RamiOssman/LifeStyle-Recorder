<?php

require_once('privateconnect.php') ; 
$conx = new callSql ; 

$conn = $conx->startConnection("librarydb") ; 


?>
<!DOCTYPE HTML>
<html>
<header>
    <title>LifeStyle Recorder</title>
        <link href="style/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="style/css.css" rel="stylesheet" type="text/css" />
    <script src="script/jquery.js" >
    
    </script>
    <script src="script/bootstrap.js">
    
    </script>
 
    </header>
    <body>
    <div style="" class="TitleHeader">
     
        <h1 class="title">LifeStyle Recorder</h1>
        
        <div class="loading-div" style="display:none">
        <img src="images/loading.gif" class="loading-img" />
        
        </div>
        <div class="actions-div"  >
        

<button type="button" class="btn btn-primary" onclick="buttonClick(this)">To Do</button>

<!-- Indicates a successful or positive action -->
<button  onclick="buttonClick(this)" type="button" class="btn btn-success">Notes</button>

<!-- Contextual button for informational alert messages -->
<button   onclick="buttonClick(this)" type="button" class="btn btn-info">Agenda</button>

<!-- Indicates caution should be taken with this action -->
<button  onclick="buttonClick(this)" type="button" class="btn btn-warning">HS Statistic</button>

<!-- Indicates a dangerous or potentially negative action -->
<button  onclick="buttonClick(this)" type="button" class="btn btn-danger">Recovery Work</button>


        </div>
        <div style="display:none" class="Todo-div">
            
        </div>
        <div style="display:visible" class="Notes-div">
            
        </div>
        
        </div>
    <script>
        function buttonClick(x)
        {
            
             $(x.parentElement).fadeOut(800) ; 
            

            switch(x.innerHTML)
                {
                    case "To Do":
                        
                        $(".Todo-div").fadeIn(800) ; 
                       
                        break ; 
                        
                    case "Notes":
                           
                           $(".loading-div").fadeIn(800) ; 
                        break ; 
                        
                    case "Agenda":
                        
                        
                        break;
                        
                    case "Infos":
                        
                        break;
                        
                    case "Recovery Work":
                        
                        break;
                    default: return 0 ; break ;    
                    
                 
                    
                }
            
            
        
        
        
        }
        
        
        
        
        
        </script>
    
    </body>
    
</html>
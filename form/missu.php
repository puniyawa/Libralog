<?php
$lambing ='';
if(isset($_GET['submit'])){      
$lambing = 'please';

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins"/>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <?php
            if($lambing != 'please'){     
            ?>
            <form role="search">                
                <div class="mt-3 p-3">
                    <h4><b>Scan the RFID Card</b></h4>                            
                    <input type="text" class="form-control" name="submit" placeholder="ISBN" required>                                         
                </div>                   
            
            </form>     
                
            <?php
            }
            ?>
            <?php
            if($lambing == 'please'){     
            ?>
            <form role="search">                
                <div class="mt-3 p-3">
                    <h1><b>Miss ko na s'ya☹</b></h1>                                                                    
                </div>                   
            
            </form>     
                
            <?php
            }
            ?>
             
                        
        </div>
    </div>
</div>
</body>
</html>
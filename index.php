<?php
include 'function/db_conn.php';
if(isset($_GET['search'])){
    $search = strval($_GET['search']);
    $dateToday = date("Y-m-d H:i:sa");
    if(strtolower($search) == 'true'){
        $sql = "SELECT * FROM `libralog` WHERE isReturned=1";
    }
    else if(strtolower($search) == 'false'){
        $sql = "SELECT * FROM `libralog` WHERE isReturned=0 AND '$dateToday' < dueDate";
    }
    else if($search[0] == '#'){
        $searchID = substr($search, 1);
        $sql = "SELECT * FROM `libralog` WHERE uid='$searchID'";
    }
    else{
       $sql = "SELECT * FROM `libralog` WHERE concat(`uid`, `firstName`, `middleName`, `lastName`, `sex`, `studentID`, `dep`, `gradeYear`, `section`, `dateOfBorrowing`, `dueDate`, `dateReturned`, `isbn`, `isReturned`) LIKE '%$search%'"; 
    }
    
}
else{
    $sql = "SELECT * FROM `libralog`";
}
if(isset($_GET['filter'])){
    $filter = $_GET['filter'];
    $dateToday = date("Y-m-d H:i:sa");
    if($filter == 'late'){
        $sql = "SELECT * FROM `libralog` WHERE isReturned=0 AND '$dateToday' > dueDate";
    }
}
if(isset($_GET['beforeDate'])){
    $dateToday = date("Y-m-d H:i:sa");
    $beforeDate = $_GET['date'];
    $sql = "SELECT * FROM `libralog` WHERE '$dateToday' > dueDate";

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP -->

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>LibraLog</title>
</head>
<body style="background-image: url(image/tesselate.png); font-family: 'Poppins', serif;">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <i class="fa-solid fa-book fa-2xl" style="color: #066634; padding-right: 20px; padding-left: 10px;"></i>
            <h1 style="padding-right: 30px; padding-top: 5px; color: #066634;"><b>LibraLog</b></h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" style="padding-right: 10px;" id="navbarNavDropdown">
                <div class="d-flex  align-items-center">
                    <form class="d-flex" role="search">
                        <input type="search" class="form-control" name="search" placeholder="Search" required>
                        <button type="submit" class="btn btn-outline-success ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    <div class="btn-group dropstart">
                        <button class="btn btn-outline-primary dropdown-toggle ms-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter by
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="index.php?search=true" class="link-dark">Returned</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?search=false" class="link-dark">Not Returned</a>                                         
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?filter=late" class="link-dark">Late</a>                                         
                            </li>
                        </ul>                                
                    </div>
                    <div class="btn-group dropstart">
                        <button class="btn btn-outline-secondary dropdown-toggle ms-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="nav-link active p-3" href="add_user.php"><i class="fa-regular fa-user pe-2"></i>Student Borrower Info</a>
                            </li>
                            <li>
                                <a href="form/add_user.php" class="nav-link active p-3"><i class="fa-solid fa-plus pe-2"></i>Add</a>
                            </li>
                            <li>
                                <a href="data_table.php" class="nav-link active p-3" aria-current="page"><i class="fa-solid fa-pen-to-square pe-2"></i>Edit</a>                             
                            </li>
                            <li>
                                <a class="nav-link active p-3" href="form/returned.php">Add Returned Book Log</a>                                        
                            </li>
                            <li>
                                <a class="nav-link active p-3" href="form/clearance.php"><i class="fa-solid fa-check pe-2"></i>Student Library Clearance Checker</a>                                       
                            </li>
                        </ul>                                
                    </div>
                    
                   
                </div>                 
            </div>
        </div>
  
           
        
    </nav>
    <div class="container-fluid">        
        <div class="row">
            <div class="col-12">
                <?php
                    if(isset($_GET['msg'])){
                        $msg = $_GET['msg'];
                        echo 
                        '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-top: 20px;">
                            '.$msg.'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    ?>
            </div>
        </div>
        
        <div class="row">
            <!-- <div style="background-color: white;" class="col-2 d-flex flex-column shadow rounded p-3 mt-3">            
                <div class="p-2">LibraLog Book Borrowing System</div>
                <div class="p-2"></div>
                <div class="m-2">   

                </div>
            </div> -->
            <div class="col">
                <div style="background-color: white;" class="shadow rounded p-3 m-5 mt-5">
                    <nav class="navbar">

                    </nav>
                    <div class="row shadow-sm border-none rounded p-3 m-2 color-danger">                       
                            <div class="col-1">UID</div>
                            <div class="col">Name</div>
                            <div class="col">Student ID</div>
                            <div class="col-1">Sex</div>
                            <div class="col">Grade/ Year and Section</div>   
                            <div class="col">ISBN Number</div>  
                            <div class="col">Due In</div>    
                            <div class="col">Status</div>               
                    </div>
                    <?php                                                 
                    $result = mysqli_query($conn, $sql);



                    while($row = mysqli_fetch_assoc($result)){
                            // Calculate the Status
                            $origin = date_create(date('Y-m-d H:i:s'));
                            $target = date_create(date('Y-m-d H:i:s',strtotime($row['dueDate'])));                        
                            $interval = date_diff($origin, $target);
                            $dueIn = $interval->format('%a days <br> %H:%I:%S');
                        
                            if ($interval->format('%R%a') > 0){
                                $dueIn = $interval->format('%a days');
                                $statusFromCalcDate = "Not Returned";
                                
                                
                            }
                            else if ($interval->format('%R%a') == 0){
                                $dueIn = 'Due Today';
                                $statusFromCalcDate = "Not Returned";
                            }
                            else if ($interval->format('%R%a') < 0){
                                $dueIn = $interval->format('Late of %a days');
                                $statusFromCalcDate = "Late";
                            }   
                            else{
                                $dueIn = '';
                            }
                        ?>

                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#userInfo-<?php echo $row['uid']?>" >
                            <div class="row card-hoverable shadow-sm rounded p-3 m-2">     
                            
                                <div class="col-1 text-truncate"> #<?php echo $row['uid']?></div>
                                <div class="col text-truncate"> <?php echo $row['lastName'] . ', <br>' . $row['firstName'] . ', <br>' . $row['middleName'][0] . '.' ?></div>
                                <div class="col text-truncate"> <?php echo $row['studentID']?></div>
                                <div class="col-1 text-truncate"> <?php echo $row['sex'][0]?></div>
                                <div class="col text-truncate"> <?php echo $row['gradeYear'] . ' - ' . $row['section']?></div>     
                                <div class="col text-truncate"> <?php echo $row['isbn']?></div>                               
                                <div class="col text-truncate"> <?php echo $dueIn;?></div>                        
                                <div class="col text-truncate"> <?php if($row['isReturned'] == 1){ echo 'Returned';} else{ echo $statusFromCalcDate;}?></div>          
                            </div>
                        </a>
                        <div class="modal fade" id="userInfo-<?php echo $row['uid']?>" tabindex="-1" aria-labelledby="userInfoLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="userInfoLabel">Selected UID: <?php echo $row['uid']?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Name: <?php echo $row['lastName'] . ', ' . $row['firstName'] . ', ' . $row['middleName'][0] . '.' ?> <br>
                                        Student ID: <?php echo $row['studentID']?> <br>
                                        Sex: <?php echo $row['sex']?> <br>
                                        Grade/Year and Section : <?php echo $row['gradeYear'] . ' - ' . $row['section']?>   <br>
                                        ISBN: <?php echo $row['isbn']?> <br>
                                        Due In: <?php echo $dueIn?> <br>
                                        Is Returned: <?php if($row['isReturned'] == 1){ echo 'Returned';} else{ echo $statusFromCalcDate;}?> <br> 
                                        
                                        Date of Borrowing: <?php echo $row['dateOfBorrowing']?> <br>
                                        Due Date: <?php echo $row['dueDate']?> <br>
                                        Date Returned: <?php echo $row['dateReturned']?> <br>
                                    </div>                            
                                </div>
                            </div>
                        </div>    
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>      
    </div>
    
    <!-- BOOTSTRAP -->    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
        })()
    </script>
</body>
</html>
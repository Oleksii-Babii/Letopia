<?php
ob_start();
require "session.php";
require 'templates/header.php';
require_once 'functions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
// Check if we are on the live server or a local XAMPP environment
if ($_SERVER['SERVER_NAME'] == 'knuth.griffith.ie') {
    // Path for the Knuth server
    $path_to_mysql_connect = '../../../mysql_connect.php';
} else {
    // Path for the local XAMPP server
    $path_to_mysql_connect = 'mysql_connect.php';
}

// Require the mysql_connect.php file using the determined path
require_once $path_to_mysql_connect;

if(isset($_SESSION["user"]["role"])){
    $role = $_SESSION["user"]["role"];

    if ($role == 'admin') {
        display_testimonial_admin($db_connection);
    } else if ($role == 'landlord' || $role == 'tenant') {
        display_for_tenant_landlord();
        display_testimonial($db_connection);
    } 
}else{
    display_testimonial($db_connection);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])){
    $comment = validate_form_input($_POST['comment']);
    $service_name = validate_form_input($_POST['service_name']);
    $currentDate = date('Y-m-d'); 
    // Format: Year-Month-Day Hour:Minute:Second
    $authorId = $_SESSION['user']['id']; 
    addTestimonial($db_connection, $service_name, $currentDate, $comment, $authorId);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
    $option = $_POST['option'];
    if($option == 'on'){
        $option = true;
    }else{
        $option = false;
    }
    $id = $_POST['id'];
    update_show($db_connection,$option, $id);
    header('Location: testimonial.php');
}

function update_show($db_connection,$option, $id){
    $stmt = $db_connection -> prepare(
        "UPDATE testimonial SET isApproved = ? WHERE id = ?"
    );

    $stmt->bind_param("ss",  $option, $id);

    if($stmt->execute()){
    }else{
        $message = 'Error updating customer: '.$stmt->error;
    }
    $stmt -> close();
}

function display_testimonial_admin($db_connection){
    $stmt = "SELECT testimonial.id AS testimonial_id, testimonial.serviceName, testimonial.date, testimonial.comment, user.firstName, user.lastName, testimonial.isApproved 
             FROM testimonial
             INNER JOIN user ON testimonial.authorId = user.id";

    $result = $db_connection->query($stmt);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            display_testimonial_result_admin($row['testimonial_id'], $row['serviceName'], $row['date'], $row['comment'], $row['firstName'], $row['lastName'], $row['isApproved']);
        }
    }
}

function display_testimonial($db_connection){
    $stmt = ("SELECT * FROM testimonial
    inner join user on testimonial.authorId = user.id");

        $result = $db_connection->query($stmt);

        if($result->num_rows > 0){

        while($row = $result -> fetch_assoc()){
            if($row['isApproved'] == true){
                display_testimonial_result($row['serviceName'], $row['date'], $row['comment'], $row['firstName'], $row['lastName'],$row['isApproved']);
            }
        }
        }
}



function display_testimonial_result_admin($id, $service_name, $date, $comment, $firstName, $lastName , $isChecked ){
    echo "       
    <div class='d-flex justify-content-center mt-5' style='margin-bottom: 3rem'>  
    <form class='card' id='loginForm'  method='POST' novalidate>
    <input type='hidden' name='id' value='$id'> <!-- Hidden input field with name 'id' -->         
    <div class='card'style='width: 50rem'>
        <div class='card-body'>
          <h5 class='card-title'>" . $service_name . "</h5>
          <p class='card-text'>" . $comment . "</p>
          <span style='display: flex; justify-content: center;'>" . $date . "</span><span style='display: flex; justify-content: right;'>" . $firstName . " " . $lastName . "</span>
        </div>
        
        <div class='form-check form-switch'>
            <input name= 'option' class='form-check-input' type='checkbox' role='switch' id='flexSwitchCheckDefault' " . ($isChecked ? 'checked' : '') . ">
            <label class='form-check-label' for='flexSwitchCheckDefault'>Show</label>
        </div>
    </div>
    <div class='form-group text-center mt-3 pr-3 pl-3' style='width: 10rem; display: flex; justify-content: center; margin: 1rem;'>
       <div>
                <input type='submit' name='save' class='btn btn-outline-primary w-100' value='Save' >
                </div>
        </div> 
    </form>
    </div>
    
    ";
}

function display_testimonial_result($service_name, $date, $comment, $firstName, $lastName){
    echo "
    <div class='d-flex justify-content-center mt-5' style='margin-bottom: 3rem'>           
    <div class='card'style='width: 50rem'>
        <div class='card-body'>
          <h5 class='card-title'>" . $service_name . "</h5>
          <p class='card-text'>" . $comment . "</p>
          <span style='display: flex; justify-content: center;'>" . $date . "</span><span style='display: flex; justify-content: right;'>" . $firstName . " " . $lastName . "</span>
        </div>       
    </div>
    </div>";
}

function addTestimonial($db_connection, $service_name, $currentDate, $comment, $authorId){
    $insertQuery = $db_connection->prepare("INSERT INTO testimonial (`ServiceName`, `Date`,`Comment`, `AuthorID`) VALUES (?, ?, ?, ?);");
    $insertQuery->bind_param("ssss", $service_name, $currentDate, $comment, $authorId);
    $result = $insertQuery->execute();

    if ($result) {
        //Data inserted successfully. Display the corresponding message
        $success = <<<SUCCESS
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading">Congratulations!</h4>
            <h5>Your message is sent to us.</h5>
            <hr>
        </div>
        SUCCESS;
        
        echo $success;
    } else {
        echo "<p class='error'>Something went wrong: '.$insertQuery->error.'</p>";
    }

    $insertQuery->close();
}

function display_for_tenant_landlord(){
    echo "<main class='d-flex justify-content-center mt-5'>
        <div id='login' >
            <h2 class='text-center'>Create Testimonial</h2>
            <form style='margin:2rem' id='loginForm' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST' novalidate>";
    
    // PHP section should not be within the echo
    if (!empty($errors)) {
        GLOBAL $noError;
        $noError = false;
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger text-center mb-1 ml-1 mr-1' role='alert'>
                        {$error}
                    </div>";
        }
    }
    
    // Continue with the form HTML
    echo "<div class='form-group mr-3 ml-3'>
                    <label for='service_name'>Service Name</label>
                    <input type='text' id='service_name' name='service_name' class='form-control' placeholder ='your service name' value='" . (isset($_POST['service_name']) ? $_POST['service_name'] : '') . "'>
                </div>

                <div class='form-group mr-3 ml-3'>
                    <label for='comment'>Comment</label>
                    <textarea id='comment' name='comment' class='form-control' placeholder ='your comment'>" . (isset($_POST['message']) ? $_POST['message'] : '') . "</textarea>
                </div>

                <div class='form-group text-center mt-3 pr-3 pl-3'>
                           <input type='submit' name='send' class='btn btn-outline-primary w-100' value='Send'>
                </div> 
            </form>
        </div>
    </main>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>
<body style='margin-top: 10rem;'>
   <?php
     if (!empty($errors)) {
        GLOBAL $noError;
          $noError = false;
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger text-center mb-1 ml-1 mr-1' role='alert'>
            {$error}
        </div>";
        }
       } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<?php
    require 'templates/footer.php';
?>
<?php
ob_end_flush();
?>


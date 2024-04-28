<?php
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


// $firstName = $_SESSION["user"]["firstName"];
// $lastName = $_SESSION["user"]["lastName"];
$role = $_SESSION["user"]["role"];
print '\n';
print '\n';



//
// echo "<p class='mt-5'>Info:</p>";
// echo "$firstName $lastName $role";

if ($role == 'admin') {
    echo '<h1>Admin role</h1>';
    display_testimonial($db_connection);
} else if ($role == 'landlord' || $role == 'tenant') {
    echo '<h1>tenant role</h1>';
    display_for_tenant_landlord();
} else{
    echo '<h1>public role</h1>';
    display_testimonial($db_connection);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])){
    $comment = validate_form_input($_POST['comment']);
    $service_name = validate_form_input($_POST['service_name']);
    $currentDate = date('Y-m-d'); // Format: Year-Month-Day Hour:Minute:Second
    $authorId = $_SESSION['user']['id'];
// Print the current date and time
    echo "Current Date and Time: " . $currentDate . " ". $authorId;  
    addTestimonial($db_connection, $service_name, $currentDate, $comment, $authorId);
}

function display_testimonial($db_connection){
    $stmt = ("SELECT * FROM testimonial
    inner join user on testimonial.authorId = user.id");

        $result = $db_connection->query($stmt);

        if($result->num_rows > 0){

        while($row = $result -> fetch_assoc()){
                display_testimonial_result($row['serviceName'], $row['date'], $row['comment'], $row['firstName'], $row['lastName']);
            }
        }
}
function display_testimonial_result($service_name, $date, $comment, $firstName, $lastName){
    echo "
    <div class='d-flex justify-content-center mt-5'>           
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
        <div id='login'>
            <h2 class='text-center'>Create Testimonial</h2>
            <form id='loginForm' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST' novalidate>";
    
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
<body>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
<?php
display_testimonial($db_connection);
?>
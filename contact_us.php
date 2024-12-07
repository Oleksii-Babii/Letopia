<?php
require "session.php";
require 'templates/header.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize global variables
$errors = [];
$noError = true;
$success = null;  // Initialize $success with a default value

// Connect to the database
if ($_SERVER['SERVER_NAME'] == 'knuth.griffith.ie') {
    $path_to_mysql_connect = '../../../mysql_connect.php';
} else {
    $path_to_mysql_connect = 'mysql_connect.php';
}
require_once $path_to_mysql_connect;

// Get validate_form_input function
require 'functions.php';

// Define addContact function
function addContact($db_connection, $name, $email, $phone, $message) {
    global $success;  // Declare $success as global to make it available outside the function

    $name = mysqli_real_escape_string($db_connection, $name);
    $email = mysqli_real_escape_string($db_connection, $email);
    $phone = mysqli_real_escape_string($db_connection, $phone);
    $message = mysqli_real_escape_string($db_connection, $message);

    $insertQuery = $db_connection->prepare("INSERT INTO contact_us (`name`, `email`,`phone`, `message`) VALUES (?, ?, ?, ?);");
    $insertQuery->bind_param("ssss", $name, $email, $phone, $message);
    $result = $insertQuery->execute();

    if ($result) {
        $success = <<<SUCCESS
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading">Congratulations!</h4>
            <h5>Your message has been sent to us.</h5>
            <hr>
        </div>
        SUCCESS;
    } else {
        echo "<p class='error'>Something went wrong: " . $insertQuery->error . "</p>";
    }

    $insertQuery->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {
    // Validate input
    if (empty($_POST['email'])) {
        $errors[] = 'Please enter your email';
    } else {
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }
    }

    if (empty($_POST['full_name'])) {
        $errors[] = 'Please enter your full name';
    } else {
        $name = validate_form_input($_POST['full_name']);
    }

    if (empty($_POST['phone'])) {
        $errors[] = 'Please enter your phone number';
    } else {
        $phone = validate_phone_number($_POST['phone']);
        if ($phone === false) {
            $errors[] = "Invalid phone number.";
        }
    }

    if (empty($_POST['message'])) {
        $errors[] = 'Please enter your message';
    } else {
        $message = validate_form_input($_POST['message']);
    }

    // If no errors, insert the contact into the database
    if (empty($errors)) {
        addContact($db_connection, $name, $email, $phone, $message);
    }
}

?>

<main id="contact_us" class="d-flex justify-content-center mt-5">
    <div id="login" style='margin-bottom: 3rem; margin-top: 5rem;'>        
        <h2 class="text-center">Contact us</h2>
        <p class="text-center text-secondary">Enter your account details below.</p>
        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" novalidate>
            <?php
            if (!empty($errors)) {
                global $noError;
                $noError = false;
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger text-center mb-1 ml-1 mr-1' role='alert'>
                    {$error}
                </div>";
                }
            } elseif ($success) {
                echo $success;
            }
            ?>

            <div class="form-group mr-3 ml-3">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="form-control" placeholder="your name" value="<?php if (isset($_POST['full_name'])) echo $_POST['full_name']; ?>">
            </div>

            <div class="form-group mr-3 ml-3">
                <label for="email">Email address</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="example@domain.com" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
            </div>

            <div class="form-group mr-3 ml-3">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="your phone" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>">
            </div>

            <div class="form-group mr-3 ml-3">
                <label for="message">Your message</label>
                <textarea id="message" name="message" class="form-control" placeholder="your message"><?php if (isset($_POST['message'])) echo $_POST['message']; ?></textarea>
            </div>

            <div class="form-group text-center mt-3 pr-3 pl-3">
                <input type="submit" name="send" class="btn btn-outline-primary w-100" value="Send">
            </div>
        </form>
    </div>
</main>

<?php
require 'templates/footer.php';
?>

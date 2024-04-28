<?php
require "session.php";
require 'templates/header.php';


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

// Create an empty array to store errors
$errors = [];
$noError = true;

// Global scope declaration
$alreadyExists = false;

//Get validate_form_input function
require 'functions.php';

// Checks if form is submitted via POST and sanitizes input to prevent XSS attacks.
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

    // Check and validate 'Address' field
    $address = htmlspecialchars($_POST['address'] ?? '');
    if (!isset($address) || empty($address) || !validate_form_input($address)) {
        $errors[] = "Please enter a valid address.";
    }

    // Check and validate 'Eircode' field
    if (isset($_POST['eircode']) && !empty($_POST['eircode'])) {
        $eircode = validate_dublin_eircode($_POST['eircode']);
        if ($eircode === false) {
            $errors[] = "Invalid Eircode format eg. D08 Y14X.";
        } else {
            // Check if a propery with this eircode already exists in the database
            // Perform database search operation for property record
            $stmt = $db_connection -> prepare("SELECT * FROM property WHERE eircode = ?");
            $stmt->bind_param("s", $eircode);
            $stmt -> execute();
            $result = $stmt -> get_result();

            if($result -> num_rows > 0) {
                GLOBAL $alreadyExists;
                $alreadyExists = true;
            }
            $stmt -> close();
        }

    } else {
        $errors[] = "Eircode field is missing.";
    }

    // Check and validate 'Rental Price' field
    if(isset($_POST['rentalPrice']) && !empty($_POST['rentalPrice'])) {
        $rentalPrice = validate_form_input($_POST['rentalPrice']);

        if ($rentalPrice === false) {
            $errors[] = "Rental Price is missing.";
        }

        if(!preg_match("/^\d+([.,]\d{1,2})?$/", $rentalPrice)) {
            $errors[] = "Rental Price is invalid.";
        }

    } else {
        $errors[] = "Rental Price is missing.";
    }

    // Check and validate 'Number of bedrooms' field
    if (isset($_POST['numberOfbedrooms']) && !empty($_POST['numberOfbedrooms'])) {
        $numberOfbedrooms = $_POST['numberOfbedrooms'];
    } else {
        $errors[] = "Number Of bedrooms is missing.";
    }

    // Check and validate 'Length of tenancy' field
    if (isset($_POST['lengthOfTenancy']) && !empty($_POST['lengthOfTenancy'])) {
        $lengthOfTenancy = $_POST['lengthOfTenancy'];
    } else {
        $errors[] = "Length of Tenancy is missing.";
    }

    // Check and validate 'Address' field
    $address = htmlspecialchars($_POST['address'] ?? '');
    if (!isset($address) || empty($address) || !validate_form_input($address)) {
        $errors[] = "Please enter a valid address.";
    }

    // Check and validate 'Property Description' field
    $description = htmlspecialchars($_POST['description'] ?? '');
    if (!isset($description) || empty($description) || !validate_form_input($description)) {
        $errors[] = "Please enter a valid Property Description.";
    }


    // Check the size of each image. (Don't check the type because document.createElement('img') let only select img ('jpg', 'jpeg', 'png', 'gif'))
    $atLeastOneImg = false;
    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
        // Get the file name
        $fileName = basename($_FILES["images"]["name"][$key]);

        // Check if the size is valid (Max 3MB = 3 * 1024 * 1024 bytes)
        $maxFileSize = 3 * 1024 * 1024; 
        if ($_FILES["images"]["size"][$key] > $maxFileSize) {
            $errors[] = "Image $fileName is not of a valid size (Max 3MB)";
        } else {
            if(!empty($fileName )){
                $atLeastOneImg = true;
            } 
        }
    }

    // Proprty must have at least one image
    if(!$atLeastOneImg) {
         $errors[] = "Select at least one image";
    }


    if(!$alreadyExists) {
        if(empty($errors) && $atLeastOneImg) {
            if(!empty($address) && !empty($eircode) && !empty($rentalPrice) && !empty($numberOfbedrooms) && !empty($lengthOfTenancy) && !empty($description)) {
                //Escape Inputs with the mysqli_real_escape_string.
                $address = mysqli_real_escape_string($db_connection, $address);
                $eircode = mysqli_real_escape_string($db_connection, $eircode);
                $rentalPrice = mysqli_real_escape_string($db_connection, $rentalPrice);
                $numOfBedrooms = mysqli_real_escape_string($db_connection, $numberOfbedrooms);
                $lengthOfTenancy = mysqli_real_escape_string($db_connection, $lengthOfTenancy);
                $description = mysqli_real_escape_string($db_connection, $description);
                $landlordId = $_SESSION["user"]["id"];

                $insertQuery = $db_connection->prepare("INSERT INTO property (address, eircode, rentalPrice, numOfBedrooms, lengthOfTenancy, description, landlordId) VALUES (?, ?, ?, ?, ?, ?, ?);");

                $insertQuery->bind_param("ssdiisi", $address, $eircode, $rentalPrice, $numOfBedrooms, $lengthOfTenancy, $description, $landlordId);
                $result = $insertQuery->execute();
                $insertQuery->close();

                //Get propertyId
                $stmt = $db_connection->prepare("SELECT id FROM property WHERE eircode = ?");
                $stmt->bind_param("s", $eircode);
                $stmt->execute();
                $result = $stmt -> get_result();
                $stmt-> close();
                
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $row = $rows[0];
                $propertyId = $row['id'];
                 echo "<p class mt-5>propertyId : $propertyId</p>";


                if(empty($errors)) {
                    // Define a directory with the appropriate property ID
                    $targetDirectory = "propertyImages/$propertyId/";
                    if (!file_exists($targetDirectory)) {
                        mkdir("propertyImages/$propertyId/", 0777, true);
                    }
                    
                    // Prepare the SQL statement
                    $insertPhoto = $db_connection->prepare("INSERT INTO property_photo (propertyId, photo) VALUES (?, ?);");

                    // Debug: Output the number of uploaded files
                    //var_dump($_FILES);

                    //Iterate through each uploaded image
                    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
                        // Get the file name
                        $fileName = basename($_FILES["images"]["name"][$key]);
                        // Define the target file path
                        $targetFilePath = $targetDirectory . $fileName;

                        // Move the file from temporary location to target location
                        if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $targetFilePath)) {
                            // Bind the property ID and file path parameters to the prepared statement
                            $insertPhoto->bind_param("is", $propertyId, $targetFilePath);
                            $insertPhoto->execute();
                        } else {
                            $errors[] = "Sorry, there was an error uploading your file.<br>";
                        }
                    }
                    // Close the prepared statement
                    $insertPhoto->close();

                    header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?registred=true");
                    exit();  
                } 

            }
        }
    } else {
        $message = <<<MESSAGE
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
              <h4><strong>A property with this eircode already exists.</strong></h4>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>              
            MESSAGE;
        echo $message;
    }
}
?>

        <main class="main" id="registerPropertyMain">
            <?php if(isset($_GET['registred']) && $_GET['registred'] == 'true'): ?>
                <div class="alert alert-success text-center mt-3" role="alert">
                    <h4 class="alert-heading">Well done!</h4>
                    <h5>New property registred successfully</h5>
                    <hr>
                </div>
            <?php endif; ?>
            <h2 class="text-center">Register New Property</h2>
            <div class="container">
                <form id="propertyRegistrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-3" method="POST" enctype="multipart/form-data" novalidate>
                    <?php
                     if (!empty($errors) && !$alreadyExists) {
                        GLOBAL $noError;
                        $noError = false;
                        foreach ($errors as $error) {
                            echo "<div class='alert alert-danger text-center mb-1 ml-1 mr-1' role='alert'>
                            {$error}
                        </div>";
                        }
                     } ?>
                <div class="details">
                    <div id="propertyRegistration">
                        <h4>Property Details</h4>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="address" rows="3" cols="30" class="form-control"><?php if(isset($_POST['address'])) echo $_POST['address']; ?>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="eircode">Eircode:</label>
                                <input type="text" id="eircode" name="eircode" value="<?php if(isset($_POST['eircode'])) echo $_POST['eircode']; ?>" class="form-control" pattern="[Dd][0-9]{2}\s?[a-zA-Z0-9]{4}" placeholder="eg. D08 Y20X" required>
                            </div>

                            <div class="form-group">
                                <label for="rentalPrice">Rental price (per month):</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="rentalPrice" name="rentalPrice" value="<?php if(isset($_POST['rentalPrice'])) echo $_POST['rentalPrice']; ?>" class="form-control" placeholder="ex. 1500.00" pattern="^\d+([.,]\d{1,2})?$" required>
                                    <span class="input-group-text">€</span>
                                    <span class="input-group-text">0.00</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="numberOfbedrooms">Number of bedrooms:</label>
                                <select id="numberOfbedrooms" name="numberOfbedrooms" class="form-control" required>
                                    <option value=""<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '') echo ' selected="selected"'; ?>>Choose...</option>
                                    <option value="1"<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '1') echo ' selected="selected"'; ?>>1 bedroom</option>
                                    <option value="2"<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '2') echo ' selected="selected"'; ?>>2 bedrooms</option>
                                    <option value="3"<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '3') echo ' selected="selected"'; ?>>3 bedrooms</option>
                                    <option value="4"<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '4') echo ' selected="selected"'; ?>>4 bedrooms</option>
                                </select>
                            </div>

                            <div class="form-group">Length of tenancy:</label>
                                <select id="lengthOfTenancy" name="lengthOfTenancy" class="form-control" required>
                                    <option value=""<?php if (isset($_POST['lengthOfTenancy']) && $_POST['lengthOfTenancy'] == '') echo ' selected="selected"'; ?>>Choose...</option>
                                    <option value="3"<?php if (isset($_POST['lengthOfTenancy']) && $_POST['lengthOfTenancy'] == '3') echo ' selected="selected"'; ?>>3-month</option>
                                    <option value="6"<?php if (isset($_POST['lengthOfTenancy']) && $_POST['lengthOfTenancy'] == '6') echo ' selected="selected"'; ?>>6-month</option>
                                    <option value="12"<?php if (isset($_POST['lengthOfTenancy']) && $_POST['lengthOfTenancy'] == '12') echo ' selected="selected"'; ?>>1 year</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description">Property Description</label>
                                <textarea id="description" name="description" rows="3" cols="30" class="form-control"><?php if(isset($_POST['description'])) echo $_POST['description']; ?>
                                </textarea>
                            </div>

                            <label for="images">Images (The recommended aspect ratio is 16:9):</label><br>
                            <button class="btn btn-info w-25 mb-2" type="button" onclick="document.getElementById('images').click();">Add</button>
                            <input type="file" id="images" name="images[]" accept="image/*" multiple style="display: none;" onchange="previewAndManageImages(event)">
                            <div id="preview"></div>

                            <script>
                            function previewAndManageImages(event) {
                                var preview = document.getElementById('preview');
                                var files = event.target.files;
                                var input = document.getElementById('images');
                                var selectedFiles = [];

                                // Clear existing previews
                                preview.innerHTML = '';

                                for (var i = 0; i < files.length; i++) {
                                    (function(file) { // Use a closure to capture the value of 'file'
                                        var reader = new FileReader();

                                        reader.onload = function(event) {
                                            var img = document.createElement('img');
                                            // ratio for property photos 16:9
                                            img.setAttribute('width', '450');
                                            img.setAttribute('height', '253');
                                            img.setAttribute('style', 'margin-top: 0.5rem;');
                                            img.setAttribute('class', 'preview-image');
                                            img.src = event.target.result;
                                            
                                            var container = document.createElement('div');
                                            container.appendChild(img);
                                            preview.appendChild(container);

                                            // Add the file to selectedFiles
                                            selectedFiles.push(file);
                                            // Update the files property of the input element
                                            input.files = new FileList(selectedFiles);
                                        }

                                        reader.readAsDataURL(file);
                                    })(files[i]); // Pass the current file to the closure
                                }
                            }
                            </script>
                        </div>
                    </div>
                    <div class="text-center mb-3 mt-3">
                        <button  type="submit" name="register" class="btn btn-primary w-25" >Register</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
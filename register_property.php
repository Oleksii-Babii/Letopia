<?php
require "session.php";

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
        $eircode = validate_eircode($_POST['eircode']);
        if ($eircode === false) {
            $errors[] = "Invalid Eircode format eg. D08 Y14X.";
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


}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		 <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- connect bootstrap libraries -->
        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" media="screen">
        <title>Register Property</title>
        <link rel="stylesheet" href="style/style.css">
	</head>

    <body>
        <main class="main">
            <h2 class="text-center mt-3">Register New Property</h2>
            <div class="container">
                <form id="propertyRegistrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-3" method="POST" novalidate>
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

                            <label for="images">Images:</label><br>
                            <button class="btn btn-info w-25 mb-2" type="button" onclick="document.getElementById('images').click();">Add</button>
                            <input type="file" id="images" name="images[]" accept="image/*" style="display: none;" onchange="previewAndManageImages(event)">
                            <div id="preview"></div>

                            <script>
                            function previewAndManageImages(event) {
                              var preview = document.getElementById('preview');
                              var files = event.target.files;

                              for (var i = 0; i < files.length; i++) {
                                var file = files[i];
                                var reader = new FileReader();

                                reader.onload = function(event) {
                                  var img = document.createElement('img');
                                  //img.setAttribute('width', '400');
                                  //img.setAttribute('height', '340');
                                  var removeButton = document.createElement('button');
                                  img.setAttribute('class', 'preview-image');
                                  img.src = event.target.result;
                                  removeButton.setAttribute('class', 'remove-button');
                                  removeButton.setAttribute('class', 'btn btn-outline-secondary rounded-circle');
                                  removeButton.setAttribute('style', 'width: 2.4rem');

                                  removeButton.innerHTML = '&#x2715;';
                                  removeButton.onclick = function() {
                                    this.parentElement.remove();
                                  };
                                  var container = document.createElement('div');
                                  container.appendChild(removeButton);
                                  container.appendChild(img);
                                  preview.appendChild(container);
                                }

                                reader.readAsDataURL(file);
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
<?php
function validate_form_input($input) {
    $input = trim($input); // Remove whitespace from the beginning and end of the string

    //Remove carriage return characters
    $input = str_replace("\r","", $input);
    //Remove new line characters
    $input = str_replace("\n","", $input);

    if (empty($input)) {
       return false; // Input is empty after trimming, so return false
    }


    $input = strip_tags($input); // Remove HTML and PHP tags
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Convert special characters to HTML entities
    return $input; // Return the sanitized input
}
?>

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

function validate_dublin_eircode($eircode) {
   $eircode = validate_form_input($eircode);

   if($eircode !== false) {
      if (!preg_match('/^[Dd][0-9]{2}\s?[a-zA-z0-9]{4}$/', $eircode)) {
         return false;
      }
   }
   return $eircode;
}

//Phone number validation
function validate_phone_number($mobile) {
   $mobile = trim($mobile);
   if(!preg_match('/^\+?[0-9]{1,3}\s?[-\s.]?(\(\d{1,4}\)|\d{1,4})[-\s.]?\d{1,4}[-\s.]?\d{1,4}[-\s.]?\d{1,4}$/', $mobile)){
      return false;
   }

   // Convert special characters to HTML entities
   $mobile = htmlspecialchars($mobile, ENT_QUOTES, 'UTF-8');
   return $mobile;
}
?>

<?php
require "session.php";
require ('templates/header.php');

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

$firstName = $_SESSION["user"]["firstName"];
$lastName = $_SESSION["user"]["lastName"];
$role = $_SESSION["user"]["role"];
print '\n';
print '\n';



//
echo "<p class='mt-5'>Info:</p>";
echo "$firstName $lastName $role";

?>
<?php
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

$firstName = "Oleksii";
$lastName = "Babii";
$password = "admin228!"; 
$email = "babiy.olexiy@ukr.net";
$role = "admin";

// hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT);
$insertQuery = $db_connection->prepare("INSERT INTO user (firstName, lastName, password, email, role) VALUES (?, ?, ?, ?, ?);");
$insertQuery->bind_param("sssss", $firstName, $lastName, $password_hash, $email, $role);
$result = $insertQuery->execute();

if ($result) {
  echo "Admin user added successfully.";
} else {
  echo "Error adding admin user: " . $stmt->error;
}

$insertQuery->close();
$db_connection->close();
?>
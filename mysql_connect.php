<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

  if ($_SERVER['SERVER_NAME'] == 'knuth.griffith.ie')
{
  //Knuth Database Connection
}
else
{
  //Xampp Database ConnectionS
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASSWORD', ''); // enter your password
  define('DB_NAME', 's3104904'); //enter your DB_Name (same as student login)
}

// create connection

  $db_connection = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die("Could not connect to MySQL! ".mysqli_connect_error()); 


  // Check connection
  if (!$db_connection) {
    die("Could not connect to MySQL: " . mysqli_connect_error());
  } else {
    // Set the character set
    mysqli_set_charset($db_connection, "utf8");
    // Select database
    if (!mysqli_select_db($db_connection, DB_NAME)) {
      die("Unable to select database: " . mysqli_error($db_connection));
    }
  } 


?>



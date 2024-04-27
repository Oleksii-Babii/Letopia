<?php
    // Connect to the database
    // Check if we are on the live server or a local XAMPP environment
    if($_SERVER['SERVER_NAME'] == 'knuth.griffith.ie'){
        // Path for the Knuth server
        $path_to_mysql_connect = '../../../mysql_connect.php';
    }else{
        // Path for the local XAMPP server
        $path_to_mysql_connect = 'mysql_connect.php';
    }

    // Require the mysql_connect.php file using the determined path
    require_once $path_to_mysql_connect;


    $stmt = ("SELECT * FROM contact_us");

    $result = $db_connection->query($stmt);

    if($result->num_rows > 0){

        while($row = $result -> fetch_assoc()){
            echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. "<br>";
        }
    }
?>
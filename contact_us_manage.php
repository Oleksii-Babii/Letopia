<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" media="screen">
    
    <title>Document</title>

    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <main>
        <div id="table-container" >
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">name</th>
                  <th scope="col">email</th>
                  <th scope="col">phone</th>
                  <th scope="col">message</th>
                </tr>
              </thead>
              <tbody>

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
                            echo "
                                <tr class='table-light' style='color:black;'>
                                <th scope='row'>" . $row['id'] . "</th>
                                <td>" . $row['name'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['phone'] . "</td>
                                <td>" . $row['message'] . "</td>
                                </tr>";
                        }
                    }
                ?>
              </tbody>
          </table>
        </div>
    </main>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
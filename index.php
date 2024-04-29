 <?php
    require "session.php";
    require ('templates/header.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

?> 
 
    <section>
        <h1 id="title">Deals of the week</h1>
        <div id="section-carusel">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="10000">
                <img src="additionalResources/appartment1-slideshow.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5>First slide label</h5>
                  <p>Some representative placeholder content for the first slide.</p>
                </div>
              </div>
              <div class="carousel-item" data-bs-interval="2000">
                <img src="additionalResources/appartment2-slideshow.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Second slide label</h5>
                  <p>Some representative placeholder content for the second slide.</p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="additionalResources/appartment3-slideshow.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Third slide label</h5>
                  <p>Some representative placeholder content for the third slide.</p>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div id="form-container">
            <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="col-auto">
                    <label  class="font-weight-bold"for="staticEmail2" >Area:</label>
                    <input name="area" type="text" class="form-control" id="staticEmail2" value="" placeholder="e.g. D08">
                </div>
                <div class="col-auto" style="width: 15rem;">
                    <label class="font-weight-bold" for="inputPassword2" >Price Range:</label>
                    <div id="start-end"  style="display: flex; flex-direction: row;">
                    <div >
                        <input name="priceStart" type="number" class="form-control" id="inputPassword2" placeholder="start" >
                    </div>
                    <div style="margin: 1%;">
                        <p>-</p> 
                    </div>  
                    <div >
                        <input name="priceEnd" type="number" class="form-control" id="inputPassword2" placeholder="end" >
                    </div> 
                    </div>
                </div>
                <div class="col-auto">
                    <label class="font-weight-bold" for="optionTypeBedroom" >Number of bedrooms:</label>
                    <select id="optionTypeBedroom" name="optionTypeBedroom" class="form-control">
                        <?php
                            $options = array(1, 2, 3);
                            foreach ($options as $option) 
                            {
                                $selected = ($options == $option) ? 'selected' : '';
                                echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="col-auto">
                    <label for="optionType" class="font-weight-bold">Length of tenancy:</label>
                    <select id="optionType" name="optionType" class="form-control">
                        <?php
                            $options = array(3, 6, 12);
                            foreach ($options as $option) 
                            {
                                $selected = ($options == $option) ? 'selected' : '';
                                echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="btn-form">
                <button type="submit" class="btn btn-primary mb-3" value="Submit" name="search">Search &#128269;</button>
                </div>
            </form>
        </div>
    </section>
    <div style="display: flex; justify-content: center;">
    <div class="grid-container">
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
            $errors = [];
            $noError = true;

            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])){         
                $area = $_POST['area']."%";
                $priceStart = $_POST['priceStart'];
                $priceEnd = $_POST['priceEnd'];
                $numberOfBedrooms = $_POST['optionTypeBedroom'];
                $length = $_POST['optionType'];
                length_validation($priceStart, $priceEnd);

                if($area == "%" && $priceEnd == "" && $priceStart == ""){
                    display_search_by_all_without_area_price($db_connection, $numberOfBedrooms, $length);
                }else if($priceStart == "" && $priceEnd == ""){
                    display_search_by_all_without_price($db_connection, $numberOfBedrooms, $length, $area);
                }else if($area == "%" && $priceEnd == ""){
                    display_search_by_all_end($db_connection, $priceStart, $numberOfBedrooms, $length);
                }else if($area == "%" && $priceStart == ""){
                    display_search_by_all_start($db_connection, $priceEnd, $numberOfBedrooms, $length);
                }else if($area == "%"){
                    display_search_by_all_without_area($db_connection, $priceStart, $priceEnd, $numberOfBedrooms, $length);
                }else if($priceEnd == ""){
                    display_search_by_all_withStartAndL($db_connection, $priceStart, $numberOfBedrooms, $length, $area);
                }else if($priceStart == ""){
                    display_search_by_all_withEndAndL($db_connection, $priceEnd, $numberOfBedrooms, $length, $area);
                }else{
                    display_search_by_all($db_connection, $priceStart, $priceEnd, $numberOfBedrooms, $length, $area);
                }
                
                // if($length == 3){

                // }
                // $length = $_POST['6'];
                // $length = $_POST['12'];

               // echo "area: ".$area ." priceStart: ". $priceStart ." priceEnd: ". $priceEnd ." numberOfBedrooms: ". $numberOfBedrooms ." length: ". $length;
            }else{
                display_all_available($db_connection);
            }

            function display_search_by_all_without_area($db_connection, $priceStart, $priceEnd, $numberOfBedrooms, $length){
                $stmt = $db_connection->prepare("SELECT property.id, property.address, property.eircode, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property
                WHERE rentalPrice BETWEEN ? AND ? 
                    AND numOfBedrooms = ? 
                    AND lengthOfTenancy = ?");
            
                $stmt->bind_param("ssss", $priceStart, $priceEnd, $numberOfBedrooms, $length);
            
                $result = $stmt->execute();
            
                if ($result) {
                    $result_set = $stmt->get_result();
            
                    if ($result_set->num_rows > 0) {
                        while ($row = $result_set->fetch_assoc()) {
                            //echo $row['rentalPrice'] . " " . $row['numOfBedrooms'] . " " . $row['lengthOfTenancy'] . " " . $row['eircode'] . "<br>";
                            display_result($row['address'] , $row['photo'], $row['rentalPrice'],$row['description']);
                        }
                    } else {
                        echo "No results found.";
                    }
                } else {
                    echo "Error executing the query: " . mysqli_error($db_connection);
                }
            }
            
            function display_search_by_all_without_price($db_connection, $numberOfBedrooms, $length, $area){
                $stmt = $db_connection->prepare("SELECT property.id, property.address, property.eircode, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property
                WHERE numOfBedrooms = ? 
                    AND lengthOfTenancy = ? 
                    AND eircode LIKE ?");
            
                $stmt->bind_param("sss", $numberOfBedrooms, $length, $area);
            
                $result = $stmt->execute();
            
                if ($result) {
                    $result_set = $stmt->get_result();
            
                    if ($result_set->num_rows > 0) {
                        while ($row = $result_set->fetch_assoc()) {
                            echo $row['rentalPrice'] . " " . $row['numOfBedrooms'] . " " . $row['lengthOfTenancy'] . " " . $row['eircode'] . "<br>";
                            display_result($row['address'] , $row['photo'], $row['rentalPrice'],$row['description']);
                        }
                    } else {
                        echo "No results found.";
                    }
                } else {
                    echo "Error executing the query: " . mysqli_error($db_connection);
                }
            }            

            function display_search_by_all_without_area_price($db_connection, $numberOfBedrooms, $length){
                $stmt = $db_connection->prepare("SELECT property.id, property.address, property.eircode, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property
                WHERE numOfBedrooms = ? 
                    AND lengthOfTenancy = ?");
            
                $stmt->bind_param("ss", $numberOfBedrooms, $length);
            
                $result = $stmt->execute();
            
                if ($result) {
                    $result_set = $stmt->get_result();
            
                    if ($result_set->num_rows > 0) {
                        while ($row = $result_set->fetch_assoc()) {
                            display_result($row['address'] , $row['photo'], $row['rentalPrice'],$row['description']);
                        }
                    } else {
                        echo "No results found.";
                    }
                } else {
                    echo "Error executing the query: " . mysqli_error($db_connection);
                }
            }     

            function display_search_by_all($db_connection, $priceStart, $priceEnd, $numberOfBedrooms, $length, $area){
                $stmt = $db_connection->prepare("SELECT property.id, property.address, property.eircode,property.lengthOfTenancy, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property
                WHERE rentalPrice BETWEEN ? AND ? 
                    AND numOfBedrooms = ? 
                    AND lengthOfTenancy = ? 
                    AND eircode LIKE ?");
            
                $stmt->bind_param("sssss", $priceStart, $priceEnd, $numberOfBedrooms, $length, $area);
            
                $result = $stmt->execute();
            
                if ($result) {
                    $result_set = $stmt->get_result();
            
                    if ($result_set->num_rows > 0) {
                        while ($row = $result_set->fetch_assoc()) {
                            //echo $row['rentalPrice'] . " " . $row['numOfBedrooms'] . " " . $row['lengthOfTenancy'] . " " . $row['eircode'] . "<br>";
                            display_result($row['address'] , $row['photo'], $row['rentalPrice'],$row['description']);                       
                        }
                    } else {
                        echo "No results found.!";
                    }
                } else {
                    echo "Error executing the query: " . mysqli_error($db_connection);
                }
            }

            function display_result($address, $photo, $rentalPrice, $description){
                    echo "
                        <div class='container-catalog' style='margin: 3rem'>
                            <p style='margin: 1rem;'>". $address."</p>
                                <div>
                                    <img src='". $photo."' class='img-size'>
                                        <div>
                                            <p style='margin: 1rem;'>". $rentalPrice . " - Apartment</p>
                                                <p style='margin: 1rem;'>". $description . "</p>
                                                <span ><a href='#' style='text-decoration: none;'><p style='text-align: right; margin: 1rem;' >More details &raquo;</p></a></span>                   
                                        </div>
                                </div>
                        </div>";
            }
            function display_search_by_all_start($db_connection, $priceEnd, $numberOfBedrooms, $length){
                $stmt = $db_connection->prepare("SELECT property.id, property.address, property.eircode, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property
                WHERE rentalPrice <= ?  
                    AND numOfBedrooms = ? 
                    AND lengthOfTenancy = ?");
            
                $stmt->bind_param("sss", $priceEnd, $numberOfBedrooms, $length);
            
                $result = $stmt->execute();
            
                if ($result) {
                    $result_set = $stmt->get_result();
            
                    if ($result_set->num_rows > 0) {
                        while ($row = $result_set->fetch_assoc()) {
                            //echo $row['rentalPrice'] . " " . $row['numOfBedrooms'] . " " . $row['lengthOfTenancy'] . " " . $row['eircode'] . "<br>";
                            display_result($row['address'] , $row['photo'], $row['rentalPrice'],$row['description']);
                        }
                    } else {
                        echo "No results found.";
                    }
                } else {
                    echo "Error executing the query: " . mysqli_error($db_connection);
                }
            }

            function display_search_by_all_end($db_connection, $priceStart, $numberOfBedrooms, $length){
                $stmt = $db_connection->prepare("SELECT property.id, property.address, property.eircode, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property
                WHERE rentalPrice >= ?  
                    AND numOfBedrooms = ? 
                    AND lengthOfTenancy = ?");
            
                $stmt->bind_param("sss", $priceStart, $numberOfBedrooms, $length);
            
                $result = $stmt->execute();
            
                if ($result) {
                    $result_set = $stmt->get_result();
            
                    if ($result_set->num_rows > 0) {
                        while ($row = $result_set->fetch_assoc()) {
                            //echo $row['rentalPrice'] . " " . $row['numOfBedrooms'] . " " . $row['lengthOfTenancy'] . " " . $row['eircode'] . "<br>";
                            display_result($row['address'] , $row['photo'], $row['rentalPrice'],$row['description']);
                        }
                    } else {
                        echo "No results found.";
                    }
                } else {
                    echo "Error executing the query: " . mysqli_error($db_connection);
                }
            }

            function display_search_by_all_withEndAndL($db_connection, $priceEnd, $numberOfBedrooms, $length, $area){
                $stmt = $db_connection->prepare("SELECT property.id, property.address, property.eircode, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property
                WHERE rentalPrice <= ? 
                AND numOfBedrooms = ? 
                AND lengthOfTenancy = ?
                AND eircode LIKE ?");
            
                $stmt->bind_param("ssss", $priceEnd, $numberOfBedrooms, $length, $area);
            
                $result = $stmt->execute();
            
                if ($result) {
                    $result_set = $stmt->get_result();
            
                    if ($result_set->num_rows > 0) {
                        while ($row = $result_set->fetch_assoc()) {
                            //echo $row['rentalPrice'] . " " . $row['numOfBedrooms'] . " " . $row['lengthOfTenancy'] . " " . $row['eircode'] . "<br>";
                            display_result($row['address'] , $row['photo'], $row['rentalPrice'],$row['description']);
                        }
                    } else {
                        echo "No results found.";
                    }
                } else {
                    echo "Error executing the query: " . mysqli_error($db_connection);
                }
            }

            function display_search_by_all_withStartAndL($db_connection, $priceStart, $numberOfBedrooms, $length, $area){
                $stmt = $db_connection->prepare("SELECT property.id, property.address, property.eircode, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property
                WHERE rentalPrice >= ? 
                AND numOfBedrooms = ? 
                AND lengthOfTenancy = ?
                AND eircode LIKE ?");
            
                $stmt->bind_param("ssss", $priceStart, $numberOfBedrooms, $length, $area);
            
                $result = $stmt->execute();
            
                if ($result) {
                    $result_set = $stmt->get_result();
            
                    if ($result_set->num_rows > 0) {
                        while ($row = $result_set->fetch_assoc()) {
                            //echo $row['rentalPrice'] . " " . $row['numOfBedrooms'] . " " . $row['lengthOfTenancy'] . " " . $row['eircode'] . "<br>";
                            display_result($row['address'] , $row['photo'], $row['rentalPrice'],$row['description']);
                        }
                    } else {
                        echo "No results found.";
                    }
                } else {
                    echo "Error executing the query: " . mysqli_error($db_connection);
                }
            }

            function length_validation($start, $end){
                if($end > $start){
                    $errors = 'Start of the price should be lower that end of the price';
                }
            }
            function display_all_available($db_connection){
                $stmt = "SELECT property.id, property.address, property.eircode, property.rentalPrice, property.description, property.numOfBedrooms, 
                (SELECT photo FROM property_photo WHERE property.id = property_photo.propertyId LIMIT 1) AS photo
                FROM property";


                 $result = $db_connection->query($stmt);

                if($result->num_rows > 0){
                    
                    while($row = $result->fetch_assoc()){
                        //echo $row['id'] . " " . $row['address'] . " " . $row['eircode'] . " " . $row['rentalPrice'] . " " . $row['numOfBedrooms']." " . $row['photo']."<br>"; // Corrected concatenation and added proper spacing
                        echo "
                            <div class='container-catalog' style='margin: 3rem'>
                                <p style='margin: 1rem;'>". $row['address']."</p>
                                <div>
                                    <img src='". $row['photo']."' class='img-size'>
                                    <div>
                                        <p style='margin: 1rem;'>". $row['rentalPrice'] . " - Apartment</p>
                                        <p style='margin: 1rem;'>". $row['description'] . "</p>
                                        <span ><a href='#' style='text-decoration: none;'><p style='text-align: right; margin: 1rem;' >More details &raquo;</p></a></span>                   
                                    </div>
                                </div>
                            </div>";

                    }
                }
            }
            ?>
    </div>
    </div>

    <footer>
        <div class="footer-container">
            <p class="text">&copy;2024 Letopia, Inc</p>
        </div>

        <div class="footer-container">
            <img src="additionalResources/footer-logo.png" alt="logo for footer" id="footer-logo">
        </div>

        <div class="footer-container">
            <p class="text">Contact us</p>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>    
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('search-form');
    const formContainer = document.getElementById('form-container');

    // Add an event listener for form submission
    if (searchForm) {
    searchForm.addEventListener('submit', function (event) {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Log a message to the console to check if the event listener is triggered
        console.log('Form submitted');

        // Scroll to the top of the form container
        if (formContainer) {
            formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Optionally, you can also focus on the first input field of the form
        const firstInput = searchForm.querySelector('input');
        if (firstInput) {
            firstInput.focus();
        }

        // Submit the form data asynchronously using AJAX if needed
        // Example: SubmitFormWithAjax();
    });
}

});
</script>
</body>
</html>
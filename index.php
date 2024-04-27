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

//dispaly_property_results();
function dispaly_property_results(){
    echo '
    <div class="container-catalog">
        <p>appartment1, Doderbank</p>
        <div >
            <img src="additionalResources\appartment1-slideshow.jpg" class="img-size">
            <div style=" width: 12rem;">
                <p>$355,000 - Appartment</p>
                <p>bespoke area dilighted to present this spacios one bed....</p><span id="more"><a href="#">More detailes &raquo;</a></span>
                
            </div>
        </div>
    </div>
    
    
    ';
}
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
            <form class="row g-3" action="POST">
                <div class="col-auto">
                <label for="staticEmail2" >Area (e.g. D08):</label>
                <input type="text" readonly class="form-control" id="staticEmail2" value="email@example.com">
                </div>
                <div class="col-auto" style="width: 10rem;">
                    <label for="inputPassword2" >Price Range:</label>
                    <div id="start-end"  style="display: flex; flex-direction: row;">
                    <div >
                        <input type="number" class="form-control" id="inputPassword2" placeholder="start" >
                    </div>
                    <div style="margin: 1%;">
                        <p>-</p> 
                    </div>  
                    <div >
                        <input type="number" class="form-control" id="inputPassword2" placeholder="end" >
                    </div> 
                    </div>
                </div>
                <div class="col-auto">
                    <label for="staticEmail2" >Number of bedrooms:</label>
                    <input type="text" readonly class="form-control" id="staticEmail2" value="email@example.com">
                </div>

                <div class="col-auto">
                    <label for="staticEmail2" >Length of tenancy:</label>
                    <input type="text" readonly class="form-control" id="staticEmail2" value="email@example.com">
                </div>
                <div class="col-auto">
                    <label for="optionType" class="font-weight-bold">Length of tenancy:</label>
                    <select id="optionType" name="optionType" class="form-control">
                        <option value="">1 week</option>
                        <option value="">2 weeks</option>
                        <option value="">1 month</option>
                        <option value="">2 months</option>
                        <option value="">3 months</option>
                        <option value="" selected></option>
                        <!-- <?php
                            $options = array("", "1 week", "2 weeks", "1 month", "2 months", "3 months");
                            foreach ($options as $option) 
                            {
                                $selected = ($options == $option) ? 'selected' : '';
                                echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                            }
                        ?> -->
                    </select>
                </div>
                <div class="form-group" id="btn-form">
                <button type="submit" class="btn btn-primary mb-3" >Search &#128269;</button>
                </div>
            </form>
        </div>
    </section>

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
</body>
</html>
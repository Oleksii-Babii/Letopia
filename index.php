<?php
echo 'hello world';

// dispaly_property_results();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>
<body >
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid" >
              <a href="#"><img src="additionalResources/logo.png" alt="logo image"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Testimonials</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Commercial
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Home</a></li>
                      <li><a class="dropdown-item" href="#">Features</a></li>
                      <li><a class="dropdown-item" href="#">Pricing</a></li>
                      <li><a class="dropdown-item" href="#">FAQs</a></li>
                      <li><a class="dropdown-item" href="#">About</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">Contact us</a>
                  </li>
                </ul>
                <div class="d-grid gap-2 d-md-block">
                    <button type="button" class="btn btn-warning">Log in</button>
                    <button type="button" class="btn btn-dark">Sign up</button>
                </div>
              </div>
            </div>
          </nav>
    </header>

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
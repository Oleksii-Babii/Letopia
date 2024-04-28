<?php
require_once ("session.php");
$authorized = '';

function generate_nav_links() {
  $nav_links = [];

  if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
      // admin links
      $nav_links = [
        ['link' => 'index.php', 'text' => 'Home'],
        ['link' => 'index_edit.php', 'text' => 'Edit Home'],
        ['link' => 'register_property.php', 'text' => 'Register Property'],
        ['link' => 'property_edit.php', 'text' => 'Property Edit'],
        ['link' => 'inventory_details.php', 'text' => 'Inventory'],
        ['link' => 'tenancies.php', 'text' => 'Tenancies'],
        ['link' => 'landlords.php', 'text' => 'Landlords'],
        ['link' => 'testimonial.php', 'text' => 'Testimonials'],
        ['link' => 'contact_us.php', 'text' => 'Contact Us'],
        ['link' => 'contact_us_manage.php', 'text' => 'Messages'],
        ['link' => 'logout.php', 'text' => 'Logout']
      ];
      GLOBAL $authorized;
      $authorized = true;
    } elseif($_SESSION['user']['role'] === 'landlord') {
      // landlord links
      $nav_links = [
        ['link' => 'index.php', 'text' => 'Home'],
        ['link' => 'register_property.php', 'text' => 'Register Property'],
        ['link' => 'property_edit.php', 'text' => 'Property Edit'],
        ['link' => 'inventory_details.php', 'text' => 'Inventory'],
        ['link' => 'landlord_account.php', 'text' => 'My Account'],
        ['link' => 'testimonial.php', 'text' => 'Testimonials'],
        ['link' => 'contact_us.php', 'text' => 'Contact Us'],
        ['link' => 'logout.php', 'text' => 'Logout']
      ]; 
      GLOBAL $authorized;
      $authorized = true;
    } else {
      // tenant links
      $nav_links = [
        ['link' => 'index.php', 'text' => 'Home'],
        ['link' => 'tenancy_account.php', 'text' => 'My Tenancy'],
        ['link' => 'testimonial.php', 'text' => 'Testimonials'],
        ['link' => 'contact_us.php', 'text' => 'Contact Us'],
        ['link' => 'logout.php', 'text' => 'Logout']
      ];
      GLOBAL $authorized;
      $authorized = true;
    }
  } else {
    // Public links
    $nav_links = [
      ['link' => 'index.php', 'text' => 'Home'],
      ['link' => 'testimonials.php', 'text' => 'Testimonials'],
      ['link' => 'contact_us.php', 'text' => 'Contact Us'],
    ];
    GLOBAL $authorized;
    $authorized = false;
  }

  return $nav_links;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>
<body >
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid" >
              <a href="index.php"><img src="additionalResources/logo.png" alt="logo image"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse ">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                  <?php foreach (generate_nav_links() as $link) { ?>
                    <li class="nav-item ">
                      <a class="nav-link" href="<?php echo $link['link']; ?>"><?php echo $link['text']; ?></a>
                    </li>
                  <?php } ?>
                  </ul>
                  <div class="d-grid gap-2 d-md-block">
                    <?php
                    GLOBAL $authorized;
                    if($authorized) {
                      $button = <<<BUTTON
                      <div class="d-grid gap-2 d-md-block">
                        <a href="logout.php">
                          <button type="button" class="btn btn-dark">Log out</button>
                        </a>
                      </div>
                    BUTTON;

                    echo $button;
                    } else {
                      $buttons = <<<BUTTONS
                      <div class="d-grid gap-2 d-md-block">
                          <a href="login.php">
                            <button type="button" class="btn btn-warning">Log in</button>
                          </a>

                          <a href="sign_up.php">
                            <button type="button" class="btn btn-dark">Sign up</button>
                          </a>
                      </div>
                      BUTTONS;
                      echo $buttons;
                    }
                    ?>
                  </div>
              </div>
            </div>
          </nav>
    </header>
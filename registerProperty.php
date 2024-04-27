<!DOCTYPE html>
<html lang="en">
	<head>
		 <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- connect bootstrap libraries -->
        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" media="screen">
        <title>Register Property</title>
        <link rel="stylesheet" href="style/style.css">
	</head>

    <body>
        <main class="main">
            <h2 class="text-center mt-3">Register Property</h2>
            <div class="container">
                <form id="propertyRegistrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-3" method="POST" novalidate>
                <div class="details">
                    <div id="propertyRegistration">
                        <h4>Property Details</h4>

                            <div class="form-group">
                                <label for="numberOfbed">Number of bedrooms:</label>
                                <select id="numberOfbedrooms" name="numberOfbedrooms" class="form-control" required>
                                    <option value=""<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '') echo ' selected="selected"'; ?>>Choose...</option>
                                    <option value="1"<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '1') echo ' selected="selected"'; ?>>1 bedroom</option>
                                    <option value="2"<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '2') echo ' selected="selected"'; ?>>2 bedrooms</option>
                                    <option value="3"<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '3') echo ' selected="selected"'; ?>>3 bedrooms</option>
                                    <option value="4"<?php if (isset($_POST['numberOfbedrooms']) && $_POST['numberOfbedrooms'] == '4') echo ' selected="selected"'; ?>>4 bedrooms</option>
                                </select>
                            </div>

                            <div class="form-group">Length of tenancy:</label>
                                <select id="lengthOfTenancy" name="lengthOfTenancy" class="form-control" required>
                                    <option value=""<?php if (isset($_POST['lengthOfTenancy']) && $_POST['lengthOfTenancy'] == '') echo ' selected="selected"'; ?>>Choose...</option>
                                    <option value="3"<?php if (isset($_POST['lengthOfTenancy']) && $_POST['lengthOfTenancy'] == '3') echo ' selected="selected"'; ?>>3-month</option>
                                    <option value="6"<?php if (isset($_POST['lengthOfTenancy']) && $_POST['lengthOfTenancy'] == '6') echo ' selected="selected"'; ?>>6-month</option>
                                    <option value="12"<?php if (isset($_POST['lengthOfTenancy']) && $_POST['lengthOfTenancy'] == '12') echo ' selected="selected"'; ?>>1 year</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description">Property Description</label>
                                <textarea id="propertyDescription" name="description" rows="3" cols="30" class="form-control"><?php if(isset($_POST['description'])) echo $_POST['description']; ?>
                                </textarea>
                            </div>
<form action="upload.php" method="post" enctype="multipart/form-data">
  <label for="images">Select multiple images:</label>
  <input type="file" id="images" name="images[]" accept="image/*" style="display: none;" onchange="previewAndManageImages(event)">
  <div id="preview"></div>
  <button type="button" onclick="document.getElementById('images').click();">Add More Images</button>
  <button type="submit">Upload</button>
</form>

<script>
function previewAndManageImages(event) {
  var preview = document.getElementById('preview');
  var files = event.target.files;

  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var reader = new FileReader();

    reader.onload = function(event) {
      var img = document.createElement('img');
      var removeButton = document.createElement('button');
      img.setAttribute('class', 'preview-image');
      img.src = event.target.result;
      removeButton.setAttribute('class', 'remove-button');
      removeButton.innerHTML = 'x';
      removeButton.onclick = function() {
        this.parentElement.remove();
      };
      var container = document.createElement('div');
      container.appendChild(removeButton);
      container.appendChild(img);
      preview.appendChild(container);
    }

    reader.readAsDataURL(file);
  }
}
</script>
                        </div>
                    </div>
                    <div id="buttons">
                        <a href="../Dashboard.html">
                            <button type="button" class="btn btn-outline-secondary" >Main Menu ☰</button>
                        </a>
                        <button id= "addButton" type="submit" class="btn btn-primary">Add to Inventory</button>
                    </div>

                </form>
            </div>
        </main>
    </body>
</html>
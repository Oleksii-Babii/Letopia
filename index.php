<?php
echo 'hello world';

dispaly_property_results();
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
        <!-- connect bootstrap libraries -->
        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" media="screen">
        <title>Login</title>
        <link rel="stylesheet" href="style/style.css">
	</head>

    <body>
		<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>
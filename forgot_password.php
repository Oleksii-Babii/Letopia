<?php 
require "session.php";
require ('templates/header.php');

?>
        <main id="forgotPassword">
            <div class="container"> 
                <div class="row">
                    <div class="col-md-4 mt-3 w-50" id="signUp">
                        <h2 class="text-center mt-2">Reset Password</h2>
                        <p class="text-center text-secondary">Confirm your email to reset your password.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST" novalidate>
                            <?php
                                if (!empty($errors)) {
                                    GLOBAL $noError;
                                    $noError = false;
                                    foreach ($errors as $error) {
                                        echo "<div class='alert alert-danger text-center mb-1 ml-1 mr-1' role='alert'>
                                        {$error}
                                    </div>";
                                    }
                                }
                             ?>

                            <div class="form-group">
                                <label for="emai;">Email</label>
                                <input type="text" id="email" name="email" class="form-control" placeholder ="example@domain.com" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                            </div>

                            <div class="form-group text-center mt-4">
                                <input type="submit" name="send" class="btn btn-primary w-25 " value="Send">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
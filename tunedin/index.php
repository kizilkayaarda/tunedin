<?php
    include_once "hf/header.php";
?>
    <!-- Login Form -->
    <form class="custom-form" action="includes/login.inc.php" method="post">
        <h1 class="display-1">TunedIn</h1>
        <?php
            // check if there is an error sent from login.inc.php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error === 'wronglogin'){
                    echo "<div class='alert alert-danger my-3' role='alert'>
                    Incorrect credentials</div>";
                } elseif ($error === 'emptyinput'){
                    echo "<div class='alert alert-danger my-3' role='alert'>
                    Please fill in all the required fields</div>";
                } elseif ($error === 'unauthorized'){
                    echo "<div class='alert alert-danger my-3' role='alert'>
                    Unauthorized access</div>";
                }
            }
        ?>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" id="credential" name="credential" class="form-control" placeholder="Email address or username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Log In" style="margin-top: 20px;">
        <a href="signup.php" class="badge badge-light" style="display: block; margin-top: 20px;">Sign Up Here!</a>
        <p class="mt-5 mb-3 text-muted">&copy;2020</p>
    </form>

<?php
    include_once "hf/footer.php";
?>
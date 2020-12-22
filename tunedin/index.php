<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Document</title>
</head>

<body class="text-center">

    <!-- Navbar for Login/ SignUp -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">TunedIn</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <!-- Login Form -->
    <form class="custom-form" action="includes/login.inc.php" method="post">
        <h1 class="display-1">TunedIn</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" id="credential" name="credential" class="form-control" placeholder="Email address or username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <?php
            // check if there is an error sent from login.inc.php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error === 'wronglogin'){
                    echo "<div class='alert alert-danger' role='alert'>
                    Incorrect credentials</div>";
                } elseif ($error === 'emptyinput'){
                    echo "<div class='alert alert-danger' role='alert'>
                    Please fill in all the required fields</div>";
                }
            }
        ?>
        <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Log In" style="margin-top: 20px;">
        <a href="signup.php" class="badge badge-light" style="display: block; margin-top: 20px;">Sign Up Here!</a>
        <p class="mt-5 mb-3 text-muted">&copy;2020</p>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
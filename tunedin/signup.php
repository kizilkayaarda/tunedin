<?php
    include_once "hf/header.php";
?>

    <!-- SignUp Form -->
    <form class="custom-form" action="includes/signup.inc.php" method="post">
        <h1 class="display-1">TunedIn</h1>

        <!-- Row for name & username inputs -->
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="name">Full name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Full name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
        </div>

        <!-- Row for email & user type inputs -->
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="col-md-6 mb-3">
                <label for="userType">I'm a/an</label>
                <select class="custom-select" id="userType" name="userType">
                    <option selected disabled value="">Choose...</option>
                    <option value="Artist">Artist</option>
                    <option value="Regular">Standard User</option>
                </select>
            </div>
        </div>

        <!-- Row for password inputs -->
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="col-md-6 mb-3">
                <label for="repeatPassword">Repeat password</label>
                <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat password">
            </div>
        </div>
        <?php
            // if any error messages are sent from signup.inc.php, notify the user
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
    
                if ($error === 'emptyinput') {
                    echo "<div class='alert alert-danger' role='alert'>
                    Please fill in all the required fields.</div>";
                } elseif ($error === 'invalidemail') {
                    echo "<div class='alert alert-danger' role='alert'>
                    Invalid email</div>";
                } elseif ($error === 'passworderror') {
                    echo "<div class='alert alert-danger' role='alert'>
                    Passwords don't match</div>";
                } elseif ($error === 'stmtfailed') {
                    echo "<div class='alert alert-danger' role='alert'>
                    Something went wrong, please try again.</div>";
                } elseif ($error === 'usernametaken') {
                    echo "<div class='alert alert-danger' role='alert'>
                    Username already taken.</div>";
                }
              
            }
        ?>
        <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
    </form>

<?php
    include_once "hf/footer.php";
?>
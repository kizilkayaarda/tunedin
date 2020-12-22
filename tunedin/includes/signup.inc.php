<?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $userType = $_POST['userType'];
        $pwd = $_POST['password'];
        $pwdRepeat = $_POST['repeatPassword'];

        require_once "dbh.inc.php";
        require_once "functions.inc.php";

        if (emptyInputSignUp($name, $email, $username, $userType, $pwd, $pwdRepeat)) {
            header('Location: ../signup.php?error=emptyinput');
            exit();
        }
        if (invalidEmail($email)) {
            header('Location: ../signup.php?error=invalidemail');
            exit();
        }  
        if (pwdMatch($pwd, $pwdRepeat)) {
            header('Location: ../signup.php?error=passworderror');
            exit();
        }
        if (usernameExists($conn, $username, $email)) {
            header('Location: ../signup.php?error=usernametaken');
            exit();
        }

        createUser($conn, $name, $email, $username, $userType, $pwd);
    } else {
        header('Location: ../signup.php');
    }
?>
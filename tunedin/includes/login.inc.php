<?php

    if (isset($_POST['submit'])) {
        $username = $_POST['credential'];
        $pwd = $_POST['password'];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if (emptyInputLogin($username, $pwd)) {
            header("location: ../index.php?error=emptyinput");
            exit();
        } 

        loginUser($conn, $username, $pwd);
    } else {
        header("location: ../index.php");
        exit();
    }
?>
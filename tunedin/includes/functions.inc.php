<?php
    // utility functions for login/signup

    // check whether any input field is left blank
    function emptyInputSignUp($name, $email, $username, $userType, $password, $repeatPassword) {
        return (empty($name) || empty($email) || empty($username) || empty($userType) || empty($password) || empty($repeatPassword));
    }

    function emptyInputLogin($username, $pwd) {
        return (empty($username) || empty($pwd));
    }

    // check if the email being provided is valid
    function invalidEmail($email) {
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }  

    // check the passwords against each other
    function pwdMatch($password, $repeatPassword) {
        return $password !== $repeatPassword;
    }

    // check if the username or email already exists before signup
    function usernameExists($conn, $username, $email) {
        $sql = "SELECT * FROM Users WHERE username=? OR email=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../signup.php?error=stmtfailed');
            exit();
        } 

        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        } else {
            return false;
        }
    }

    // get the user type by using the username 
    function getUserType($conn, $username) {

        $sql = "SELECT * FROM Artist WHERE artist_username=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../signup.php?error=stmtfailed');
            exit();
        } 

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            return "Artist";
        } else {
            return "Standard User";
        }
    }

    // add user to system
    function createUser($conn, $name, $email, $username, $userType, $pwd) {
        $sql = "INSERT INTO Users(username, name, email, password) 
                VALUES(?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../signup.php?error=stmtfailed');
            exit();
        } 

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssss", $username, $name, $email, $hashedPwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($userType === "Artist") {
            $sql = "INSERT INTO Artist(artist_username) VALUES(?);";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header('Location: ../signup.php?error=stmtfailed');
                exit();
            } 
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        header('Location: ../index.php?error=none');
        exit();
    }

    // login the user
    function loginUser($conn, $username, $pwd) {
        $usernameExists = usernameExists($conn, $username, $username);

        if (!$usernameExists) {
            header('Location: ../index.php?error=wronglogin');
            exit();
        } 

        $pwdHashed = $usernameExists["password"];
        $checkPwd = password_verify($pwd, $pwdHashed);

        if (!$checkPwd) {
            header('Location: ../index.php?error=wronglogin');
            exit();
        } else {
            session_start();
            $_SESSION['username'] = $usernameExists["username"];
            $_SESSION['userType'] = getUserType($conn, $usernameExists["username"]);
            
            // redirect to respective pages
            if ($_SESSION['userType'] === "Artist") {
                header("location: ../artist_homepage.php");
            } else {
                header("location: ../regular_homepage.php");
            }
            //header("location: ../index.php?error=none");
            exit();
        }
    }
?>
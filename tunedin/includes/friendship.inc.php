<?php
    if (isset($_GET['action'])) {

        require_once "dbh.inc.php";

        $action = $_GET['action'];
        $src = $_GET['src'];
        $dst = $_GET['dst'];

        if ($action === "send") {
            
            $sql = "INSERT INTO Friend(requesting_username, requested_username, request_date, is_accepted)
                    VALUES('$src', '$dst', NOW(), 0);";

            mysqli_query($conn, $sql);
            header("location: ../user_profile.php?username=$dst");
            exit();
        } elseif ($action === "cancel") {

            $sql = "DELETE FROM Friend WHERE requesting_username='$src' AND requested_username='$dst';";

            mysqli_query($conn, $sql);
            header("location: ../user_profile.php?username=$dst");
            exit();
        } elseif ($action === "accept") {

            $sql = "UPDATE Friend SET is_accepted=1 WHERE requesting_username='$src' AND requested_username='$dst' ;";

            mysqli_query($conn, $sql);
            header("location: ../user_profile.php?username=$src");
            exit();
        } elseif ($action === "reject") {

            $sql = "DELETE FROM Friend WHERE requesting_username='$src' AND requested_username='$dst';";

            mysqli_query($conn, $sql);
            header("location: ../user_profile.php?username=$src");
            exit();
        }
        $sql = "DELETE FROM Friend WHERE (requesting_username='$src' AND requested_username='$dst') OR (requesting_username='$dst' AND requested_username='$src');";

        mysqli_query($conn, $sql);
        
        if ($src !== $_SESSION['username']) {
            header("location: ../user_profile.php?username=$src");
        } else {
            header("location: ../user_profile.php?username=$dst");
        }
        exit();
    }
?>
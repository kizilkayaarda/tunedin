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

    function isFriend($conn, $curUsername, $otherUsername) {
        $sql = "SELECT * FROM Friend WHERE (requesting_username=? AND requested_username=?) OR (requesting_username=? AND requested_username=?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../regular_search.php?error=stmtfailed');
            exit();
        } 

        mysqli_stmt_bind_param($stmt, "ssss", $curUsername, $otherUsername, $otherUsername, $curUsername);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($resultData);
        mysqli_stmt_close($stmt);

        if ($numRows === 0) {
            return -1;
        } else {
            $row = mysqli_fetch_assoc($resultData);
            return $row;
        }
    }

    function getProfileButton($conn, $curUsername, $userUsername) {

        $result = isFriend($conn, $curUsername, $userUsername);
        
        if ($result === -1) {
            return "<a href='includes/friendship.inc.php?src=$curUsername&dst=$userUsername&action=send' class='btn btn-primary'>Add Friend</a>";
        }
        $status = $result['is_accepted'];
        $src = $result['requesting_username'];

        if ($status === 0) {
            if ($src === $curUsername) {
                return "<a href='includes/friendship.inc.php?src=$curUsername&dst=$userUsername&action=cancel' class='btn btn-warning'>Cancel Request</a>";
            }
            return "<a href='includes/friendship.inc.php?src=$userUsername&dst=$curUsername&action=accept' class='btn btn-success'>Accept Request</a>
                    <a href='includes/friendship.inc.php?src=$userUsername&dst=$curUsername&action=reject' class='btn btn-danger'>Reject Request</a>";
        }
        return "<a href='includes/friendship.inc.php?src=$userUsername&dst=$curUsername&action=delete' class='btn btn-danger'>Delete Friend</a>";
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
                header("location: ../regular_feed.php");
            }
            //header("location: ../index.php?error=none");
            exit();
        }
    }

    // utility functions for uploading a song
    function uploadSong($conn, $name, $price, $length, $genre, $score, $releaseDate, $coverImage, $artistUsername) {
        $sql = "INSERT INTO `musicobject`(`name`, `price`, `length`, `score`, 
                `release_date`, `cover_img`, `artist_username`) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../artist_upload_song.php?error=stmtfailed');
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $price, $length, $score, $releaseDate, $coverImage, $artistUsername);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $newSongID = mysqli_insert_id($conn);
        $sql = "INSERT INTO `musicobjectgenre`(`music_object_id`, `genre_name`) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../artist_upload_song.php?error=stmtfailed');
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "is", $newSongID, $genre);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $newSongID;
    }

    function uploadAlbum($conn, $albumName, $albumCoverImg, $artistUsername) {
        $sql = "INSERT INTO `musicobject`(`name`, `cover_img`, `artist_username`) 
                VALUES (?, ?, ?)";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../artist_upload_album.php?error=stmtfailed');
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "sss", $albumName, $albumCoverImg, $artistUsername);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        $newAlbumID = mysqli_insert_id($conn);
        $sql = "INSERT INTO `album`(`album_id`) VALUES (?)";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../artist_upload_album.php?error=stmtfailed');
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "i", $newAlbumID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $newAlbumID;
    }


    // utility functions for uploading a song
    function uploadSongToAlbum($conn, $albumID, $order, $name, $price, $length, $genre, $score, $releaseDate, $coverImage, $artistUsername) {
        $sql = "INSERT INTO `musicobject`(`name`, `price`, `length`, `score`, 
                `release_date`, `cover_img`, `artist_username`) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../artist_upload_album.php?error=stmtfailed');
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $price, $length, $score, $releaseDate, $coverImage, $artistUsername);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $newSongID = mysqli_insert_id($conn);
        $sql = "INSERT INTO `musicobjectgenre`(`music_object_id`, `genre_name`) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../artist_upload_album.php?error=stmtfailed');
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "is", $newSongID, $genre);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $sql = "INSERT INTO `song`(`song_id`, `album_id`, `number`) 
                VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../artist_upload_album.php?error=stmtfailed');
            exit();
        } 
        mysqli_stmt_bind_param($stmt, "iii", $newSongID, $albumID, $order);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $newSongID;
    }
?>
<?php

    if (isset($_POST['submit'])) {
        session_start();
        $name = $_POST['name'];
        $price = $_POST['price'];
        $length = $_POST['length'];
        $genre = $_POST['genre'];
        $score = $_POST['score'];
        $releaseDate = $_POST['releaseDate'];
        $coverImage = $_POST['coverImage'];
        $artistUsername = $_SESSION['username'];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        uploadSong($conn, $name, $price, $length, $genre, $score, $releaseDate, $coverImage, $artistUsername);
        header('Location: ../artist_homepage.php?error=none');
        exit();
    } else {
        header("location: ../artist_homepage.php");
        exit();
    }
?>
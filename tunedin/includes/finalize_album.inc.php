<?php
session_start();
$artistUsername = $_SESSION['username'];
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$albumOrder = explode(",",$_POST['order']);
if(!isset($_COOKIE["data"])) {
    $songs = json_decode("{}", true);
}
else {
    $data = json_decode($_COOKIE["data"], true);
}

// Create an album
$album = $data["album"];
$albumName = $album['name'];
$albumCoverImg = $album['cover_img'];
$newAlbumID = uploadAlbum($conn, $albumName, $albumCoverImg, $artistUsername);

foreach ($albumOrder as $value) {
    // echo $value . "<br>";
    // Get song params
    $song = $data["songs"][$value];
    echo $song;
    $name = $song['name'];
    $price = $song['price'];
    $length = $song['length'];
    $genre = $song['genre_name'];
    $score = $song['score'];
    $releaseDate = $song['release_date'];
    $coverImage = $song['cover_img'];
    // Create song and add it to album
    $newSongID = uploadSongToAlbum($conn, $newAlbumID, $value, $name, $price, $length, $genre, $score, $releaseDate, $coverImage, $artistUsername);
}
echo json_encode($data["songs"]);
?>
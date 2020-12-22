<?php
    // handle database connection
    $serverName = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'tunedin';

    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

    if (!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }
?>
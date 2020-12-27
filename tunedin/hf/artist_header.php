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
    <!-- Required for tables & ordering -->
    <link href="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/1.0.3/jquery.tablednd.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js"></script>
    
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">TunedIn</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="artist_homepage.php">My Music <span class="sr-only">(current)</span></a>
                </li>

                <!-- Content Dropdpwn -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="contentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Content
                    </a>
                    <div class="dropdown-menu" aria-labelledby="contentDropdown">
                        <a class="dropdown-item" href="artist_upload_song.php">Upload Song</a>
                        <a class="dropdown-item" href="artist_upload_album.php">Upload Album</a>
                    </div>
                </li>

                <!-- Account dropdpwn -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="accountDropdown">
                        <a class="dropdown-item" href="artist_profile.php">Manage Account</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="includes/logout.inc.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
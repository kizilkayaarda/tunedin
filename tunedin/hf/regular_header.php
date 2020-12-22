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
                
                <!-- Social Dropdpwn -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="libraryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Social
                    </a>
                    <div class="dropdown-menu" aria-labelledby="libraryDropdown">
                        <a class="dropdown-item" href="regular_feed.php">Feed</a>
                        <a class="dropdown-item" href="regular_friends.php">Friends</a>
                    </div>
                </li>

                <!-- Library Dropdpwn -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="libraryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Library
                    </a>
                    <div class="dropdown-menu" aria-labelledby="libraryDropdown">
                        <a class="dropdown-item" href="regular_recently_added.php">Recently Added</a>
                        <a class="dropdown-item" href="regular_artists.php">Artists</a>
                        <a class="dropdown-item" href="regular_albums.php">Albums</a>
                        <a class="dropdown-item" href="regular_songs.php">Songs</a>
                    </div>
                </li>

                <!-- Playlist dropdpwn -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="playlistDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Playlists
                    </a>
                    <div class="dropdown-menu" aria-labelledby="playlistDropdown">
                        <a class="dropdown-item" href="regular_new_playlist.php">Create New</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="regular_playlists.php">See all</a>
                    </div>
                </li>

                <!-- Account dropdpwn -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="accountDropdown">
                        <a class="dropdown-item" href="regular_profile.php">Manage Account</a>
                        <a class="dropdown-item" href="regular_balance.php">Balance</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="includes/logout.inc.php">Logout</a>
                    </div>
                </li>
            </ul>

            <form class="form-inline my-2 my-lg-0" action="regular_search.php" method="post">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
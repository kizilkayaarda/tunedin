<?php
    include_once "hf/regular_header.php";
?>
    
    <?php
        if (isset($_POST['search']) && isset($_POST['submit']) && strlen(trim($_POST['search'])) != 0) {

            $query = $_POST['search'];
            $username = $_SESSION['username'];

            require_once "includes/dbh.inc.php";
            require_once "includes/functions.inc.php";

            // search users
            echo "<h1>Users</h1>";
            echo "<hr>";

            $userSearch = "SELECT name, username, profile_pic 
                            FROM users WHERE (username LIKE '%$query%' OR name LIKE '%$query%')
                            AND username NOT IN (SELECT artist_username AS username FROM Artist) AND username <> '$username';";

            $userResults = mysqli_query($conn, $userSearch);

            if (mysqli_num_rows($userResults) === 0) {
                echo "<p>No users found for '$query'</p>";
            } else {

                echo "<div class='card-deck'>";

                while ($row = mysqli_fetch_assoc($userResults)) {

                    echo "<div class='card' style='width: 18rem;'>
                            <img src='".$row['profile_pic']."' class='card-img-top'>
                            <div class='card-body'>
                                <h5 class='card-title'>".$row['name']."</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>".$row['username']."</h6>
                                <a href='user_profile.php?username=".$row['username']."' class='btn btn-primary'>See profile</a>
                            </div>
                        </div>";
                }
                echo "</div>";
            }

            echo "<h1>Artists</h1>";
            echo "<hr>";

            $artistSearch = "SELECT name, username, profile_pic 
                            FROM Users JOIN Artist ON Users.username=Artist.artist_username
                            WHERE username LIKE '%$query%' OR name LIKE '%$query%';";

            $artistResults = mysqli_query($conn, $artistSearch);

            if (mysqli_num_rows($artistResults) === 0) {
                echo "<p>No artists found for '$query'</p>";
            } else {
                echo "<div class='card-deck'>";

                while ($row = mysqli_fetch_assoc($artistResults)) {

                    echo "<div class='card' style='width: 18rem;'>
                            <img src='".$row['profile_pic']."' class='card-img-top'>
                            <div class='card-body'>
                                <h5 class='card-title'>".$row['name']."</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>".$row['username']."</h6>
                                <a href='artist_profile_view.php?username=".$row['username'].".' class='btn btn-primary'>See profile</a>
                            </div>
                        </div>";
                }
                echo "</div>";
            }

            echo "<h1>Albums</h1>";
            echo "<hr>";

            $albumSearch = "SELECT name, artist_username, music_object_id, cover_img
                            FROM MusicObject 
                            WHERE name LIKE '%$query%' AND music_object_id IN (SELECT album_id AS music_object_id FROM Album);";

            $albumResults = mysqli_query($conn, $albumSearch);

            if (mysqli_num_rows($albumResults) === 0) {
                echo "<p>No albums found for '$query'</p>";
            } else {
                echo "<div class='card-deck'>";

                while ($row = mysqli_fetch_assoc($albumResults)) {

                    echo "<div class='card' style='width: 18rem;'>
                            <img src='".$row['cover_img']."' class='card-img-top'>
                            <div class='card-body'>
                                <h5 class='card-title'>".$row['name']."</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>".$row['artist_username']."</h6>
                                <a href='album_profile.php/album_id=".$row['music_object_id'].".' class='btn btn-primary'>See profile</a>
                            </div>
                        </div>";
                }
                echo "</div>";
            }

            echo "<h1>Songs</h1>";
            echo "<hr>";

            $songSearch = "SELECT name, artist_username, music_object_id, cover_img
                            FROM MusicObject 
                            WHERE name LIKE '%$query%' AND music_object_id IN (SELECT song_id AS music_object_id FROM Song);";


            $songResults = mysqli_query($conn, $songSearch);

            if (mysqli_num_rows($songResults) === 0) {
                echo "<p>No songs found for '$query'</p>";
            } else {
                echo "<div class='card-deck'>";

                while ($row = mysqli_fetch_assoc($songResults)) {

                    echo "<div class='card' style='width: 18rem;'>
                            <img src='".$row['cover_img']."' class='card-img-top'>
                            <div class='card-body'>
                                <h5 class='card-title'>".$row['name']."</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>".$row['artist_username']."</h6>
                                <a href='song_profile.php/song_id=".$row['music_object_id'].".' class='btn btn-primary'>See profile</a>
                            </div>
                        </div>";
                }
                echo "</div>";
            }
        } else {
            header("location: regular_recently_added.php/error=invalidaccess");
        }
    ?>

<?php
    include_once "hf/regular_footer.php";
?>
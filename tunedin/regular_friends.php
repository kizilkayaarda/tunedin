<?php
    include_once "hf/regular_header.php";
?>
    
    <!-- everything goes between includes -->
    <!-- Test if the session works -->
    <?php
        $username = $_SESSION['username'];
        require_once "includes/dbh.inc.php";

        // friends section
        echo "<h1>Friends</h1>";
        echo "<hr>";

        $friends = "SELECT username, name, profile_pic
                    FROM Users 
                    WHERE username IN (SELECT requesting_username AS username FROM Friend WHERE requested_username='$username' AND is_accepted=1
                                        UNION
                                        SELECT requested_username AS username FROM Friend WHERE requesting_username='$username' AND is_accepted=1);";
                                    
        $friendsResult = mysqli_query($conn, $friends);

        if (mysqli_num_rows($friendsResult) !== 0) {

            echo "<div class='card-deck'>";

                while ($row = mysqli_fetch_assoc($friendsResult)) {

                    echo "<div class='card' style='width: 18rem;'>
                            <img src='user.png' class='card-img-top'>
                            <div class='card-body'>
                                <h5 class='card-title'>".$row['name']."</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>".$row['username']."</h6>
                                <a href='user_profile.php?username=".$row['username']."' class='btn btn-primary'>See profile</a>
                            </div>
                        </div>";
                }
                echo "</div>";

        } else {
            echo "<p>You don't have any friends :(</p>";
        }

        // friend requests section
        echo "<h1>Friend Requests</h1>";
        echo "<hr>";

        $requests = "SELECT username, name, profile_pic
                    FROM Users
                    WHERE username IN (SELECT requesting_username AS username FROM Friend WHERE requested_username='$username' AND is_accepted=0);";

        $requestsResult = mysqli_query($conn, $requests);

        if (mysqli_num_rows($requestsResult) !== 0) {

            echo "<div class='card-deck'>";

                while ($row = mysqli_fetch_assoc($requestsResult)) {

                    echo "<div class='card' style='width: 18rem;'>
                            <img src='user.png' class='card-img-top'>
                            <div class='card-body'>
                                <h5 class='card-title'>".$row['name']."</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>".$row['username']."</h6>
                                <a href='user_profile.php?username=".$row['username'].".' class='btn btn-primary'>See profile</a>
                                <a href='includes/friendship.inc.php?src=".$row['username']."&dst=".$username."&action=accept' class='btn btn-success'>Accept request</a>
                                <a href='includes/friendship.inc.php?src=".$row['username']."&dst=".$username."&action=reject' class='btn btn-danger'>Reject request</a>
                            </div>
                        </div>";
                }
                echo "</div>";

        } else {
            echo "<p>You don't have any friend requests</p>";
        }
    ?>

<?php
    include_once "hf/regular_footer.php";
?>
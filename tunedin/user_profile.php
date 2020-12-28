<?php
    include_once "hf/regular_header.php";
?>
    
    <?php
        //echo $_SESSION['username'];
        if (isset($_GET['username'])) {
            $curUsername = $_SESSION['username'];
            $userUsername = $_GET['username'];

            require_once "includes/dbh.inc.php";
            require_once "includes/functions.inc.php";

            $sql = "SELECT * FROM Users WHERE username='$userUsername';";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            
            echo "<div class='card' style='width: 18rem;'>
                <img src='".$row['profile_pic']."' class='card-img-top'>
                <div class='card-body'>
                    <h5 class='card-title'>".$row['name']."</h5>
                    <h6 class='card-subtitle mb-2 text-muted'>".$row['username']."</h6>".getProfileButton($conn, $curUsername, $userUsername)."
                </div>
            </div>";
        }
    ?>

<?php
    include_once "hf/regular_footer.php";
?>
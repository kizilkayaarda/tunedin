<?php
    include_once "hf/artist_header.php";
    if (!isset($_SESSION["username"])) {
        header("location: index.php?error=unauthorized");
        exit();
    }
    if (!isset($_SESSION["userType"]) || ($_SESSION["userType"] != "Artist")){
        header("location: index.php?error=unauthorized");
        exit();
    }
?>
<?php
    include_once "hf/artist_footer.php";
?>
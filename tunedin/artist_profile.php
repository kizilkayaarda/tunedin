<?php
    include_once "hf/artist_header.php";
?>
    <!-- everything goes between includes -->
    <!-- Test if the session works -->
    <?php
        echo $_SESSION['username'];
        echo $_SESSION['userType'];
    ?>
<?php
    include_once "hf/artist_footer.php";
?>
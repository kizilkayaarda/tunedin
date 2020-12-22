<?php
    include_once "hf/regular_header.php";
?>
    
    <!-- everything goes between includes -->
    <!-- Test if the session works -->
    <?php
        echo $_SESSION['username'];
        echo $_SESSION['userType'];
    ?>

<?php
    include_once "hf/regular_footer.php";
?>
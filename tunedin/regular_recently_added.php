<?php
    include_once "hf/regular_header.php";
?>

 <?php

	require('includes/dbh.inc.php');

	$username = $_SESSION['username'];
	//retrieve last 5 songs bought
	$sql = "SELECT * FROM Buys, Song, musicobject where Buys.username='$username' and buys.music_object_id=musicobject.music_object_id and song.song_id=musicobject.music_object_id ORDER BY buys.date DESC LIMIT 5";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		echo '<script type="text/javascript">alert("Could not get the last 5 songs you bought!");</script>';
		echo "Error while processing the query " . $mysqli->error;
	}
	else {
		$songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
	}

	$sql = "SELECT * FROM Buys, Album, musicobject where Buys.username='$username' and buys.music_object_id=musicobject.music_object_id and Album.album_id=musicobject.music_object_id ORDER BY Buys.date DESC LIMIT 5";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		echo '<script type="text/javascript">alert("Could not get the last 5 albums you bought!");</script>';
		echo "Error while processing the query " . mysqli_connect_error();
	}
	else {
		$albums = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
	}

?>

<!DOCTYPE html>
<html>

	

	<div class="container">
	  	<div class="row">
	    <div class="col">
	    	<h4>Recently added songs</h4>
	    	<?php if (!$songs) { ?>
				<p>You have not bought a single song yet!</p>
			<?php } ?>
			
				<div class="list-group">
				<?php foreach($songs as $song) { ?>
				  <img src="song.jpg" class="img-thumbnail">
				  <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
				    <?php echo htmlspecialchars($song['name']) . ' by ' .  htmlspecialchars($song['artist_username']) ?>
				  </a>
				<?php } ?>
				</div>
	    </div>
	    <div class="col">
	    	<h4>Recently added albums</h4>
	    	<?php if (!$albums) { ?>
				<p>You have not bought a single album yet!</p>
			<?php } ?>
			
				<div class="list-group">
				<?php foreach($albums as $album) { ?>
				<img src="album.jpg" class="img-thumbnail">
				  <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
				    <?php echo htmlspecialchars($album['name']) ?>
				  </a>
				<?php } ?>
				</div>
	    </div>
	</div>
	

</html>


<?php
    include_once "hf/regular_footer.php";
?>

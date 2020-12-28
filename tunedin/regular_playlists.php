<?php
    include_once "hf/regular_header.php";
?>
    
<?php 
	
	require('includes/dbh.inc.php');
	//session_start();

	$username = $_SESSION['username'];
	//$username = 'akkurt';

	$query = "SELECT * FROM playlist NATURAL JOIN playlistGenre WHERE playlist.username = '$username'";

	$genres_with_playlist = array();
	$result = mysqli_query($conn, $query);
	
	if (!$result) {
		echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
		echo "Error while processing the query" . mysqli_connect_error();
		
	}
	else {
		$playlists = mysqli_fetch_all($result, MYSQLI_ASSOC);
		//$genres = array();
		//echo "Playlists" . print_r($playlists);

		foreach ($playlists as $playlist) {
			$current_genre = $playlist['genre_name'];
			//echo "Current genre" . $current_genre;
			if (array_key_exists($current_genre, $genres_with_playlist)) {
				array_push($genres_with_playlist[$current_genre], array($playlist['name'], $playlist['playlist_id']));
				//array_push($genres_with_playlist[$current_genre], $playlist['name'], $playlist['playlist_id']);
			}
			else {
				$genres_with_playlist[$current_genre] = array();
				array_push($genres_with_playlist[$current_genre], array($playlist['name'], $playlist['playlist_id']));
				//array_push($genres, $current_genre);
				//array_push($genres_with_playlist[$current_genre], $playlist['name'], $playlist['playlist_id']);
			}
		}
		//echo "adsad" . print_r($genres_with_playlist);

		mysqli_free_result($result);
	}
	//print_r($genres_with_playlist);
?>


<!DOCTYPE html>
<html>

	<h4 class="center grey-text">Your Playlists</h4>
	<?php if (count($genres_with_playlist) == 0) { ?>
		<div class="card">
		<h6>You do not have any playlist!</h6>
		</div>
	<?php } ?>

	<div id="accordion">
	<?php foreach ($genres_with_playlist as $genre) : ?>
	  <div class="card">
	    <div class="card-header" id="headingOne">
	      <h5 class="mb-0">
	        <div >
	          <?php echo htmlspecialchars(key($genres_with_playlist)); ?>
	        </div>
	      </h5>
	    </div>
	    <?php foreach ($genre as $playlist) : ?>
	    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
	      <div class="card-body">
	      	<a href="regular_playlist_detail.php?playlist_id=<?php echo $playlist[1]; ?>">
	  		<?php echo htmlspecialchars($playlist[0]) ?>
	      	</a>
	      </div>
	    </div>
	    <?php endforeach; ?>
	  </div>
	  <?php next($genres_with_playlist); ?>
	  <?php endforeach; ?>
	 </div>

	 <div class="center">
	 	<form action="regular_new_playlist.php" method="GET">
    		<button type="submit" class="btn btn-success">Create Playlist</button>
		</form>
	 </div>

</html>

<?php
    include_once "hf/regular_footer.php";
?>
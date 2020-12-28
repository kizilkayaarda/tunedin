<?php
    include_once "hf/regular_header.php";
?>

<?php 
	
	require('includes/dbh.inc.php');
	//session_start();
	$username = $_SESSION['username'];
	//$no_playlist = false;

	$songs = null;
	$other_songs = null;

	if (isset($_POST['remove'])) {
		
		$playlist_id = intval($_POST['playlist-id']);
		$song_id = intval($_POST['song-id']);

		
		$sql = "DELETE FROM playlistsong WHERE song_id='$song_id' and playlist_id='$playlist_id'";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Could not remove the song from the playlist!");</script>';
			echo "Error while processing the query" . mysqli_connect_error();
			
		}
		$_GET['playlist_id'] = $playlist_id;
	}

	if (isset($_POST['add'])) {
		
		$playlist_id = intval($_POST['playlist-id']);
		$song_id = intval($_POST['song-id']);

		//echo "playlist id before insert: " . $playlist_id . " song id: " . $song_id . "....";
		$sql = "INSERT INTO playlistsong VALUES ('$playlist_id', '$song_id', curdate())";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Could not add the song to the playlist!");</script>';
			echo "Error while processing the query" . mysqli_error($conn);
			echo "SONG COULD NOT ADDED TO THE PLAYLIST!";
			
		}	
		$_GET['playlist_id'] = $playlist_id;
	}

	if (isset($_GET['playlist_id'])) {

		$playlist_id = intval($_GET['playlist_id']);
		//echo "PLAYLIST ID IS: " . $playlist_id . " BEFORE THE QUERY\n";
		//echo "PLAYLIST ID" . $playlist_id;
		$sql = "SELECT song.song_id as song_id, playlist.name as playlist_name, musicobject.name as song_name, musicobject.length, musicobject.release_date, musicobject.artist_username FROM playlistsong, Song, musicobject, playlist WHERE playlistsong.playlist_id='$playlist_id' and playlistsong.song_id=song.song_id and musicobject.music_object_id=song.song_id and playlist.playlist_id=playlistsong.playlist_id;";

		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Could not load the songs in the playlist!");</script>';
			echo "Error while processing the query" . mysqli_error($conn);
		}
		else {
			$songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
		}
		//echo "SONGS" . print_r($songs);

		$sql = "SELECT song.song_id as song_id, musicobject.name as song_name, musicobject.length, musicobject.release_date, musicobject.artist_username FROM Song, musicobject, buys WHERE musicobject.music_object_id=song.song_id and buys.music_object_id=song.song_id and buys.username='$username' and song.song_id not in (SELECT playlistsong.song_id from playlistsong WHERE playlist_id=$playlist_id);";

		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Could not load the songs you bought!");</script>';
			echo "Error while processing the query" . mysqli_error($conn);
		}
		else {
			$other_songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
		}
	}


?>


<!DOCTYPE html>
<html>


	<?php if (!$songs) { ?>
	<div class="alert alert-danger" role="alert">
 	 <strong>Well...</strong>There is either no playlist with the given id or there are no songs in this playlist.
	</div>
	<?php } ?>



	<?php if ($songs) { ?>
	<h3>Songs in <?php echo $songs[0]['playlist_name']; ?></h3>
		<table class="table">
		<thead>
	    <tr>	
	      <th scope="col">Name</th>
	      <th scope="col">Artist</th>
	      <th scope="col">Length</th>
	      <th scope="col">Release Date</th>
	      <th scope="col">Remove from Playlist</th>
	    </tr>
	  	</thead>
	 	<tbody>
		<?php foreach($songs as $song) { ?>
		<tr>
			<td><?php echo htmlspecialchars($song['song_name']); ?></td>
			<td><?php echo htmlspecialchars($song['artist_username']); ?></td>
			<td><?php echo htmlspecialchars($song['length']); ?> seconds</td>
			<td><?php echo htmlspecialchars($song['release_date']); ?></td>
			<td>
				<form method="POST" action="regular_playlist_detail.php">
					<input type="hidden" name="playlist-id" value="<?php echo htmlspecialchars($_GET['playlist_id']); ?>">
					<input type="hidden" name="song-id" value="<?php echo htmlspecialchars($song['song_id']); ?>">
					<input type="submit" name="remove" class="btn btn-danger" value="REMOVE">
				</form>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } ?>

	<div>
	<?php if ($other_songs) { ?>
		<table class="table">
		<thead>
	    <tr>	
	      <th scope="col">Name</th>
	      <th scope="col">Artist</th>
	      <th scope="col">Length</th>
	      <th scope="col">Release Date</th>
	      <th scope="col">Add to playlist</th>
	    </tr>
	  	</thead>
	 	<tbody>
	<?php foreach($other_songs as $song) { ?>
			<tr>
				<td><?php echo htmlspecialchars($song['song_name']); ?></td>
				<td><?php echo htmlspecialchars($song['artist_username']); ?></td>
				<td><?php echo htmlspecialchars($song['length']); ?> seconds</td>
				<td><?php echo htmlspecialchars($song['release_date']); ?></td>
				<td>
				<form method="POST" action="regular_playlist_detail.php">
					<input type="hidden" name="playlist-id" value="<?php echo htmlspecialchars($_GET['playlist_id']); ?>">
					<input type="hidden" name="song-id" value="<?php echo htmlspecialchars($song['song_id']); ?>">
					<input type="submit" name="add" class="btn btn-primary" value="ADD">
				</form>
			</td>
			</tr>
	  	</label>
	<?php } ?>
	<?php } ?>
	</div>
	
</html>

<?php
    include_once "hf/regular_footer.php";
?>

<?php
    include_once "hf/regular_header.php";
?>
    
    <!-- everything goes between includes -->
    <!-- Test if the session works -->

<?php
	
	require('includes/dbh.inc.php');

	//$username = 'akkurt';
	$username = $_SESSION['username'];
	
	//if create playlist button is submitted
	if (isset($_POST['create-playlist'])) {

		$playlist_name = $_POST['playlist-name'];

		//echo "Create playlist button is clicked! Name of the playlist is: " . $playlist_name;		
		//inserted playlist into db, continue with the songs
		//else {
			//check if genre(s) selected
			if (isset($_POST['genre'])) {
				//check if song(s) selected
				if (isset($_POST['song'])) {

					$sql = "INSERT INTO playlist (name, length, username) VALUES  ('$playlist_name', 0, '$username')";
					$rslt = mysqli_query($conn, $sql);

					//could not insert playlist into the playlist table
					if (!$rslt) {
						echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
						echo "Error while processing the query" . mysqli_connect_error();
					}
					$song = $_POST['song'];

					$length = 0;
					foreach ($song as $id) {
						# code...
						$sql = "SELECT * FROM musicobject WHERE music_object_id='$id'";
						$result = mysqli_query($conn, $sql);

						$info = mysqli_fetch_row($result);

						$song_length = $info[3];
						$song_id = $info[0];
						$length += $song_length;

						//update the total length of the playlist
						$sql = "UPDATE playlist SET length=length+'$song_length' WHERE username='$username' and name='$playlist_name'";
						$result = mysqli_query($conn, $sql);
						if ($result) {
							//get playlist id in order to insert into playlistsong
							$sql = "SELECT playlist_id FROM playlist WHERE name='$playlist_name' and username='$username'";
							$result = mysqli_query($conn, $sql);
							$p_id = mysqli_fetch_row($result)[0];

							//add song into playlistsong table
							$sql = "INSERT INTO playlistsong VALUES ('$p_id', '$song_id', curdate())";
							$result = mysqli_query($conn, $sql);

							if (!$result) {
								echo '<script type="text/javascript">alert("Could not add song into the playlist!");</script>';
								echo "Error while processing the query" . mysqli_connect_error();
							}
						}
						//could not update the total length
						else {
							echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
							echo "Error while processing the query" . mysqli_connect_error();
						}
					}
					$genres = $_POST['genre'];
					foreach ($genres as $genre) {
						$sql = "INSERT INTO playlistgenre VALUES ('$p_id', '$genre')";
						$result = mysqli_query($conn, $sql);

						if (!$result) {
							echo '<script type="text/javascript">alert("Could not set genre for the playlist!");</script>';
							echo "Error while processing the query" . mysqli_connect_error();
						}
					}

					echo '<script type="text/javascript">
						alert("Successfuly created the playlist!");
						location="regular_playlists.php";
						</script>';	
				}

				else {
					echo '<script type="text/javascript">
						alert("You need to select at least one song!");
						location="regular_new_playlist.php";
						</script>';		
				}
			}
			else {
				echo '<script type="text/javascript">
						alert("You need to select at least one genre!");
						location="regular_new_playlist.php";
						</script>';
			}

			

		//}
	}

	else {
		$sql = "SELECT * FROM buys, musicobject, song WHERE song.song_id=musicobject.music_object_id and buys.music_object_id=song.song_id and buys.username='$username';";

		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
			echo "Error while processing the query" . mysqli_connect_error();
		}
		else {
			$songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
			//echo "SONGS ARRAY: " . print_r($songs);
		}

		$sql = "SELECT * FROM genre";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
			echo "Error while processing the query" . mysqli_connect_error();
		}
		else {
			$genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
			//echo "GENRE ARRAY: " . print_r($genres);
		}
		//print_r($genres);
	}




	/**
	In order to insert a playlist into the database,
	Get the total length of all the songs
	Insert with playlist_name, length, and username into playlist
	Insert song_id and date into playlistsong 
	*/

?>

<!DOCTYPE html>
<html>

	<form method="POST" action="regular_new_playlist.php">
	  <div class="form-group">
	    <label for="playlist-name">Name of the Playlist</label>
	    <input type="text" class="form-control" id="playlist-name" name="playlist-name" placeholder="Enter the name of the playlist" required>
	  </div>
	<table class="table">
	<thead>
		<tr>	
			<th scope="col">Select<br>to add</th>
		    <th scope="col">Name</th>
		    <th scope="col">Artist</th>
		    <th scope="col">Length</th>
		</tr>
	</thead>
	<tbody>
	<?php if (!$songs) { ?>
		<h4>You have not purchased any song yet!</h4>
	<?php } ?>
	<?php if ($songs) { ?>
	<?php foreach($songs as $song) { ?>
			<tr>
				<td>
				<div class="custom-control custom-checkbox">
				  	<input type="checkbox" class="form-control custom-control-input" name="song[]" id="<?php echo $song['song_id'] ?>" value="<?php echo $song['song_id'] ?>">
				  	<label class="custom-control-label" for="<?php echo $song['song_id'] ?>">
				</div>
				</td>
				<td><?php echo htmlspecialchars($song['name']); ?></td>
				<td><?php echo htmlspecialchars($song['artist_username']); ?></td>
				<td><?php echo htmlspecialchars($song['length']); ?> seconds</td>
			</tr>
	  	</label>
	<?php } ?>
	<?php } ?>
	</tbody>
	</table>
	
	<div class="center">
		<h5>You need to select at least one genre from below</h5>
	</div>

	<?php foreach($genres as $genre) { ?>
		<div class="custom-control custom-checkbox center">
		  <input class="form-control custom-control-input" name="genre[]" type="checkbox" id="<?php echo htmlspecialchars($genre['genre_name']) ?>" value="<?php echo htmlspecialchars($genre['genre_name']) ?>">
		  <label class="custom-control-label" for="<?php echo htmlspecialchars($genre['genre_name']) ?>"><?php echo htmlspecialchars($genre['genre_name']) ?></label>
		</div>
	<?php } ?>

	<div class="center">
		<?php if (!$songs) { ?>
			<input type="submit" name="create-playlist" class="btn btn-success" value="Create" disabled="">
		<?php } ?>
		<?php if ($songs) { ?>
			<input type="submit" name="create-playlist" class="btn btn-success" value="Create">
		<?php } ?>
	</div>
	  
	</form>

</html>



<?php
    include_once "hf/regular_footer.php";
?>
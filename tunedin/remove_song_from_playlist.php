<?php
	
	require('includes/dbh.inc.php');

	$username = $_SESSION['username'];

	if (isset($_POST['remove'])) {
		
		$playlist_id = $_POST['playlist-id'];
		$song_id = $_POST['song-id'];

		
		$sql = "DELETE FROM playlistsong WHERE song_id='$song_id' and playlist_id='$playlist_id'";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Could not remove the song from the playlist!");</script>';
			echo "Error while processing the query" . mysqli_connect_error();
			
		}

		header("Location: regular_playlist_detail.php?playlist_id='$playlist_id'");
		exit();
	}



?>



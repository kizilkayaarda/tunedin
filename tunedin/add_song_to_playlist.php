<?php
	
	require('includes/dbh.inc.php');

	$username = $_SESSION['username'];

	if (isset($_POST['add'])) {
		
		$playlist_id = $_POST['playlist-id'];
		$song_id = $_POST['song-id'];

		
		$sql = "INSERT INTO playlistsong VALUES ('$playlist_id', '$song_id', curdate())";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Could not remove the song from the playlist!");</script>';
			echo "Error while processing the query" . mysqli_connect_error();
			
		}

		header("Location: regular_playlist_detail.php?playlist_id='$playlist_id'");
		exit();
	}



?>
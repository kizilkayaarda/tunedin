<?php
    include_once "hf/regular_header.php";
?>
    
<?php 
	
	require('includes/dbh.inc.php');
	//session_start();
	$data = null;
	
	$username = $_SESSION['username'];


	$query = "SELECT * FROM Buys, Song, musicobject WHERE Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id;";

	if (isset($_GET['filter'])) {
		$filter = $_GET['sort'];

		if ($_GET['start-date'] !== '' && $_GET['end-date'] !== '') {
			$start_date = $_GET['start-date'];
			$end_date = $_GET['end-date'];

			if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$start_date) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$end_date)) {
				//$start_date = $start_date . ' 00:00:00';
				//$end_date = $end_date . ' 23:59:59';
				//echo "START DATE IS: " . $start_date;
				if ($filter === 'length-asc') {
					$query = "SELECT * FROM Buys, Song, musicobject WHERE DATE(buys.date) BETWEEN '$start_date' and '$end_date' and Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id ORDER BY musicobject.length ASC;";
				}
				else if ($filter === 'length-desc') {
					$query = "SELECT * FROM Buys, Song, musicobject WHERE DATE(buys.date) BETWEEN '$start_date' and '$end_date' and Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id ORDER BY musicobject.length DESC;";
				}
				else if ($filter === 'date-asc') {
					$query = "SELECT * FROM Buys, Song, musicobject WHERE DATE(buys.date) BETWEEN '$start_date' and '$end_date' and Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id ORDER BY buys.date ASC;";
				}
				else if ($filter === 'date-desc') {
					$query = "SELECT * FROM Buys, Song, musicobject WHERE DATE(buys.date) BETWEEN '$start_date' and '$end_date' and Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id ORDER BY buys.date DESC;";
				}
				else {
					 $query = "SELECT * FROM Buys, Song, musicobject WHERE DATE(buys.date) BETWEEN '$start_date' and '$end_date' and Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id;";
				}
			}
			else {
				echo '<script type="text/javascript">alert("Enter valid dates in the specified format!");</script>';
			}
		}
		else {
			if ($filter === 'length-asc') {
			$query = "SELECT * FROM Buys, Song, musicobject WHERE Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id ORDER BY musicobject.length ASC;";
			}
			else if ($filter === 'length-desc') {
				$query = "SELECT * FROM Buys, Song, musicobject WHERE Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id ORDER BY musicobject.length DESC;";
			}
			else if ($filter === 'date-asc') {
				$query = "SELECT * FROM Buys, Song, musicobject WHERE Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id ORDER BY buys.date ASC;";
			}
			else if ($filter === 'date-desc') {
				$query = "SELECT * FROM Buys, Song, musicobject WHERE Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id ORDER BY buys.date DESC;";
			}
			else {
				 $query = "SELECT * FROM Buys, Song, musicobject WHERE Buys.username='$username' and song.song_id=Buys.music_object_id and musicobject.music_object_id=Buys.music_object_id;";

			}
		}

	}
   
	$result = mysqli_query($conn, $query);

	if (!$result) {
		echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
		echo "Error while processing the query " . mysqli_connect_error();
	}

	else {
		$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
	}



?>

<!DOCTYPE html>
<html>



	<h4>Songs</h4>
	<table class="table">
		<thead>
	    <tr>	
	      <th scope="col">Name</th>
	      <th scope="col">Artist</th>
	      <th scope="col">Length</th>
	      <th scope="col">Purchase Date</th>
	      <!--<th scope="col">Add to Playlist</th>-->
	    </tr>
	  	</thead>
	 	<tbody>
	 	<?php if ($data) { ?>
		<?php foreach($data as $object) { ?>
		<tr>
			<td><?php echo htmlspecialchars($object['name']); ?></td>
			<td><?php echo htmlspecialchars($object['artist_username']); ?></td>
			<td><?php echo htmlspecialchars($object['length']); ?></td>
			<td><?php echo htmlspecialchars($object['date']); ?></td>

			<!--
			<td>
				<form method="POST" action="playlist_add_song.php">
					<input type="hidden" name="music_object_id" value="<?php echo htmlspecialchars($object['music_object_id']); ?>">
					<input type="submit" name="submit" class="btn btn-success" value="Add">
				</form>
			</td>
			-->
		</tr>
		<?php } ?>
		<?php } ?>
		<?php if (!$data) { ?>
			<h4>NO SONG FOUND</h4>
		<?php } ?>
		</tbody>
	</table>
	
	<br><br>

	<form action="regular_songs.php" method="GET">
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label class="center">SORT</label>
			<select class="form-control form-control-sm" name="sort">
				<option value="default">Select one</option>
			  	<option value="length-asc">Sort by Length Ascending</option>
			 	<option value="length-desc">Sort by Length Descending</option>
			 	<option value="date-asc">Sort by Purchase Date Ascending</option>
				<option value="date-desc">Sort by Purchase Date Descending</option>
			</select>
	    </div>
	  </div>
	  <div class="form-group">
		<label>Filter by purchase date (enter your input in the following format: YYYY-MM-DD)</label>
		<input type="text" name="start-date" placeholder="Minimum date">
		<input type="text" name="end-date" placeholder="Maximum date">
	  </div>
	  <button type="submit" name="filter" class="btn btn-primary">Search & Filter</button>
</form>

</html>

<?php
    include_once "hf/regular_footer.php";
?>
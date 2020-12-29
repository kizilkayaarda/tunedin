<?php
    include_once "hf/regular_header.php";
?>
    

<?php 
	require('includes/dbh.inc.php');
	//session_start();

	//$username = mysqli_real_escape_string($_SESSION['username']);
	$username = $_SESSION['username'];

	$warnings = array('balance_zero'=>'', 'insufficient_balance'=>'', 'buy_success'=>'');

	if (isset($_POST['submit'])) {

		$balance = 0;

		$sql = "SELECT balance FROM users WHERE username='$username'";

		$result = mysqli_query($conn, $sql);


		if (!$result) {
			echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
			echo "Error while processing the query " . mysqli_error($conn);
		}
		//get balance
		else {
			$fetch = mysqli_fetch_assoc($result);
			//echo "balance array: " . print_r($fetch);
			//echo "FETCH" . print_r($fetch);
			$balance = $fetch['balance'];
			//if user has no money
			if ($balance == 0) {
				$warnings['balance_zero'] = "You have no money in your account! Please add some money using account button above.";
			}
			//get the price of the music product
			else {
				$id = $_POST['music_object_id'];
				$sql = "SELECT price FROM musicobject WHERE music_object_id='$id'";

				$result = mysqli_query($conn, $sql);
				if (!$result) {
						echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
						echo "Error while processing the query " . mysqli_error();
				}
				else {
					$fetch = mysqli_fetch_assoc($result);

					$price = $fetch['price'];

					//user does not have enough money
					if ($balance < $price) {
						$warnings['insufficient_balance'] = "Insufficient money!";
					}
					//purchase the music product
					else {
						//update users balance
						$newBalance = $balance - $price;
						$sql = "UPDATE Users SET balance='$newBalance' WHERE username='$username'"; 
						$result = mysqli_query($conn, $sql);

						//if could not update users balance
						if (!$result) {
							echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
							echo "Error while processing the query " . mysqli_error();
						}
						else {
							//insert into buys table
							$sql = "INSERT INTO buys VALUES ('$username', '$id', curdate())";
							$result = mysqli_query($conn, $sql);

							if (!$result) {
								echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
								echo "Error while processing the query " . mysqli_error($conn);
							}
							else {
								$warnings['buy_success'] = "Successfuly bought the product.";
							
								//add songs if album
								$sql = "SELECT * FROM Album WHERE Album.album_id='$id'";
								$result = mysqli_query($conn, $sql);

								if ($result) {
									if ($result->num_rows > 0) {
										//select songs in that album 
										$sql = "SELECT song_id FROM song WHERE album_id='$id'";

										$result = mysqli_query($conn, $sql);

										if ($result) {
											$ids = mysqli_fetch_all($result, MYSQLI_ASSOC);

											foreach ($ids as $id) {
												$song_id = $id['song_id'];

												$sql = "SELECT COUNT(*) FROM Buys WHERE buys.music_object_id='$song_id' and buys.username='$username'";
												$result = mysqli_query($conn, $sql);

												if ($result) {
													$fetch = mysqli_fetch_assoc($result);

													//echo "COUNT IS " . $fetch[0];
													//echo "array: " . print_r($fetch);
													if ($fetch['COUNT(*)'] == 0) {

														$sql = "INSERT INTO buys VALUES ('$username', '$song_id', curdate())";
														$result = mysqli_query($conn, $sql);

														if (!$result) {
															echo '<script type="text/javascript">alert("Could not add songs in the album you bought to your library!");</script>';
															echo "Error while processing the query " . mysqli_error($conn);
														}
													}
												}
												else {
													echo '<script type="text/javascript">alert("Error getting the song!");</script>';
													echo "Error while processing the query " . mysqli_error($conn);
												}
											}
										}
										else {
											echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
											echo "Error while processing the query " . mysqli_error($conn);
										}
									}
								}
								else {
									echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
									echo "Error while processing the query " . mysqli_error($conn);
								}
							}
						}
					}
				}
			}
		}
	}

	//all the music objects the user has not bought yet
	$query = "SELECT * from musicobject where musicobject.music_object_id not in (select musicobject.music_object_id from users, musicobject, buys WHERE users.username=buys.username and users.username = '$username' and buys.music_object_id=musicobject.music_object_id)";

	$objects = array();

	$result = mysqli_query($conn, $query);

	if (!$result) {
		echo '<script type="text/javascript">alert("Error while processing the query!");</script>';
		echo "Error while processing the query " . mysqli_error($conn);
	}

	else {
		$objects = mysqli_fetch_all($result, MYSQLI_ASSOC);
		//echo "array: "  . print_r($objects);
		//$mysqli->free_result();
	}


?>

<!DOCTYPE html>
<html>


	<?php if($warnings['buy_success']) { ?>
		<div class="alert alert-success" role="alert">
			<?php echo $warnings['buy_success']; ?>
		</div>
	<?php } ?>

	<?php if($warnings['balance_zero']) { ?>
		<div class="alert alert-primary" role="alert">
			<?php echo $warnings['balance_zero']; ?>
		</div>
	<?php } ?>

	<?php if($warnings['insufficient_balance']) { ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $warnings['insufficient_balance']; ?>
		</div>
	<?php } ?>

	<h3>Songs and albums</h3>
		<table class="table">
		<thead>
	    <tr>	
	      <th scope="col">Name</th>
	      <th scope="col">Artist</th>
	      <th scope="col">Length</th>
	      <th scope="col">Price</th>
	      <th scope="col">Buy Product</th>
	    </tr>
	  	</thead>
	 	<tbody>
		<?php foreach($objects as $object) { ?>
		<tr>
			<td><?php echo htmlspecialchars($object['name']); ?></td>
			<td><?php echo htmlspecialchars($object['artist_username']); ?></td>
			<td><?php echo htmlspecialchars($object['length']); ?> seconds</td>
			<td><?php echo htmlspecialchars($object['price']); ?> $</td>
			<td>
				<form method="POST" action="regular_discover.php">
					<input type="hidden" name="music_object_id" value="<?php echo htmlspecialchars($object['music_object_id']); ?>">
					<input type="submit" name="submit" class="btn btn-success" value="Buy">
				</form>
			</td>
			
		</tr>
		<?php } ?>
		</tbody>
	</table>


<?php
    include_once "hf/regular_footer.php";
?>

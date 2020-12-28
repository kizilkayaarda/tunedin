<?php 
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

session_start();
$artistUsername = $_SESSION['username'];

$sql = "SELECT m.`music_object_id`, m.`name`, m.`price`, m.`length`, mg.`genre_name`, m.`score`, m.`release_date`, m.`cover_img` FROM musicobject m LEFT JOIN musicobjectgenre mg ON mg.music_object_id=m.music_object_id WHERE m.artist_username=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $artistUsername);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
  $rows[]=$row;
}
$result->close();

for ($i = 0; $i < count($rows); $i++) {
  $rows[$i]['cover_img'] = "<img src=". $rows[$i]['cover_img'] ." style=\"width:50px;height:50px;\">";
}

echo json_encode($rows);
?>
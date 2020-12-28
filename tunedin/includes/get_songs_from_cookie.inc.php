<?php 
if(!isset($_COOKIE["data"])) {
  $arr = json_decode("{}", true);
}
else {
  $arr = json_decode($_COOKIE["data"], true);
}

$songs = $arr["songs"];

for ($i = 0; $i < count($songs); $i++) {
  $songs[$i]['cover_img'] = "<img src=". $songs[$i]['cover_img'] ." style=\"width:50px;height:50px;\">";
}

echo json_encode($songs);
?>
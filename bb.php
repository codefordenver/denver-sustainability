<?php

include("utilities.php");
$nwLat = $_GET['nwlat'];
$nwLng = $_GET['nwlng'];
$seLat = $_GET['selat'];
$seLng = $_GET['selng'];

$stmt = $db_link->prepare("SELECT building_id, FORMAT(building_lat-39, 4), FORMAT(building_lng+104.5, 4) FROM buildings WHERE building_lat>? AND building_lat<? AND building_lng>? AND building_lng<?");
$stmt->bind_param("dddd", $seLat, $nwLat, $nwLng, $seLng);
$stmt->bind_result($id, $lat, $lng);
$stmt->execute();
while ($stmt->fetch()) {
	echo "$id,$lat,$lng\n";	
}
$stmt->close();
?>
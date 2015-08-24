<?php

include("utilities.php");
include("lib/geohash.php");

$hasher = new Geohash();

$hashes = array();
$result = $db_link->query("SELECT building_id, building_lat, building_lng FROM buildings");
while ($row = mysqli_fetch_assoc($result)) {
	$hash = $hasher->encode($row['building_lat'], $row['building_lng']);
	$hashes[$row['building_id']] = $hash;
}

foreach ($hashes as $id => $hash) {
	$db_link->query("UPDATE buildings SET building_geohash='$hash' WHERE building_id=$id");
}
?>
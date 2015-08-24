<?php

include("utilities.php");

$id = $db_link->real_escape_string($_GET['id']);
$result = $db_link->query("SELECT building_address FROM buildings LEFT JOIN energy_star_score ON score_building_id=building_id WHERE building_geohash='$id'");

if ($row = mysqli_fetch_assoc($result)) {
	$address = $row['building_address'];
	print $address;
}
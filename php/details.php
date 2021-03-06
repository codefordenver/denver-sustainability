<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 

include("utilities.php");

$id = 0;
$placeId = 0;
if (isset($_GET['place_id'])) {
	$placeId = $db_link->real_escape_string($_GET['place_id']);
} else {
	$id = $db_link->real_escape_string($_GET['id']);
}
$result = $db_link->query("SELECT building_name, building_address, building_lat, building_lng, building_geocoded_address, building_gross_square_footage, building_year_built, building_website, building_updated, building_sector, building_source_prim, building_number_units, building_geocoded_lat, building_geocoded_lng, building_geohash, (building_view_count+1) AS building_view_count, score_score, score_wns_eui, GROUP_CONCAT(cert_type SEPARATOR ';') as certifications, GROUP_CONCAT(strategy_text SEPARATOR ';') AS strategies FROM buildings LEFT JOIN energy_star_score ON score_building_id=building_id LEFT JOIN building_certifications ON cert_building_id=building_id LEFT JOIN strategies ON strategy_building_id=building_id WHERE ".($placeId ? "building_geocoded_place_id='$placeId'" : "building_geohash='$id'")." GROUP BY building_id");

if ($row = mysqli_fetch_assoc($result)) {
	print json_encode($row);
		
    $db_link->query("UPDATE buildings SET building_view_count=building_view_count+1 WHERE building_geohash='$id'");
}

?>
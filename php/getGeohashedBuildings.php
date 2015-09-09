<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
include("utilities.php");
$result = $db_link->query("SELECT building_geohash, building_benchmarked, IFNULL(score_score, 0) AS score, building_gross_square_footage AS footage FROM buildings LEFT JOIN energy_star_score ON score_building_id=building_id ORDER BY building_geohash");
$lastPrefix = '******';
while ($row = mysqli_fetch_assoc($result)) {
	$hash = $row['building_geohash'];
	$score = $row['score'];
	$benchmarked = $row['building_benchmarked'];
	$footage = $row['footage'];
	$typeCode = 0;
	if ($score > 0) {
		$typeCode = 2;
	} else if ($benchmarked) {
		$typeCode = 1;
	}
	if ($footage >= 50000) {
		$typeCode += 4;
	}
	
	$newPrefix = substr($hash, 0, 5);
	for ($i = 0; $i < 5; $i++) {
		if ($newPrefix[$i] != $lastPrefix[$i]) {
			break;
		}
	}
	$diffCount = 5 - $i;
	if ($diffCount > 0) {
		print '~'.$diffCount;
		print substr($newPrefix, 5 - $diffCount, $diffCount);
	}
	print substr($hash, 5, 4);
	print $typeCode;	
	
	$lastPrefix = $newPrefix;
}
?>
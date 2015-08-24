<?php

$conn = pg_connect("postgres://icpmirhpfnyjuj:u70w7Na-RvFT3QMDqJj1RtzMmX@ec2-54-204-27-193.compute-1.amazonaws.com:5432/de70id6cbkrt96");

$file = fopen("data/buildings.csv", "r");
$headings = fgetcsv($file);
while (!feof($file)) {
	$next = fgetcsv($file);
	pg_query($conn, "INSERT INTO buildings(building_name, building_address, building_lat, building_lng, building_year_built, building_property_type, building_gross_square_footage) VALUES ('{$next[0]}', '{$next[6]}', $next[9], $next[8], $next[4], NULL, $next[2])");
}
fclose($file);

?>

<?php

include("utilities.php");

$queries = array();

for ($numReps = 0; $numReps < 10; $numReps++) {
$result = $db_link->query("SELECT building_id, building_address FROM buildings WHERE building_geocoded_lat=0 LIMIT 50", MYSQLI_USE_RESULT);
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['building_id'];
    $address = $row['building_address'];

    $unitIndex = strpos($address, "UNIT");
    if ($unitIndex > 0) {
      $address = substr($address, 0, $unitIndex);
    } else {
      $unitIndex = strpos($address, "MISC");
      if ($unitIndex > 0) {
        $address = substr($address, 0, $unitIndex);
      }
    }
    $unitIndex = strpos($address, "MASTER");
      if ($unitIndex > 0) {
        $address = substr($address, 0, $unitIndex);
      }

    $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address.", Denver, CO")."&sensor=false";
 
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $details_url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
curl_setopt($ch, CURLOPT_PROXYPORT,3128); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0); 
$response = curl_exec($ch); 
curl_close($ch);
   $response = json_decode($response, true);
   if (count($response['results']) == 0) {
      print $address."\n";
      continue;
   }
    $geometry = $response['results'][0]['geometry'];
    $newPlaceId = $response['results'][0]['place_id'];
    $newAddress = $response['results'][0]['formatted_address'];

    $newLng = $geometry['location']['lng'];
    $newLat = $geometry['location']['lat'];
    
    
    $queries[] = "UPDATE buildings SET building_geocoded_address='".$db_link->real_escape_string($newAddress)."', building_geocoded_lat=$newLat, building_geocoded_lng=$newLng, building_geocoded_place_id='$newPlaceId' WHERE building_id=$id";
}

foreach ($queries as $query) {
    $db_link->query($query);
    print mysqli_error($db_link);
}
}
?>
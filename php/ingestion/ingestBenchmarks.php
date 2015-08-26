<?php

include("utilities.php");

$file = fopen("data/benchmarked.csv", "r");
$headings = fgetcsv($file);
$numUpdated = 0;
$notUpdated = 0;
while (!feof($file)) {
    $line = fgetcsv($file);
	if (!$line[2]) {
		continue;
	}
    $result = $db_link->query("SELECT building_id FROM buildings WHERE building_geocoded_address='{$line[4]}'");
    if ($row = mysqli_fetch_assoc($result)) {
        $id = $row["building_id"];
        $db_link->query("UPDATE buildings SET building_name='{$line[0]}', building_website='{$line[12]}' WHERE building_id=$id");
        if (mysqli_affected_rows($db_link) > 0) {
          if (intval($line[8]) > 0) {
            $years = explode(",", $line[11]);
            $lastYear = -1;
            if (intval($years[0]) > 0) {
              $lastYear = $years[0];
            }
            $strategyText = $db_link->real_escape_string($line[24]);
            $db_link->query("INSERT INTO energy_star_score (score_building_id, score_score, score_pbt_nms_eui, score_wns_eui, score_date) VALUES ($id, {$line[8]}, {$line[9]}, {$line[10]}, $lastYear)");
            if ($strategyText) {
              $db_link->query("INSERT INTO strategies (strategy_text, strategy_user_id, strategy_building_id) VALUES ('$strategyText', 1, $id)");
            }
            if ($line[13]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'Denver 2030 District Member', 1)");
            }
            if ($line[14]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'LEED Platinum', 1)");
            }
            if ($line[15]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'LEED Gold', 1)");
            }
            if ($line[16]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'LEED Silver', 1)");
            }
            if ($line[17]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'LEED Certified', 1)");
            }
            if ($line[18]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'Green Key', 1)");
            }
            if ($line[19]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'Green Key', 2)");
            }
            if ($line[20]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'Green Key', 3)");
            }
            if ($line[21]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'Green Key', 4)");
            }
            if ($line[22]) {
              $db_link->query("INSERT INTO (cert_building_id, cert_type, cert_score) VALUES ($id, 'Green Key', 5)");
            }
          }
        }
        $numUpdated++;
    } else {
        $notUpdated++;
        print "<BR>{$line[4]}";
    }
}
print "<BR>Number of rows updated: $numUpdated Not updated: $notUpdated";
?>

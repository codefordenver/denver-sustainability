<?php
include("utilities.php");
if (!$db_link) {
	// Backup example data.
	print "~59xj64smc1smd1smd1smm1smy1sqn0sqs1sr00sr91sre1st60st70st80stb0ste0sts0stv1stw0stx0sv61sv91svb1sw41sw90swm0swn0swt1swu0swz0sx00sx31sx91sxe0sxm1sxx0sy30sy50syd1syk0syk0syz1szc0szc0sze0szn0szx1tm80tmw1tn21tnu1tp31tp30trb0tw50txr1txv1ty61tyn1tyx1tz60u2m1u2n1u3g1u3r3u3t0u3y0u621u6p1u7e1u8n0u941u9r0ub00ub20ub91ubg0ubk0ubw0ubz0uc40uc90ucf0ucq0uct0ucx0ud60udm1udv0ue41ue91uep0uew0uex1uf01uf50ufp0ufv0ugk0ugy0umq0"; 	
	return;
}
$result = $db_link->query("SELECT building_geohash, IFNULL(score_score, 0) AS score, building_gross_square_footage AS footage FROM buildings LEFT JOIN energy_star_score ON score_building_id=building_id ORDER BY building_geohash");
$lastPrefix = '******';
while ($row = mysqli_fetch_assoc($result)) {
	$hash = $row['building_geohash'];
	$score = $row['score'];
	$footage = $row['footage'];
	$typeCode = ($score > 0 ? 2 : 0) + ($footage >= 50000 ? 1 : 0); 
	
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
	print substr($hash, 5, 3);
	print $typeCode;	
	
	$lastPrefix = $newPrefix;
}
?>
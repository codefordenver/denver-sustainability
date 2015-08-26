<?php
require_once "config.php";
$db_link = getDBConn();

function getDBConn() {
	set_time_limit(1);
	@$db_link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE) or print "";
	//emailAdmin("Could not connect", "Could not connect to database (utilities.getDBConn):".mysql_error());
   	//die('Could not connect: ' . mysql_error()); 
	if ($db_link) {
		print mysql_error();
		return $db_link;
	}
}
?>
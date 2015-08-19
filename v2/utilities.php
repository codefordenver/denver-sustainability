<?php
require_once "config.php";
$db_link = getDBConn();

function getDBConn() {
	$db_link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if (!$db_link) {
		emailAdmin("Could not connect", "Could not connect to database (utilities.getDBConn):".mysql_error());
   		die('Could not connect: ' . mysql_error()); 
	}
	print mysql_error();
	return $db_link;
}
?>
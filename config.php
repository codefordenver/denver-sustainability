<?php

//require_once "Mail.php";

define('DB_HOST', 'YOUR_MYSQL_SERVER_HERE');

define('DB_USER', 'YOUR_MYSQL_DB_USER_HERE');

define('DB_PASSWORD', 'YOUR_MYSQL_DB_PASSWORD_HERE');

define('DB_DATABASE', 'YOUR_MYSQL_DB_HERE');

function sendMail($receiver, $subject, $body, $from) {
	return mail($receiver, $subject, $body, $from);
}

?>

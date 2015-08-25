<?php

//require_once "Mail.php";

define('DB_HOST', 'YOUR_HOST_HERE');

define('DB_USER', 'YOUR_USERNAME_HERE');

define('DB_PASSWORD', 'YOUR_PASSWORD_HERE');

define('DB_DATABASE', 'YOUR_DB_HERE');

function sendMail($receiver, $subject, $body, $from) {
	return mail($receiver, $subject, $body, $from);
}

?>
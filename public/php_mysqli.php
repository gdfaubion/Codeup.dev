<?php
	// Get new instance of MySQLi object
	$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_test_db');

	// Check for errors
	if ($mysqli->connect_error) {
	    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	} else {
		echo $mysqli->host_info . "\n";
	}

		
?>
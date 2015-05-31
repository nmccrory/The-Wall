<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_DATABASE', 'the_wall');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if ($connection-> connect_errno){
	die("Failed to connect to MySQL: (".$connection->connect_errno.") " . $connection->connect_error);
}

function fetch($query){
	$data = array();
	global $connection;
	//returns an object if valid query, false if not, and null if valid query but no results found
	$result = $connection->query($query);
	if($result !== false){
		//if may results
		if($result->num_rows > 1){
			foreach($result as $row){
				$data[] = $row;
			}
		return $data;	
		}

		return mysqli_fetch_assoc($result);

	}

	return $result;
}


?>
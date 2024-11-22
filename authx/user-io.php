<?php
require_once 'dbinfo.php';

global $conn;

// Add user function

function add_user($conn, $firstname, $lastname, $username, $token, $email, $driver, $address){
	//code to add user here
	$query = "insert into users(firstname, lastname, username, password, email, driver_type, address) 
    values ('$firstname', '$lastname', '$username', '$token', '$email', '$driver', '$address')";

	$result = $conn->query($query);
	if(!$result) die($conn->error);
}

?>
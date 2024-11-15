<?php

require_once 'dbinfo.php';
require_once 'user-io.php';

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

//code for create user table here
$query = "create table if not exists users(
    driver_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	firstname varchar(128) not null,
	lastname varchar(128) not null,
	username varchar(128) not null unique,
	password varchar(128) not null,
	email varchar(128) not null,
	driver_type varchar(16) not null,
	address varchar(128)
)";

$result = $conn->query($query);
if(!$result) die($conn->error);

//Bill Smith
$firstname = 'Bill';
$lastname = 'Smith';
$username = 'bsmith';
$password = 'mysecret';
$email = 'billsmith@email.com';
$driver = 'student';
$address = '123 Main St, Anytown, TX 77777';

$token = password_hash($password,PASSWORD_DEFAULT); 

add_user($conn, $firstname, $lastname, $username, $token, $email, $driver, $address);

//Pauline Jones
$firstname = 'Pauline';
$lastname = 'Jones';
$username = 'pjones';
$password = 'acrobat';
$email = 'paulajones@email.com';
$driver = 'faculty';
$address = '567 Green St, Anytown, TX 77777';

$token = password_hash($password,PASSWORD_DEFAULT); 

add_user($conn, $firstname, $lastname, $username, $token, $email, $driver, $address);

?>
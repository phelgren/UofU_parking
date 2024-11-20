<?php

$hn='localhost:3306';
$db='parking';
$un='root';
$pw='';

global $conn;
$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
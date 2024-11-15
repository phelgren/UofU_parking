<?php 

function getDrivers($onedriver){

$hn='localhost:3306';
$db='parking';
$un='root';
$pw='';
//require_once 'dbinfo.php';

$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error) die("Fatal Error");
$query = "";

if(empty($onedriver))
    $query  = "SELECT * from users";
else
    $query = "select * from users";


$result = $conn->query($query);
if (!$result) die ($query->error);

return $result;

$result->close();
$conn->close();

}

?>
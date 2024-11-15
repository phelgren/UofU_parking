<?php 
// This is all very similar to Users since a Driver == User
function getDrivers($onedriver,$did){

$hn='localhost:3306';
$db='parking';
$un='root';
$pw='';
//require_once 'dbinfo.php';

$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error) die("Fatal Error");
$query = "";

// So, if the driver ID is empty follow the list logic
if(empty($did)){
    if(empty($onedriver))
        $query  = "SELECT * from users";
    else
        $query = "select * from users where username = '$onedriver'";
}
else // must be a selected driver
    $query = "select * from users where driver_id = '$did'";


$result = $conn->query($query);
if (!$result) die ($query->error);

return $result;

$result->close();
$conn->close();

}

if (isset($_POST['update'])){

    $did = $_POST['did'];  //Driver ID

    $firstname = mysql_entities_fix_string($conn,$_POST['first-name']);
    $lastname = mysql_entities_fix_string($conn,$_POST['last-name']);
    $username = mysql_entities_fix_string($conn,$_POST['user-name']);
    $email = mysql_entities_fix_string($conn,$_POST['email-address']);
    $pwd = mysql_entities_fix_string($conn,$_POST['password']);
    $address = mysql_entities_fix_string($conn,$_POST['address']);
    $dtype = mysql_entities_fix_string($conn,$_POST['dtype']);
  
    $token = password_hash($pwd,PASSWORD_DEFAULT);
  
    update_driver($conn, $firstname, $lastname, $username, $token, $email, $dtype, $address,$did);
  
    header("Location: list-drivers.php");
  
  }

  if (isset($_POST['add'])){

    $firstname = mysql_entities_fix_string($conn,$_POST['first-name']);
    $lastname = mysql_entities_fix_string($conn,$_POST['last-name']);
    $username = mysql_entities_fix_string($conn,$_POST['user-name']);
    $email = mysql_entities_fix_string($conn,$_POST['email-address']);
    $pwd = mysql_entities_fix_string($conn,$_POST['password']);
    $address = mysql_entities_fix_string($conn,$_POST['address']);
    $dtype = mysql_entities_fix_string($conn,$_POST['dtype']);
  
    $token = password_hash($pwd,PASSWORD_DEFAULT);
  
    add_driver($conn, $firstname, $lastname, $username, $token, $email, $dtype, $address);
  
    header("Location: list-drivers.php");
  
  }

  function update_driver($conn, $firstname, $lastname, $username, $token, $email, $driver, $address, $did){
	//code to add user here
	$query = "update users set firstname = '$firstname', lastname = '$lastname', username='$username', password = '$token',
     email='$email', driver_type = '$driver', address = '$address' where driver_id = $did";

	$result = $conn->query($query);
	if(!$result) die($conn->error);
}

function add_driver($conn, $firstname, $lastname, $username, $token, $email, $driver, $address){
	//code to add user here
	$query = "insert into users(firstname, lastname, username, password, email, driver_type, address) 
    values ('$firstname', '$lastname', '$username', '$token', '$email', '$driver', '$address')";

	$result = $conn->query($query);
	if(!$result) die($conn->error);
}

?>
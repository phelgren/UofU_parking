<?php 
require_once 'utilities.php';
require_once 'sanitize.php';

// This is all very similar to Users since a Driver == User
function getDrivers($onedriver,$did){

global $conn;

$query = "";

// So, if the driver ID is empty follow the list logic
if(empty($did)){

    if(empty($onedriver)){

        $query  = "SELECT * from users";
    }
    else{

        $query = "select * from users where username = ?";
    }
}
else // must be a selected driver
    $query = "select * from users where driver_id = ?";

    $stmt = $conn->prepare($query);
    if(empty($did)){
        if(empty(!$onedriver))
            $stmt->bind_param("s", $onedriver);
    }
    else
    {
        $stmt->bind_param("s", $did);
    }

    $stmt->execute();
    $result = $stmt->get_result();

if (!$result) die ($query->error);

return $result;

$result->close();
$conn->close();

}

if (isset($_POST['updatedriver'])){

    $did = $_POST['did'];  //Driver ID

    $firstname = mysql_entities_fix_string($conn,$_POST['first-name']);
    $lastname = mysql_entities_fix_string($conn,$_POST['last-name']);
    $username = mysql_entities_fix_string($conn,$_POST['user-name']);
    $email = mysql_entities_fix_string($conn,$_POST['email-address']);
    $pwd = mysql_entities_fix_string($conn,$_POST['password']);
    $address = mysql_entities_fix_string($conn,$_POST['address']);
    $dtype = mysql_entities_fix_string($conn,$_POST['dtype']);
    $token = password_hash($pwd,PASSWORD_DEFAULT);

    if(!empty($pwd)) // They can leave it blank if they don't want to change it
        update_driver_with_password($conn, $firstname, $lastname, $username, $token, $email, $dtype, $address,$did);
    else 
        update_driver_no_password($conn, $firstname, $lastname, $username, $email, $dtype, $address,$did);

    header("Location: list-drivers.php");
  
  }

  if (isset($_POST['adddriver'])){

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

  function update_driver_with_password($conn, $firstname, $lastname, $username, $token, $email, $driver, $address, $did){
	//code to add user here
	$query = "update users set firstname = '$firstname', lastname = '$lastname', username='$username', password = '$token',
     email='$email', driver_type = '$driver', address = '$address' where driver_id = $did";

	$result = $conn->query($query);
	if(!$result) die($conn->error);
}

function update_driver_no_password($conn, $firstname, $lastname, $username, $email, $driver, $address, $did){
	//code to add user here
	$query = "update users set firstname = '$firstname', lastname = '$lastname', username='$username',
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
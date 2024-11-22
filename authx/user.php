<?php
require_once 'utilities.php';
global $conn;

// Function to check if the user is an admin
function isAdmin($conn, $username) {
    $sql = "SELECT role FROM roles WHERE username = ?";
	$userrolesql = "select driver_type from users where username= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
	$rows = $result->num_rows;
	$found = 0;
	if($rows > 0){
		for($i=0; $i<$rows; $i++){
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$role = $row['role'];
			if($role == 'admin'){	
				$found = 1;
				break;
			}
		}
	    return ($found);
	}
	else{
		$stmt = $conn->prepare($userrolesql);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		return ($row['driver_type'] == 'admin');
	}
}

function getUserID($username){
global $conn;
	$sql = "select driver_id from users where username= ?";
	$stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
	$row = $result->fetch_assoc();
	return $row['driver_id'];

}

class User{
	
	public $username;
	public $roles = Array();
	
	function __construct($username){
		global $conn;
				
		$this->username = $username;
		$query="select role from roles where username='$username' ";
		//echo $query.'<br>';
		$result = $conn->query($query);
		if(!$result) die($conn->error);
			
		$rows = $result->num_rows;		
		
		$roles = Array();

		for($i=0; $i<$rows; $i++){
			$row = $result->fetch_array(MYSQLI_ASSOC);
			
			$roles[] = $row['role'];		
		}		
		if(empty($roles)){// nothing in the roles table get is from the driver record

			$result = getDrivers($username,'');
			$driver = $result->fetch_array(MYSQLI_ASSOC);
			$role = $driver['driver_type'];
			$roles[]= $role;
		}
		$this->roles = $roles;
	}

	function getRoles(){
		return $this->roles;
	}

}
















?>
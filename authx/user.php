<?php
//$conn = new mysqli($hn, $un, $pw, $db);
//if ($conn->connect_error) die($conn->connect_error);

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
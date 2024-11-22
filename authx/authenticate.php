<?php
require_once 'utilities.php';


//$conn = new mysqli($hn, $un, $pw, $db);
//if($conn->connect_error) die($conn->connect_error);

if (isset($_POST['username']) && isset($_POST['password'])) {
	
	//Get values from login screen
	$tmp_username = mysql_entities_fix_string($conn, $_POST['username']);
	$tmp_password = mysql_entities_fix_string($conn, $_POST['password']);

    //get password from DB w/ SQL
	$query = "SELECT password FROM users WHERE username = ?";
	
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tmp_username);
    $stmt->execute();

	$result = $stmt->get_result();
	
	if(!$result) die($conn->error);
	
	$rows = $result->num_rows;
	$passwordFromDB="";
	for($j=0; $j<$rows; $j++)
	{
		$result->data_seek($j); 
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$passwordFromDB = $row['password'];
	}
    	
	//Compare passwords
	if(password_verify($tmp_password,$passwordFromDB))
	{
		//echo "successful login<br>";
		$user = new User($tmp_username);

		$_SESSION['username'] = $tmp_username; // just the user name 
		$_SESSION['user'] = $user; // and instance of the class
		$user_roles = $user->getRoles();
		$_SESSION['roles'] = $user_roles;
		// Since all is well lets flag us as logged in
		
		header("Location: ..\list-drivers.php");
	}
	else
	{
		header("Location: ..\login-error.php");
	}	
}


$conn->close();


?>

<?php
include('header.php');
$page_roles = array('student','faculty','admin');
require_once 'authx/checksession.php';
require_once 'authx/driver-io.php';
require_once 'authx/sanitize.php';

$driver_id = mysql_entities_fix_string($conn,$_GET['did']);
$result = getDrivers('',$driver_id);
$driver = $result->fetch_array(MYSQLI_ASSOC);
// Roles are keyed by username so grab it from the session
$username = mysql_entities_fix_string($conn,$_SESSION['username']);

echo <<<_END

<div class="container">
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <h1><div class="card-header">DELETE driver information for $driver[firstname] $driver[lastname] </div></h1>
            <p><h3><strong style="color:red;"> NOTE: All permits, payments, vehicles and roles will be deleted with this driver/user </strong></h3></p>
            <div class="card-body"><br><br><br>
            <form action="delete-driver.php" method="post">
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    Delete this driver
                </button>
            </div>  
            <div class="col-md-3">
                <a href="list-drivers.php" class="btn btn-info" role="button">Cancel and return</a>
            </div>    
            <input type='hidden' name='did' value=$driver[driver_id] >
            <input type='hidden' name='delete' value='yes'>

            </form>

            </div>
        </div>
    </div>
</div>
_END;


if(isset($_POST['delete']))
{
    // Ok, now the complication is that a driver ID is a foriegn key for
    // Permits and vehicles and permits have a foriegn key of payment so
    // without a cascade delete easily handling things, we'll need to do it manually
    // Permits will cascade a delete to payments but the rest we'll need to navigate
    // Not a lot of error handling here

	$did = mysql_entities_fix_string($conn,$_POST['did']);

    // delete the permits
    $query = "DELETE FROM permit WHERE driver_id='$did' ";
    $result = $conn->query($query); 
	if(!$result) die($conn->error);
  
    // delete the vehicles
    $query = "DELETE FROM vehicle WHERE driver_id='$did' ";
    $result = $conn->query($query); 
    if(!$result) die($conn->error);

    // delete the roles, if any
    $query = "DELETE FROM roles WHERE username in(
    select username from users where driver_id = '$did')";
    $result = $conn->query($query); 
    if(!$result) die($conn->error);

	$query = "DELETE FROM users WHERE driver_id='$did' ";
	
	$result = $conn->query($query); 
	if(!$result) die($conn->error);
	// Head back to driver list
	header("Location: list-drivers.php");
}

?>
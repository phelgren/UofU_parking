<?php
include('header.php');
$page_roles = array('student','faculty','admin');
require_once 'authx\checksession.php';
require_once 'authx\driver-io.php';

$driver_id = $_GET['did'];
$result = getDrivers('',$driver_id);
$driver = $result->fetch_array(MYSQLI_ASSOC);

echo <<<_END

<div class="container">
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <h1><div class="card-header">DELETE driver information for $driver[firstname] $driver[lastname] </div></h1>
            <div class="card-body">
            <form action="delete-driver.php" method="post">
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    Delete this driver
                </button>
            </div>      
            <input type='hidden' name='did' value=$driver[driver_id] >
            <input type='hidden' name='delete' value='yes'>

            </form>
            <div class="col-md-3">
                <a href="list-drivers.php" class="btn btn-info" role="button">Cancel and return</a>
            </div>
            </div>
        </div>
    </div>
</div>
_END;


if(isset($_POST['delete']))
{
	$did = $_POST['did'];

	$query = "DELETE FROM users WHERE driver_id='$did' ";
	
	$result = $conn->query($query); 
	if(!$result) die($conn->error);
	// Head back to driver list
	header("Location: list-drivers.php");
}

?>
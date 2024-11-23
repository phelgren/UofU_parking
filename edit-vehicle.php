<?php
include 'header.php';
include 'authx/dbinfo.php';
require_once 'authx/sanitize.php';

global $conn;

$disabled = '';
if(isset($_GET['view']))
    $disabled = 'disabled';

if (isset($_GET['edit_id'])) {
    global $conn;
    $vehicle_id = intval(mysql_entities_fix_string($conn,$_GET['edit_id']));
    
    // Fetch vehicle details
    $sql = "SELECT * FROM vehicle WHERE VEHICLE_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    global $vehicle;
    $vehicle = $result->fetch_assoc();
    
    if (!$vehicle) {
        echo "Permit not found.";
        exit;
    }
}

if (isset($_POST['update'])){
    global $conn;
    $vid = $_POST['vehicle_id'];  //Vehicle ID

    $make = mysql_entities_fix_string($conn,$_POST['make']);
    $model = mysql_entities_fix_string($conn,$_POST['model']);
    $color= mysql_entities_fix_string($conn,$_POST['color']);
    $year = mysql_entities_fix_string($conn,$_POST['year']);
    $license_plate = mysql_entities_fix_string($conn,$_POST['license_plate']);

	$query = "update vehicle set Model = '$model', Make = '$make', Color = '$color', Year ='$year',
     License_Plate ='$license_plate'  where VEHICLE_ID = $vid";

	$result = $conn->query($query);
	if(!$result) die($conn->error);

    header("Location: list-vehicles.php");
  
  }

?>

<div class="container">
<div class="row justify-content-center">
<h2>Edit Vehicle</h2>
<div class="col-md-8">
    <div class="card">

        <div class="card-body">

            <form method="post" action="edit-vehicle.php?edit_id=<?php echo $vehicle['VEHICLE_ID']; ?>">
                <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['VEHICLE_ID']; ?>">
                <input type="hidden" name="update" value="yes">
                Make: <input type="text" name="make" <?php echo $disabled ?> value="<?php echo $vehicle['Make']; ?>"><br>
                Model: <input type="text" name="model" <?php echo $disabled ?> value="<?php echo $vehicle['Model']; ?>"><br>
                Color: <input type="text" name="color" <?php echo $disabled ?> value="<?php echo $vehicle['Color']; ?>"><br>
                Year: <input type="text" name="year" <?php echo $disabled ?> value="<?php echo $vehicle['Year']; ?>"><br>
                License: <input type="text" name="license_plate" <?php echo $disabled ?>  value="<?php echo $vehicle['License_Plate']; ?>"><br>

                <?php if(empty($disabled)) echo "<button type='submit'>Update Vehicle</button>" ?>

            </form>

      <a href='list-vehicles.php'><button>Back to Vehicle List</button></a>

        </div>
    </div>
</div>
</div>

<?php
include 'footer.php';
?>
</div>
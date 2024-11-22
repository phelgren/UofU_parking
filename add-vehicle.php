<?php
include 'header.php';
$page_roles = array('admin','faculty','student'); 
require_once 'authx/dbinfo.php';
require_once 'authx/checksession.php';
require_once 'authx/sanitize.php';

$message = '';

global $conn;

$did = '0';

$username = $_SESSION['username'];

if(!isAdmin($conn,$username))
    $did = getUserID($username);


    if (isset($_POST['addvehicle'])){
        global $conn;
        $did = $_POST['driver_id'];  //Vehicle ID
    
        $make = mysql_entities_fix_string($conn,$_POST['make']);
        $model = mysql_entities_fix_string($conn,$_POST['model']);
        $color= mysql_entities_fix_string($conn,$_POST['color']);
        $year = mysql_entities_fix_string($conn,$_POST['year']);
        $license_plate = mysql_entities_fix_string($conn,$_POST['license_plate']);
        $driver_id = mysql_entities_fix_string($conn,$_POST['driver_id']);

        $sql = "INSERT INTO vehicle (DRIVER_ID,Make, Model, Color, year, License_Plate) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssis", $driver_id,$make, $model,$color, $year, $license_plate);
    
        if ($stmt->execute()) {
            $message = "Permit added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    
        header("Location: list-vehicles.php");
      
      }
// So a couple of wrinkles here  if there is just a solo user, not an admin, you can only select stuff related to yourself.

if($did == '0'){
    $drivers = $conn->query("SELECT DRIVER_ID, CONCAT(firstname, ' ', lastname) AS DriverName FROM Users");
}
else{
    $drivers = $conn->query("SELECT DRIVER_ID, CONCAT(firstname, ' ', lastname) AS DriverName FROM Users where DRIVER_ID = $did");
}


?>
    <div class="container">
            <div class="row justify-content-center">
            <h2>Add New Vehicle</h2>

                    <?php if ($message): ?>
                        <p><?php echo $message; ?></p>
                    <?php endif; ?>

                <div class="col-md-8">
                    <div class="card">

                        <div class="card-body">
                            
                        <form action="add-vehicle.php" method="POST">

                            <label for="driver_id">Driver:</label>
                            <select id="driver_id" name="driver_id" required>
                                <option value="">Select Driver</option>
                                <?php while ($driver = $drivers->fetch_assoc()): ?>
                                    <option value="<?php echo $driver['DRIVER_ID']; ?>">
                                        <?php echo $driver['DriverName']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select><br>

                        <input type="hidden" name="addvehicle" value="yes">
                        Make: <input type="text" name="make" required><br>
                        Model: <input type="text" name="model" required><br>
                        Color: <input type="text" name="color" required><br>
                        Year: <input type="text" name="year" required><br>
                        License: <input type="text" name="license_plate" required><br>

                <button type="submit">Add Vehicle</button>

            </form>

                        </form>

                        <br>
                        <a href="list-vehicles.php"><button>Back to Vehicle List</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $conn->close(); ?>
<?php include 'footer.php'; ?>

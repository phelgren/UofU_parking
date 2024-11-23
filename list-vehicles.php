<?php
include 'header.php';
$page_roles = array('admin','faculty','student'); 

require_once 'authx/checksession.php';
require_once 'authx/sanitize.php';
require_once 'authx/user.php';

global $conn;
$did = '0';

$username = $_SESSION['username'];

if(!isAdmin($conn,$username))
    $did = getUserID($username);


if (isset($_GET['delete_id'])) {
    $delete_id = intval(mysql_entities_fix_string($conn,$_GET['delete_id']));
    // Complication: Vehicle is a foreign key to permits 
    // so delete the permits associated with the vehicle and then delete the vehicle

    $delete_sql = "DELETE FROM permit WHERE VEHICLE_ID = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    $delete_sql = "DELETE FROM vehicle WHERE VEHICLE_ID = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<p>Vehicle ID $delete_id deleted successfully.</p>";
    } else {
        echo "<p>Error deleting permit: " . $conn->error . "</p>";
    }
    header("Location: list-vehicles.php");
}

if($did == '0')
        $sql = "SELECT 
                users.firstname, 
                users.lastname, 
                Vehicle.VEHICLE_ID, 
                Vehicle.License_Plate, 
                Vehicle.Make, 
                Vehicle.Model,
                Vehicle.Color, 
                Vehicle.Year 
            FROM users
            JOIN Vehicle ON users.DRIVER_ID = Vehicle.DRIVER_ID
            ORDER BY users.lastname,users.firstname,vehicle.make,vehicle.model";
else
        $sql = "SELECT 
            users.firstname, 
            users.lastname, 
            Vehicle.VEHICLE_ID, 
            Vehicle.License_Plate, 
            Vehicle.Make, 
            Vehicle.Model,
            Vehicle.Color, 
            Vehicle.Year 
            FROM users
            JOIN Vehicle ON users.DRIVER_ID = Vehicle.DRIVER_ID
            WHERE Users.driver_id = $did 
            ORDER BY users.lastname,users.firstname,vehicle.make,vehicle.model";

$result = $conn->query($sql);

?>
<div class="container">
<div class="row justify-content-center">
<h2>List Vehicles</h2>
<div class="col-md-8">
    <div class="card">

        <div class="card-body">
    
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Driver Name</th>
                <th>License Plate</th>
                <th>Vehicle Make</th>
                <th>Vehicle Model</th>
                <th>Vehicle Color</th>
                <th>Vehicle Year</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="col-sm-3"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    <td><?php echo $row['License_Plate']; ?></td>
                    <td><?php echo $row['Make']; ?></td>
                    <td><?php echo $row['Model']; ?></td>
                    <td><?php echo $row['Color']; ?></td>
                    <td><?php echo $row['Year']; ?></td>
                    <td class="col-sm-3">
                        <a href="edit-vehicle.php?edit_id=<?php echo $row['VEHICLE_ID']; ?>">Edit</a> |
                        <a href="edit-vehicle.php?edit_id=<?php echo $row['VEHICLE_ID']; ?>&view='yes'">View</a> |
                        <a href="list-vehicles.php?delete_id=<?php echo $row['VEHICLE_ID']; ?>" onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        </div>

    <?php else: ?>
        <p>No vehicles found.</p>
    <?php endif; ?>

    <br>
    <a href="add-vehicle.php"><button>Add Vehicle</button></a>

    <?php 
    $conn->close();
    ?>
    </div>

<?php
include 'footer.php';
?>
</div>

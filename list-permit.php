<?php
include 'header.php';
$page_roles = array('admin','faculty','student'); 

require_once 'authx/checksession.php';
require_once 'authx/sanitize.php';
require_once 'authx/user.php';

global $conn;
$did = '0';
$solo = "no";

$username = $_SESSION['username'];

if(isset($_GET['single']))
    $solo = mysql_entities_fix_string($conn,$_GET['single']);

if(!isAdmin($conn,$username))
    $did = getUserID($username);

if(isset($_GET['single'])){
    $solo = mysql_entities_fix_string($conn,$_GET['single']);

if(isset($_GET['did'])) // passed in
    $did = mysql_entities_fix_string($conn,$_GET['did']);

}

if (isset($_GET['delete_id'])) {
    $delete_id = intval(mysql_entities_fix_string($conn,$_GET['delete_id']));
    $delete_sql = "DELETE FROM Permit WHERE PERMIT_ID = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<p>Permit ID $delete_id deleted successfully.</p>";
    } else {
        echo "<p>Error deleting permit: " . $conn->error . "</p>";
    }
}

if($did == '0')
        $sql = "SELECT 
                Permit.PERMIT_ID, 
                Permit.Permit_Type, 
                Permit.Purchase_date, 
                Permit.Expiry_date, 
                Permit.Cost, 
                users.firstname, 
                users.lastname, 
                users.driver_id,
                Vehicle.License_Plate, 
                Vehicle.Make, 
                Vehicle.Model,
                Vehicle.Vehicle_ID
            FROM Permit
            JOIN users ON Permit.DRIVER_ID = users.DRIVER_ID
            JOIN Vehicle ON Permit.VEHICLE_ID = Vehicle.VEHICLE_ID
            ORDER BY Permit.PERMIT_ID";
else
        $sql = "SELECT 
            Permit.PERMIT_ID, 
            Permit.Permit_Type, 
            Permit.Purchase_date, 
            Permit.Expiry_date, 
            Permit.Cost, 
            users.firstname, 
            users.lastname, 
            users.driver_id,
            Vehicle.License_Plate, 
            Vehicle.Make, 
            Vehicle.Model,
            Vehicle.Vehicle_ID 
            FROM Permit
            JOIN users ON Permit.DRIVER_ID = users.DRIVER_ID
            JOIN Vehicle ON Permit.VEHICLE_ID = Vehicle.VEHICLE_ID
            WHERE users.driver_id = $did 
            ORDER BY Permit.PERMIT_ID";

$result = $conn->query($sql);

?>
<div class="container">
<div class="row justify-content-center">
<h2>List Permits</h2>
<div class="col-md-12">
    <div class="card">

        <div class="card-body">
    
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Permit ID</th>
                <th>Permit Type</th>
                <th>Purchase Date</th>
                <th>Expiry Date</th>
                <th>Cost($)</th>
                <th>Driver Name</th>
                <th>License Plate</th>
                <th>Vehicle Make</th>
                <th>Vehicle Model</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['PERMIT_ID']; ?></td>
                    <td class="col-sm-2"><?php echo $row['Permit_Type']; ?></td>
                    <td class='col-sm-2'><?php echo $row['Purchase_date']; ?></td>
                    <td class='col-sm-2'><?php echo $row['Expiry_date']; ?></td>
                    <td><?php echo $row['Cost']; ?></td>
                    <td class='col-sm-3'><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    <td><?php echo $row['License_Plate']; ?></td>
                    <td><?php echo $row['Make']; ?></td>
                    <td><?php echo $row['Model']; ?></td>
                    <td class='col-sm-3'>
                        <a href="edit-permit.php?edit_id=<?php echo $row['PERMIT_ID']; ?>&name=<?php echo $row['firstname'] .'%20'. $row['lastname']; ?>&driverid=<?php echo $row['driver_id']; ?>&vehicleid=<?php echo $row['Vehicle_ID']; ?>">Edit</a> |
                        <a href="edit-permit.php?edit_id=<?php echo $row['PERMIT_ID']; ?>&name=<?php echo $row['firstname'] .'%20'. $row['lastname']; ?>&driverid=<?php echo $row['driver_id']; ?>&vehicleid=<?php echo $row['Vehicle_ID']; ?>&view=yes">View</a> |
                        <a href="list-permit.php?delete_id=<?php echo $row['PERMIT_ID']; ?>" onclick="return confirm('Are you sure you want to delete this permit?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        </div>

    <?php else: ?>
        <p>No permits found.</p>
    <?php endif; ?>

    <br>
    <a href="add-permit.php"><button>Add Permit</button></a> <?php if($solo=="yes") echo "<a href='list-permit.php'><button>Back to Permit List</button></a>";?>

    <?php 
    $conn->close();
    ?>
    </div>

<?php
include 'footer.php';
?>
</div>

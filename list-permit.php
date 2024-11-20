<?php

include 'authx\dbinfo.php';

global $conn;

// Function to check if the user is an admin
function isAdmin($conn, $username) {
    $sql = "SELECT role FROM roles WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return ($row && $row['role'] === 'admin');
}

// Check if user is logged in and has admin privileges
//if (!isset($_SESSION['username']) || !isAdmin($conn, $_SESSION['username'])) {
   // echo "403 Forbidden: You do not have permission to view this page.";
   // exit;
//}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM Permit WHERE PERMIT_ID = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<p>Permit ID $delete_id deleted successfully.</p>";
    } else {
        echo "<p>Error deleting permit: " . $conn->error . "</p>";
    }
}

$sql = "SELECT 
            Permit.PERMIT_ID, 
            Permit.Permit_Type, 
            Permit.Purchase_date, 
            Permit.Expiry_date, 
            Permit.Cost, 
            users.firstname, 
            users.lastname, 
            Vehicle.License_Plate, 
            Vehicle.Make, 
            Vehicle.Model 
        FROM Permit
        JOIN users ON Permit.DRIVER_ID = users.DRIVER_ID
        JOIN Vehicle ON Permit.VEHICLE_ID = Vehicle.VEHICLE_ID
        ORDER BY Permit.PERMIT_ID";

$result = $conn->query($sql);
include 'header.php';
?>
<div class="container">
<div class="row justify-content-center">
<h2>List Permits</h2>
<div class="col-md-8">
    <div class="card">

        <div class="card-body">
    
    <?php if ($result && $result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Permit ID</th>
                <th>Permit Type</th>
                <th>Purchase Date</th>
                <th>Expiry Date</th>
                <th>Cost ($)</th>
                <th>Driver Name</th>
                <th>License Plate</th>
                <th>Vehicle Make</th>
                <th>Vehicle Model</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['PERMIT_ID']; ?></td>
                    <td><?php echo $row['Permit_Type']; ?></td>
                    <td><?php echo $row['Purchase_date']; ?></td>
                    <td><?php echo $row['Expiry_date']; ?></td>
                    <td><?php echo $row['Cost']; ?></td>
                    <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    <td><?php echo $row['License_Plate']; ?></td>
                    <td><?php echo $row['Make']; ?></td>
                    <td><?php echo $row['Model']; ?></td>
                    <td>
                        <a href="edit-permit.php?edit_id=<?php echo $row['PERMIT_ID']; ?>">Edit</a> |
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
    <a href="add-permit.php"><button>Add Permit</button></a>

    <?php 
    $conn->close();
    ?>
    </div>

<?php
include 'footer.php';
?>
</div>

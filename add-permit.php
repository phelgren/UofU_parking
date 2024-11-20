<?php
//session_start();
include 'authx\dbinfo.php';

function isAdmin($conn, $username) {
    $sql = "SELECT role FROM roles WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return ($row && $row['role'] === 'admin');
}

//if (!isset($_SESSION['username']) || !isAdmin($conn, $_SESSION['username'])) {
  //  echo "403 Forbidden: You do not have permission to access this page.";
  //  exit;
//}

$message = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $permit_type = $_POST['permit_type'];
    $vehicle_id = $_POST['vehicle_id'];
    $driver_id = $_POST['driver_id'];
    $purchase_date = $_POST['purchase_date'];
    $expiry_date = $_POST['expiry_date'];
    $cost = $_POST['cost'];
    $payment_id = $_POST['payment_id'];

    $sql = "INSERT INTO Permit (Permit_Type, VEHICLE_ID, Purchase_date, Expiry_date, Cost, DRIVER_ID, PAYMENT_ID) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissdii", $permit_type, $vehicle_id, $purchase_date, $expiry_date, $cost, $driver_id, $payment_id);

    if ($stmt->execute()) {
        $message = "Permit added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$vehicles = $conn->query("SELECT VEHICLE_ID, License_Plate FROM Vehicle");
$drivers = $conn->query("SELECT DRIVER_ID, CONCAT(firstname, ' ', lastname) AS DriverName FROM Users");
$payments = $conn->query("SELECT PAYMENT_ID FROM Payment");
include 'header.php';
?>


    <div class="container">
            <div class="row justify-content-center">
            <h2>Add New Permit</h2>

                    <?php if ($message): ?>
                        <p><?php echo $message; ?></p>
                    <?php endif; ?>

                <div class="col-md-8">
                    <div class="card">

                        <div class="card-body">
                            
                        <form action="add-permit.php" method="POST">
                            <label for="permit_type">Permit Type:</label>
                            <input type="text" id="permit_type" name="permit_type" required><br>

                            <label for="vehicle_id">Vehicle:</label>
                            <select id="vehicle_id" name="vehicle_id" required>
                                <option value="">Select Vehicle</option>
                                <?php while ($vehicle = $vehicles->fetch_assoc()): ?>
                                    <option value="<?php echo $vehicle['VEHICLE_ID']; ?>">
                                        <?php echo $vehicle['License_Plate']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select><br>

                            <label for="driver_id">Driver:</label>
                            <select id="driver_id" name="driver_id" required>
                                <option value="">Select Driver</option>
                                <?php while ($driver = $drivers->fetch_assoc()): ?>
                                    <option value="<?php echo $driver['DRIVER_ID']; ?>">
                                        <?php echo $driver['DriverName']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select><br>

                            <label for="purchase_date">Purchase Date:</label>
                            <input type="date" id="purchase_date" name="purchase_date" required><br>

                            <label for="expiry_date">Expiry Date:</label>
                            <input type="date" id="expiry_date" name="expiry_date" required><br>

                            <label for="cost">Cost ($):</label>
                            <input type="number" step="0.01" id="cost" name="cost" required><br>

                            <label for="payment_id">Payment ID:</label>
                            <select id="payment_id" name="payment_id" required>
                                <option value="">Select Payment</option>
                                <?php while ($payment = $payments->fetch_assoc()): ?>
                                    <option value="<?php echo $payment['PAYMENT_ID']; ?>">
                                        <?php echo $payment['PAYMENT_ID']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select><br>

                            <button type="submit">Add Permit</button>
                        </form>

                        <br>
                        <a href="list-permit.php"><button>Back to Permit List</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php $conn->close(); ?>
<?php include 'footer.php'; ?>

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $permit_type = mysql_entities_fix_string($conn,$_POST['selectedpermit']);
    $vehicle_id = mysql_entities_fix_string($conn,$_POST['vehicle_id']);
    $driver_id = mysql_entities_fix_string($conn,$_POST['driver_id']);
    $purchase_date = mysql_entities_fix_string($conn,$_POST['purchase_date']);
    $expiry_date = mysql_entities_fix_string($conn,$_POST['expiry_date']);
    $cost = mysql_entities_fix_string($conn,$_POST['permitcost']);
    $cc_num = mysql_entities_fix_string($conn,$_POST['cc_num']);

    // The assumption, in this limited demo, is that the cost will be a payment transaction
    // Only taking cedit cards
    $cash = 0;
    $check_no = '0';
    $sql = "Insert into payment (amount,Credit_Card_No,check_no,cash,Date)
                values (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dssds", $cost, $cc_no, $check_no, $cash, $purchase_date);
    $payment_id = 0;
    if ($stmt->execute()) 
        $payment_id = mysqli_insert_id($conn);
    else
        $payment_id = 99999;

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

// So a couple of wrinkles here  if there is just a solo user, not an admin, you can only select stuff related to yourself.
// Further wrinkle, the vehicle list should be filtered by the driver selected

if($did == '0'){
    $vehicles = $conn->query("SELECT VEHICLE_ID,Concat(License_Plate,'-',Make,'-',Model,'-',Color,'-', Year) as description FROM Vehicle");
    $drivers = $conn->query("SELECT DRIVER_ID, CONCAT(firstname, ' ', lastname) AS DriverName FROM Users");
}
else{
    $vehicles = $conn->query("SELECT VEHICLE_ID,Concat(License_Plate,'-',Make,'-',Model,'-',Color,'-', Year) as description 
    FROM vehicle v, users u where v.driver_id = u.driver_id and v.driver_id = $did ");
    $drivers = $conn->query("SELECT DRIVER_ID, CONCAT(firstname, ' ', lastname) AS DriverName FROM Users where DRIVER_ID = $did");
}


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
                            <select name="permit_type" id="permit_type" required onchange="updateCost() ">
                                <option value="No permit,00.00">Select Permit</option>
                                <option value="Permit A,828.00">Permit A</option>
                                <option value="Permit CA,883.00">Permit CA</option>
                                <option value="Permit CU,828.00">Permit CU</option>
                                <option value="Permit U,345.00">Permit U</option>
                                <option value="Semester U,172.50">Semester U</option>
                                <option value="Vendor,1331.70">Vendor</option>
                                <option value="Permit MR,2815.20">Permit MR</option>  
                                <option value="Permit R,2346.00">Permit R</option>
                                <option value="Permit T,1393.80">Permit T</option>
                                <option value="Motorcycle,115.20">Motorcycle</option>                         
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

                            <label for="vehicle_id">Vehicle:</label>
                            <select id="vehicle_id" name="vehicle_id" required>
                                <option value="">Select Vehicle</option>
                                <?php while ($vehicle = $vehicles->fetch_assoc()): ?>
                                    <option value="<?php echo $vehicle['VEHICLE_ID']; ?>">
                                        <?php echo $vehicle['description']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select><br>


                            <label for="purchase_date">Purchase Date:</label>
                            <input type="date" id="purchase_date" name="purchase_date" required><br>

                            <label for="expiry_date">Expiry Date:</label>
                            <input type="date" id="expiry_date" name="expiry_date" required><br>

                            <label for="cost">Cost ($):</label>
                            <input type="text" id="cost" name="cost" disabled><br>

                            <input type='hidden' id='permitcost' name='permitcost'>

                            <label for="cost">Credit Card:</label>
                            <input type="text" id="cc_num" name="cc_num" required><br>

                            <input type='hidden' id='selectedpermit' name='selectedpermit'>

                            <button type="submit">Add Permit</button>
                        </form>

                        <br>
                        <a href="list-permit.php"><button>Back to Permit List</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const cost = document.getElementById("cost"); 
        const permitcost = document.getElementById("permitcost"); 
        const permitname = document.getElementById("selectedpermit"); 

        const selectElement = document.getElementById("permit_type");

        function updateCost(){
    
            var permit_array  = selectElement.value.split(",")

            cost.value = permit_array[1]
            permitcost.value = permit_array[1]
            permitname.value = permit_array[0]
        }
        
    </script>
    <?php $conn->close(); ?>
<?php include 'footer.php'; ?>

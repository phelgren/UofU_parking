<?php
include 'header.php';
include 'authx/dbinfo.php';
require_once 'authx/sanitize.php';

global $conn;

if(isset($_GET['name']))
    $name = $_GET['name'];

if (isset($_GET['edit_id'])) {
    $permit_id = intval(mysql_entities_fix_string($conn,$_GET['edit_id']));
    
    // Fetch permit details
    $sql = "SELECT * FROM Permit WHERE PERMIT_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $permit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    global $permit;
    $permit = $result->fetch_assoc();
    
    if (!$permit) {
        echo "Permit not found.";
        exit;
    }
}


if (isset($_POST['updatepermit'])){

    $vehicle_id = mysql_entities_fix_string($conn,$_POST['vehicle_id']);

    $sql = "update Permit set VEHICLE_ID = $vehicle_id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    header("Location: list-permit.php");
  
  }

  if(isset($_GET['driverid'])){
    $driverid = mysql_entities_fix_string($conn,$_GET['driverid']);

    $vehicles = $conn->query("SELECT VEHICLE_ID,Concat(License_Plate,'-',Make,'-',Model,'-',Color,'-', Year) as description FROM vehicle v, users u where v.driver_id = u.driver_id and v.driver_id = $driverid ");
    }
?>

<div class="container">
<div class="row justify-content-center">
<h2>Edit Permit</h2>
<div class="col-md-8">
    <div class="card">

        <div class="card-body">
            Driver <?php echo $name ?>

        <p><h3><strong style="color:red;"> NOTE: You can only change the vehicle for a permit.  If you need a different permit type, add a new permit and delete this one. </strong></h3></p>

            <form method="post" action="edit-permit.php?edit_id=<?php echo $permit['PERMIT_ID']; ?>">
                <input type="hidden" name="permit_id" value="<?php echo $permit['PERMIT_ID']; ?>">
                
                <label for="vehicle_id">Vehicle:</label>
                            <select id="vehicle_id" name="vehicle_id" required>
                                <option value="">Select Vehicle</option>
                                <?php while ($vehicle = $vehicles->fetch_assoc()): ?>
                                    <option value="<?php echo $vehicle['VEHICLE_ID']; ?>">
                                        <?php echo $vehicle['description']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select><br>
                <label for="permit_type">Permit Type:</label>
                <input type="text" name="permit_type" id="permit_type" value="<?php echo $permit['Permit_Type']; ?>" disabled><br>
                Cost: <input type="text" name="cost" id="cost" value="<?php echo $permit['Cost']; ?>" disabled><br>
                Purchase Date: <input type="date" name="purchase_date" id="purchase_date" value="<?php echo $permit['Purchase_date']; ?>" disabled><br>
                Expiry Date: <input type="date" name="expiry_date" id="expiry_date" value="<?php echo $permit['Expiry_date']; ?>" disabled><br>
                <button type="submit">Update Permit</button>
                <input type='hidden' id='permitcost' name='permitcost' value="<?php echo $permit['Cost']; ?>">
                <input type='hidden' id='selectedpermit' name='selectedpermit'>
                <input type='hidden' id='updatepermit' name='updatepermit' value="yes">


            </form>
            <a href="list-permit.php"><button>Back to Permit List</button></a>
        </div>
    </div>
</div>
</div>

<?php
include 'footer.php';
?>
</div>
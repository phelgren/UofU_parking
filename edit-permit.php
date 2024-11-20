<?php

include 'authx\dbinfo.php';

global $conn;

if (isset($_GET['edit_id'])) {
    $permit_id = intval($_GET['edit_id']);
    
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
include 'header.php';

?>

<div class="container">
<div class="row justify-content-center">
<h2>Edit Permit</h2>
<div class="col-md-8">
    <div class="card">

        <div class="card-body">

            <form method="post" action="edit-permit.php?edit_id=<?php echo $permit['PERMIT_ID']; ?>">
                <input type="hidden" name="permit_id" value="<?php echo $permit['PERMIT_ID']; ?>">
                Permit Type: <input type="text" name="permit_type" value="<?php echo $permit['Permit_Type']; ?>"><br>
                Cost: <input type="text" name="cost" value="<?php echo $permit['Cost']; ?>"><br>
                Expiry Date: <input type="date" name="expiry_date" value="<?php echo $permit['Expiry_date']; ?>"><br>
                <button type="submit">Update Permit</button>

            </form>
        </div>
    </div>
</div>
</div>

<?php
include 'footer.php';
?>
</div>

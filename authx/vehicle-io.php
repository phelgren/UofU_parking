<?php
require_once 'dbinfo.php';

// Add user function

function getVehiclesForDriver($d_id){
global $conn;

$driver_id = mysql_entities_fix_string($conn,$d_id);

$sql = "SELECT Vehicle.License_Plate, Vehicle.Make, Vehicle.Model 
            FROM users 
            JOIN Vehicle ON users.driver_id = Vehicle.DRIVER_ID
            where users.driver_id = ? 
            ORDER BY vehicle.make, vehicle.model";

	//code to add user here

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $driver_id);
    $stmt->execute();
    $result = $stmt->get_result();

	if(!$result) die($conn->error);

    $content = <<<END
        <div class="col-md-4">
            <tr><td colspan='3'><strong> No Permits found</strong><td></tr>
        </div>
END;
    if($result->num_rows>0)
        $content = "";
    
        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $content = $content . <<<END
            <div class="col-md-4">
            <tr>
                <td>$row[Make]</td>
                <td>$row[Model]</td>
                <td>$row[License_Plate]</td>
            </tr>
            </div>
        END;

    }

    return $content;
}

?>
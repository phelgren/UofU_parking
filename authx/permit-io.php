<?php
require_once 'dbinfo.php';
require_once 'sanitize.php';

//$conn = new mysqli($hn, $un, $pw, $db);
//if($conn->connect_error) die($conn->connect_error);

// Add user function

function getPermitsForDriver($d_id){
global $conn;

$driver_id = mysql_entities_fix_string($conn,$d_id);


$sql = "SELECT Permit.Permit_Type, Permit.Expiry_date, Vehicle.License_Plate, Vehicle.Make, Vehicle.Model 
            FROM Permit 
            JOIN users ON Permit.DRIVER_ID = users.DRIVER_ID 
            JOIN Vehicle ON Permit.VEHICLE_ID = Vehicle.VEHICLE_ID 
            where users.driver_id = ? 
            ORDER BY Permit.PERMIT_ID";

	//code to add user here

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $driver_id);
    $stmt->execute();
    $result = $stmt->get_result();

	if(!$result) die($conn->error);

    echo $result->num_rows;

    $content = <<<END
        <div class="col-md-4">
            <tr><td colspan='3'><strong> No Permits found</strong><td></tr>
        </div>
END;
    if($result->num_rows>0)
        $content = "";
    
        for ($j=0; $j < $result->num_rows; $j++) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $content = $content .  <<<END
            <div class="col-md-4">
            <tr>
                <td>$row[Permit_Type]</td>
                <td>$row[Expiry_date]</td>
                <td>$row[License_Plate]</td>
            </tr>
            </div>
        END;
    }

    return $content;
}

?>
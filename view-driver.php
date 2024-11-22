<?php
  include('header.php');
  $page_roles = array('student','faculty','admin');
  require_once 'authx/checksession.php';
  require_once 'authx/driver-io.php';
  require_once 'authx/vehicle-io.php';
  require_once 'authx/permit-io.php';
    require_once 'authx/roletypes.php';

    $driver_id = $_GET['did'];

    $result = getDrivers('',$driver_id);

    $vehicleList = getVehiclesForDriver($driver_id);

    $permitList = getPermitsForDriver($driver_id);

    $driver = $result->fetch_array(MYSQLI_ASSOC);
    $role = $driver['driver_type'];
    $typelist = listtypes($role);

echo <<<_END
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Edit driver information for $driver[firstname] $driver[lastname] </div>
                        <div class="card-body">
                        <form action="list-drivers.php" method="post">

                                    <label for="first-name" class="col-md-4 control-label">First Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="first-name" class="form-control" name="first-name" value="$driver[firstname]" disabled autofocus>
                                    </div>

                                    <label for="last-name" class="col-md-4 control-label">Last Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="last-name" class="form-control" name="last-name" value="$driver[lastname]" disabled>
                                    </div>
                                    <label for="last-name" class="col-md-4 control-label">User Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="user-name" class="form-control" name="user-name" value="$driver[username]" disabled>
                                    </div>
                                    <label for="email-address" class="col-md-4 control-label">Email Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email-address" class="form-control" name="email-address" value="$driver[email]" disabled>
                                    </div>

                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password" disabled>
                                    </div>
                                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="address" class="form-control" name="address" value="$driver[address]" disabled>
                                    </div>
                                    <label for="sel-type" class="col-md-4 col-form-label text-md-right">Driver type</label>
                                    <div class="col-md-6">
                                        <select aria-label="Select permit type" id="sel-type"  name="sel-type" disabled>
                                            $typelist
                                        </select>
                                    </div>
_END;

                                if(in_array('admin',$_SESSION['roles'])){
                                echo <<<_END
                                    <div class="col-md-4">
                                        <a href="delete-driver.php?did=$driver[driver_id]" class="btn btn-info" role="button">Delete this driver</a>
                                    </div>
                                _END;
                                }
                                echo <<<_END
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Return
                                    </button>
                                </div>      

                        </form>
                    </div>
                </div>
            </div>

                <div class="col-md-4">
                        <div class="card">
                        <div class="card-header"><strong>Vehicles for $driver[firstname] $driver[lastname] </strong></div>
                        <div class="card-body">
                        <table class="table table-bordered table-striped">
                        <thead><tr><th> Vehicle Make</th><th> Vehicle Model</th><th> License plate</th><tr></thead>
                        $vehicleList
                        </table>
                        </div>
                        </div>

                </div>
                    <div class="col-md-4">
                        <div class="card">
                        <div class="card-header"><strong>Permits for $driver[firstname] $driver[lastname] </strong></div>
                        <div class="card-body">
                        <table class="table table-bordered table-striped">
                        <thead><tr><th> Permit Type</th><th> Expiration date</th><th> License plate</th><tr></thead>
                        $permitList
                        </table>
                        </div>
                        </div>
                </div>

            </div>

_END;

  include('footer.php');
?>
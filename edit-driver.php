<?php
  include('header.php');
  $page_roles = array('student','faculty','admin');
  require_once 'authx\checksession.php';
  require_once 'authx\driver-io.php';
  require_once 'authx\roletypes.php';

    $driver_id = $_GET['did'];
    $result = getDrivers('',$driver_id);

    $driver = $result->fetch_array(MYSQLI_ASSOC);
    $role = $driver['driver_type'];
    $typelist = listtypes($role);
    $hidden = 'hidden';

    if(in_array('admin',$_SESSION['roles']))
        $hidden = '';
    
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
                                        <input type="text" id="first-name" class="form-control" name="first-name" value="$driver[firstname]" required autofocus>
                                    </div>

                                    <label for="last-name" class="col-md-4 control-label">Last Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="last-name" class="form-control" name="last-name" value="$driver[lastname]" required>
                                    </div>
                                    <label for="last-name" class="col-md-4 control-label">User Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="user-name" class="form-control" name="user-name" value="$driver[username]" required>
                                    </div>
                                    <label for="email-address" class="col-md-4 control-label">Email Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email-address" class="form-control" name="email-address" value="$driver[email]" required>
                                    </div>

                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password(only if changing)</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password">
                                    </div>
                                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="address" class="form-control" name="address" value="$driver[address]" required>
                                    </div>
                                    <label for="dtype" class="col-md-4 col-form-label text-md-right" $hidden>Driver type</label>
                                    <div class="col-md-6">
                                        <select aria-label="Select driver type" id="dtype"  name="dtype" $hidden>
                                            $typelist
                                        </select>
                                    </div>
_END;

                                if(in_array('admin',$_SESSION['roles'])){
                                echo <<<_END
                                    <div class="col-md-3">
                                        <a href="delete-driver.php?did=$driver[driver_id]" class="btn btn-info" role="button">Delete this driver</a>
                                    </div>
                                _END;
                                }
                                echo <<<_END
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>      
                                <input type='hidden' name='did' value=$driver[driver_id] >
                                <input type='hidden' name='update' value='yes'>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
_END;

  include('footer.php');
?>
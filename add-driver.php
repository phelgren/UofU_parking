<?php
  include('header.php');
  $page_roles = array('admin');
  require_once 'authx/checksession.php';
  require_once 'authx/driver-io.php';
  require_once 'authx/roletypes.php';
  require_once 'authx/sanitize.php';
  
    $username = mysql_entities_fix_string($conn,$_SESSION['username']);
    $result = getDrivers($username,'');

    $driver = $result->fetch_array(MYSQLI_ASSOC);
    $role = $driver['driver_type'];
    $typelist = listtypes($role);
    $hidden = 'hidden';

    if(isAdmin($conn,$username))
        $hidden = '';
    
echo <<<_END
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Add a new driver </div>
                        <div class="card-body">
                        <form action="list-drivers.php" method="post">

                                    <label for="first-name" class="col-md-4 control-label">First Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="first-name" class="form-control" name="first-name" required autofocus>
                                    </div>

                                    <label for="last-name" class="col-md-4 control-label">Last Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="last-name" class="form-control" name="last-name" required>
                                    </div>
                                    <label for="last-name" class="col-md-4 control-label">User Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="user-name" class="form-control" name="user-name"  required>
                                    </div>
                                    <label for="email-address" class="col-md-4 control-label">Email Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email-address" class="form-control" name="email-address" required>
                                    </div>

                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password(only if changing)</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password">
                                    </div>
                                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="address" class="form-control" name="address"  required>
                                    </div>
                                    <label for="dtype" class="col-md-4 col-form-label text-md-right" $hidden>Driver type</label>
                                    <div class="col-md-6">
                                        <select aria-label="Select driver type" id="dtype"  name="dtype" $hidden>
                                            $typelist
                                        </select>
                                    </div>
_END;


                                echo <<<_END
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>      

                                <input type='hidden' name='adddriver' value='yes'>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
_END;

  include('footer.php');
?>
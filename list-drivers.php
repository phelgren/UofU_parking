<?php
  include('header.php');
  $page_roles = array('admin','faculty','student');
  require_once 'authx\checksession.php';
  require_once 'authx\driver-io.php';

  if(in_array('admin',$_SESSION['roles'])){
    echo <<<_END
      <div class="container">
      <a href="add-driver.php" class="btn btn-info" role="button">Add a new driver</a>
    _END;
  }else
    echo "<div class='container'>";
echo <<<_END

    <h1 > Driver List</h1>
    <table class="table table-bordered table-striped">
    <thead><tr><th> Driver Info</th><th> Actions </th><tr></thead>
    <tbody>
_END;

$result = '';
// So, admin folks have access to all drivers, but student, faculty, and guests only see themselves
if(in_array('admin',$_SESSION['roles']))
    $result = getDrivers('','');
  else
    $result = getDrivers($_SESSION['username'],'');

$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)
{
  $row = $result->fetch_array(MYSQLI_ASSOC);

  echo <<<_END

      <tr>
      <td>$row[firstname] $row[lastname] ID: $row[driver_id]</td>
      <td> <a href='edit-driver.php?did=$row[driver_id]&firstname=$row[firstname]&lastname= $row[lastname]' class='btn btn-info' role='button'>Edit</a></td>
      <td> <a href='view-driver.php?did=$row[driver_id]' class='btn btn-info' role='button'>View</a></td></tr>

  _END;
  
}

echo <<<_END
  </table>
    </tbody>
</div>
_END;

  include('footer.php');
?>
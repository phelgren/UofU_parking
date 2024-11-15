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
    <ul class="list-group">
_END;

$result = getDrivers('');
$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)
{
  $row = $result->fetch_array(MYSQLI_ASSOC);

  echo <<<_END

      <li class='list-group-item'>$row[firstname] $row[lastname] ID: $row[driver_id] <a href='edit-driver.php' class='btn btn-info' role='button'>Edit</a> <a href='view-driver.php' class='btn btn-info' role='button'>View</a></li>

  _END;
  
}

echo <<<_END
    </ul>
</div>
_END;

  include('footer.php');
?>
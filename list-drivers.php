<?php
  include('header.php');
  $page_roles = array('admin','faculty','admin');
  require_once 'authx\checksession.php';
?>
<div class="container">
<a href="add-driver.php" class="btn btn-info" role="button">Add a new driver</a>

    <h1 > Driver List</h1>
    <ul class="list-group">
    <li class="list-group-item">Driver name and ID <a href="edit-driver.php" class="btn btn-info" role="button">Edit</a> <a href="view-driver.php" class="btn btn-info" role="button">View</a></li>
    <li class="list-group-item">Driver name and ID <a href="edit-driver.php" class="btn btn-info" role="button">Edit</a> <a href="view-driver.php" class="btn btn-info" role="button">View</a></li>
    <li class="list-group-item">Driver name and ID <a href="edit-driver.php" class="btn btn-info" role="button">Edit</a> <a href="view-driver.php" class="btn btn-info" role="button">View</a></li>
    <li class="list-group-item">Driver name and ID <a href="edit-driver.php" class="btn btn-info" role="button">Edit</a> <a href="view-driver.php" class="btn btn-info" role="button">View</a></li>
    <li class="list-group-item">Driver name and ID <a href="edit-driver.php" class="btn btn-info" role="button">Edit</a> <a href="view-driver.php" class="btn btn-info" role="button">View</a></li>
    <li class="list-group-item">Driver name and ID <a href="edit-driver.php" class="btn btn-info" role="button">Edit</a> <a href="view-driver.php" class="btn btn-info" role="button">View</a></li>
    </ul>
</div>
<?php
  include('footer.php');
?>
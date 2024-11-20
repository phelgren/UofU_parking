<?php
require_once 'authx\utilities.php';

?>

<html>
    <title> U of U Parking System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="styles.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body id="myPage">
<!-- Navbar -->
	<nav class="navbar navbar-default">
	  <div class="container">
		<div class="navbar-header">
		   <a class="navbar-brand" href="#home"><span><img src='images\uofu.png' height='50' width='50'></span></a>
		</div>
		<div class="collapse navbar-collapse" id="upnavbar">
		  <ul class="nav navbar-nav navbar-right">
		  <?php
			if(isset($_SESSION['username']))
				echo '<li><a href="logout.php">LOGOUT</a></li>';
			else
				echo '<li><a href="login.php">LOGIN</a></li>';
			?>
		  </ul>
		</div>
	  </div>
	</nav>

    <!--Header-->
    <div class="jumbotron text-center">
        <h1>U of U Parking System</h1>
        <p> Put 'er there...'.</p>
    </div>

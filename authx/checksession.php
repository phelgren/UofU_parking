<?php

require_once 'user.php';

//session_start();

if(!isset($_SESSION['user'])){
	// Head to login
	header("Location: login.php");
	exit();
}else{
	$user = $_SESSION['user'];
	$username = $user->username;
	$user_roles = $user->getRoles();
	
	$found=0;
 	foreach($user_roles as $urole){

		foreach($page_roles as $prole){

			if($urole == $prole){
				$found=1;
			}
		}
	}
	
	if(!$found){
		//print_r($user_roles);
		//print_r($page_roles);
		header("Location: unauthorized.php");
		exit();
	}
}
?>
<?php
require_once 'dbinfo.php';

updatePwd('pjones','acrobat');
updatePwd('bsmith','mysecret');
updatePwd('phelgren','pass123');  //no sweat Github, this is a demo...

function updatePwd($username,$pwd){
   GLOBAL $hn,$db,$un,$pw;
 
    $conn = new mysqli($hn, $un, $pw, $db);

    if ($conn->connect_error) die("Fatal Error");

    $token = password_hash($pwd,PASSWORD_DEFAULT);

    $query = "update users set password = '$token' where username = '$username'";

    $result = $conn->query($query);

	if(!$result) die($conn->error);

}

?>

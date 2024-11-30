<?php
require_once 'dbinfo.php';

updatePwd('pjones','acrobat');
updatePwd('bsmith','mysecret');
updatePwd('phelgren','secure_me!');  //no sweat Github, this is a demo...
updatePwd('jdoe', 'secure_me!');
updatePwd('jsmith', 'secure_me!');
updatePwd('ajohnson', 'secure_me!');
updatePwd('bwilliams',  'secure_me!');
updatePwd('cbrown', 'secure_me!');
updatePwd( 'dmiller', 'secure_me!');
updatePwd('edavis',  'secure_me!');
updatePwd('fgarcia', 'secure_me!');
updatePwd('gmartinez', 'secure_me!');
updatePwd('hlopez','secure_me!');
updatePwd('iclark', 'secure_me!');
updatePwd('jharris',  'secure_me!');
updatePwd('klewis',  'secure_me!');
updatePwd('lwalker',  'secure_me!');
updatePwd( 'mrobinson', 'secure_me!');

function updatePwd($username,$pwd){
   GLOBAL $hn,$db,$un,$pw;
 
    $conn = new mysqli($hn, $un, $pw, $db);

    if ($conn->connect_error) die("Fatal Error");

    $token = password_hash($pwd,PASSWORD_DEFAULT);

    $query = "update users set password = '$token' where username = '$username'";

   // needed to generate visible passwords -- echo $token .','.$username;

    $result = $conn->query($query);

	if(!$result) die($conn->error);

}

?>

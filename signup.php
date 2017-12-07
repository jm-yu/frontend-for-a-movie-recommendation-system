<?php
ob_start();
session_start();
include "dbconf.php";

$myusername = $_POST['s_username']; 
$mypassword = $_POST['s_password_1']; 
$email = $_POST['s_email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div>Email address ".$email." is considered valid.\n</div>";
    exit;
}
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
try{
	$conn = new PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//$sql = "CREATE DATABASE myDB";
	$user_id = uniqid("u");
	$sql = "insert into user_table_test (user_id, username, user_email, password)values('".$user_id."', '".$myusername."', '".$email."', '".$mypassword."')";
	//echo $sql;
	$conn->query($sql);
	//$count = $stmt->rowCount();
	//echo var_dump($count);
}
catch(PDOException $e){
	echo "<div>username ".$myusername." has been used</div>";
	exit;
}

//$sql = "SELECT * FROM user_info WHERE username='".$myusername."' and password='".$mypassword."'";

	// If result matched $myusername and $mypassword, table row must be 1 row
echo "true";
?>
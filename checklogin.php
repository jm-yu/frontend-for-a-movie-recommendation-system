<?php
ob_start();
session_start();
include "dbconf.php";


$myusername = $_POST['myusername']; 
$mypassword = $_POST['mypassword']; 
	// To protect MySQL injection
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
try{
	$conn = new PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//$sql = "CREATE DATABASE myDB";
	$sql = "SELECT * FROM user_table_test WHERE username='".$myusername."' and password='".$mypassword."'";
	//echo $sql;
	$stmt = $conn->query($sql);
	$count = $stmt->rowCount();
	//echo var_dump($count);
}
catch(PDOException $e){
	die("Error:".$e->getMessage());
}

//$sql = "SELECT * FROM user_info WHERE username='".$myusername."' and password='".$mypassword."'";

	// If result matched $myusername and $mypassword, table row must be 1 row
if($count == 1){
		// Register $myusername, $mypassword and print "true"
	echo "true";
	$_SESSION['username'] = $myusername;
	$_SESSION['password'] = $mypassword;		
} else {
	//return the error message
	echo "<div>Wrong Username or Password</div>";
}
?>
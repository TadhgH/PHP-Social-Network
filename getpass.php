<?php
ob_start();
include("./inc/header.php"); 

$bool = "";
$oldpassword = "";
$db_password="";

if(isset($_POST['oldpass'])){
	$password_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
	while($row = mysqli_fetch_assoc($password_query)){
		
		$oldpassword = @$_POST['oldpass'];
		$oldpassword = md5($oldpassword);
		$db_password = $row['password'];
		
		if($oldpassword === $db_password){
			$bool = 1;
		}else {
			$bool = 0;
		}
	}	
}
ob_clean();
echo "$bool";
ob_end_flush();
?>
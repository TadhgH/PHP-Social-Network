<?php 
include("inc/connect.php");

session_start();
if(!isset($_SESSION["user_login"])){
	$username = "";
} else {
	$username = $_SESSION["user_login"];
	//header("location: home.php");
}

$post = $_POST['post'];
if($post != ""){
	$date_added = date("Y-m-d");
	$added_by = "$username";
	$user_posted_to = "Q";

	$sqlCommand = "INSERT INTO posts VALUES('', '$post', '$date_added', '$added_by', '$user_posted_to')";
	$query = mysqli_query($con, $sqlCommand) or die (mysql_error());
} else {
	echo "Abyssum abyssus invocat...";
}
?>
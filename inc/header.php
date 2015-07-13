<?php include("inc/connect.php");
$con = mysqli_connect("localhost", "root", "pass", "enola")or die("Couldnt connect host");
session_start();
if(!isset($_SESSION["user_login"])){
	$username = "";
} else {
	$username = $_SESSION["user_login"];
	//header("location: home.php");
}
 ?>
<!doctype html>
<html>
	<head>
		<title>whutever</title>
		<link rel="stylesheet" text="text/css" href="./css/style.css">
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
	</head>
	<body>
		<div class="headerMenu">
			<div id="wrapper">
				<div class="logo">
					<img src="img/thelema.png" alt="">
				</div>
				<div class="search_box">
					<form id="search" method="GET" action="search.php">
						<input type="text" name="q" size="60" placeholder="Search..."/>
					</form>
				</div>


				<div id="menu">
					<?php
					if(!$username){
					echo '<a href="#">Home</a>
						<a href="#">About</a>
						<a href="index.php">Sign Up</a>
						<a href="index.php">Login</a>';
					} else {
						echo '
						<a href="profile.php?u='.$username.'">Profile</a>
						<a href="account_settings.php">Account Settings</a>
						<a href="logout.php">Logout</a>
						';
					}
					?> 
					
					<!--JQuery workarounds-->
					
				</div>
			</div>
		</div>
		<div id="wrapper">
		<br>
		<br>
		<br>
		

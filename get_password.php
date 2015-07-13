<?php
	
$password_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
$row = mysqli_fetch_assoc($password_query);
$db_password = $row['password'];
echo "$username";


?>
<?php

include("./inc/header.php"); 

$new_fname = strip_tags(@$_POST['fname']);
$new_lname = strip_tags(@$_POST['lname']);
$new_bio = strip_tags(@$_POST['bio']);

echo "$username";
$query = mysqli_query($con,
 "UPDATE users SET first_name='$new_fname', last_name='$new_lname', bio='$new_bio' WHERE username='$username'");

?>
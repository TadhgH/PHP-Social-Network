<?php 
$con = mysqli_connect("localhost", "root", "pass")or die("Couldnt connect host");

if (!$con) 
{
	echo('Could not connect: ' . mysql_error());
}
mysqli_select_db($con, "enola") or die("Couldnt select db");

?>
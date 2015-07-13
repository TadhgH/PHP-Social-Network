<?php include("./inc/header.php"); ?>
<?php

//Find friend requests
$findRequests = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$username'");
$numrows = mysqli_num_rows($findRequests);
if($numrows == 0){
	echo "you got no friend requests!";
	$user_from = "";
} else {
	while($get_row = mysqli_fetch_assoc($findRequests)){

		$id = $get_row['id'];
		$user_to = $get_row['user_to'];
		$user_from = $get_row['user_from'];

		echo "".$user_from." wants to be your friend <br />";

?>
<?php 
if (isset($_POST['acceptrequest'.$user_from])) {

  //Get friend array for logged in user
  $get_friend_check = mysqli_query($con, "SELECT friend_array FROM users WHERE username='$username'");
  $get_friend_row = mysqli_fetch_assoc($get_friend_check);
  $friend_array = $get_friend_row['friend_array'];
  $friendArray_explode = explode(",",$friend_array);
  $friendArray_count = count($friendArray_explode);

  //Get friend array for person who sent request
  $get_friend_check_friend = mysqli_query($con, "SELECT friend_array FROM users WHERE username='$user_from'");
  $get_friend_row_friend = mysqli_fetch_assoc($get_friend_check_friend);
  $friend_array_friend = $get_friend_row_friend['friend_array'];
  $friendArray_explode_friend = explode(",",$friend_array_friend);
  $friendArray_count_friend = count($friendArray_explode_friend);

  if ($friend_array == "") {
     $friendArray_count = count(NULL);
  }
  if ($friend_array_friend == "") {
     $friendArray_count_friend = count(NULL);
  }
  if ($friendArray_count == NULL) {
   $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,'$user_from') WHERE username='$username'");
  }
  if ($friendArray_count_friend == NULL) {
   $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,'$user_to') WHERE username='$user_from'");
  }
  if ($friendArray_count >= 1) {
   $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,',$user_from') WHERE username='$username'");
  }
  if ($friendArray_count_friend >= 1) {
   $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,',$user_to') WHERE username='$user_from'");
  }
  $delete_request = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$user_to'&&user_from='$user_from'");
  echo "You are now friends!";
  header("Location: friend_requests.php");

}

if(isset($_POST['ignorerequest'.$user_from])){
	$ignore_request = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$user_to'&&user_from='$user_from'");
	echo "".$user_from." Rejected!";
 	header("Location: friend_requests.php");
}
?>
<form action="friend_requests.php" method="POST">
<input type="submit" name="acceptrequest<?php echo $user_from; ?>" value="Accept Request">
<input type="submit" name="ignorerequest<?php echo $user_from; ?>" value="Ignore Request">
</form>
<?php		
}
}
?>
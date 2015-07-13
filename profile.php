<?php include("./inc/header.php"); ?>
<?php

if(isset($_GET['u'])){
	$user = mysqli_real_escape_string($con, $_GET['u']);
	if(ctype_alnum($user)){
		$check = mysqli_query($con, "SELECT username, first_name FROM users WHERE username='$user'");
		if(mysqli_num_rows($check)===1){
			$get = mysqli_fetch_assoc($check);
			$user = $get['username'];
			$firstname = $get['first_name'];
		} else {
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/tutorials/findFriends/index.php\">";
			exit();
		}
	}
}
$profile ="profile.php?u=".$user;
$post = @$_POST['post'];
if($post != ""){
	$date_added = date("Y-m-d");
	$added_by = "$username";
	$user_posted_to = "$user";

	$sqlCommand = "INSERT INTO posts VALUES('', '$post', '$date_added', '$added_by', '$user_posted_to')";
	$query = mysqli_query($con, $sqlCommand) or die (mysql_error());
}

$check_pic = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user'");
$get_pic_row = mysqli_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];

if($profile_pic_db == ""){
	$profile_pic = "img/default_pic.jpg";
} else{
	$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}
?>
<div id="status"></div>

<div class="postForm">
	<form action="<?php echo $profile; ?>" method="POST">
	<textarea name="post" id="post" cols="80" rows="5"></textarea>
	<!--<input type="submit" onclick="javascript:send_post()" name="send" value="Post" id="postForm_input">-->
	<input type="submit" name="send" value="Post" id="postForm_input">
	</form>
</div>

<div class="profilePosts">
<?php
	$getposts = mysqli_query($con, "SELECT * FROM posts WHERE user_posted_to='$user' ORDER BY id DESC LIMIT 10") or die(mysql_error());
	while($row = mysqli_fetch_assoc($getposts)){
		$id = $row['id'];
		$body = $row['body'];
		$date_added = $row['date_added'];
		$added_by = $row['added_by'];
		$user_posted_to = $row['user_posted_to'];
		echo "<br/><div class='posted_by'><a href='$added_by'>$added_by</a> - $date_added - </div>&nbsp;&nbsp;$body<br class='postBreak'/><hr />";
	}
?>
<?php 
	if(isset($_POST['addfriend'])){
		
		$friend_request = $_POST['addfriend'];
		$user_to = $user;
		$user_from = $username;

		echo "$user_to : $user_from";

		if($user_to == $username){
			echo "chnt send request to selv";
		} else {
			$create_request = mysqli_query($con, "INSERT INTO friend_requests VALUES ('', '$user_from', '$user_to')");

		}
	} else {

	}
?>
</div>

<img src="<?php echo $profile_pic; ?>" height="250" width="200" alt="<?php echo $username; ?>'s Profile" title="<?php echo $username; ?>'s Profile">
<br>

<form action="<?php echo "profile.php?u=".$user; ?>" method="POST">
<?php
$friendArray = "";
$countFriends = "";
$friendsArray12 = "";
$addAsFriend = "";
$i = 0;
$selectFriendsQuery = mysqli_query($con, "SELECT friend_array FROM users WHERE username='$user'");
$friendRow = mysqli_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];

if($friendArray != ""){
	$friendArray = explode(",", $friendArray);
	$countFriends = count($friendArray);
	$friendArray12 = array_slice($friendArray, 0, 12);//slice array into individual strings

	if(in_array($username, $friendArray)){
		$addAsFriend = '<input type="submit" name="removefriend" value="Remove">';
	} else {
		$addAsFriend = '<input type="submit" name="addfriend" value="Add">';
	}
	echo $addAsFriend;
} else {
	$addAsFriend = '<input type="submit" name="addfriend" value="Add">';
	echo $addAsFriend;
}
if(@$_POST['removefriend']){
	echo "string";
	//Logged in user
	$add_friend_check = mysqli_query($con, "SELECT friend_array FROM users WHERE username='$username'");
	$get_friend_row = mysqli_fetch_assoc($add_friend_check);
	$friend_array = $get_friend_row['friend_array'];
	$friend_array_explode = explode(",",$friend_array);
	$friend_array_count = count($friend_array_explode);

	//Other user
	$add_friend_check_other = mysqli_query($con, "SELECT friend_array FROM users WHERE username='$user'");
	$get_friend_row_other = mysqli_fetch_assoc($add_friend_check_other);
	$friend_array_other = $get_friend_row_other['friend_array'];
	$friend_array_explode_other = explode(",",$friend_array_other);
	$friend_array_count_other = count($friend_array_explode_other);

	$usernameComma = ",".$username;
	$usernameComma2 = $username.",";
	$userComma = ",".$user;
	$userComma2 = $user.",";

	$friend1 = "";
	$friend2 = "";
	//This should be done in a function

		//Remove logged in
	if(strstr($friend_array,$usernameComma)){
		$friend = str_replace("$usernameComma","",$friend_array);
	}
	else if(strstr($friend_array,$usernameComma2)){
		$friend = str_replace("$usernameComma2","",$friend_array);
	}
	else if(strstr($friend_array,$username)){
		$friend = str_replace("$username","",$friend_array);
	}

	//Remove other
	if(strstr($friend_array_other,$userComma)){
		$other = str_replace("$userComma","",$friend_array);
	}
	else if(strstr($friend_array_other,$userComma2)){
		$other = str_replace("$userComma2","",$friend_array);
	}
	else if(strstr($friend_array_other,$user)){
		$other = str_replace("$user","",$friend_array);
	}


	$removeFriendQuery = mysqli_query($con, "UPDATE users SET friend_array='$friend' WHERE username='$username'");
	$removeFriendQuery2 = mysqli_query($con, "UPDATE users SET friend_array='$other' WHERE username='$user'");

	$pageRefresh = "profile.php?u=".$user;
	header("Location: $pageRefresh");
}
?>
	
	<input type="submit" name="sendmsg" value="Send Message">
</form>

<div class="textHeader"><?php echo $user; ?>'s Profile</div>
<div class="profileLeftSideContent">

<?php
	$about_query = mysqli_query($con, "SELECT bio FROM users WHERE username='$user'");
	$get_result = mysqli_fetch_assoc($about_query);
	$about_the_user = $get_result['bio'];
	echo "$about_the_user";
?>
</div>
<div class="textHeader"><?php echo $user; ?>'s friends</div>
<div class="profileLeftSideContent">
<?php
echo '<div id="profileFriends">';
if($countFriends != 0){
	foreach($friendArray12 as $key => $value){
		$i++;
		$getFriendQuery = mysqli_query($con, "SELECT * FROM users WHERE username='$value' LIMIT 1");
		$getFriendRow = mysqli_fetch_assoc($getFriendQuery);
		$friendUsername = $getFriendRow['username'];
		$friendProfilePic = $getFriendRow['profile_pic'];
		$friendLink = "profile.php?u=".$friendUsername;

		if($friendProfilePic == ""){
			echo "<a href='$friendLink'><img src='img/default_pic.jpg' alt='$friendUsername' title='$friendUsername' height='50' width='40' style='padding-right=6px;'/></a>";
		} else {
			echo "<a href='$friendLink'><img src='userdata/profile_pics/".$friendProfilePic."' alt='$friendUsername' title='$friendUsername' profile height='50' width='40' style='padding-right=6px;'/></a>";
		}
	}
}else {
	echo $user."has no friends yet";
}
echo "</div>";
?>	
 

</div>
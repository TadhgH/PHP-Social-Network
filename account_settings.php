<?php 
include("./inc/header.php"); 
if ($username) {

} else {
	die ("you must be logged in to view settings");
}
?>

<?php
 // Fetching Values from URL.
$newpassword = @$_POST['newp'];

if(isset($newpassword)){
	$newpassword_md5 = md5($newpassword);
	$password_update_query = mysqli_query($con, "UPDATE users SET password='$newpassword_md5' WHERE username='$username'");
} else {
	
}

$get_info = mysqli_query($con, "SELECT first_name, last_name, bio FROM users WHERE username='$username'");
$get_row = mysqli_fetch_assoc($get_info);
$db_firstname = $get_row['first_name'];
$db_lastname = $get_row['last_name'];
$db_bio = $get_row['bio'];

//profile image
$check_pic = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$username'");
$get_pic_row = mysqli_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];

if($profile_pic_db == ""){
	$profile_pic = "img/default_pic.jpg";
} else{
	$profile_pic = "userdata/profile_pics/".$profile_pic_db;
}

//profile image upload
if(isset($_FILES['profilepic'])){
	if((@$_FILES['profilepic']["type"]=="image/jpeg" || @$_FILES['profilepic']["type"]=="image/png" || @$_FILES['profilepic']["type"]=="image/gif") && (@$_FILES['profilepic']['size']<1048576)){
		
		$rand_dir_name = $username;
		
		if(file_exists("userdata/profile_pics/$rand_dir_name")) {
		} else {
			mkdir("userdata/profile_pics/$rand_dir_name");
		}
		
		if(file_exists("userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"])){
			$profile_pic = "userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
		} else {
			
			move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/profile_pics/$rand_dir_name/".$_FILES["profilepic"]["name"]);
			echo "Uploaded".@$_FILES["profilepic"]["name"]."  userdata/profile_pics/$rand_dir_name/";
		    $profile_pic_name = @$_FILES["profilepic"]["name"];
		    $profile_pic_query = mysqli_query($con, "UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username='$username'");
		    header("Location: account_settings.php");
		}
	} else {
		echo "invalid file type/size";
	}
}



?>

<h2>Edit your Account Settings</h2>

<hr/>
<p>UPLOAD YOUR PROFILE PHOTO:</p>

<form action="" method="POST" enctype="multipart/form-data">
	<img src="<?php echo $profile_pic; ?>" width="70" alt="">
	<input type="file" name="profilepic" /><br />
	<input type="submit" name="uploadpic" value="Upload Image">
</form>

<hr>
<form action="account_settings.php">
<p>Change Your Password</p><br>
Your old password: <input type="password" name="oldpassword" id="oldpassword" size="30"><br>
Your new password: <input type="password" name="newpassword" id="newpassword" size="30"><br>
Repeat password: <input type="password" name="repeatpassword" id="repeatpassword" size="30"><br>
<input type="submit" name="sendpass" id="sendpass" ><!--value="Update Information"-->
</form>
<hr/>

<form action="account_settings.php">
<p>Update Your Profile Info</p><br>
First Name: <input type="text" name="fname" id="fname" size="30" value="<?php echo $db_firstname;?>"><br>
Last Name: <input type="text" name="lname" id="lname" size="30" value="<?php echo $db_lastname;?>"><br>
About You: <textarea name="aboutyou" id="bio" cols="45" rows="2"><?php echo $db_bio;?></textarea><br>
<input type="submit" name="sendbio" id="sendbio" ><!--value="Update Information"-->
</form>
<hr>

<br>
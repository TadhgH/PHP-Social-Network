<?php include("./inc/header.php"); ?>
<?php 
$reg = @$_POST['reg'];

//declaring variables to prevent errors
$fn = "";
$ln = "";
$un = "";
$em = "";
$pswd = "";
$pswd2 = "";
$d = "";
$u_check = "";
//registration form
$fn = strip_tags(@$_POST['fname']);
$ln = strip_tags(@$_POST['lname']);
$un = strip_tags(@$_POST['username']);
$em = strip_tags(@$_POST['email']);
$pswd = strip_tags(@$_POST['password']);
$pswd2 = strip_tags(@$_POST['password2']);
$d = date("Y-m-d");

//if form is submitted run code
if ($reg) {

// Check if user already exists
$u_check = mysqli_query($con,"SELECT username FROM users WHERE username='$un'")or die(mysqli_error());
// Count the amount of rows where username = $un
$check = mysqli_num_rows($u_check);
//Check whether Email already exists in the database
$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'")or die(mysqli_error());
//Count the number of rows returned
$email_check = mysqli_num_rows($e_check);
if ($check == 0) {
if ($email_check == 0) {
//check all of the fields have been filed in
if ($fn&&$ln&&$un&&$em&&$pswd&&$pswd2) {
// check that passwords match
if ($pswd==$pswd2) {
// check the maximum length of username/first name/last name does not exceed 25 characters
if (strlen($un)>25||strlen($fn)>25||strlen($ln)>25) {
echo "The maximum limit for username/first name/last name is 25 characters!";
}
else
{
// check the maximum length of password does not exceed 25 characters and is not less than 5 characters
if (strlen($pswd)>30||strlen($pswd)<5) {
echo "Your password must be between 5 and 30 characters long!";
}
else
{
//encrypt password and password 2 using md5 before sending to database
$pswd = md5($pswd);
$pswd2 = md5($pswd2);


$query = mysqli_query($con, "INSERT INTO users(username, first_name, last_name, email, password, sign_up_date) VALUES('".$un."','".$fn."','".$ln."','".$em."','".$pswd."','".$d."')") or die('Error: ' . mysqli_error($con));
die("<h2>Welcome to findFriends</h2>Login to your account to get started ...");
}
}
}
else {
echo "Your passwords don't match!";
}
}
else
{
echo "Please fill in all of the fields";
}
}
else
{
 echo "Sorry, but it looks like someone has already used that email!";
}
}
else
{
echo "Username already taken ...";
}
}

//User Login Code

if (isset($_POST["user_login"]) && isset($_POST["password_login"])){
	$user_login = preg_replace('#[^A-Za-z0-9]#i','', $_POST["user_login"]);
	$password_login = preg_replace('#[^A-Za-z0-9]#i','', $_POST["password_login"]);
	$password_login_md5 = md5($password_login);
	$sql = mysqli_query($con, "SELECT id FROM users WHERE username='$user_login' AND password='$password_login_md5' LIMIT 1")or die("yo");
	$userCount = mysqli_num_rows($sql);
	print "NOT $userCount";
	if($userCount == 1){
		while($row = mysql_fetch_array($sql)){
			$id = $row["id"];
		}
		$_SESSION["user_login"] = $user_login;
		header("location: home.php");
		exit();
	}else {
		echo 'Information is incorrect';
		exit();
	}
}

?>
		
			<table>
			<tr>
				<td width="60%" valign="top">
					<h2>Already a member? Sign in below!</h2>
					<form action="index.php" method="POST">
						<input type="text" name="user_login" size="25" placeholder="Username"><br/><br/>
						<input type="text" name="password_login" size="25" placeholder="Password"><br/><br/>
						<input type="submit" name="login" value="Login">
					</form>
				</td>
				<td width="40%" valign="top">
					<h2>Sign up</h2>
					<form action="index.php" method="POST">
						<input type="text" name="fname" size="25" placeholder="First Name"><br/><br/>
						<input type="text" name="lname" size="25" placeholder="Last Name"><br/><br/>
						<input type="text" name="username" size="25" placeholder="User Name"><br/><br/>
						<input type="text" name="email" size="25" placeholder="you@email.com"><br/><br/>
						<input type="password" name="password" size="25" placeholder="password"><br/><br/>
						<input type="password" name="password2" size="25" placeholder="retype password"><br/><br/>
						<input type="submit" name="reg" value="Sign-Up">
					</form>
				</td>
			</tr>
		</table>
<?php include("./inc/footer.php"); ?>
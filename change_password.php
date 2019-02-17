<?php 
include 'includes/db.php';
$error = '';
$errorClass='';
	session_start();
	if (isset($_SESSION['username'])) {
		$user = $_SESSION['username'];
		$id = $_SESSION['id'];
		$email = $_SESSION['email'];
	} else {
		header("Location: login.php");
	}
	if (isset($_POST['change'])) {
		$old = mysqli_escape_string($conn, $_POST['old_Pwd']);
		$new = mysqli_escape_string($conn, $_POST['new_pwd']);
		$new_2 = mysqli_escape_string($conn, $_POST['confirm_password']);
		//check for errors
		if (empty($old) || empty($new) || empty($new_2)) {
			$error = 'Please Fill in All Fields';
			$errorClass='error';
		}  else if ($new_2 != $new) {
			$error = 'Confirming Password Failed';
			$errorClass='error';
		} else {
			//check if old password and password in the database match
			$sql = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
			if ($row = mysqli_fetch_assoc($sql)) {
				$pwdCheck = password_verify($old, $row['password']);
				if ($pwdCheck == false) {
					$error = 'Wrong Old Password';
					$errorClass='error';	
				} else if ($pwdCheck == true) {
					//Check for password length
					if (strlen($new) < 4) {
						$error = 'Password Should be at least 4 characters';
						$errorClass='error';
					} else {
						//update user's password in the database
						$hashedPwd = password_hash($new, PASSWORD_DEFAULT);
						$sql = mysqli_query($conn, "UPDATE users SET password='$hashedPwd' WHERE id='$id'");
						$error='Password Changed Successful';
						$errorClass='success';
					}
				}
			}
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav>
		<ul>
			<li>Changing Password</li>
		</ul>
		<a href="#" class="loginbtn">Home</a>
	</nav>
	<form class="signup" action="change_password.php" method="post">
		<div class="<?php echo $errorClass ?>"><?php echo $error; ?></div>
		<input type="password" name="old_Pwd" value="<?php echo isset($_POST['old_Pwd']) ? $old : ''; ?>" placeholder="Old Password">
		<input type="password" name="new_pwd" value="<?php echo isset($_POST['new_pwd']) ? $new : ''; ?>" placeholder="New Password">
		<input type="password" name="confirm_password" value="" placeholder="Confirm Password">
		<input type="submit" name="change" value="Change Password">
	</form>
</body>
</html>
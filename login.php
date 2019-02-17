<?php
session_start();
	include 'includes/db.php';
	$error = '';
	$errorClass='';

	#Check if button is submitted
	if (isset($_POST['login'])) {
		//Get input field values
		$uid = mysqli_escape_string($conn, $_POST['uid']);
		$pwd = mysqli_escape_string($conn, $_POST['password']);

		//Check for errors
		if (empty($uid) || empty($pwd)) {
			$error = 'Please fill All fields';
			$errorClass='error';
		} else {
			//check if user exists
			$sql = mysqli_query($conn, "SELECT * FROM users WHERE username='$uid' OR email ='$uid'");
			$result = mysqli_num_rows($sql);
			if ($result < 1) {
				$error = 'User Does not exits';
				$errorClass='error';
			} else {
				//Check if password match
				if ($row = mysqli_fetch_assoc($sql)); {
					$PwdCheck = password_verify($pwd, $row['password']);
					if ($PwdCheck == false) {
						$error = 'Wrong Password';
						$errorClass='error';
					} elseif ($PwdCheck == true) {
						$_SESSION['id'] = $row['id'];
						$_SESSION['first'] = $row['first'];
						$_SESSION['last'] = $row['last'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['username'] = $row['username'];

						header("Location: index.php?login=success?");
						exit();	
					}
				}
			}
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login Here</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav>
		<ul>
			<li>Login</li>
		</ul>
		<a href="signup.php" class="loginbtn">Create Account</a>
	</nav>

	<form action="login.php" method="POST" class="signup">
		<div class="<?php echo $errorClass ?>"><?php echo $error; ?></div>
		<input type="text" name="uid" value="<?php echo isset($_POST['uid']) ? $uid : ''; ?>" placeholder="Username / E-mail">
		<input type="password" name="password" value="" placeholder="Set A Password">
		<input type="submit" name="login" value="Signup">
	</form>
</body>
</html>
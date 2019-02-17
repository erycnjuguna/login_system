<?php 
include 'includes/db.php';
$error = '';
$errorClass='';
if (isset($_POST['forgot'])) {
	$email = mysqli_escape_string($conn, $_POST['email']);
	$sql = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
	$result = mysqli_num_rows($sql);
	if ($result < 1) {
		$error = 'User not registered';
		$errorClass = 'error';
	} else if ($row = mysqli_fetch_assoc($sql)) {
		 $cstrong = True;
         $token = bin2hex(openssl_random_pseudo_bytes(60, $cstrong));
         $hashedtoken = sha1($token);
         $userid = $row['id'];
         $sql = mysqli_query($conn, "DELETE FROM forgot_tokens WHERE user_id=$userid");
         $query = mysqli_query($conn, "INSERT INTO forgot_tokens (token,user_id) VALUES('$hashedtoken','$userid')");
         $error ='Click link sent to your email to reset your Password';
         $errorClass ='success';
	}
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav>
		<ul>
			<li>Forgot Password</li>
		</ul>
		<a href="#" class="loginbtn">Home</a>
	</nav>
	
			<form class="signup" action="forgot_password.php" method="post">
		<div class="<?php echo $errorClass ?>"><?php echo $error; ?></div>
		<input type="text" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" placeholder="Enter Email">
		<input type="submit" name="forgot" value="Continue">
	</form>
</body>
</html>
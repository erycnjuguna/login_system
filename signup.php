<?php 
include 'includes/db.php';
$error = '';
$errorClass='';
	#check if the submit button is clicked
	if (isset($_POST['signup'])) {
		//Get input field values
	$first = mysqli_escape_string($conn, $_POST['first']);
	$last = mysqli_escape_string($conn, $_POST['last']);
	$email = mysqli_escape_string($conn, $_POST['email']);
	$username = mysqli_escape_string($conn, $_POST['username']);
	$password = mysqli_escape_string($conn, $_POST['password']);
	//Secure password before storing to database
	$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

	#Check for errors before creating users
						///////////////

		//check if all fields have been filled
		if (empty($first) || empty($last) || empty($email) || empty($username) || empty($password)) {
			$error = 'Please Fill in All Fields';
			$errorClass = 'error';
			
			//check if email is valid
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = 'Please Use A Valid Email';
			$errorClass = 'error';
			
			
			//check if username is more than 3 characters
		} else if(strlen($username) < 3) {
			$error = 'Username should be at least 3 characters';
			$errorClass = 'error';
			
			
			//Check if password is more than 4 characters
		} else if(strlen($password) < 4) {
			$error = 'Passord should be at least 4 Characters';
			$errorClass = 'error';		
			
		} else {
			//check if user is  already registered
			$query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' OR username='$username'");
			$res = mysqli_num_rows($query);
			if ($res > 0) {
				$error = 'User Exists';
				$errorClass = 'error';
				
			} else {
				//Insert user into database
				$sql = mysqli_query($conn, "INSERT INTO users (firstname,lastname,email,username,password) VALUES('$first','$last','$email','$username','$hashedpassword')");
				header("Location: login.php?success");
				exit();
			}
		}
		//////////////////////////////////////////////////////////
	} 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Account</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav>
		<ul>
			<li>Join Us</li>
		</ul>
		<a href="login.php" class="loginbtn">Login</a>
	</nav>

	<form action="signup.php" method="POST" class="signup">
		<div class="<?php echo $errorClass ?>"><?php echo $error; ?></div>
		<input type="text" name="first" value="<?php echo isset($_POST['first']) ? $first : ''; ?>" placeholder="First Name">
		<input type="text" name="last" value="<?php echo isset($_POST['last']) ? $last : ''; ?>" placeholder="Last Name">
		<input type="text" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" placeholder="E-Mail">
		<input type="text" name="username" value="<?php echo isset($_POST['username']) ? $username : ''; ?>" placeholder="Username">
		<input type="password" name="password" value="" placeholder="Set A Password">
		<input type="submit" name="signup" value="Signup">
	</form>
</body>
</html>
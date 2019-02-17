<?php 
session_start();
	if (isset($_SESSION['username'])) {
		$user = $_SESSION['username'];
		$email = $_SESSION['email'];
	} else {
		header("Location: login.php");
	}

	if (isset($_POST['logout'])) {
		session_unset();
		session_destroy();
		header("Location: login.php");
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Welcome <?php echo $user?></title>
 	<link rel="stylesheet" type="text/css" href="style.css">
 </head>
 <body>
 	<nav>
		<ul>
			<li>Home</li>
		</ul>
		<form action="" method="post" class="loginbtn">
		<input type="submit" value="Logout" name="logout">
		</form>
	</nav>
	<div class="container">
		<h3>Welcome, <?php echo $user; ?></h3>
		<br>
		<h4><?php echo $email; ?></h4><br>
		<a href="change_password.php" style="color: #fff;text-decoration: underline;">Change Password</a>
	</div>
 	
 </body>
 </html>
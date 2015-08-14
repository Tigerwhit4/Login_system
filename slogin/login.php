<?php
require_once('includes/initialize.php');

// Var for error messages
$message = "";

if (isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) { // Login form submitted
	if (!empty($_POST['username']) && !empty($_POST['password'])) { // Login fields are submitted
		// Setting form submitted data to vars
		$username = escape_value($_POST['username']);
		$password = escape_value($_POST['password']);
		
		$sql  = "SELECT * FROM users ";
		
		$users = mysqli_query($mysqli, $sql);
		while ($user = $users->fetch_object()) {
			if ($username == $user->username & (md5($password) == $user->password)) { // Matching form input with DB values
				$login_successful = true;
				
				login_user($user->id);
			}
		}
		
		if (!isset($login_successful)) {
			// We never let the user know if the username matched or not so we check both at the same time
			$message .= "Please check the spelling of the username and the password<br />";
			$message .= "Note that the password is case-sensitive";
		}
	} else {$message .= "Please fill in all form fields";}
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Login page</title>
	<link type="text/css" rel="stylesheet" href="css/style.css" media="screen" />
</head>
<body>
	<div class="wrapper">
		<h1>Welcome, Please login bellow first</h1>
		<div class="loginForm">
<?php
	if (!empty($message)) {
?>
			<div class="login_error">
<?php
	echo $message;
?>
			</div>
<?php
	}
?>
			<form action="login.php" method="post">
				<div class="formDivs">
					<label for="username">Username: </label>
					<input type="text" name="username" id="username" placeholder="Enter your username" />
				</div>
				<div class="formDivs">
					<label for="password">Password: </label>
					<input type="password" name="password" id="password" placeholder="Enter your password" />
				</div>
				<div class="formDivs">
					<input type="submit" name="submit" />
				</div>
			</form>
		</div>
	</div>
</body>
</html>
<?php $mysqli->close(); ?>
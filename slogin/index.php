<?php
	require_once('includes/initialize.php');
	
	$user_id = escape_value(get_user_id());
	$sql  = "SELECT id, profilename FROM users";
	
	$users = $mysqli->query($sql);
	while ($user = $users->fetch_object()) {
		if ($user->id == $user_id) {
			$user_name = $user->profilename;
			break;
		}
	}
	
	if (!isset($user_name)) {redirect_to("logout.php");}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Home Page</title>
</head>
<body>
	<h1>Home Page</h1>
	<h2>Welcome, <?php echo $user_name; ?></h2>
	<button type="button" value="Logout" onClick="window.location= 'logout.php'">Click2Logout</button>
</body>
</html>
<?php
	$magic_quotes_active = get_magic_quotes_gpc();
	$real_escape_string_exists = function_exists( "mysql_real_escape_string" );
	
	function db_connect() {
		global $mysqli;
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($mysqli->connect_error) {die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);}
	}
	function escape_value($value) { // For escaping values (get, post, any-user-submitted-values
		global $magic_quotes_active, $real_escape_string_exists;
		if( $real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$real_escape_string_exists ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	function login_user($user_id) {
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $user_id;
		redirect_to("index.php");
	}
	function check_login() {
		// Detect pages where it should redirect to homepage or login page
		$page_name = get_page_name();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
			if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
				// Cast the user_id to int, and check if it is an int
				// Casting to int (multiplying by int)
				if (is_int((int)$_SESSION['user_id'])) { // The user is logged in
					$loggedin = true;
					
					if ($page_name == "login.php") {
						redirect_to("index.php");
					}
				}
			}
		}
		
		if (!isset($loggedin) && $page_name != "login.php") { // User is not logged in
			redirect_to("login.php");
		}
	}
	function logout() {
		// We will do all the methods in order
		// Empty the session vars
		$_SESSION['logged_in'] = false;
		$_SESSION['user_id'] = "";
		// Unset the session vars
		unset($_SESSION['logged_in']);
		unset($_SESSION['user_id']);
		// Unset all sessoin vars and delete it
		session_unset();
		session_destroy();
		// Remove the cookie that is linking to the session (session ID)
		if (isset($_COOKIE['PHPSESSID'])) {
			unset($_COOKIE['PHPSESSID']);
			setcookie('PHPSESSID', null, -1, '/');
		}
		// Redirect to login page
		redirect_to("login.php");
	}
	function redirect_to($location) {
		header("Location: {$location}");
		exit;
	}
	function get_page_name() {
		// Getting the correct version of siteroot
		$siteroot = str_replace("\\", "/", SITE_ROOT);
		
		// Get the filename by itself
		$rootfile = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
		
		if (stripos($rootfile, $siteroot) !== FALSE) {
			$extlen = strlen($siteroot);
			
			$filename = substr($rootfile, ($extlen+1));
		}
		else {$filename = false;}
		
		return $filename;
	}
	function get_user_id() {
		return $_SESSION['user_id'];
	}
?>